<?php
/*
https://ehpad.home/xlsStats
gu;list;phpx ~/home/ehpad/app/z/json2excel.php;say tsv exported
 */
namespace Alptech\Wip;chdir(__DIR__);require_once'../autoload.php';
if(!$included and !isset($argv))die('no argv nor included');

register_shutdown_function(function(){@unlink(__file__.'.lock');});
if(is_file(__file__.'.lock'))die('locked:'.date('Ymd H:is',filemtime(__file__.'.lock')).';;'.__file__.'.lock');
touch(__file__.'.lock');ini_set('max_execution_time',-1);

$sep="\t";
$x=glob('curlcache/*https-www.pour-les-personnes-agees.gouv.fr-api-v1-establishment-json');
$x=end($x);
if(!$x)die('#noFile');
$tsvF=str_replace(['curlcache/','https-www.pour-les-personnes-agees.gouv.fr-api-v1-establishment-json'],['xls/',''],$x).'.tsv';
$rp=$tsvF.'.xlsx';

if(is_file($rp)){fun::r302('/z/'.$rp);}#die("file::$rp");
if(is_file($tsvF)){fun::r302('/z/'.$tsvF);}#die("file::$tsvF");

$x=io::fgc($x);
$x=io::isJson($x);
$fields=$data=[];
foreach($x as $t){
    $t2=[];
    foreach($t as $k=>$v){
        if(is_array($v) and $v){
            foreach($v as $k2=>$v2){
                if(!is_array($v2) and $v2){
                    $t2[$k.'_'.$k2]=_c($v2);
                }
            }
        } elseif($v){
            $t2[$k]=_c($v);
        }
    }
/* It might take a while (......) ....... ....... ........ .......
if(isset($t['coordinates']) and is_array($t['coordinates'])){
    foreach($t['coordinates'] as $k=>$v){
        if(!isset($t2[$k]) and $v)$t2[$k]=$v;
        elseif($v){}
    }
}
*/
    $fields=array_merge($fields,array_keys($t2));#ceux trouvée
    $data[]=$t2;
}

$fields=array_unique($fields);
$tsv=[$fields];
$tsv2=[implode($sep,$fields)];
foreach($data as $t){
    $line=[];
    foreach($fields as $field){
        if(isset($t[$field]) and $t[$field]){$line[]=$t[$field];}
        else $line[]='';
    }
    $tsv[]=$line;
    $tsv2[]=implode($sep,$line);
}

$__ok=file_put_contents($tsvF,implode("\n",$tsv2));unset($tsv2);$tsv2=null;

try{
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    $reader->setDelimiter($sep);
    $spreadsheet = $reader->load($tsvF);
/*
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle(substr(preg_replace('~[^a-z0-9 \.]+~is','','extraction'),0,31));#31 max chars '.$historyData['body']['request']['adresse'].','.$historyData['body']['request']['perimetre']);
    $cols=[];$letter = 'A';while ($letter !== 'AAA') {$cols[] = $letter++;}
    $sheet->getCell('A1')->setValue('extraction');
    if ('parcours des données .. cela est long ... so long ..') {
        foreach ($tsv as $l => $t) {
            foreach ($t as $c => $v) {
                $x = $cols[$c];
                $coord = $x . '' . $l;
                #$coord = $x . '' . ($l + 2);#démarre à la seconde ligne -- car headers posés
                $sheet->getCell($coord)->setValue($v);
            }
        }
    }
*/
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);$writer->save($rp);
    fun::r302('/z/'.$rp);echo $rp;
}catch(\Exception $e){
    $a=1;print_r($e);
}

$a=1;
function _c($x){
    if(strpos($x,"\r") or strpos($x,"\n") or strpos($x,"\t"))$x=preg_replace("~[\r\n\r]+~is",' ',$x);
    if(strpos($x,"[separateur]"))$x=str_replace('[separateur]','-',$x);
    return $x;
}

return;?>
https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/010001246#MARPA::F1
https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/390006211#MARPA::F1
tsv,xlsx;
