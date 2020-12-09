<?die;/*
https://codepen.io/mawshin/pen/YYgGJe
*/
if (isset($_POST['imgURI'])) {#to /z/receptor
    $name = 'markers/'.$_POST['name'];#uniqid()
    $img = $_POST['imgURI'];
    $len=strlen($img);if($len<2000)die;
    $img = str_replace('data:image/png;base64,', '', $img);//replace the name of image
    #str_replace('data:image/png;base64,','
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file =  $name . '.png';//with unique name each image saves
    $success = file_put_contents($file, $data); // image put to folder upload

    echo $success ? $file : 'Unable to save the file.';
    die;
}
?><html><head>

<script src="/z/js/jquery.min.js#https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js#//code.jquery.com/jquery-1.12.4.min.js#"></script>

<script src="/z/global.js"></script>
<script>
needSvgToCanvas();
ajax('/z/ajax.php?markers=1','GET','',function(r){pngMarkers=JSON.parse(r);cl(pngMarkers);});
cl('coucou');
defer(function(){
    cl('inside');
    k=62;bgColor='EB9B6C';txtColor='F00';border='0A0';w=40;h=51;zoom=1.5;
    pngFileName=k+'-'+bgColor+'-'+txtColor+'-'+border+'-'+w+'-'+h+'-'+zoom;
    var final=pngFileName+'.png';
    if(pngMarkers.indexOf(final)!=-1){
        dqs('#svgC')[0].innerHTML='<img src="/z/markers/'+final+'"/>';
        dqs('.message')[0].innerHTML='existe déjà';
    }else{//Génération
        document.querySelector('#svgC').innerHTML=genSvg(k,bgColor,txtColor,border,w,h,zoom);
        svg2png();
    }
},function(){return ( typeof svg2png == 'function' && typeof document.body =='object' && typeof pngMarkers =='object' && typeof Canvas2Image =='object' && typeof RGBColor=='function' && typeof jQuery=='function'  && typeof $=='function'  && typeof canvg=='function');});
cl('après defer');
</script>
<style>
    /*.hidden{display:none}*/
    polygon {fill:red;}
</style>

</head><body>

</body></html>
