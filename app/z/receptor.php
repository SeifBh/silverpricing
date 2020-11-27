<?php
namespace z;
require_once'../autoload.php';
/*reçoit les images des cartes canvas encodées en base64*/
if(isset($_POST['img'])){
    #$_received=\Alptech\Wip\fun::dbm([__FILE__.__line__,'missing b64'],'php500');
    $ext='nf';
    if(strpos($_POST['img'],'data:image/jpeg')!==FALSE){
        $ext='jpg';$_POST['img']=str_replace('data:image/jpeg;base64,','',$_POST['img']);
    } elseif(strpos($_POST['img'],'data:image/png')!==FALSE){
        $ext='png';$_POST['img']=str_replace('data:image/png;base64,','',$_POST['img']);
    }
    $b64=base64_decode($_POST['img']);
    if(!$b64){
        \Alptech\Wip\fun::dbm([__FILE__.__line__,'missing b64'],'php500');
    }
    $target="genmaps/".date('ymdHis').'-'.preg_replace('~\.+~','.',preg_replace('~[^a-z0-9_\-]~is','.',$_POST['name'])).'.'.$ext;
    $ok=file_put_contents($target,$b64);
    if($ok){
        die($target);
    }
    \Alptech\Wip\fun::dbm([__FILE__.__line__,'cant write image'],'php500');
    die;
    $a=1;
}
return;?>


preserveDrawingBuffer: true

var hereMap = initHereMap(

{multiplier:1}
if (canvas.getContext) {
    var ctx = canvas.getContext('2d');// non existant ....
    b64img = ctx.toDataURL("image/jpeg",2.0);
}

canvasCopy.setBackgroundColor('#FFFFFF')
canvasCopy.renderAll();

var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");window.location.href=image;



$(canvas).css({"width":"100vw","height":"100vh","z-index":1,"position":"fixed"})
https://stackoverflow.com/questions/58389022/how-to-export-here-maps-to-image-file-for-printing-programmatically


0) change map size
1) https://developer.here.com/documentation/examples/maps-js/maps/capture-map-area


//var original=document.querySelectorAll('canvas')[0];//ne sait pas pourquoi il faut le copier d'abord ...

var styleback,datasize,cap,b64img,r=$('#dashCap')[0];
styleback=$('#dashboard-map-result').attr('style');
$('#dashboard-map-result').attr('style','').addClass('fullScreen');
hereMap.map.getViewPort().resize();
hereMap.map.capture(function(cap){
    r.innerHTML='';r.appendChild(cap);
    cap=document.querySelectorAll('canvas')[0];//First one
    b64img=cap.toDataURL("image/jpeg");
    $('#dashboard-map-result').removeClass('fullScreen').attr('style',styleback);
    r.innerHTML='';
    datasize=b64img.length;
    console.log(datasize);
    $.ajax({"url":"/z/receptor.php","method":"POST","data":{"name":"testé£¨$^é'1","img":b64img}}).done(function(e) {    console.log(e);     });
    //$('#dashCap').css({"z-index":9999});
}, [], 0, 0, 1400, 1400);

var ctx,b64img,canvas = document.querySelectorAll('canvas')[0];b64img = canvas.toDataURL('image/jpeg',1);
$.ajax({"url":"/z/receptor.php","method":"POST","data":{"name":"testé£¨$^é'1","img":b64img}}).done(function(e) {    console.log(e);     });


map.capture(function(capturedCanvas) {
    captureBackground.innerHTML = '';
    captureBackground.appendChild(capturedCanvas);
    document.body.appendChild(captureBackground);
}, [], 50, 50, 700, 700);


find . -type f -mmin -120 | grep -v .jpg | grep -v data/cache | grep -v ~lock | tee modified.list
x=`cat modified.list`;for i in $x; do git add $i -f;done;
