<?php
/*
 * ?nbMonth=
https://ehpad.home/z/resFullAlert2.php?m83=00a3f83475e28a9d536d17dc00f93ff6&rids=31889,32855
x1=`php -r 'echo md5(json_encode([31889,32855]));'`;echo $x1;#Par liste de notifiées
php72 ~/home/ehpad/app/z/resFullAlert2.php '{"rids":"31889,32855","m83":"'$x1'"}'
obtenir les variations les plus récentes de prix
*/

$lastVariationWithinInterval=$month=1;$standAlone=$displayNull=$details=$range=0;#?details=1,2,3
if(strpos($_SERVER['REQUEST_URI'],'resFullAlert2.php'))$standAlone=1;

/*
=> implémenter un filtre de date limite
=> implémenter au niveau des alertes pour que l'on a le même status peut importe les date de modification des prix
 */

require_once __DIR__."/../vendor/autoload.php";#chdir(__DIR__);#alptech

if(isset($argv) and 'cli emulation'){
    $_SERVER['DOCUMENT_ROOT']=__DIR__.'/../';
    if($argv[1]){$_GET=Alptech\Wip\io::isJson($argv[1]);}
}else{#http
    if(0 and $standAlone){
        Alptech\Wip\fun::r302('/ra/?'.$_SERVER["QUERY_STRING"]);
    }
}

if('verifs'){
    if(!isset($_GET['rids']))die('#'.__line__);if(!isset($_GET['m83']))Alptech\Wip\fun::r404('nothing here#'.__line__);
    $rids=explode(',',$_GET['rids']);if(!$rids)die('?rids=');$_ENV['dieOnFirstError']=1;
    foreach($rids as &$rid){$rid=intval($rid);}unset($rid);$j=json_encode($rids);$md5=md5($j);
    if(isset($_SERVER['WINDIR'])); elseif($_GET['m83'] != $md5)die('#'.__line__);#die('#'.implode(',',$rids).'<>'.$j.'<>'.$_GET['m83'].'<>'.$md5.'#'.__line__);
}

if(isset($_GET['lastVariationWithinInterval'])){$lastVariationWithinInterval=$_GET['lastVariationWithinInterval'];}
if(isset($_GET['nbMonth'])){$month=$_GET['nbMonth'];}
if(isset($_GET['range'])){$range=intval($_GET['range']);}
if(isset($_GET['displayNull'])){$displayNull=intval($_GET['displayNull']);}

$ttLimit=time()-intval($month*31*24*3600);
$dateLimite=strtotime(intval($month).' month ago');

if('1:lister les variations pour chacune des 10 résidences les plus proches au cours de 30 derniers jours'){
    $residencesTriggers=$rids;
    $neighbours=$p102Neighbours=[];

    $c='clo10';
    if($range==20)$c='clo20';
    elseif($range==30)$c='list';

$c='list';#anyways then splice
$closestByResidence=[];
    $sql="select rid,$c,closest from z_geo where rid in(".implode(',',$residencesTriggers).")";#dont need more values, being Obviously Within in that list
    $dansLeVoisinage=Alptech\Wip\fun::sql($sql);#il nous faut tout
    foreach($dansLeVoisinage as $k=>$t) {
        $closest=json_decode($t['closest'],1);
        foreach($closest as $dist=>$rids2){
            foreach($rids2 as $rids3){
                $closestByResidence[$t['rid']][$rids3]=$dist;
            }
        }
        $clo10 = explode(',', trim($t[$c], ','));
        $p102Neighbours[$t['rid']] = array_diff($clo10,[$t['rid']]);#remove self from list
        if(isset($_SERVER['WINDIR'])){
            $_clo=getResidencesProchesByStatus($t['rid'],[],10,1);
            $concurrenceIndirecte=getResidencesProchesByStatus($t['rid'],[],10);
            $_x=[];foreach($concurrenceIndirecte as $t2){$_x[$t2->nid]=$t2->field_tarif_chambre_simple_value;}
            $_ak=array_keys($_x);
            $__mean[$t['rid']]=array_sum($_x)/count($_x);#77.901 indirecte
            $a=1;
        }
        $neighbours=array_merge($neighbours,$clo10);
    }
}
$neighbours=array_unique($neighbours);
#filtrer les voisins par leur proximitat !

