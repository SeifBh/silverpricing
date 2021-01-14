/*}0:variables{
const ret1=await defer
*/
//Todo:global png image onload observer for map loading ..
var p,pngMarkers,
    nb,nav,classname,ua,x,k,color,svg,v,v1,v2,v3,
    pngFileName,k,bgColor,txtColor,border,w,h,zoom,
    svg,canvasOriginal,ctxOriginal,canvasComputed,ctxConverted,emptySvgDeclarationComputed,allElements,i,image,len,image_data,
    cap,currentMap,hereMap,rendered=0,renderingSteps=0,mapName='map',
    toload=[],imgErr=[],markers = [],callbacks={},callbacksInc=0,dev=0,markerObject,
    cl=console.log,nf=function(a){return;}
;

if(location.host.indexOf('.home')<0 && !getCookie('ben')){dev=0;cl=nf;}//neutralisation
console.log=nf;

ua=navigator.userAgent.toLowerCase();
/*}1:calc{*/
if (ua.indexOf('safari') != -1) {
    if (ua.indexOf('edge') > -1) {
        nav=classname='edge';
    } else if (ua.indexOf('android') > -1) {
        nav='android';classname='chrome android';
    } else if (ua.indexOf('chrome') > -1) {
        nav=classname='chrome';
    }else {//Safari :: "mozilla/5.0 (windows nt 6.2; wow64) applewebkit/534.57.2 (khtml, like gecko) version/5.1.7 safari/534.57.2"
        nav=classname='safari';
    }
}
/*}2:events{*/
window.addEventListener('load', function(e){document.body.parentNode.className+=' '+classname;});


/*}90:functions{*/

function getCookie(e){return document.cookie.length>0&&(begin=document.cookie.indexOf(e+"="),-1!=begin)?(begin+=e.length+1,end=document.cookie.indexOf(";",begin),-1==end&&(end=document.cookie.length),unescape(document.cookie.substring(begin,end))):null}
function delCookie(e){path=";path=/",domain=";domain=."+document.location.hostname;var o="Thu, 01-Jan-1970 00:00:01 GMT";document.cookie=e+"="+path+domain+";expires="+o}
var sc=setCookie,gc=getCookie;
function setCookie(name,value,expires,path,domain,secure){
    path=path || '/';
    var today = new Date();today.setTime(today.getTime());
    if(expires){expires = expires * 1000/*ms*/ * 3600/*hours*/ * 24;}
    else{expires=1000*60*60*24*365;}//365 dats
    var expires_date = new Date( today.getTime() + (expires) );
    document.cookie=name+"="+escape(value)+ ((expires)?";expires="+expires_date.toGMTString():"")+ ((path)?";path="+path:"")+ ((domain)?";domain="+domain:"")+ ( ( secure ) ? ";secure" : "" );
}


/*var hereMap = initHereMap(*/
//defer(,function(){return window[hereMap] && window[jQuery];});
//captureMap(0,cl); works !
async function defer(method, which, timeout) {
    var timeout = timeout || 200,which=which || function(){return typeof window['jQuery']=='function';};
    if (which()) {
        return method();
        //args
    }
    setTimeout(function () {defer(method,which,timeout);}, timeout);
}

