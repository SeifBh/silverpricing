<?php
namespace Alptech\Wip;
return [
    'defaultHost'=>$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/',
    'host'=>$_SERVER['HTTP_HOST'],
    'logCollectorUrl' => $_SERVER['REQUEST_SCHEME'].'://1.x24.fr/a/logCollector.php',#exposed path loading alptech
    'logCollectorSecret'=>'secretBenSeed',

    'mysql'=>['h' => '127.0.0.1', 'silverpricing' => 'a', 'p' => 'Silverpicing@wynter@2020', 'db' => 'silverpricing_db','names'=>'utf8'],
    'mysql_host' => '127.0.0.1','mysql_user' => 'a', 'mysql_pass' => 'b', 'mysql_db' => 'alptech',#bash

    'routes'=>['/route1'=>['router','test']],
    'a'=>['b'=>1],
    'devIps'=>['127.0.0.1'],'localhostIps'=>['127.0.0.1'],
    'ip2hostname'=>['127.0.0.1'=>'local'],
#multidimensional ignored for bash variables


    /** activate the logs here */
    'log'=>1,
    'sendLogs' => 1,
    'logdir' => 'logs',
    'errorLog'=>'logs/errorLog.log',
    'exceptionsLog'=>'logs/exceptions.log',
    'logCollectorSeed'=>'%y%m%d',#one valid per day, avoid Hours if datetime resolution is not the same sync or timezone, will cause mismatches
    'authorizedIps'=>['local'=>'127.0.0.1','l6'=>'::1','pom2'=>'2a01:e0a:2d7:fe0:cda9:527f:604a:10e9'],

    'pathSeparator' => '-_',
    'thumbAuthorizedWidths' => [100],
    'thumbAuthorizedHeights' => [100],
    'thumbnailsDir' => 'y/thumbs/',
    'defaultImage' => 'y/default.png',
    'mediaTypes' => 'jpeg,jpg,png,webp,ico,gif,woff,ttf,eot,woff2,css,js,map',#404 is /**/
];?>

