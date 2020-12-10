<?php /*
phpx  ~/home/ehpad/app/z/tests/excel.php
 */
chdir(__DIR__);die;
require_once '../../autoload.php';
$a=json_decode('{"request":{"adresse":"boulogne","latitude":"46.7947224","longitude":"-1.3210389","statut":"aucun","perimetre":"5"},"response":[{"nid":"44489","title":"EHPAD Les Glycines","field_statut_value":"Public","field_location_locality":"ST DENIS LA CHEVASSE","field_location_postal_code":"85170","field_tarif_chambre_simple_value":"NA","field_gestionnaire_value":"CCAS St Denis la Chevasse","field_latitude_value":"46.822174","field_longitude_value":"-1.360569","name":"85 - Vend\u00e9e","grp_term_name":"Default","field_logo_fid":"14","distance":"4.2858621205721255"}]}',1);
#

$t=$a['response'][0];unset($t['nid'],$t['field_logo_fid']);
$headers=array_keys($t);
$translate=['title'=>'titre','field_statut_value'=>'type','field_location_locality'=>'ville','field_location_postal_code'=>'code postal','field_tarif_chambre_simple_value'=>'tarif chambre','field_gestionnaire_value'=>'gestionnaire','field_latitude_value'=>'latitude','field_longitude_value'=>'longitude','name'=>'département','distance'=>'distance en km'];
foreach($headers as &$v){
    if(isset($translate[$v])){$v=$translate[$v];}
    $v=str_replace(['field_','_value',],'',$v);
    $b=1;
}unset($v);
$lines=[$headers];
foreach($a['response'] as $k=>$t){
    if(is_object($t))$t=(array)$t;
    unset($t['nid'],$t['field_logo_fid']);
    $lines[]=array_values($t);
}

$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Résultats de recherche');
$line=1;
#$cols=range('A','ZZ');
$cols=[];$letter = 'A';while ($letter !== 'AAA') {$cols[] = $letter++;}

try{
    foreach($lines as $l=>$t){
        foreach($t as $c=>$v){
            $x=$cols[$c];
            $coord=$x.''.($l+1);
            $sheet->getCell($coord)->setValue($v);
        }
    }
$a=1;
// Increase row cursor after header write
#$sheet->fromArray($this->getData(),null, 'A2', true);
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('helloworld.xlsx');
}catch(\Exception $e){
    $a=1;
}
$b=1;
return;?>
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save("05featuredemo.xlsx");
