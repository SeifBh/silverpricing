<?php
if(isset($_COOKIE['ben']) and isset($_GET['opc'])){
    opcache_reset();
}if(0){#is image not found ?

}

require_once __DIR__.'/vendor/autoload.php';
Alptech\Wip\fun::firewall();
