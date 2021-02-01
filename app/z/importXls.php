<?#phpx ~/home/ehpad/app/z/importXls.php
namespace Alptech\Wip;chdir(__DIR__);require_once'../autoload.php';
if(!$included and !isset($argv))die('no argv nor included');
#upon file upload ....
#$file='c:/desk/roland2z_people.xls';
#require_once'/z/importXls.php';
__main($file);

function __main($file){
    if(!is_file($file))die('#'.__line__);
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    if (!$spreadsheet) {
        $json['error'][$file][] = "cant load spreadsheet";
        die('cant load spreadsheet');
    }

    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();
    foreach($rows as &$t){$t=array_filter($t);}unset($t);$rows=array_filter($rows);
    $fields=array_shift($rows);
    $r2field=explode(',','finess,service,fonction,titre,nom,prenom,adresse,codepostal,ville,telephone,email,commentaire');
    #750803371

    foreach($fields as &$t)$t=_u($t);unset($t);
    #,nom,prenom,email
    $existing=[];$s='select id,md5 from professionels_sante';$x=fun::sql($s,'larav');
    foreach($x as $t){$existing[$t['md5']]=$t['id'];}

    foreach($rows as $t){
        $t2=[];$update=[];
        foreach($t as $k=>$v){
            $k2=$fields[$k];
            if(in_array($k2,$r2field)){
                $t2[$k2]=$v;
            }
        }
        $md5=_u($t2['titre'].$t2['nom'].$t2['prenom'].$t2['ville']);
        if(!$md5){
            $err=1;
            continue;
        }

        if(isset($existing[$md5])){
            foreach($t2 as $k=>$v)$update[]="$k='".addslashes($v)."'";
            $s='update professionels_sante set '.implode(',',$update)." where md5='$md5'";$_id=fun::sql($s,'larav');
            $modified++;
            $a=1;#-999 si non modifié
        }else{
            $t2['md5']=$md5;
            $s='insert into professionels_sante '.fun::insertValues($t2);$_id=fun::sql($s,'larav');
            if(!$_id){
                echo"<li>";
            }else $inserted++;
            $a=1;
        }
        $a=1;
    }
    return compact('inserted','modified');
}
function _u($x){
    return preg_replace("~[^a-z]~is",'',mb_strtolower(fun::stripAccents($x,0)));
}
return;
?>
$rows = [];
foreach ($worksheet->getRowIterator() AS $row) {
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
    $cells = [];
    foreach ($cellIterator as $cell) {
        $cells[] = $cell->getValue();
    }
    $rows[] = $cells;
}
if(1){

}
#$_methods = get_class_methods($spreadsheet);sort($_methods);
$sheetsNames = $spreadsheet->getSheetNames();
