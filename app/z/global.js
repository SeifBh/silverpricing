var mapName='map',cl=console.log,nf=function(){return;};
if(location.host.indexOf('.home')<0)cl=nf;//neutralisation
/*var hereMap = initHereMap(*/
function defer(method, timeout) {
    var timeout = timeout || 200;
    if (window.jQuery) {
        method();
    } else {
        setTimeout(function () {
            defer(method)
        }, timeout);
    }
}

//map-recherche-silverex
//captureMap(0,cl); works !
async function captureMap(el,callback){
    var styleback,datasize,cap,b64img,r;
    el=el||'.heremap';callback=callback||nf;
    r=document.querySelector('#dashCap');
    styleback=$(el).attr('style');
/*could be even wider than ever .... */
    $(el).attr('style','').addClass('fullScreen');
    hereMap.map.getViewPort().resize();
    await new Promise(r => setTimeout(r, 1000));
//wait a little , nope ? surveiller les chargements réseau du navigateur ?
    hereMap.map.capture(function(cap){

        //$('#adresse').val()
        _mapName='';
        if(typeof session['hid']!='undefined')_mapName+='-hid='+session['hid'];
        if(typeof uid!='undefined')_mapName+='-uid='+uid;
        if(typeof post['adresse']!='undefined')_mapName+='-adress='+post['adresse'];
        if(typeof post['perimetre']!='undefined')_mapName+='-perimetre='+post['perimetre'];
        if(typeof post['residence']!='undefined')_mapName+='-residence='+post['residence'];

        //_mapName='uid:'+uid+'-'+location.pathname+'-'+mapName;

        r.innerHTML='';r.appendChild(cap);
        cap=document.querySelectorAll('canvas')[0];//First one dans la dom
        b64img=cap.toDataURL('image/jpeg');
        $(el).removeClass('fullScreen').attr('style',styleback);
        r.innerHTML='';
        datasize=b64img.length;
        //console.log(datasize);
        $.ajax({"url":"/z/receptor.php","method":"POST","data":{"name":_mapName,"img":b64img}}).done(function(e) {    callback(e);  cl(e);     });
        //$('#dashCap').css({"z-index":9999});
    }, [], 0, 0, 1400, 1400);
}
