<?php
#/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/auto_prepend.php
if(strpos($_SERVER['DOCUMENT_ROOT'],'abcd-1/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr')){
    require_once __DIR__.'/autoload.php';
}
