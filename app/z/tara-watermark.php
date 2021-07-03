<?php
/*
echo C:/Users/ben/signaturesPhotos/*_.png
phpx ~/home/ehpad/app/z/tara-watermark.php C:/Users/ben/Desktop/mists.jpg 'C:/Users/ben/signaturesPhotos/_£.png';
phpx ~/home/ehpad/app/z/tara-watermark.php '{"baseImg":"C:/Users/ben/Desktop/toSign/£.jpg","sign":"C:/Users/ben/signaturesPhotos/_£.png","maxW":10,"quality":90,"position":"br","output":"C:/Users/ben/Desktop/signed/"}';
phpx ~/home/ehpad/app/z/tara-watermark.php '{"baseImg":"C:/Users/ben/Desktop/toSign/£.jpg","sign":"C:/Users/ben/signaturesPhotos/_s74white£.png","maxW":10,"quality":90,"position":"br","output":"C:/Users/ben/Desktop/signed/"}';
phpx ~/home/ehpad/app/z/tara-watermark.php '{"baseImg":"C:/Users/ben/Desktop/toSign/£.jpg","sign":"C:/Users/ben/signaturesPhotos/_s74white£.png","maxW":10,"quality":90,"position":"br","output":"C:/Users/ben/Desktop/signed/"}';
 */
namespace Alptech\Wip;chdir(__DIR__);require_once'../autoload.php';
if(!$included and !isset($argv))die('no argv nor included');

#imagecropauto ( resource $image , int $mode = IMG_CROP_DEFAULT ) crop white or black sides of an image
function _cropTo($baseImg,$ratio=16/9,$position='center',$suffix='-t£.jpg',$save=1,$qual=80,$target=''){
    if(is_array($baseImg))extract($baseImg);
    if(gettype($baseImg)=='resource')$im =$baseImg;else{$im=imagecreatefromjpeg($baseImg);if(!$target)$target=$baseImg.$suffix;}
    $w=imagesx($im);$h=imagesy($im);
    $cropH=$horizontal=1;if($h>$w)$horizontal=0;if($ratio<1)$cropH=0;
$x=$y=0;#starts
    $nh=$h;$nw=$ratio*$h;
    if($nw>$w){#nous n'avons pas cette ressource disponible
        $nw=$w;$nh=$w/$ratio;
    }else{#la place existe, le souhait est-il vertical ?
    }

    if($position=='center'){
        $y=$h/2-$nh/2;
        $x=$w/2-$nw/2;
    }

    $rect=['x' => $x, 'y' => $y, 'width' => $nw, 'height' => $nh];
    $res=imagecrop($im,$rect);
    if($save)return imagejpeg($res,$target,$qual);else return imagejpeg($res,null,$qual);
}

function _addBorder($baseImg,$perWidth=0.5,$suffix='-t£.jpg',$save=1,$qual=80){
    if(is_array($baseImg))extract($baseImg);
    if(gettype($baseImg)=='resource'){$im=$baseImg;}
    else{$im = imagecreatefromjpeg($baseImg);if(!$target)$target=$baseImg.$suffix;}
    $w=imagesx($im);$h=imagesy($im);
    $mw=round($w*$perWidth/100);$nw=$w+$mw*2;$nh=$h+$mw*2;

    $tmp = imagecreatetruecolor($nw, $nh);
    $color_white = ImageColorAllocate($tmp, 255, 255, 255);
    ImageFilledRectangle($tmp, 0, 0, $nw, $nh, $color_white);

    imagecopy($tmp, $im, $mw, $mw, 0, 0, $w, $h);
    if($save)return imagejpeg($tmp,$target,$qual);else return imagejpeg($tmp,null,$qual);;
}

function _addPhotoWaterMark($baseImg=null,$sign=null,$target=null,$position='br',$edgeMargin=10,$quality=90,$maxW=100,$maxH=100){
    if(is_array($baseImg))extract($baseImg);
    if(!$baseImg)return;
    $im = imagecreatefromjpeg($baseImg);$w=imagesx($im);$h=imagesy($im);$wr=$w/$h;#1.17
    $stamp=imagecreatefrompng($sign);$sx=imagesx($stamp);$sy=imagesy($stamp);$sr=$sx/$sy;#3.8
    if($sx>($w*$maxW/100)){
        $nw=round($w*$maxW/100);$nh=round($nw/$sr);
        $tmp = imagecreatetruecolor($nw, $nh);$destX=$destY=$srcx=$srcy=0;
        imagealphablending($tmp, false);imagesavealpha($tmp, true);$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);imagefilledrectangle($tmp, 0, 0, $nw, $wr, $transparent);
        $res=imagecopyresampled($tmp, $stamp, $destX, $destY, $srcx, $srcy, $nw, $nh, $sx, $sy);
        #imagePng($tmp,uniqid().'.png',9);
        $stamp=$tmp;$sx=$nw;$sy=$nh;
    }