$tutti=array_filter(array_unique(array_merge($residencesTriggers,$neighbours)));#on veut également savoir pour la résidence notifiée également

if('1:residence2chambre'){
    $x = Alptech\Wip\fun::sql("select entity_id,field_residence_target_id from field_data_field_residence where bundle='chambre' and field_residence_target_id in(" . implode(',',$tutti) . ") order by field(field_residence_target_id,".implode(',',$tutti).")");
    $residence2chambre=$chambres=$_missingChambre=[];foreach($x as $t){$residence2chambre[$t['field_residence_target_id']]=$t['entity_id'];}
    $chambre2residence=array_flip($residence2chambre);
    $chambresSansPrix=$residence2chambre;
    $mainChambres=[];
    foreach($residencesTriggers as $rid){
        $mainChambres[]=$residence2chambre[$rid];
    }
}

$sql=0;$pf=$tarifs=$cs0=$cs1=$ph=$found=$_expiredPrices=[];

if("2:tous les prix sans distinctions pour l'instant"){
    $sql = "select group_concat(nr.timestamp)as tt,group_concat(field_tarif_chambre_simple_value order by revision_id desc) as v,group_concat(revision_id order by revision_id desc) as revid,entity_id as cid from field_revision_field_tarif_chambre_simple cs inner join node_revision nr on nr.nid=cs.entity_id where cs.entity_id in(" . implode(',', $chambresSansPrix) . ") and cs.field_tarif_chambre_simple_value<>'NA' group by cs.entity_id order by field(cs.entity_id,".implode(',',$chambresSansPrix).")";#,timestamp asc

    $chambresPrix = Alptech\Wip\fun::sql($sql);
    $_nbPrixRemontes=count($x);
    $a=1;
    /*prix from 33007*/
    foreach ($chambresPrix as $t) {
        $rid = $chambre2residence[$t['cid']];
        if (in_array($rid, $pf)/* or count($pf)>$range*/) {continue;}

        $prices=explode(',', $t['v']);
        $ph1 = array_unique($prices);
        $priceHistory = array_slice($ph1, 0, 2);#les deux premieres variation uniquement

        $tt=explode(',', $t['tt']);#parfois plusieurs modification sur same timestamp .. is really messy
        $last=max($tt);

        if(in_array($rid,$residencesTriggers));#toujours la conserver pour listing
        if ($last > $ttLimit) {#et filter ici par date limite de dernière variation ( dernier record ), logique !!!!, seulement si lastVariationWithinInterval est à 0 bien entendu :)
            $_expiredPrices[] = $rid;
            $pf[] = $rid;#no price change within limit
            continue;
        }elseif($lastVariationWithinInterval){
            if(count($ph1)<2){
                $noHistory[]=$rid;
                $pf[] = $rid;#'hasNoPriceHistory .. excluding from variations >Simple !!!';
                continue;
            }

            $pptt=[];foreach($prices as $k=>$price){$k1=$tt[$k];while(isset($pptt[$k1])){$k1+=1;}/*#increment ms variations =)#*/$pptt[$k1]=$price;}krsort($pptt);

            $lastprice=end($pptt);#the final one..
            foreach($pptt as $time=>$price){
                $diff=$price-$lastprice;
                if($diff){#the variation
                    if($time>$ttLimit){
                        $_expiredPrices[] = $rid;
                        $pf[] = $rid;#no price change within limit
                        continue 2;
                    }
                    break;#price variation is valid.
                }
            }
        }

        if(0){#potentiels autres points d'arrêt ..
            if ($rid == 33121) {
                $a = 1;
            }
        }

        $pf[] = $rid;
        foreach ($priceHistory as $k => $v) {
            if (0 and isset($cs0[$rid])) {#76.46 vs same
                $err = 'déjà présent';
            } else {#£:todo:attention : même si ces dernières n'ont pas évolué
                if ($k == 0) {#now
                    $cs1[$rid] = $v;#la première ..
                }#by revision desc, so it should be the latest one
                elseif ($k == 1) {#auparavant ..
                    $cs0[$rid] = $v;
                }#by revision desc, so it should be the latest one
                $ph[$rid][$k] = $v;
            }
        }
    }
}



