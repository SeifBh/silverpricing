<?php
/*
php72 ~/home/ehpad/app/z/scripts.php '{"rid":42871}'
if(!isset($argv))die;

obtenir les variations les plus récentes de prix

*/
$_SERVER['DOCUMENT_ROOT']=__DIR__.'/../';chdir(__DIR__);
$module='../sites/all/modules/residence_mgmt';
require_once "../vendor/autoload.php";#alptech

require_once "../vendor/autoload.php";#alptech
if(isset($argv) and $argv[1]){
    $_GET=Alptech\Wip\io::isJson($argv[1]);
}
$rid=$_GET['rid'];if(!$rid)die('?rid=');$_ENV['dieOnFirstError']=1;
$mysql58groupMode=Alptech\Wip\fun::sql("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
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