//map-recherche-silverex
//captureMap(0,cl); works !
async function captureMap(el,callback){
    cl('captureMap expecting rendering');
    var styleback, datasize, b64img, r, necessaires = 1,ms=100,waits=0;
    el=el||'.heremap';callback=callback||nf;
    r=document.querySelector('#dashCap');
    styleback=$(el).attr('style');
    /*could be even wider than ever .... */
    //here map capture map and markers
//$(el).attr('style','').addClass('fullScreen');hereMap.map.getViewPort().resize();necessaires=2;//Passée derrière
//So we get the second rendering en mode FullScreen, de toutes façons 2 car on doit attendre que la copie soit rendue
    $(el).attr('style','').addClass('hidden');
    while(toload.length!=0 || !rendered || document.querySelectorAll('canvas').length<1) {waits+=ms;await new Promise(r => setTimeout(r,ms));}//cl(rendered,renderingSteps,necessaires,document.querySelectorAll('canvas').length);
    cl('waited:',waits,',rendering steps:',renderingSteps);
    await new Promise(r => setTimeout(r,400));//Make sure All Duplicated Png Markers are loaded !!!

    //while(renderingSteps<necessaires || document.querySelectorAll('canvas').length<1) {cl(renderingSteps,necessaires,document.querySelectorAll('canvas').length);await new
    // Promise(r => setTimeout(r,2000));}
// rendered maps
//await new Promise(r => setTimeout(r,4000));
//wait a little , nope ? surveiller les chargements réseau du navigateur ?
    hereMap.map.capture(function(cap){
        //$('#adresse').val()
        _mapName='';
        if(typeof session['hid']!='undefined')_mapName+='-hid='+session['hid'];
        if(typeof uid!='undefined')_mapName+='-uid='+uid;
        if(typeof post['adresse']!='undefined')_mapName+='-adress='+post['adresse'];
        if(typeof post['perimetre']!='undefined')_mapName+='-perimetre='+post['perimetre'];
        if(typeof post['residence']!='undefined')_mapName+='-residence='+post['residence'];
        _mapName += '-rs=' + renderingSteps;
        renderingSteps = rendered = 0;

        //_mapName='uid:'+uid+'-'+location.pathname+'-'+mapName;

        r.innerHTML='';r.appendChild(cap);
        cap=document.querySelectorAll('canvas')[0];//First one dans la dom
        b64img=cap.toDataURL('image/jpeg');
        /*
                cap=document.querySelectorAll('canvas')[0];//First one dans la dom
                b64img=cap.toDataURL('image/jpeg');
                $.ajax({"url":"/z/receptor.php","method":"POST","data":{"name":_mapName,"img":b64img}}).done(function(e) {
                    $.ajax({"url":"/updateHistory","method":"POST","data":{"hid":session['hid'],"mapName":e}}).done(function(e) {
                        cl('updated',e);
                    });
                    callback(e);
                });
        */

        $(el).removeClass('hidden').attr('style',styleback);
        //r.innerHTML='';
        datasize=b64img.length;
        //console.log(datasize);
        $.ajax({"url":"/z/ajax.php","method":"POST","data":{"name":_mapName,"img":b64img}}).done(function(e) {
            $.ajax({"url":"/updateHistory","method":"POST","data":{"hid":session['hid'],"mapName":e}}).done(function(e) {
                cl('updated',e);
            });
            callback(e);cl(e);
        });
        //$('#dashCap').css({"z-index":9999});
    }, [], 0, 0, 1400, 1400);
}

needSvgToCanvas.t=0;
function needSvgToCanvas(){
    if(needSvgToCanvas.t)return;
    addJs('/z/js/svg2png.js#mine');
    addJs('/z/js/rgbcolor.min.js#https://cdnjs.cloudflare.com/ajax/libs/canvg/1.4/rgbcolor.min.js#https://unpkg.com/rgbcolor@1.0.1/index.js');
    addJs('/z/js/canvg.min.js#https://cdn.jsdelivr.net/npm/canvg/dist/browser/canvg.min.js#https://cdnjs.cloudflare.com/ajax/libs/amstockchart/3.13.0/exporting/canvg.js');
    addJs('/z/js/canvas2image.min.js#https://cdn.jsdelivr.net/npm/canvas2image@1.0.5/canvas2image.min.js#/z/js/canvas2image.js#https://github.com/hongru/canvas2image/edit/master/canvas2image.js');

    defer(function(){
        var div = document.createElement('div');div.className='hidden';div.innerHTML='<div class="message"></div><div id="svgC"></div><svg id="emptysvg" xmlns="http://www.w3.org/2000/svg" version="1.1" height="2"></svg><br>Orig:<canvas id="canvasOriginal" height="190" width="190" ></canvas><br>Com:<canvas id="canvasComputed" height="190" width="190" ></canvas>';
        document.body.appendChild(div);
    },function(){return (typeof document.body =='object' && document.body); });
}