/*
 * Red bonobo :: todo :: obtenir même moyenne concurrence que la concurrence indirecte ! Soit 77.9
https://ehpad.home/ra?m83=ff58d146d4aa32d35985e69944263d58&rids=33089&range=10&nbMonth=12
*/
if('2:choper tous tarifs then and now, nb: certaines peuvent ne jamais avoir varié, done non présents ici'){}

#sur la dernière MAJ ( order by date )
#/* les 10 les plus proches :: field(rid,4,3,2,1) */
#$ttLimit,$x=Alptech\Wip\fun::sql("select rid,cs_0,cs_1,date from z_variations where rid in(".implode(',',$tutti).") and btime>".$dateLimite."  and cs_1 is not null and cs_0 is not null order by field(rid,".implode(',',$tutti)."),date desc");if(!$x)die('#nv:'.__line__);$found=[];

if(0 and 'ancien modèle simple qui va prendre le dessus'){
    $variationsPrixDansIntervalle=Alptech\Wip\fun::sql("select rid,cs_0,cs_1,date from z_variations where rid in(".implode(',',$tutti).") and btime>".$dateLimite."  and cs_1 is not null and cs_0 is not null order by field(rid,".implode(',',$tutti)."),date desc");if(!$variationsPrixDansIntervalle)die('#nv:'.__line__);
    #$x=Alptech\Wip\fun::sql("select rid,cs_0,cs_1 from z_variations where rid in(".implode(',',$tutti).") and btime>".$dateLimite."  and cs_1 is not null and cs_0 is not null order by date desc");if(!$x)die('#nv:'.__line__);$found=[];
#order by date desc(),field(rid,4,3,2,1),field
    foreach($variationsPrixDansIntervalle as $t){
        if(in_array($t['rid'],$found)/* or count($found)>$range*/){
            continue;#never loops twice the same residence ( maximal date update only )
        }
        if(!in_array($t['rid'],$found))$found[]=$t['rid'];
        $ph[$t['rid']][1]/*nb:inversion*/=$cs0[$t['rid']]=$t['cs_0'];
        $ph[$t['rid']][0]=$cs1[$t['rid']]=$t['cs_1'];
        $a=1;#splice by range and that's alll
    }



$nf=count($found)-$range;
$notFound=array_diff($tutti,$found);
$triggersSansPrix=array_diff($residencesTriggers,$found);
$chambresSansPrix=[];

    if(0 and "5: ,ne pas récupérer tous les prix n'ayant subi aucune violence, ni variation, this is global scope"){
        if(!$lastVariationWithinInterval and "on regarde toutes les variations de prix au dela de l'intervalle"){#if(count($found)<$range) {
            $chambresSansPrix=$residence2chambre;
        }elseif($triggersSansPrix){
            foreach($triggersSansPrix as $rid){
                $chambresSansPrix[]=$residence2chambre[$rid];
            }
            $a=1;
        }if($chambresSansPrix){#donc, si l'un des ehpad parent n'a pas eu de variation de prix au cours des n derniers mois ..
            $sql = "select group_concat(nr.timestamp)as tt,group_concat(field_tarif_chambre_simple_value order by revision_id desc) as v,group_concat(revision_id order by revision_id desc) as revid,entity_id as cid from field_revision_field_tarif_chambre_simple cs inner join node_revision nr on nr.nid=cs.entity_id where cs.entity_id in(" . implode(',', $chambresSansPrix) . ") and cs.field_tarif_chambre_simple_value<>'NA' group by cs.entity_id order by field(cs.entity_id,".implode(',',$chambresSansPrix).")";#,timestamp asc

            $chambresPrix = Alptech\Wip\fun::sql($sql);
            $_nbPrixRemontes=count($x);
            $a=1;$_expiredPrices=[];
/*prix from 33007*/
            foreach ($chambresPrix as $t) {
                $tt=explode(',', $t['tt']);
                $last=max($tt);
                $rid = $chambre2residence[$t['cid']];
                if($last>$ttLimit){#et filter ici par date limite
                    $_expiredPrices[]=$rid;
                    continue;
                }
                if($rid==33121){
                    $a=1;
                }
                $ph1=array_unique(explode(',', $t['v']));
                $priceHistory = array_slice($ph1, 0, 2);#les deux premiers uniquement
                if(in_array($rid,$pf)/* or count($pf)>$range*/){continue;}$pf[]=$rid;

                foreach ($priceHistory as $k => $v) {
                    if (0 and isset($cs0[$rid])) {#76.46 vs same
                        $err = 'déjà présent';
                    } else {#£:todo:attention : même si ces dernières n'ont pas évolué
                        if ($k == 0) {
                            $cs1[$rid] = $v;#la première ..
                        }#by revision desc, so it should be the latest one
                        elseif ($k == 1) {
                            $cs0[$rid] = $v;
                        }#by revision desc, so it should be the latest one
                        $ph[$rid][$k] = $v;
                    }
                }
            }
        }
    }
    $a=1;
}

