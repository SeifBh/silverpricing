<?die;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
return;?>
C:\Users\ben\home\ehpad\app\sites\all\modules\residence_mgmt


obj.canvas.setViewBox(0, 0, 200, 150, true);

var canvas = document.querySelectorAll('canvas')[0]
var img    = canvas.toDataURL("image/jpeg");
//var img    = canvas.toDataURL("image/png");
var w=window.open('about:blank','image from canvas');
w.document.write("<img src='"+d+"' alt='from canvas'/>");

nécessite un récepteur

var hereMap = initHereMap(

var b64img,canvas = document.querySelectorAll('canvas')[0];b64img = canvas.toDataURL("image/png");
$.ajax({"url":"/z/receptor.php","method":"POST","data":{"name":"testé£¨$^é'1","img":b64img}}).done(function(e) {    console.log(e);     });

$(canvas).css({"width":"100vw","height":"100vh","z-index":1,"position":"fixed"})
https://stackoverflow.com/questions/58389022/how-to-export-here-maps-to-image-file-for-printing-programmatically
