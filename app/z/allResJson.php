<?php
#php72 ~/home/ehpad/app/z/allResJson.php
chdir(__DIR__);
$_a=file_get_contents('201128105147toutesResidences.json');
$_a=json_decode($_a,1);
/*
Drupal 7 multisite
residenceSenior.silverpricing => same alias
residence.typeResidence={Ehpad,residence,} ..
https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/search?longitude=2.3577861688909&latitude=48.87180125&rayon=10
*/
foreach($_a as $k=>$a){
    if(!isset($a["noFinesset"]) or !$a["noFinesset"]){
        $b=1;
    }
    #hors médical / social $a["noFinesset"]
    if($a['IsEHPA'] or $a['IsRa'] or $a['IsF1'] or $a['IsF1Bis'] or $a['IsF2']){#superficie chambre, montants services / charges
        $nestPasEhpad=1;#=> résidence Senior Silverpricing =>
    } elseif($a['IsF1']){#Résidence Autonomie F1,F1Bis,F2
        $b=1;
    } elseif($a['IsRa']){#Résidence Autonomie
        $b=1;
    }
}
$a=1;
return;?>
IsHAB_AIDE_SOC
IsF1
IsRa
