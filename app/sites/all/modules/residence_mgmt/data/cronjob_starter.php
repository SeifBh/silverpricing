<?php

require_once __DIR__ . "/../vendor/autoload.php";

use GO\Scheduler;


$scheduler = new Scheduler();

$scheduler->php( __DIR__ . '/alert_processing.php')->at('* * * * *');

$scheduler->run();
