<?php
#gu;list;phpx ~/home/ehpad/app/z/larav.php
namespace Alptech\Wip;chdir(__DIR__);require_once'../autoload.php';#todo:rename to ajax
/*
 * https://stackoverflow.com/questions/43191812/how-to-speed-up-the-haversine-formula-in-mysql
 * obtenir distance pour un degré d'écart en notation décimale
 */
$olat=46;$olon=2;$dist=5;
$x=fun::shortDist($olat,$olon,$dist);
print_r($x);
die;

$latDegDist=fun::distance($olat,$olat+1,$olon,$olon);#updown::  111 km par deg
$lonDegDist=fun::distance($olat,$olat,$olon,$olon+1);#rightleft:: 77 km
$dlon=$dist/$lonDegDist;
$dlat=$dist/$latDegDist;
$rect=[$olat-$dlat,$olat+$dlat,$olon-$dlon,$olon+$dlon];
$a=1;
die;


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
