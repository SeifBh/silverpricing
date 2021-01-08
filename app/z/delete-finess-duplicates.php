<?php /*
 export PHP_IDE_CONFIG=serverName=ehpad.home;php72 ~/home/ehpad/app/z/delete-finess-duplicates.php
 * => Lancer => enregister anciennes références
Rectifier les anciens numéro, supprimer les nouveaux
& codes postaux

 * suppression de celle qui n'ont pas de status rempli
 * 31701 a status=public,
https://ehpad.home/z/delete-finess-duplicates.php
x1=`php -r 'echo md5(json_encode([47236,32855]));'`;echo $x;#Par liste de notifiées

obtenir les variations les plus récentes de prix
*/
$date=date('YmdHis');
#$dateLimite=strtotime('1 month ago');

if('cli emulation'){
    $_SERVER['DOCUMENT_ROOT']=__DIR__.'/../';chdir(__DIR__);
    require_once "../vendor/autoload.php";#alptech
    if(isset($argv) and $argv[1]){
        $_GET=Alptech\Wip\io::isJson($argv[1]);
    }
}

$h='mysql';
#$h='mysqlProd';_confirm($h);

$f='backups/z_old2new.json';
if(0){
    if(is_file($f)) {$old2new = json_decode(file_get_contents($f), 1);}$new2old=array_flip($old2new);die($new2old[47236]);
    $x=Alptech\Wip\fun::sql("select entity_id as k,field_finess_value as v from field_data_field_finess where entity_id in(".implode(',',array_keys($old2new)).")",$h);
    $a=1;

    die('Run Once And Destroy !!');
    $_ENV['dieOnFirstError']=1;
}

if('extraction:list of tables'){
    $tables=explode(',','field_data_body,field_data_comment_body,field_data_field_acces_groupes,field_data_field_acces_residences,field_data_field_accueil_de_jour,field_data_field_aide_sociale,field_data_field_alerts,field_data_field_alzheimer,field_data_field_balance,field_data_field_balance_consumed,field_data_field_capacite,field_data_field_cd_aide_sociale_lits,field_data_field_cd_aide_sociale_tarif,field_data_field_cd_standard_lits,field_data_field_cd_standard_tarif,field_data_field_cs_aide_sociale_lits,field_data_field_cs_aide_sociale_tarif,field_data_field_cs_alzheimer_lits,field_data_field_cs_alzheimer_tarif,field_data_field_cs_entree_de_gamme_lits,field_data_field_cs_entree_de_gamme_tarif,field_data_field_cs_luxe_lits,field_data_field_cs_luxe_tarif,field_data_field_cs_standard_lits,field_data_field_cs_standard_tarif,field_data_field_cs_superieur_lits,field_data_field_cs_superieur_tarif,field_data_field_date_de_modification,field_data_field_departement,field_data_field_department_request,field_data_field_designation,field_data_field_developpement_tool_request,field_data_field_email,field_data_field_excel,field_data_field_favoris,field_data_field_features,field_data_field_file_image_alt_text,field_data_field_file_image_title_text,field_data_field_finess,field_data_field_gestionnaire,field_data_field_groupe,field_data_field_group_request,field_data_field_image,field_data_field_images,field_data_field_latitude,field_data_field_location,field_data_field_logo,field_data_field_longitude,field_data_field_map,field_data_field_name,field_data_field_nombre_cd_aide_sociale,field_data_field_nombre_cd_standard,field_data_field_nombre_cs_aide_sociale,field_data_field_nombre_cs_alzheimer,field_data_field_nombre_cs_entre_de_gamme,field_data_field_nombre_cs_luxe,field_data_field_nombre_cs_standard,field_data_field_nombre_cs_superieur,field_data_field_plan,field_data_field_plans,field_data_field_residence,field_data_field_residence_request,field_data_field_schedule,field_data_field_site,field_data_field_statut,field_data_field_tags,field_data_field_tarif,field_data_field_tarif_cd_aide_sociale,field_data_field_tarif_chambre_double,field_data_field_tarif_chambre_double_tempo,field_data_field_tarif_chambre_simple,field_data_field_tarif_chambre_simple_tempo,field_data_field_tarif_cs_aide_sociale,field_data_field_tarif_gir_1_2,field_data_field_tarif_gir_3_4,field_data_field_tarif_gir_5_6,field_data_field_telephone,field_data_field_tmh,field_data_field_types_de_chambres,field_data_field_url_source,field_data_field_uuid,field_data_node_gallery_media,field_data_node_gallery_ref_1,field_revision_body,field_revision_comment_body,field_revision_field_acces_groupes,field_revision_field_acces_residences,field_revision_field_accueil_de_jour,field_revision_field_aide_sociale,field_revision_field_alerts,field_revision_field_alzheimer,field_revision_field_balance,field_revision_field_balance_consumed,field_revision_field_capacite,field_revision_field_cd_aide_sociale_lits,field_revision_field_cd_aide_sociale_tarif,field_revision_field_cd_standard_lits,field_revision_field_cd_standard_tarif,field_revision_field_cs_aide_sociale_lits,field_revision_field_cs_aide_sociale_tarif,field_revision_field_cs_alzheimer_lits,field_revision_field_cs_alzheimer_tarif,field_revision_field_cs_entree_de_gamme_lits,field_revision_field_cs_entree_de_gamme_tarif,field_revision_field_cs_luxe_lits,field_revision_field_cs_luxe_tarif,field_revision_field_cs_standard_lits,field_revision_field_cs_standard_tarif,field_revision_field_cs_superieur_lits,field_revision_field_cs_superieur_tarif,field_revision_field_date_de_modification,field_revision_field_departement,field_revision_field_department_request,field_revision_field_designation,field_revision_field_developpement_tool_request,field_revision_field_email,field_revision_field_excel,field_revision_field_favoris,field_revision_field_features,field_revision_field_file_image_alt_text,field_revision_field_file_image_title_text,field_revision_field_finess,field_revision_field_gestionnaire,field_revision_field_groupe,field_revision_field_group_request,field_revision_field_image,field_revision_field_images,field_revision_field_latitude,field_revision_field_location,field_revision_field_logo,field_revision_field_longitude,field_revision_field_map,field_revision_field_name,field_revision_field_nombre_cd_aide_sociale,field_revision_field_nombre_cd_standard,field_revision_field_nombre_cs_aide_sociale,field_revision_field_nombre_cs_alzheimer,field_revision_field_nombre_cs_entre_de_gamme,field_revision_field_nombre_cs_luxe,field_revision_field_nombre_cs_standard,field_revision_field_nombre_cs_superieur,field_revision_field_plan,field_revision_field_plans,field_revision_field_residence,field_revision_field_residence_request,field_revision_field_schedule,field_revision_field_site,field_revision_field_statut,field_revision_field_tags,field_revision_field_tarif,field_revision_field_tarif_cd_aide_sociale,field_revision_field_tarif_chambre_double,field_revision_field_tarif_chambre_double_tempo,field_revision_field_tarif_chambre_simple,field_revision_field_tarif_chambre_simple_tempo,field_revision_field_tarif_cs_aide_sociale,field_revision_field_tarif_gir_1_2,field_revision_field_tarif_gir_3_4,field_revision_field_tarif_gir_5_6,field_revision_field_telephone,field_revision_field_tmh,field_revision_field_types_de_chambres,field_revision_field_url_source,field_revision_field_uuid,field_revision_node_gallery_media,field_revision_node_gallery_ref_1');

}
elseif('tablesNotListed'){
$tables=[];
$x=Alptech\Wip\fun::sql("select table_name from information_schema.tables where table_schema='silverpricing_db' and table_name like'field_data_field_%'",$h);foreach($x as $t){$tables[]=$t['table_name'];}
$x=Alptech\Wip\fun::sql("select table_name from information_schema.tables where table_schema='silverpricing_db' and table_name like'field_revision_field_%'",$h);foreach($x as $t){$tables[]=$t['table_name'];}
$_a=implode(',',$tables);
}