#todo#¤: others positions, max watermark width %, max watermark height %
    switch($position){
        case'br':
            $wp=$w - $sx - $edgeMargin;
            $hp=$h - $sy - $edgeMargin;
            break;
    }

    imagecopy($im, $stamp, $wp, $hp, 0, 0, $sx, $sy);#placer dessus aux coordonnées calculées

    imageJpeg($im,$target,$quality);imagedestroy($im);
    return [$target,filesize($target)];
    #header('Content-type: image/png');imagepng($im,$target,$quality);

}


$output='C:/Users/ben/Desktop/toSign/--';$baseImg=trim($argv[1]," '");$sign=trim($argv[2]," '");$maxW=100;$quality=90;$position='br';
if($x=io::isJson($baseImg) and $x){extract($x);}#else{$baseImg=explode(',',$baseImg);#peut être la seule ..}

if(!is_dir($output))mkdir($output,0777,1);

if(!isset($sign)){$sign='C:/Users/ben/signaturesPhotos/£_.png';}
$sign=str_replace('£','*',$sign);
$baseImg=str_replace('£','*',$baseImg);


$baseImgs=glob($baseImg);
$signs=glob($sign);

foreach($baseImgs as $baseImg) {
    $x = explode('/', $baseImg);
    $eb = end($x);
#echo"arg2:".trim($argv[2]," '");echo"\n\n";print_r($signs);
    foreach ($signs as $sign) {
        $x = explode('/', $sign);
        $end = end($x);
        if(strpos($end,'£.jpg')){
            echo"\n".$end;
            Continue;}
        #echo $end . ',';
        $target =$output . $end . $eb;
        $ratio=16/9;$position='center';$suffix='169£.jpg';
        print_r(cropTo(compact('baseImg','ratio','position','suffix')));
        $ratio=9/16;$position='center';$suffix='169v£.jpg';
        print_r(cropTo(compact('baseImg','ratio','position','suffix')));
        $ratio=21/2;$position='center';$suffix='212£.jpg';
        print_r(cropTo(compact('baseImg','ratio','position','suffix')));
        #print_r(addBorder(compact('baseImg')));
        #print_r(addPhotoWaterMark(compact('baseImg', 'sign', 'target', 'position', 'maxW')));
        #print_r(addPhotoWaterMark($baseImg,$sign,$target,10,90,15));
    }
}

function addPhotoWaterMark($baseImg=null,$sign=null,$target=null,$position='br',$edgeMargin=10,$quality=90,$maxW=100,$maxH=100){
    if(is_array($baseImg))extract($baseImg);
    if(!$baseImg)return;
    $im = imagecreatefromjpeg($baseImg);$w=imagesx($im);$h=imagesy($im);$wr=$w/$h;#1.17
    $stamp=imagecreatefrompng($sign);$sx=imagesx($stamp);$sy=imagesy($stamp);$sr=$sx/$sy;#3.8
    if($sx>($w*$maxW/100)){
        $nw=round($w*$maxW/100);$nh=round($nw/$sr);
        $tmp = imagecreatetruecolor($nw, $nh);$destX=$destY=$srcx=$srcy=0;
        imagealphablending($tmp, false);imagesavealpha($tmp, true);$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);imagefilledrectangle($tmp, 0, 0, $nw, $wr, $transparent);
        $res=imagecopyresampled($tmp, $stamp, $destX, $destY, $srcx, $srcy, $nw, $nh, $sx, $sy);
        #imagePng($tmp,uniqid().'.png',9);
        $stamp=$tmp;$sx=$nw;$sy=$nh;
    }
#todo#¤: others positions, max watermark width %, max watermark height %
    switch($position){
        case'br':
            $wp=$w - $sx - $edgeMargin;
            $hp=$h - $sy - $edgeMargin;
            break;
    }

    imagecopy($im, $stamp, $wp, $hp, 0, 0, $sx, $sy);#placer dessus aux coordonnées calculées

    imageJpeg($im,$target,$quality);imagedestroy($im);
    return [$target,filesize($target)];
    #header('Content-type: image/png');imagepng($im,$target,$quality);

}
