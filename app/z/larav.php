<?php
#gu;list;phpx ~/home/ehpad/app/z/larav.php
namespace Alptech\Wip;die;chdir(__DIR__);require_once'../autoload.php';#todo:rename to ajax
$h='larav';
#$h='laravProd';
if(1){
#$ids=io::fgc('/c/Users/ben/Desktop/etablissements-prescripteurs.txt');
$ids=file_get_contents('c:/Users/ben/Desktop/etablissements-prescripteurs.txt');
$a=1;
$x=fun::sql("update health_organizations set prescripteur=1 where id in(".$ids.")",$h);#laravProd
}
$x=fun::sql("select prescripteur,id from health_organizations where prescripteur=1 limit 10",$h);
$a=1;
