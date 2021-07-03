<?php
if(isset($_COOKIE['ben']) and isset($_GET['opc'])){
    opcache_reset();
}if(0){#is image not found ?

}

require_once __DIR__.'/vendor/autoload.php';
$u=$_SERVER['REQUEST_URI'];
$ext=Alptech\Wip\fun::getExtension($u);
if(in_array($ext,['map','jpeg','png','jpg','gif']) and strpos($u,'sites/default/files/')===FALSE){
    Alptech\Wip\fun::r404($u);
}#no further drupal processing
if(strpos($_SERVER['REQUEST_URI'],'ajax.php')===FALSE){
    $firewall=Alptech\Wip\fun::firewall();
    if($firewall){
        Alptech\Wip\fun::r404($firewall);
    }
    $a=1;
}

if(0){
    if(strpos($_SERVER['REQUEST_URI'],'plupload/113')!==FALSE){
        $b[]=Alptech\Wip\fun::getBody();
        $b[]=Alptech\Wip\fun::getBody();
        $a=1;
    }
}
