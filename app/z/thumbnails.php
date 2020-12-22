<?php /*
phpx ~/home/ehpad/app/z/thumbnails.php
*/
chdir(__DIR__);
require_once'../autoload.php';
chdir('../sites/default/files/ehpad');
$x=glob('*');
foreach($x as $t){
    $t2='../../styles/thumbnail/public/ehpad/'.$t;
    if(is_file($t2))continue;
    $_resized=Alptech\Wip\fun::resizeImage($t,100,null,$t2);#1200 max as jpg 70
    $hop=1;
}



