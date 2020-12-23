<?php
/*
https://ehpad.home/z/resFullAlert2.php?m83=d6692fcc251ea8dde49296f06dfd1a90&rids=47236,32855
x1=`php -r 'echo md5(json_encode([47236,32855]));'`;echo $x;#Par liste de notifiées
php72 ~/home/ehpad/app/z/resFullAlert2.php '{"rids":"47236,32855","m83":"'$x1'"}'
obtenir les variations les plus récentes de prix
*/
$dateLimite=strtotime('1 month ago');

if('cli emulation'){
    $_SERVER['DOCUMENT_ROOT']=__DIR__.'/../';chdir(__DIR__);
    require_once "../vendor/autoload.php";#alptech
    if(isset($argv) and $argv[1]){
        $_GET=Alptech\Wip\io::isJson($argv[1]);
    }
}

if('verifs'){
    if(!isset($_GET['rids']))die('#'.__line__);if(!isset($_GET['m83']))die('#'.__line__);
    $rids=explode(',',$_GET['rids']);if(!$rids)die('?rids=');$_ENV['dieOnFirstError']=1;
    foreach($rids as &$rid){$rid=intval($rid);}unset($rid);$j=json_encode($rids);$md5=md5($j);
    if($_GET['m83'] != $md5)die('#'.__line__);#die('#'.implode(',',$rids).'<>'.$j.'<>'.$_GET['m83'].'<>'.$md5.'#'.__line__);
}

if('1:lister les variations pour chacune des 10 résidences les plus proches au cours de 30 derniers jours'){
    $residencesTriggers=$rids;
    $neighbours=$p102Neighbours=[];
    $sql="select rid,clo10 from z_geo where rid in(".implode(',',$residencesTriggers).")";#dont need more values, being Obviously Within in that list
    $dansLeVoisinage=Alptech\Wip\fun::sql($sql);#il nous faut tout
    foreach($dansLeVoisinage as $t) {
        $clo10 = explode(',', trim($t['clo10'], ','));
        array_diff($clo10,$t['rid']);#beware a self is in list
        $p102Neighbours[$t['rid']] = $clo10;
        $neighbours=array_merge($neighbours,$clo10);
    }
}
$neighbours=array_unique($neighbours);
$tutti=array_filter(array_unique(array_merge($residencesTriggers,$neighbours)));#on veut également savoir pour la résidence notifiée également

