<?php
#gu;list;phpx ~/home/ehpad/app/z/larav.php
namespace Alptech\Wip;chdir(__DIR__);require_once'../autoload.php';#todo:rename to ajax

$ids=fun::fgc('/c/desk/etablissements-prescripteurs.txt');
$a=1;



$x=fun::sql("update health_organizations set prescripteur=1 where id in(".$ids.")",'larav');
$x=fun::sql("select * from health_organizations limit 10",'larav');
$a=1;
