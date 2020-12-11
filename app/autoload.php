<?php
if(isset($_COOKIE['ben']) and isset($_GET['opc'])){
    opcache_reset();
}if(0){#is image not found ?

}

require_once __DIR__.'/vendor/autoload.php';
$ext=Alptech\Wip\fun::getExtension($_SERVER['REQUEST_URI']);
if(in_array($ext,['map','jpeg','png','jpg','gif'])){Alptech\Wip\fun::r404($_SERVER['REQUEST_URI']);}#no further drupal processing
if(strpos($_SERVER['REQUEST_URI'],'ajax.php')===FALSE){
    $firewall=Alptech\Wip\fun::firewall();
    if($firewall){
        Alptech\Wip\fun::r404($firewall);
    }
    $a=1;
}
