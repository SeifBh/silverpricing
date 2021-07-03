<?php
/*
 ?rids=47236,32855
php -r 'echo json_encode([47236,32855]);'
x=`php -r 'echo md5(json_encode([47236,32855]));'`;echo $x;#Par liste de résidence connaissant des variations
php72 ~/home/ehpad/app/z/resFullAlert.php '{"rids":"47236,32855","m83":"'$x'"}'
obtenir les variations les plus récentes de prix
*/
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

$dateLimite=strtotime('1 month ago');

if('1:variations valides'){
    $residencesTriggers=[];
    $sql="select group_concat(rid)as rids from z_variations where rid in(".implode(',',$rids).") and btime>".$dateLimite."  and cs_1 is not null and cs_0 is not null order by date desc";
    $x=Alptech\Wip\fun::sql($sql);
    if(!$x)die('#'.__line__);
    $residencesTriggers=explode(',',$x[0]['rids']);
    foreach($residencesTriggers as &$t)$t=intval($t);unset($t);
    $a=2;
}


if('2:proxima10'){
    $maxNeighbours=10;$proxima20=$origin2notifies=$notifiee2alerteOrigine=[];
    $regexp=','.implode(',|,',$residencesTriggers).',';
    #$sql="select rid,list from z_geo where closest is not null and `list` regexp '".$regexp."'";
    $sql="select rid,clo10 from z_geo where clo10 is not null and clo10 regexp '".$regexp."'";#dont need more values, being Obviously Within in that list
    $dansLeVoisinage=Alptech\Wip\fun::sql($sql);#il nous faut tout
    foreach($dansLeVoisinage as $t){
        $liste=trim($t['clo10'],',');$xliste=explode(',',$liste);
        $closests=array_splice($xliste,0,$maxNeighbours);#la résidence qui déclenche l'alerte fait-elle partie des 10 les plus proches ???
        $hasIntersections=array_intersect($closests,$residencesTriggers);
        if($hasIntersections){
            $proxima10[$t['rid']]=[];
            foreach($hasIntersections as $baseRid){
                $baseRid=intval($baseRid);
                if(!isset($notifiee2alerteOrigine[$t['rid']])){$notifiee2alerteOrigine[$t['rid']]=[];}
                $notifiee2alerteOrigine[$t['rid']][]=$baseRid;
                $origin2notifies[$baseRid][]=$t['rid'];
            }
            $proxima10[$t['rid']]=$xliste;#afin de limiter à 10
            $proxima20=array_merge($proxima20,$xliste);
        }else{
            $err='pasnormal';
        }
    }
    $proxima20=array_unique($proxima20);
}
/*
if(0 and $proxima20 and "3rd :: les 10 résidences les plus proches des notifiées ( pas mal d'intersections également ) "){
    $regexp=','.implode(',|,',array_keys($proxima10)).',';
    $sql="select rid,clo10 from z_geo where clo10 is not null and clo10 regexp '".$regexp."'";#dont need more values,
}
*/

$tutti=array_unique(array_merge($proxima20,array_keys($proxima10),$residencesTriggers));
#$proxima10G=$residencesTriggers#=$residencesTriggers de base

if('4:choper tous tarifs then and now, nb: certain peuvent ne jamais avoir varié, done non présents ici'){
    $tarifs=$cs0=$cs1=[];
    $x=Alptech\Wip\fun::sql("select rid,cs_0,cs_1 from z_variations where rid in(".implode(',',$tutti).") and btime>".$dateLimite."  and cs_1 is not null and cs_0 is not null order by date desc");if(!$x)die('#'.__line__);$found=[];
    foreach($x as $t){
        if(!in_array($t['rid'],$found))$found[]=$t['rid'];
        $cs0[$t['rid']]=$t['cs_0'];
        $cs1[$t['rid']]=$t['cs_1'];
    }
    $notFound=array_diff($tutti,$found);
    if("5: tous les prix n'ayant subi aucune violence, ni variation"){
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
                }else{
                    if($k==0)$cs0[$rid]=$v;#by revision desc, so it should be the latest one
                    elseif($k==1)$cs1[$rid]=$v;#by revision desc, so it should be the latest one
                    $ph[$rid][$k]=$v;
                }
            }
        }
    }
    $a=1;
}

if('9: tous les titres'){
    $rid2title=$dep=[];
    $sql="select b.name as v,entity_id as k from field_data_field_departement a inner join taxonomy_term_data b on b.tid=a.field_departement_tid where entity_id in(".implode(',',$tutti).")";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t){$dep[$t['k']]=$t['v'];}
    $sql="select nid,title from node where nid in(".implode(',',$tutti).") and title is not null";$x=Alptech\Wip\fun::sql($sql); foreach($x as $t){$rid2title[$t['nid']]=$t['title'];}
}

if('10 >> pour chacune des notifiees'){
    foreach($proxima10 as $rid=>$_rids){
        $inc0=$inc1=$_cs0=$_cs1=0;
        foreach($_rids as $_rid) {
            foreach ($ph[$_rid] as $k => $v) {
                if ($k == 0) {
                    $_cs1 += $v;
                    $inc1++;
                } elseif ($k == 1) {
                    $_cs0 += $v;
                    $inc0++;
                }
            }
        }
        if($inc0)$_cs0/=$inc0;
        if($inc1)$_cs1/=$inc1;
        $evolutions[$rid]=[$_cs0,$_cs1];
    }
}
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