$f='z_old2new.json';if(0 and is_file($f)){
    $old2new=json_decode(file_get_contents($f),1);
    $a=1;
}else{
/*
select field_location_postal_code,right(field_location_postal_code,5) from field_data_field_location where length(field_location_postal_code)>5
select field_finess_value,right(field_location_postal_code,9) from field_data_field_finess where length(field_finess_value)>9
 */
    $old2new=$finess2id=$more9digits=[];
    $x=Alptech\Wip\fun::sql("select entity_id as k,field_finess_value as v from field_data_field_finess",$h);
    foreach($x as $t){$finess2id[$t['v']]=$t['k'];}
    foreach($x as $t){
        if(strlen($t['v'])>9){#rectifier l'ancienne et affecter valeurs nouvelle
            $last9digits=substr($t['v'],-9);
            $fin2new[$t['v']]=$last9digits;
            if(isset($finess2id[$last9digits])){
                $more9digits[]=$t['k'];
                $old2new[$t['k']]=$finess2id[$last9digits];
                continue;
            }
        }
        if(strlen($t['v'])<9 and isset($finess2id['0'.$t['v']])){
            $old2new[$t['k']]=$finess2id['0'.$t['v']];
        }
    }
    file_put_contents($f,json_encode($old2new));#
}

if(!$old2new)die('no duplicates');

$new2old=array_flip($old2new);$old=array_values($new2old);$new=array_values($old2new);

