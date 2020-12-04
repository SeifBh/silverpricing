
function genSvg(k,bgColor,txtColor,border,w,h,zoom,fs){
    fs=fs||14;if(k>99)fs=11; else if(k>9)fs=13;
    return ' <svg id=svg xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="map" preserveAspectRatio="xMidYMid meet" viewBox="0 0 '+w/zoom+' '+h/zoom+'" xmlns="http://www.w3.org/2000/svg" style="margin:-'+h+'px 0 0 -'+w/2+'px" width="'+w+'px" height="'+h+'px"><path d="M 19 31 C 19 32.7 16.3 34 13 34 C 9.7 34 7 32.7 7 31 C 7 29.3 9.7 28 13 28 C 16.3 28 19 29.3 19 31 Z" fill="#000" fill-opacity=".2"></path><path d="M 13 0 C 9.5 0 6.3 1.3 3.8 3.8 C 1.4 7.8 0 9.4 0 12.8 C 0 16.3 1.4 19.5 3.8 21.9 L 13 31 L 22.2 21.9 C 24.6 19.5 25.9 16.3 25.9 12.8 C 25.9 9.4 24.6 6.1 22.1 3.8 C 19.7 1.3 16.5 0 13 0 Z" fill="#'+border+'"></path><path d="M 13 2.2 C 6 2.2 2.3 7.2 2.1 12.8 C 2.1 16.1 3.1 18.4 5.2 20.5 L 13 28.2 L 20.8 20.5 C 22.9 18.4 23.8 16.2 23.8 12.8 C 23.6 7.07 20 2.2 13 2.2 Z" fill="#'+bgColor+'"></path><text x="12" y="19" font-size="'+fs+'pt" font-weight="bold" text-anchor="middle" fill="#'+txtColor+'">'+k+'</text></svg>';
}

function svg2png(finalPngFileName,cb){
    svg = $('#svg')[0];
    canvasOriginal = $('#canvasOriginal')[0];
    ctxOriginal = canvasOriginal.getContext('2d');
    canvasComputed = $('#canvasComputed')[0];
    ctxConverted = canvasComputed.getContext('2d');
    // this saves the inline svg to canvas without external css
    canvg('canvasOriginal', new XMLSerializer().serializeToString(svg));
    // we need to calculate the difference between the empty svg and ours
    emptySvgDeclarationComputed = getComputedStyle($('#emptysvg')[0]);

    // hardcode computed css styles inside svg
    allElements = traverse(svg);
    i = allElements.length;
    while (i--) {explicitlySetStyle(allElements[i]);}
    // this saves the inline svg to canvas with computed styles
    canvg('canvasComputed', new XMLSerializer().serializeToString(svg));
    image = Canvas2Image.convertToPNG(canvasComputed);
    image_data = $(image).attr('src');
    len=image_data.length;
    cl('generating png',len,finalPngFileName);
    ajax('/z/ajax.php#png','POST',{ name:finalPngFileName, imgURI: image_data,},cb);
}

function svgtoimg(x){
    dqs('#svgC')[0].innerHTML='<img src="/z/'+x+'"/>';
}

function explicitlySetStyle(element) {
    var cSSStyleDeclarationComputed = getComputedStyle(element);
    var i, len, key, value;
    var computedStyleStr = "";
    for (i = 0, len = cSSStyleDeclarationComputed.length; i < len; i++) {
        key = cSSStyleDeclarationComputed[i];
        value = cSSStyleDeclarationComputed.getPropertyValue(key);
        if (value !== emptySvgDeclarationComputed.getPropertyValue(key)) {
            computedStyleStr += key + ":" + value + ";";
        }
    }
    element.setAttribute('style', computedStyleStr);
}

function traverse(obj) {
    var tree = [];
    tree.push(obj);
    if (obj.hasChildNodes()) {
        var child = obj.firstChild;
        while (child) {
            if (child.nodeType === 1 && child.nodeName != 'SCRIPT') {
                tree.push(child);
            }
            child = child.nextSibling;
        }
    }
    return tree;
}
