<?php
if(isset($_COOKIE['ben']) and isset($_GET['opc'])){
    opcache_reset();
}if(0){#is image not found ?

}

require_once __DIR__.'/vendor/autoload.php';
if(1){
    $firewall=Alptech\Wip\fun::firewall();
    if($firewall){
        Alptech\Wip\fun::r404($firewall);
    }
    $a=1;
}
