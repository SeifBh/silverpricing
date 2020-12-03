<?php

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/data_config.php";

require_once __DIR__ . "/../inc/tools.inc.php";
require_once __DIR__ . "/../inc/http_client.inc.php";
require_once __DIR__ . "/../inc/cnsa_connector.inc.php";
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

// $residences = array_slice($queue, 0, DRUPAL_RESIDENCE_DATA_SCRAPPING);
$residences = $queue;
$totalCount = count($residences);

// varDebug($residences);
// echo "LENGTH : " . count($queue) . "\n";
// echo "DATE : " . date("Y-m-d") . "\n";
// exit();

echo "------------------------ START ---------------------- \n";

$errors = array(); 

foreach( $residences as $k => $residence) {
    echo "COUNT : " . $k . "/" . $totalCount . "\n";
    echo "FINESS : " . $residence->field_finess_value . "\n";

    $finess = ( strlen($residence->field_finess_value) == 9 ) ? $residence->field_finess_value : "0" . $residence->field_finess_value;

    try {

        $result = getEstablishementByFiness($finess); 

        if( $result != null ) {
            file_put_contents( DRUPAL_RESIDENCE_DATA . "/$finess.json", $result);
        } else {
            echo "RESULT IS EMPTY \n";
        }

    } catch( Exception $e ) {
        $errors[] = $residence;
        echo "Error extracting the content json \n";
        continue;
    }


}

$updateQueue = array_slice($queue, DRUPAL_RESIDENCE_DATA_SCRAPPING);
file_put_contents( DRUPAL_RESIDENCE_DATA_QUEUE . "/data_queue.json", json_encode($updateQueue));
file_put_contents( DRUPAL_RESIDENCE_DATA_QUEUE . "/data_error.json", json_encode($errors));

echo "------------------------- END ----------------------- \n";

exit();