if('9: tous les titres'){
    $rid2title=$dep=$finesses=[];

    $sql="select entity_id as k,field_finess_value as v from field_data_field_finess where entity_id in(".implode(',',$tutti).")";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t){$finesses[$t['k']]=$t['v'];}
    $sql="select b.name as v,entity_id as k from field_data_field_departement a inner join taxonomy_term_data b on b.tid=a.field_departement_tid where entity_id in(".implode(',',$tutti).")";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t){$dep[$t['k']]=$t['v'];}
    $sql="select nid,title from node where nid in(".implode(',',$tutti).") and title is not null";$x=Alptech\Wip\fun::sql($sql); foreach($x as $t){$rid2title[$t['nid']]=$t['title'];}
}




if('10 >> pour chacune des notifiees'){
    $prixManquantAuSeinDesVariations=$moyennes=[];
    foreach($p102Neighbours as $rid=>$_rids){
        $inc=$inc0=$inc1=$_cs0=$_cs1=0;$p1=$po=$skipped=[];
        $_ridsRange=array_slice($_rids,0,$range);
        foreach($_rids as $_rid) {
            if($inc>=$range){break;}
            if($_rid==$rid or !isset($ph[$_rid])){
                $skipped[]=$_rid;
                continue;
            }#selfs#
            $inc++;
            if(isset($_SERVER['WINDIR'])){
                $prix=[];
                foreach($_ak as $id){
                    if(!isset($ph[$id])){
                        $prixManquantAuSeinDesVariations[]=$id;#sans doutes à cause du temps de révision du dernier prix ..
                    }
                    $prix[$id]=$ph[$id];
                }
                $a=1;
            }

            foreach ($ph[$_rid] as $k => $v) {#sortis dans leur bon ordre
                if ($k == 0) {#now
                    $p1[$_rid]=$v;
                    #$_cs1 += $v;$inc1++;
                } elseif ($k == 1) {#then
                    $po[$_rid]=$v;
                    #$_cs0 += $v;$inc0++;
                }
            }
        }
        if($po){
            $_cs0=array_sum($po);
            $_cs0/=count($po);$_cs0=round($_cs0,2);
            $a=1;
        }if($p1) {/*
then, newest (+33063 before 33075 ) , original has 33135 = "82.1" before 33169
33131 = "81.09" <> 80.72
*/
            $_cs1 = array_sum($p1);$_cs1 /= count($p1);$_cs1 = round($_cs1, 2);
            #$_x
            $a=1;#77.90 for the new mean vs 75.99 pour _cs1
        }
        if(0){
            if($inc0)$_cs0/=$inc0;
            if($inc1)$_cs1/=$inc1;
            $_cs0=round($_cs0,2);
            $_cs1=round($_cs1,2);
        }
        $moyennes[$rid]=[$_cs0,$_cs1];
    }
}


