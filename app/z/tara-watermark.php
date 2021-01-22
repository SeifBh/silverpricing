<?php
/*
echo C:/Users/ben/signaturesPhotos/*_.png
phpx ~/home/ehpad/app/z/tara-watermark.php C:/Users/ben/Desktop/mists.jpg 'C:/Users/ben/signaturesPhotos/_£.png';
phpx ~/home/ehpad/app/z/tara-watermark.php '{"baseImg":"C:/Users/ben/Desktop/mi£ts.jpg","sign":"C:/Users/ben/signaturesPhotos/_£.png","maxW":10,"quality":90,"position":"br"}';
 */
namespace Alptech\Wip;chdir(__DIR__);require_once'../autoload.php';
if(!$included and !isset($argv))die('no argv nor included');

$baseImg=trim($argv[1]," '");$sign=trim($argv[2]," '");$maxW=100;$quality=90;$position='br';
if($x=io::isJson($baseImg) and $x){extract($x);}#else{$baseImg=explode(',',$baseImg);#peut être la seule ..}

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
        echo $end . ',';
        $target = 'C:/Users/ben/Desktop/Signed-' . $end . $eb;

        print_r(addPhotoWaterMark(compact('baseImg', 'sign', 'target', 'position', 'maxW')));
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
