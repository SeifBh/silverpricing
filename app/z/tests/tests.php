<?php
die;
if (isset($_POST['imgURI'])) {
    $img = $_POST['imgURI'];
    $len=strlen($img);if($len<2000)die;
    $img = str_replace('data:image/png;base64,', '', $img);//replace the name of image
    #str_replace('data:image/png;base64,','
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file =  uniqid() . '.png';//with unique name each image saves
    $success = file_put_contents($file, $data); // image put to folder upload
    echo $success ? $file : 'Unable to save the file.';
    die;
}
?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style>img,canvas{border:1px dashed #F00;height:51px;width:40px;}</style>

<canvas id="canvas"></canvas>
<img id="img"/>
<div class="message"></div>

<hr>
<div class="svgpointer" style="margin-left:50px;">


    <svg xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="map" preserveAspectRatio="xMidYMid meet" viewBox="0 0 26.666666666667 34" xmlns="http://www.w3.org/2000/svg" style="margin:-51px 0 0 -20px" width="40px" height="51px"><path d="M 19 31 C 19 32.7 16.3 34 13 34 C 9.7 34 7 32.7 7 31 C 7 29.3 9.7 28 13 28 C 16.3 28 19 29.3 19 31 Z" fill="#000" fill-opacity=".2"></path><path d="M 13 0 C 9.5 0 6.3 1.3 3.8 3.8 C 1.4 7.8 0 9.4 0 12.8 C 0 16.3 1.4 19.5 3.8 21.9 L 13 31 L 22.2 21.9 C 24.6 19.5 25.9 16.3 25.9 12.8 C 25.9 9.4 24.6 6.1 22.1 3.8 C 19.7 1.3 16.5 0 13 0 Z" fill="#FFF"></path><path d="M 13 2.2 C 6 2.2 2.3 7.2 2.1 12.8 C 2.1 16.1 3.1 18.4 5.2 20.5 L 13 28.2 L 20.8 20.5 C 22.9 18.4 23.8 16.2 23.8 12.8 C 23.6 7.07 20 2.2 13 2.2 Z" fill="#EB9B6C"></path><text x="12" y="19" font-size="14pt" font-weight="bold" text-anchor="middle" fill="#000">69</text></svg>
</div>
<br><button>Copy</button>

<script>
var ContainerElements = ["svg","g"];
var RelevantStyles = {"rect":["fill","stroke","stroke-width"],"path":["fill","stroke","stroke-width"],"circle":["fill","stroke","stroke-width"],"line":["stroke","stroke-width"],"text":["fill","font-size","text-anchor"],"polygon":["stroke","fill"]};

var oDOM,ctx,data,img,DOMURL,svgBlob,url,imgURI;
var btn = document.querySelector('button');
var svg = document.querySelector('svg');
var canvas = document.querySelector('canvas');
var rawImage = document.getElementById('yourimageID');

$(document).ready(function(){xport();});

btn.onclick=xport;

function xport(){
    ctx= canvas.getContext('2d');
    oDOM = svg.cloneNode(true);
    read_Element(oDOM, svg);

    data = (new XMLSerializer()).serializeToString(oDOM);
    svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
    DOMURL = window.URL || window.webkitURL || window;
    url = DOMURL.createObjectURL(svgBlob);
    //console.log('lickce',data);
    document.querySelector('img').src=url;

    var link = document.createElement("a");
    link.setAttribute("target","_blank");
    var Text = document.createTextNode("Export");
    link.appendChild(Text);
    link.href=url;
    document.body.appendChild(link);

    img = new Image();
    img.onload = function () {
        //ctx.drawImage(rawImage, 0, 0);
        ctx.drawImage(img, 0, 0);//Au sein
        DOMURL.revokeObjectURL(url);
        imgURI = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');

        console.log(imgURI);
        // alert(imgURI);
        $.ajax({
            url: "?",
            type: "POST",
            data: {imgURI: imgURI,},
            success: function(dataResult){
                $('.message').html('<div class=\'\'><div class=\"alert icon-alert with-arrow alert-success form-alter\" role=\"alert\">\n' +
                    '<i class=\"fa fa-fw fa-check-circle\"></i>\n<strong> Success ! </strong> <span class=\"success-message\"> SVG converted Successfully. </span>\n</div></div>');
            }
        });
    };
    img.src = url;
}

function read_Element(ParentNode, OrigData){
    var Children = ParentNode.childNodes;
    var OrigChildDat = OrigData.childNodes;

    for (var cd = 0; cd < Children.length; cd++){
        var Child = Children[cd];

        var TagName = Child.tagName;
        if (ContainerElements.indexOf(TagName) != -1){
            read_Element(Child, OrigChildDat[cd])
        } else if (TagName in RelevantStyles){
            var StyleDef = window.getComputedStyle(OrigChildDat[cd]);

            var StyleString = "";
            for (var st = 0; st < RelevantStyles[TagName].length; st++){
                StyleString += RelevantStyles[TagName][st] + ":" + StyleDef.getPropertyValue(RelevantStyles[TagName][st]) + "; ";
            }

            Child.setAttribute("style",StyleString);
        }
    }
}


</script>