$s=$data=[];
if('keepOldData'){
    foreach($tables as $t) {
        $c = $t . '_value';#ou c_tid
        if(strpos($t,'field_images'))$c='field_images_fid';
        elseif(strpos($t,'field_image'))$c='field_image_fid';
        elseif(strpos($t,'field_acces_groupes') or strpos($t,'field_acces_residences'))$c = $t . '_target_id';
        elseif(strpos($t,'_departement') or strpos($t,'_designation') or strpos($t,'_groupe'))$c = $t . '_tid';
        $c=str_replace('field_data_field_','field_',$c);
        #select entity_id as k,field_statut_value as v from field_data_field_statut
        #$c as v
        $x = Alptech\Wip\fun::sql("select * from $t where entity_id in(" . implode(',', $new) . ")",$h);
        foreach($x as $t2){
            $id=$t2['entity_id'];unset($t2['id']);
            $data[$t][$id]=$t2;
        }
    }
    file_put_contents('z_data.'.$date.'.json',json_encode($data));#
}
if('updatesData with old identifiers'){
    $a=1;
    foreach($new2old as $knew=>$kold){#swap images once
        $s[]="update field_revision_field_images set entity_id=$kold where entity_id=$knew";
        $x=Alptech\Wip\fun::sql(end($s),$h);
        $s[]="update field_data_field_images set entity_id=$kold where entity_id=$knew";
        $x=Alptech\Wip\fun::sql(end($s),$h);
    }
    $f='finess';
    $s[]="update field_data_field_$f set field_".$f."_value=concat('0',field_".$f."_value) where entity_id in(".implode(',',$old).")";#run
    $x=Alptech\Wip\fun::sql(end($s),$h);
    $s[]="update field_revision_field_$f set field_".$f."_value=concat('0',field_".$f."_value) where entity_id in(".implode(',',$old).")";
    $x=Alptech\Wip\fun::sql(end($s),$h);#run

    $s[]="update field_data_field_location set field_location_postal_code=concat('0',field_location_postal_code)where entity_id in(".implode(',',$old).")";
    $x=Alptech\Wip\fun::sql(end($s),$h);#run
    $s[]="update field_revision_field_location set field_location_postal_code=concat('0',field_location_postal_code)where entity_id in(".implode(',',$old).")";
    $x=Alptech\Wip\fun::sql(end($s),$h);#run

    $x=Alptech\Wip\fun::sql("select entity_id as k from field_data_field_residence where field_residence_target_id in(".implode(',',$new).")",$h);   foreach($x as $t){$chambres[]=$t['k'];}
    $keys=array_merge($new,$chambres);

    $s[]="delete from z_geo where rid in(".implode(',',$new).")";
    $x=Alptech\Wip\fun::sql(end($s),$h);
    $s[]="delete from z_variations where rid in(".implode(',',$new).")";
    $x=Alptech\Wip\fun::sql(end($s),$h);
    $a=1;
}

if(!$keys){
    die('no keys');
}

foreach($tables as $t){
    $s[]='delete from '.$t.' where entity_id in('.implode(',',$keys).')';
    $x=Alptech\Wip\fun::sql(end($s),$h);
    $s[]='delete from '.$t.' where entity_id in('.implode(',',$keys).')';
    $x=Alptech\Wip\fun::sql(end($s),$h);
}
$s[]='delete from node where nid in('.implode(',',$keys).')';
    $x=Alptech\Wip\fun::sql(end($s),$h);
$s[]='delete from node_revision where nid in('.implode(',',$keys).')';
    $x=Alptech\Wip\fun::sql(end($s),$h);

file_put_contents('z_new.'.$s.'.json',implode(";\n",$s).';');#
return;
die;

function _confirm($h)
{
    echo "Confirm action $h ? type 'y' then enter : ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) != 'y') {
        die('action not confirmed');
    }
    fclose($handle);
}

?>


$finess=[];
# once and destroy
$s="select entity_id as k,field_".$f."_value as v from field_data_field_$f where entity_id in(".implode(',',$old).")";
$x=Alptech\Wip\fun::sql($s);   foreach($x as $t){$finess[$t['k']]=$t['v'];}
$s=[];#




die;
file_put_contents('z_keys.'.$date.'.json',json_encode($keys));#
#file_put_contents('z_old.'.$date.'.json',json_encode($old));#
#file_put_contents('z_chambres.'.$date.'.json',json_encode(array_keys($chambres)));#
file_put_contents('z_old2new.'.$date.'.json',json_encode($old2new));

/*
 affectée à un groupe
 */
$s=$data=[];
foreach($tables as $t){
    $c=$table.'_value';
    #select entity_id as k,field_statut_value as v from field_data_field_statut
    $data[$t]=Alptech\Wip\fun::sql("select entity_id as k,$c as v from $t  where entity_id in(".implode(',',$keys).")");
    $s[]='delete from '.$t.' where entity_id in('.implode(',',$keys).')';
    $s[]='delete from '.$t.' where entity_id in('.implode(',',$keys).')';
}
$s[]="delete from node where nid in(".implode(',',$keys).")";
file_put_contents('z_delete.'.$date.'.json',implode(";\n",$s).';');

return;die;
$id2finess=array_flip($finess2id);#520 références !!
$a=1;
