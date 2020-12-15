<?php

namespace Alptech\Wip;

if(isset($_SERVER['WINDIR'])){
    return ['cliHost' => 'https://ehpad.home/', 'cliDocRoot' => 'C:\Users\ben\home\ehpad\app/'];
}#else prod
return ['cliHost' => 'http://ehpad.silverpricing.fr/', 'cliDocRoot' => '/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/'];
