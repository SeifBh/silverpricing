<?php
/*
id2latlon:7522
7517 having total found 154250 with 20.520154316882
processed in Time::::219(base)
php74 ~/home/ehpad/app/z/geo.php reindex

ssh ubuntu@ehpad.silverpricing.fr
php7.1 /home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/z/geo.php reindex

8122 having total found 1637712 with 201.63900517114
8123 insertions
processed in :3105 secondsArray
 */
namespace Alptech\Wip;
ini_set('memory_limit',-1);ini_set('max_execution_time',-1);
$maxFound=200;$maxKmSearch=$radius=round(200/2);

if(!isset($GLOBALS['argv']) and !isset($_SESSION)){die('#'.__line__);}
$_mem=[__line__=>memory_get_usage(1)];
chdir(__DIR__);
$a=getcwd();
require_once'../autoload.php';
#use Alptech\Wip\fun as fun;
$a1=$now=time();
echo "\nmaxFound:$maxFound,maxKmSearch:$maxKmSearch";

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
$jeubase=md5(json_encode($id2latlon)).'a';#hype algo
#die("update z_geo set jeu='$jeubase' where 1");
#
$_mem=[__line__=>memory_get_usage(1)];
echo"\ngeo.php => nb ResidencesLatLon:".count($id2latlon);
$_inserts=$closests=$dist=$exists=[];$cfound=0;

$x=fun::sql('select rid,list,jeu from z_geo');
foreach($x as $t){$id=$t['rid'];unset($t['rid']);$exists[$id]=$t;}

foreach($id2latlon as $kId=>$latlon){
    if(isset($exists[$kId]) and $jeubase==$exists[$t['rid']]['jeu'])continue;

    $x1=$x2=$i=0;$j++;#echo','.$j;
    $found=$searched=$list=$clo10=$clo20=[];
    $latBase=$latlon[2];$lonBase=$latlon[3];
    $lats=[$latBase];$lons=[$lonBase];
#count($found)<$maxFound => needed for speed !! , mais peut hélas tronquer le nombre de résultats alors que chaque incrémentation en retourne exponentiellement plus 8 cases à chaque grossissement non inscrites au sein d'un cercle ..
    while(count($found)<$maxFound and $i<$maxKmSearch) {#car on peut trouver masse de choses plus la couronne grandit !
        /* Puis on élargi  le scope*/
        $max=0;
        if($i>0){
            $lats[]=$latBase+$i;$lons[]=$lonBase+$i;#plus
            $lats[]=$latBase-$i; $lons[]=$lonBase-$i;#minus
            $max=hypot($i,$i);#;$i,2));#hypothenuse, rayon du cercle désiré
            #$max=sqrt(pow($i,2)+pow($i,2));#hypothenuse
        }

        foreach ($lats as $lat) {
            foreach ($lons as $lon) {#de la croix au carré
                if (isset($searched[$lat . ',' . $lon])) {Continue;}#si déjà fait
                $xdelta=abs($lon-$lonBase);
                $ydelta=abs($lat-$latBase);
                #$hype=sqrt(pow($xdelta,2)+pow($ydelta,2));
                $hype=$xdelta+$ydelta;
                #$hype=hypot($xdelta,$ydelta);
                if($hype>$max){
                    $a="toofaryet--outside the circle's radius -- sera traitée plus tard";
                    continue;
                }
                $a=1;
                $x1=$x2=0;$searched[$lat . ',' . $lon] = 1;
                if(isset($_lat[$lat]))$x1=$_lat[$lat];
                if(isset($_lon[$lon]))$x2=$_lon[$lon];
                if($x1 and $x2){#en excluant lui même , ce qui est logique .. pour le premier uniquement au same coordinates
                    $new=array_intersect($x1,$x2);
                    if($new){
                        foreach($new as $id){
                            if($id==$kId){#self, normal
                                continue;
                            }
                            if(!in_array($id,$found)){
                                if($latlon[0]==$id2latlon[$id][0] and$latlon[1]==$id2latlon[$id][1]){
                                    $err='same';
                                    continue;
                                }
                                $distance=distance($latlon[0],$id2latlon[$id][0],$latlon[1],$id2latlon[$id][1]);
                                $dk=$kId.'-'.$id;$dk2=$id.'-'.$kId;if(!isset($dist[$dk]) and !isset($dist[$dk2])){$dist[$dk]=$distance;}#keep real metric distances excluding oposite statement
                                $distance=intval($distance);
                                $closests[$kId][$distance][]=$id;#pour le tri final km par km
                            }
                        }
                        if($i==0){#self excluding initial point
                            $intersect=array_diff($new,[$kId]);
                            if($intersect) {
                                $found = array_unique(array_merge($found, $intersect));
                                $a=1;
                            }
                        }else{
                            $found = array_unique(array_merge($found,$new));
                            $a=1;
                        }
                    }
                }
            }
        }
        $i++;
    }

    ksort($closests[$kId]);
    foreach($closests[$kId] as $d=>$t){
        foreach($t as $v){
            $list[]=$v;#ordonnancer la liste dans le bon ordre
            if(count($list)>=$maxFound)break 2;
            #if(count($list)>=20)break 2;
        }
    }
    $clo20=array_slice($list,0,20);
    $clo10=array_slice($list,0,10);
    $a=1;

    $ilist=','.implode(',',$list).',';
    if(isset($exists[$kId])){
        #$md5f=md5($found);
        if($jeubase==$exists[$t['rid']]['jeu'] and $ilist==$exists[$t['rid']]['list']){
            Continue;#dont need to update a single thing !
        }
        $s='update z_geo set upd='.$now.',jeu="'.$jeubase.'",clo10=",'.implode(',',$clo10).',",clo20=",'.implode(',',$clo20).',",list="'.$ilist.'",closest=\''.json_encode($closests[$kId]).'\' where rid='.$kId;#values('.$kId.',",'.implode(',',$clo10).',",",'.implode(',',
        $ok=fun::sql($s);if(!$ok){$err=1;}#si cardinalités 0,1,2,3,4 à la suite alors array
    }else{#delayed, atomic opeations
        $s='insert into z_geo (rid,clo10,clo20,list,closest,upd,jeu)values('.$kId.',",'.implode(',',$clo10).',",",'.implode(',',$clo20).'","'.$ilist.'",\''.json_encode($closests[$kId]).'\','.$now.',"'.$jeubase.'")';
        $ok=fun::sql($s);if(!$ok){$err=1;}
    }
    $_inserts[]=$s;
}

ksort($closests);
file_put_contents('distances.json',json_encode($dist));
file_put_contents('closests.json',json_encode($closests));
file_put_contents('geoinserts.json',json_encode($_inserts));
$a2=time();
$ratio=$cfound/count($closests);
$_mem=[__line__=>memory_get_usage(1)];

$i=0;
if(0){
foreach($_inserts as $insert){
    $ok=fun::sql($insert);#si cardinalités 0,1,2,3,4 à la suite alors array
    if(!$ok){
        $err=1;
    }
    $i++;
}
}
echo"\n".count($closests)." having total found $cfound with $ratio\n".count($_inserts)." insertions
\nprocessed in :".($a2-$a1).' seconds';
print_r($_mem);
return;

#$x=fun::sql("truncate table z_geo");





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
