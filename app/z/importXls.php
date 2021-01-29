<?
namespace Alptech\Wip;chdir(__DIR__);require_once'../autoload.php';
if(!$included and !isset($argv))die('no argv nor included');

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
if (!$spreadsheet) {
$json['error'][$file][] = "cant load spreadsheet";
continue;
}
#$_methods = get_class_methods($spreadsheet);sort($_methods);
$sheetsNames = $spreadsheet->getSheetNames();
