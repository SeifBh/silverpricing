<?php

define("ENVIRONMENT", "PROD");

define("RESIDENCE_MGMT_URI", "/sites/all/modules/residence_mgmt");
define("RESIDENCE_MGMT_DATA", "/sites/all/modules/residence_mgmt/data");
define("RESIDENCE_MGMT_CNSA_API", "https://www.pour-les-personnes-agees.gouv.fr/api/v1");

if( ENVIRONMENT == "PROD" ) {

    define("BASE_URL", "http://ehpad.silverpricing.fr");
    define("BASE_API_URL", "http://api.silverpricing.fr");
    define("RESIDENCE_MGMT_PATH", "/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/sites/all/modules/residence_mgmt");
    define("RESIDENCE_MGMT_WKHTMLTOPDF", "/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/sites/all/modules/residence_mgmt/wkhtmltox/bin/wkhtmltopdf");

    define('DRUPAL_RESIDENCE_CACHE', RESIDENCE_MGMT_PATH . "/data/cache");

} else if( ENVIRONMENT == "DEV" ) {
    
    define("BASE_URL", "https://residence-management.dev");
    define("BASE_API_URL", "https://french-data.dev");
    define("RESIDENCE_MGMT_PATH", "C:\laragon\www\\residence-management\sites\all\modules\\residence_mgmt");
    define("RESIDENCE_MGMT_WKHTMLTOPDF", "C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe");

    define('DRUPAL_RESIDENCE_CACHE', RESIDENCE_MGMT_PATH . "\data\cache");

} 
