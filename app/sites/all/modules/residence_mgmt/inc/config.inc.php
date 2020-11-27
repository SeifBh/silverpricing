<?php

define("ENVIRONMENT", "PROD");
if(stripos($_SERVER['HTTP_HOST'],'.home')){
    define("BASE_URL", "https://ehpad.home");
    #define("BASE_API_URL", "http://api.silverpricing.fr");
    define("BASE_API_URL", "https://laravel.home");
}else{
    define("BASE_URL", "http://ehpad.silverpricing.fr");
    define("BASE_API_URL", "http://api.silverpricing.fr");
}
// define("BASE_URL", "https://residence-management.dev");

// define("BASE_API_URL", "https://french-data.dev");

define("RESIDENCE_MGMT_DATA", "/sites/all/modules/residence_mgmt/data");

// define("RESIDENCE_MGMT_WKHTMLTOPDF", "C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe");

define("RESIDENCE_MGMT_WKHTMLTOPDF", "/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/sites/all/modules/residence_mgmt/wkhtmltox/bin/wkhtmltopdf");