function addJs(src,x){
    var link = document.createElement('script');link.async=true;link.type = 'text/javascript';link.src =src;document.head.appendChild(link);
}

/*
defer(function(){
},function(){return (typeof Canvas2Image =='object' && typeof RGBColor=='function' && typeof jQuery=='function'  && typeof $=='function'  && typeof canvg=='function');});
 */

ajax.nb=0;ajax.inc=0;ajax.urls=[];
function ajax(url,method,data,callback){
    url=url||'?';method=method||'POST';data=data||'';callback=callback||nf;
    var res,xhr = new XMLHttpRequest();
    xhr.open(method, url, true);url+='#'+ajax.inc;
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    if(method=='POST')xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        ajax.urls.remove(url);ajax.nb--;
        callback(this.responseText);
        //cl('response for',url,':',this.responseText);
    };
    ajax.inc++;ajax.nb++;ajax.urls.push(url);
    if(typeof data=='object'){
        data=params(data);
        //cl('stringify',data);//JSON.stringify is the opposite !!
    }
    xhr.send(data);
    //cl({url,method,data,'urls':ajax.urls});
}

function params(data) {
    return Object.keys(data).map(key => `${key}=${encodeURIComponent(data[key])}`).join('&');
}

function errorhandler(desc, page, line, chr, errobj) {
    if(/bat\.js|facebook\.net/i.test(page))return true;//dontcare
    var err=(desc+page+line+'').toLowerCase();
    if(errors.indexOf(err)>-1)return true;
    if(dev && errobj){
        var err = new Error();
        ct(err.stack);
        ct(errobj);
    }
    ct(desc, page,line, chr);//desc, page, line, chr, //	script error.
    //if(errobj)console.error(errobj);//desc, page, line, chr, //	Script error. :0 0 => is undefined function
    if(dev)return true;
    ajax('/tag.php','POST',('jsx='+desc+'&page='+page+'&line='+line+'&loc='+window.location.href).toLowerCase());
    return true;
}

function imgLoad(a,cb,nb){
    x=callbacks[cb]();
    //cl('loaded',a,nb,cb,x);
    imgErr.remove(a);
    toload.remove(a);/*cl({a,b,c});*/
}

function imgError(a,cb,nb){
    if(nb==0){
        imgErr.push(a);
    }if(nb>10){return;}
    cl('imgError',a,cb,nb);
    var img = new Image();img.src = '/z/markers/'+a;
    img.onload=imgLoad.bind(this,a,cb,nb+1);
    img.onerror=imgError.bind(this,a,cb,nb+1);//attention peu devenir méchamment récursif !!
}

function dqs(x){return document.querySelectorAll(x);}
/*


window.onerror = errorhandler;
window.addEventListener('hashchange',onHashChange, false);//au démarrage ;)
window.addEventListener('resize', resize);//better, only Fire at event end ?
window.addEventListener('load', resize);//better, only Fire at event end ?
//better, only Fire at event end ?
 */


/*}{*/
Object.size = function(obj) {var size = 0, key;for (key in obj) {if (obj.hasOwnProperty(key)) size++;}return size;};
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

var cd=new Date();
function sendMailUpdateChambreByUUid(rid,mail,title,uuid,el){
    $.ajax({"url":"/z/ajax.php","method":"POST","data":{"action":"sendMailUpdateChambreByUUid","rid":rid,"mail":mail,"title":title,"uuid":uuid}}).done(function(e){
        el.parentNode.innerHTML='mail envoyé : '+cd.toLocaleDateString();
        //$(el).hide();
        cl(e);
    });
}
