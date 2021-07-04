<?php
#/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/auto_prepend.php
if(strpos($_SERVER['DOCUMENT_ROOT'],'home/ubuntu/SilverPricing/public_html/app.silverpricing.fr')){
    require_once __DIR__.'/autoload.php';
}