if(isset($_SERVER['WINDIR'])){$__expiredPriceTitles=[];##
    foreach($_expiredPrices as $k){
        $__expiredPriceTitles[]=$rid2title[$k];
    }foreach($noHistory as $k){
        $__expiredPriceTitles[]=$rid2title[$k];
    }
    $a='$noHistory';#
}

#
if($standAlone){
echo"\n<html><head><link rel='preconnect' href='https://fonts.gstatic.com'><link href='https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap' rel='stylesheet'><style>html{font:10px 'IBM Plex Sans','Montserrat',sans-serif;background:#000;}    </style></head><body>";
}

echo"\n<style>
.r1{background:#CCC;}
#fullPriceAlert a{color:rgba(66,100,190,1);}  
#fullPriceAlert{    border-radius: 5px;border-collapse:collapse;margin:auto;background:#FAFAFA;box-shadow: 0 0 7px #fff;}       
#fullPriceAlert td:nth-child(n+2) {text-align: right;}  #fullPriceAlert td{padding:1rem;}
</style>
<table border=1 id='fullPriceAlert'><thead><tr><td>Nom</td><td>Dep</td><td>Ancien tarif</td><td>Nouveau tarif</td><td>Variation</td><td>Ancienne moyenne concurrence</td><td>Nouvelle moyenne concurrence</td><td>Km</td></tr></thead><tbody>";
#todo: rajouter le logo du groupe pour chaque résidence
foreach($p102Neighbours as $rid=>$_rids){
    if(!isset($moyennes[$rid]))Continue;
    $evol=round($moyennes[$rid][1]-$moyennes[$rid][0],2);
    if($evol>0)$evol='+'.$evol;
    echo"\n<tr class=r1 title='".$finesses[$rid]." » $rid » ".count($_rids).' » '.implode(',',$_rids)."'><td><a target=r href='/residence/$rid'>".$rid2title[$rid].'</a></td><td>'.trim(substr($dep[$rid],0,3)). '</td><td>'.$ph[$rid][1]. ' €</td><td>'.$ph[$rid][0].' €</td><td>'.$evol.'€</td><td> '.$moyennes[$rid][0].' €</td><td> '.$moyennes[$rid][1].' €</td><td></td></tr>';
    $newrow=$inc=0;
    foreach($_rids as $_rid){
        if($inc>=$range){continue;}
        if($_rid==$rid)Continue;#self listing
        if(1 or ($ph[$_rid][1] and $ph[$_rid][0] != $ph[$_rid][1])){#Nb => il faut qu'il existe une réelle différence de prix
            $evol=round($ph[$_rid][0]-$ph[$_rid][1],2);
            if($evol !=0 or $displayNull){
                $dist=0;
                $inc++;#display les prix pris en compte du coup
                if($evol>0)$evol='+'.$evol;
                if(!$newrow){$newrow=1;echo"\n<tr class='linge1 b'><td colspan=4>Résidences les plus proches de ".$rid2title[$rid]."</td><td>Variation</td><td>Ancien Prix</td><td>Nouveau prix</td><td>Km</td></tr>";}

                if(isset($closestByResidence[$rid][$_rid])){
                    $dist=$closestByResidence[$rid][$_rid];
                }else{
                    $a='err';
                }

                echo"\n<tr title='".$finesses[$_rid]." » $_rid'><td colspan=4 class='linge2 b'>  &nbsp; &nbsp; &nbsp; »»» <a target=r href='/residence/$_rid'>".$rid2title[$_rid].'</a></td><td>'.$evol.' €</td><td>'.$ph[$_rid][1].' €</td><td>'.$ph[$_rid][0].'€</td><td>'.$dist.'</td></tr>';#.' // => '.$cs0[$rid].' à '.$cs1[$rid];
            }
        }
    }
}
echo"\n</tbody></table>";
return;
?>
