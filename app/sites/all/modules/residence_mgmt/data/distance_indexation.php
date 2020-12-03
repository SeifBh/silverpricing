<?php

include __DIR__ . "/data_config.php";

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$start = microtime(true);

echo "------------------------ START ---------------------- \n";

$query = db_select('node', 'n');
$query->condition('n.type', "residence", '=');
$query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
$query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
$query->fields('n', array('nid', 'title'));
$query->fields('lat', array('field_latitude_value'));
$query->fields('lng', array('field_longitude_value'));
$query->orderBy('n.nid', 'ASC');
$residences = $query->execute()->fetchAll();

$totalResidences = count($residences);

for( $m = 0 ; $m < $totalResidences ; $m++ ) {
    for( $i = 0 ; $i < $totalResidences ; $i++ ) {

        echo "Distance between : " . $residences[$m]->nid . " and " . $residences[$i]->nid . " \n";

        if( $residences[$m]->nid == $residences[$i]->nid ) {
            continue;
        }

        if( indexationExist($residences[$m]->nid, $residences[$i]->nid) ) {
            continue;
        }

        $distance = getDistance(
          $residences[$m]->field_latitude_value,
          $residences[$m]->field_longitude_value,
          $residences[$i]->field_latitude_value,
          $residences[$i]->field_longitude_value
        );

        try {

            db_insert('distance_indexation')
                ->fields(array('primary_nid', 'secondary_nid', 'distance'))
                ->values(array(
                    'primary_nid' => $residences[$m]->nid,
                    'secondary_nid' => $residences[$i]->nid,
                    'distance' => $distance
                    ))
                ->execute();

        } catch( Exception $e ) {
            echo "Error : " . $e->getMessage() . "\n";
        }

        echo "Distance : " . $distance . " \n";

    }

}

echo "------------------------ END ---------------------- \n";

$time_elapsed_secs = microtime(true) - $start;

echo $time_elapsed_secs . " seconds \n";

die();
