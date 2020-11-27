var mapName='testé£¨$^é\'1';
/*var hereMap = initHereMap(*/

//map-recherche-silverex
async function captureMap(el){
    var styleback,datasize,cap,b64img,r;
    el=el||'.heremap';
    r=$('#dashCap')[0];
    styleback=$(el).attr('style');
/*could be even wider than ever .... */
    $(el).attr('style','').addClass('fullScreen');
    hereMap.map.getViewPort().resize();
    await new Promise(r => setTimeout(r, 1000));
//wait a little , nope ? surveiller les chargements réseau du navigateur ?
    hereMap.map.capture(function(cap){
        r.innerHTML='';r.appendChild(cap);
        cap=document.querySelectorAll('canvas')[0];//First one dans la dom
        b64img=cap.toDataURL('image/jpeg');
        $(el).removeClass('fullScreen').attr('style',styleback);
        r.innerHTML='';
        datasize=b64img.length;
        console.log(datasize);
        $.ajax({"url":"/z/receptor.php","method":"POST","data":{"name":mapName,"img":b64img}}).done(function(e) {    console.log(e);     });
        //$('#dashCap').css({"z-index":9999});
    }, [], 0, 0, 1400, 1400);
}
