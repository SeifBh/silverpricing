<?php
/*
 * => Lancer => enregister anciennes références
Rectifier les anciens numéro, supprimer les nouveaux
& codes postaux

 * suppression de celle qui n'ont pas de status rempli
 * 31701 a status=public,
https://ehpad.home/z/finess.php
x1=`php -r 'echo md5(json_encode([47236,32855]));'`;echo $x;#Par liste de notifiées
php72 ~/home/ehpad/app/z/finess.php '{"rids":"47236,32855","m83":"'$x1'"}'
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

$old2new=$finess2id=[];
$x=Alptech\Wip\fun::sql("select entity_id as k,field_finess_value as v from field_data_field_finess");
foreach($x as $t){$finess2id[$t['v']]=$t['k'];}
foreach($x as $t){if(isset($finess2id['0'.$t['v']])){$old2new[$t['k']]=$finess2id['0'.$t['v']];}}
$old=array_keys($old2new);

$x=Alptech\Wip\fun::sql("select entity_id as k from field_data_field_residence where field_residence_target_id in(".implode(',',$old).")");   foreach($x as $t){$chambres[]=$t['k'];}

foreach($old2new as $old=>$new){#savoir quelles sont les infos que l'on souhaite conserver de ces dernières

}

$keys=array_merge(array_keys($old2new),$chambres);

file_put_contents('z_keys.'.$date.'.json',json_encode($keys));#
#file_put_contents('z_old.'.$date.'.json',json_encode($old));#
#file_put_contents('z_chambres.'.$date.'.json',json_encode(array_keys($chambres)));#
file_put_contents('z_old2new.'.$date.'.json',json_encode($old2new));

$tables=[];
$x=Alptech\Wip\fun::sql("select table_name from information_schema.tables where table_schema='silverpricing_db' and table_name like'field_data_%'");foreach($x as $t){$tables[]=$t['table_name'];}
$x=Alptech\Wip\fun::sql("select table_name from information_schema.tables where table_schema='silverpricing_db' and table_name like'field_revision_%'");foreach($x as $t){$tables[]=$t['table_name'];}
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
