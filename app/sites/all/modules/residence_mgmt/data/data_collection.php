<?php

define('DRUPAL_RESIDENCE_DATA_SCRAPPING', 50);
define('DRUPAL_RESIDENCE_DATA', __DIR__ . "/residences");
define('DRUPAL_RESIDENCE_DATA_OUTPUT', __DIR__ . "/output");
define('DRUPAL_RESIDENCE_DATA_QUEUE', __DIR__ . "/cron_config");
// define('DRUPAL_ROOT', "C:\laragon\www\\residence-management\\");
define('DRUPAL_ROOT', "/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr");

require_once __DIR__ . "/../inc/tools.inc.php";
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE);

$queue = file_get_contents(DRUPAL_RESIDENCE_DATA_QUEUE . "/data_queue.json");
$queue = json_decode($queue);

if( empty($queue) ) {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->leftjoin('field_data_field_finess', 'ff', 'ff.entity_id = n.nid', array());
    $query->fields('n', array('nid'));
    $query->fields('ff', array('field_finess_value'));
    $query->orderBy("n.nid", "ASC");
    $allResidences = $query->execute()->fetchAll();

    file_put_contents( DRUPAL_RESIDENCE_DATA_QUEUE . "/data_queue.json", json_encode($allResidences));

    $queue = $allResidences;
}

$residences = array_slice($queue, 0, DRUPAL_RESIDENCE_DATA_SCRAPPING);

//varDebug($residences);
// echo "LENGTH : " . count($queue) . "\n";
// echo "DATE : " . date("Y-m-d") . "\n";
// exit();

define("BASE_URL_TARGET", "https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/");

echo "------------------------ START ---------------------- \n";

foreach( $residences as $residence) {

    $finess = ( strlen($residence->field_finess_value) == 9 ) ? $residence->field_finess_value : "0" . $residence->field_finess_value;

    $urlTarget = BASE_URL_TARGET . $finess;

    echo $urlTarget . "\n\n";

    try {

        $result = getRequest( $urlTarget );

        if( $result != null ) {
            file_put_contents( DRUPAL_RESIDENCE_DATA . "/$finess.json", $result);
        }

    } catch( Exception $e ) {
        echo "Error extracting the content json \n";
        continue;
    }


}

$updateQueue = array_slice($queue, DRUPAL_RESIDENCE_DATA_SCRAPPING);
file_put_contents( DRUPAL_RESIDENCE_DATA_QUEUE . "/data_queue.json", json_encode($updateQueue));

echo "------------------------- END ----------------------- \n";

exit();
