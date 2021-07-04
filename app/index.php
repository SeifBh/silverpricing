<?php #d7 index
#require_once'../auto_prepend.php';
define('DRUPAL_ROOT', getcwd());
$f=DRUPAL_ROOT . '/includes/bootstrap.inc';
require_once 'autoload.php';
if(strpos($_SERVER['HTTP_HOST'],'.home')){#£:ben:custom
    $_ENV['path']['drupal']['database']=DRUPAL_ROOT.'includes';   
    $f='/Users/ben/home/overrides/d7.bootstrap.php';
}
require_once $f;
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
menu_execute_active_handler();
return;?>
