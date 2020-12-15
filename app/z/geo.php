<?php
/*
id2latlon:7522
7517 having total found 154250 with 20.520154316882
processed in Time::::219(base)
php z/geo.php reindex
 */
namespace Alptech\Wip;
if(!isset($GLOBALS['argv']) and !isset($_SESSION)){die('#'.__line__);}
$_mem=[__line__=>memory_get_usage(1)];
chdir(__DIR__);
$a=getcwd();
require_once'../autoload.php';
#use Alptech\Wip\fun as fun;
$a1=time();
$maxFound=20;
$maxKmSearch=round(50/2);
/*
phpx ~/home/ehpad/app/z/geo.php
*/
#$ga=\Alptech\Wip\fun::sql([__FILE__.__line__,'missing b64'],'php500');
#$_minLat=fun::sql("select min(field_latitude_value) as v from field_data_field_latitude where bundle='residence'")[0]['v'];$_minLon=fun::sql("select min(field_longitude_value) as v from field_data_field_longitude where bundle='residence'")[0]['v'];
$_maxLat=fun::sql("select max(field_latitude_value) as v from field_data_field_latitude where bundle='residence'")[0]['v'];$_maxLon=fun::sql("select max(field_longitude_value) as v from field_data_field_longitude where bundle='residence'")[0]['v'];
#Respectivement à maxlong

$id2latlon=$_lat=$_lon=[];
$x=fun::sql("select a.entity_id as k,a.field_longitude_value as lon,b.field_latitude_value as lat from field_data_field_longitude a inner join field_data_field_latitude b on b.entity_id=a.entity_id where a.bundle='residence'");
foreach($x as $t){
    $sLat=shortLat($t['lat']);
    $sLon=shortLon($t['lon']);
    $_lat[$sLat][]=$t['k'];
    $_lon[$sLon][]=$t['k'];
    $id2latlon[$t['k']]=[$t['lat'],$t['lon'],$sLat,$sLon];
}
$_mem=[__line__=>memory_get_usage(1)];
echo"\ngeo.php => nb ResidencesLatLon:".count($id2latlon);
$closests=[];$cfound=0;

$x=fun::sql("truncate table z_geo");

foreach($id2latlon as $kId=>$latlon){
    $x1=$x2=$i=0;$j++;
    $found=$searched=[];
    $latBase=$latlon[2];$lonBase=$latlon[3];
    $lats=[$latBase];$lons=[$lonBase];

    while(count($found)<$maxFound and $i<$maxKmSearch) {
        /* Puis on élargi  le scope*/
        if($i>0){
            $lats[]=$latBase+$i;$lons[]=$lonBase+$i;#plus
            $lats[]=$latBase-$i; $lons[]=$lonBase-$i;#minus
        }
        foreach ($lats as $lat) {
            foreach ($lons as $lon) {
                if (isset($searched[$lat . ',' . $lon])) {#si déjà fait
                    continue;
                }
                $searched[$lat . ',' . $lon] = 1;
                if(isset($_lat[$lat]))$x1=$_lat[$lat];
                if(isset($_lon[$lon]))$x2=$_lon[$lon];
                if($x1 and $x2){#en excluant lui même , ce qui est logique
                    $intersect=array_diff(array_intersect($x1,$x2),[$kId]);
                    if($intersect) {
                        $found = array_unique(array_merge($found, $intersect));
                        $a=1;
                    }
                }
            }
        }
        $i++;
    }
    if($found){
        $cfound+=count($found);
        foreach($found as $id){
            $distance=distance($latlon[0],$id2latlon[$id][0],$latlon[1],$id2latlon[$id][1]);
            $closests[$kId][$distance][]=$id;#plusieurs possibles bien entendu ;)
        }
        ksort($closests[$kId]);
        $a=1;
    }
    $x=fun::sql('insert into z_geo (rid,list,closest)values('.$kId.',",'.implode(',',$found).',",\''.json_encode($closests[$kId]).'\')');
    continue;
/*
    while(count($found)<$maxFound and $i<$maxKmSearch){
        $i++;
        if('recherche en croix'){
            $x1=$_lat[$lat+$i];$x2=$_lon[$lon+$i];#plus
            $x3=$_lat[$lat-$i];$x4=$_lon[$lon-$i];#minus
        }
        if($x1 and $x2){
            $intersect=array_intersect($x1,$x2);
            if($intersect) {
                $a = 1;
                $found = array_unique(array_merge($found, $intersect));
            }
        }
        if($x3 and $x4){
            $intersect=array_intersect($x3,$x4);
            if($intersect) {
                $a = 1;
                $found = array_unique(array_merge($found, $intersect));
            }
        }
        $a=1;
    }
*/
}

ksort($closests);
file_put_contents('closests.json',json_encode($closests));
$a2=time();
$ratio=$cfound/count($closests);
$_mem=[__line__=>memory_get_usage(1)];
echo"\n".count($closests)." having total found $cfound with $ratio\nprocessed in :".($a2-$a1).' seconds';
print_r($_mem);
return;


$a=1;
function distance($lat1,$lat2,$lng1,$lng2)
{
    $pi80 = M_PI / 180;#1 rad
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;

    $r = 6372.797; // rayon moyen de la Terre en km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;
    return $km;
}
function shortLon($x){
    global $_maxLon;$kmPerDegreeLon=78.5;#km per degré at 45°
    return round(78.5*($x-$_maxLon));
}
function shortLat($x){
    global $_maxLat;$kmPerDegreeLat=111;
    return round(111*($x-$_maxLat));
}
return;?>
foreach($id2latlon as $k=>$latlon){

}
#

$a=1;
$ga=fun::sql('select * from field_data_field_longitude');
$ga=fun::sql('select * from distance_indexation');
echo $a;
$a=1;





return;?>

$x=fun::sql("select entity_id as k,field_latitude_value as v from field_data_field_latitude where bundle='residence'");
foreach($x as $t){
$short=shortLat($t['v']);
$_lat[$short][]=$t['k'];
$id2latlon[$t['k']]=[$t['v'],0,$short,0];
}

$x=fun::sql("select entity_id as k,field_longitude_value as v from field_data_field_longitude where bundle='residence'");
foreach($x as $t){
$short=shortLon($t['v']);
$_lon[$short][]=$t['k'];
$id2latlon[$t['k']][1]=$t['v'];
$id2latlon[$t['k']][3]=$short;
}