if('2:choper tous tarifs then and now, nb: certaines peuvent ne jamais avoir varié, done non présents ici'){
    $tarifs=$cs0=$cs1=[];
    $x=Alptech\Wip\fun::sql("select rid,cs_0,cs_1 from z_variations where rid in(".implode(',',$tutti).") and btime>".$dateLimite."  and cs_1 is not null and cs_0 is not null order by date desc");if(!$x)die('#'.__line__);$found=[];
    foreach($x as $t){
        if(!in_array($t['rid'],$found))$found[]=$t['rid'];
        $cs0[$t['rid']]=$t['cs_0'];
        $cs1[$t['rid']]=$t['cs_1'];
    }
    $notFound=array_diff($tutti,$found);
    if(1 and "5: ,ne pas récupérer tous les prix n'ayant subi aucune violence, ni variation"){
        $x = Alptech\Wip\fun::sql("select entity_id,field_residence_target_id from field_data_field_residence where bundle='chambre' and field_residence_target_id in(" . implode(',',$tutti) . ")");
        $residence2chambre=$chambres=$_missingChambre=[];foreach($x as $t){$residence2chambre[$t['field_residence_target_id']]=$t['entity_id'];}
        $chambre2residence=array_flip($residence2chambre);

        $sql="select substring_index(group_concat(field_tarif_chambre_simple_value order by revision_id desc),',',3)as v,substring_index(group_concat(revision_id order by revision_id desc),',',3)as revid,entity_id as cid from field_revision_field_tarif_chambre_simple where entity_id in(" . implode(',', $residence2chambre).") and field_tarif_chambre_simple_value<>'NA' group by entity_id";
        $x = Alptech\Wip\fun::sql($sql);$ph=[];#de toutes façons
        foreach ($x as $t) {
            $rid=$chambre2residence[$t['cid']];
            $priceHistory=array_slice(explode(',',$t['v']),0,2);
            foreach($priceHistory as $k=>$v){
                if(isset($cs0[$t['rid']])){
                    $err='déjà présent';
                }else{#£:todo:attention : même si ces dernières n'ont pas évolué
                    if($k==0)$cs1[$rid]=$v;#by revision desc, so it should be the latest one
                    elseif($k==1)$cs0[$rid]=$v;#by revision desc, so it should be the latest one
                    $ph[$rid][$k]=$v;
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
    $moyennes=[];
    foreach($p102Neighbours as $rid=>$_rids){
        $inc0=$inc1=$_cs0=$_cs1=0;$p1=$po=[];
        foreach($_rids as $_rid) {
            if($_rid==$rid)continue;
            foreach ($ph[$_rid] as $k => $v) {#sortis dans leur bon ordre
                if ($k == 0) {#now
                    $p1[]=$v;
                    #$_cs1 += $v;$inc1++;
                } elseif ($k == 1) {#then
                    $po[]=$v;
                    #$_cs0 += $v;$inc0++;
                }
            }
        }
        if($po){
            $_cs0=array_sum($po);
            $_cs0/=count($po);$_cs0=round($_cs0,2);
            $a=1;
        }if($p1) {
            $_cs1 = array_sum($p1);$_cs1 /= count($p1);$_cs1 = round($_cs1, 2);
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

echo"\n<html><body><style>table{border-collapse:collapse}   .r1{background:#EEE}</style>\n<table border=1><thead><tr><td>Nom</td><td>Dep</td><td>Ancien tarif</td><td>Nouveau tarif</td><td>Var moy</td><td>Ancienne Moy</td><td>Nouvelle Moy</td></tr></thead><tbody>";
foreach($p102Neighbours as $rid=>$_rids){
    if(!isset($moyennes[$rid]))Continue;
    $evol=round($moyennes[$rid][1]-$moyennes[$rid][0],2);
    if($evol>0)$evol='+'.$evol;
    echo"\n<tr class=r1 title='".$finesses[$rid]." » $rid » ".count($_rids).' » '.implode(',',$_rids)."'><td><a target=r href='/residence/$rid'>".$rid2title[$rid].'</a></td><td>'.trim(substr($dep[$rid],0,3)). '</td><td>'.$ph[$rid][1]. ' €</td><td>'.$ph[$rid][0].' €</td><td>'.$evol.'€</td><td> '.$moyennes[$rid][0].' €</td><td> '.$moyennes[$rid][1].' €</td></tr>';
    foreach($_rids as $_rid){
        if($_rid==$rid)Continue;#self listing
        if(1 or ($ph[$_rid][1] and $ph[$_rid][0] != $ph[$_rid][1])){#Nb => il faut qu'il existe une réelle différence de prix
            echo"\n<tr title='".$finesses[$_rid]." » $_rid'><td colspan=5>  &nbsp; &nbsp; &nbsp; »»» <a target=r href='/residence/$_rid'>".$rid2title[$_rid].'</a></td><td>'.$ph[$_rid][1].' €</td><td>'.$ph[$_rid][0].'€</td></tr>';#.' // => '.$cs0[$rid].' à '.$cs1[$rid];
        }
    }
}
echo"\n</tbody></table></body></html>";
$a=1;
die;



foreach($rids as $rid){

    foreach($x as $t){if(isset($cs0[$t['rid']]))Continue;$cs0[$t['rid']]=$t['cs_0'];$cs1[$t['rid']]=$t['cs_1'];}#bcp de tarifs ..
}#end foreach rids

die;
$module='../sites/all/modules/residence_mgmt';

$mysql58groupMode=Alptech\Wip\fun::sql("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

if(1){

}




$x=Alptech\Wip\fun::sql('select list from z_geo where rid='.$rid);
if(!$x)die('#'.__line__);
$tenClosestRes=[];$liste=trim($x[0]['list'],',');$x=explode(',',$liste);$tenClosest=array_slice($x,0,10);
$liste2=implode(',',$tenClosest);
$y=Alptech\Wip\fun::sql('select nid,title from node where nid in('.$rid.')');
echo"<pre>".$y[0]['title']."\n";

$x=Alptech\Wip\fun::sql('select nid,title from node where nid in('.$liste2.')');
foreach($x as $t)$tenClosestRes[$t['nid']]=$t['title'];

$r2c=res2ch($rid);$chp=chprix($r2c);$historiquePrix=implode(',',$chp[$rid]);

if('1:get Current Prices') {
    if ('2:chambresByResidences') {
        $x = Alptech\Wip\fun::sql("select entity_id,field_residence_target_id from field_data_field_residence where bundle='chambre' and field_residence_target_id in(" . $liste2 . ")");
        $residence2chambre = $_missingChambre = [];
        foreach ($x as $t) {
            $residence2chambre[$t['field_residence_target_id']] = $t['entity_id'];
        }
        $chambre2residence = array_flip($residence2chambre);
    }
/*
    if (0 and '2:get Current Residences Prices') {
        $sql = "select entity_id as k,field_tarif_chambre_simple_value as v from field_data_field_tarif_chambre_simple where entity_id in(" . implode(',', $residence2chambre) . ")";
        $x = Alptech\Wip\fun::sql($sql);
        foreach ($x as $t) {
            $_rid = $chambre2residence[$t['k']];
            $prixActuels[$_rid] = $t['v'];
        }
    }
*/
    $ph=[];$inc0=$inc1=$cs0=$cs1=0;
    if('2:get prices history => does the whole stuff'){#count(*)as nb,
        $sql="select substring_index(group_concat(field_tarif_chambre_simple_value order by revision_id desc),',',2)as v,substring_index(group_concat(revision_id order by revision_id desc),',',2)as revid,entity_id as cid from field_revision_field_tarif_chambre_simple where entity_id in(" . implode(',', $residence2chambre).") and field_tarif_chambre_simple_value<>'NA' group by entity_id";#order by entity_id desc,revision_id desc
        $x = Alptech\Wip\fun::sql($sql);
        foreach ($x as $t) {
            $rid=$chambre2residence[$t['cid']];
            $priceHistory=array_slice(explode(',',$t['v']),0,2);
            foreach($priceHistory as $k=>$v){
                $ph[$rid][$k]=$v;
                if($k==0){$cs0+=$v;$inc0++;} elseif($k==1){$cs1+=$v;$inc1++;}
            }
            $a=1;
        }
        if($inc0)$cs0/=$inc0;if($inc1)$cs1/=$inc1;$cs0=round($cs0,2);$cs1=round($cs1,2);
        $tarifChambreSeuleApres=$cs0;$tarifChambreSeuleAvant=$cs1;
        print_r(compact('tenClosestRes','historiquePrix','tarifChambreSeuleAvant','tarifChambreSeuleApres','inc0','inc1'));#,'c','avg'
        return;
    }
}



if(0){
    #$c=count($prixActuels);$avg=array_sum($prixActuels)/$c;
    #NB : ne jamais utiliser le script des variations
    $inc0=$inc1=$cs0=$cs1=0;
    $x=Alptech\Wip\fun::sql('select rid,date,cs_0,cs_1 from z_variations where rid in('.$liste2.') order by date desc');
    foreach($x as $t){
        $id=$t['rid'];if(isset($variations[$id]))continue;#exclude older dates
        unset($t['rid'],$t['date']);$t['title']=$tenClosestRes[$id];$variations[$id]=$t;
        if($t['cs_0']){$inc0++;$cs0+=$t['cs_0'];}
        if($t['cs_1']){$inc1++;$cs1+=$t['cs_1'];}
    }
    if($inc0)$cs0/=$inc0;if($inc1)$cs1/=$inc1;$cs0=round($cs0,2);$cs1=round($cs1,2);
    print_r(compact('tenClosestRes','historiquePrix','variations','cs0','cs1','inc0','inc1','c','avg'));
}


$a=1;
return;


if(0){#$prod=1;
require_once $module . "/vendor/autoload.php";#others -- dont need them
require_once $module . "/data/data_config.php";
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
require_once $module . "/residence_mgmt.module";
}
return;?>
