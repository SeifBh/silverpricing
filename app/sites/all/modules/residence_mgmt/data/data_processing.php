<?php

include __DIR__ . "/data_config.php";

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo "------------------------ START ---------------------- \n";

$residenceList =  array_diff(scandir(DRUPAL_RESIDENCE_DATA), array('..', '.'));


// varDebug($residenceList);
// exit();

foreach( $residenceList as $residenceFileName ) {

    $residenceData = file_get_contents(DRUPAL_RESIDENCE_DATA . "/$residenceFileName");
    $residenceData = json_decode($residenceData);
    $residenceData = $residenceData[0];

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_finess', 'f', 'f.entity_id = n.nid and (f.field_finess_value = :finess or CONCAT(0, f.field_finess_value) = :finess)', array(':finess' => $residenceData->noFinesset ));
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->fields('n', array('nid', 'title'));
    $query->fields('f', array('field_finess_value'));
    $query->fields('rc', array('entity_id'));
    $node = fetchObject($query);

    $chambre = node_load($node->entity_id);

    // varDebug($residenceData);
    // varDebug($node);
    // varDebug($chambre);
    // exit();

    if( !empty($chambre) ) {

        $oldPrice = $chambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'];
        $newPrice = $residenceData->ehpadPrice->prixHebPermCs;

        // UPDATE ROOMS PRICING
        $chambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'] = ( !empty($residenceData->ehpadPrice->prixHebPermCs) ) ? $residenceData->ehpadPrice->prixHebPermCs : "NA";
        $chambre->field_tarif_chambre_double[LANGUAGE_NONE][0]['value'] = ( !empty($residenceData->ehpadPrice->prixHebPermCd) ) ? $residenceData->ehpadPrice->prixHebPermCd : "NA";
        $chambre->field_tarif_chambre_simple_tempo[LANGUAGE_NONE][0]['value'] = ( !empty($residenceData->ehpadPrice->prixHebTempCs) ) ? $residenceData->ehpadPrice->prixHebTempCs : "NA";
        $chambre->field_tarif_chambre_double_tempo[LANGUAGE_NONE][0]['value'] = ( !empty($residenceData->ehpadPrice->prixHebTempCd) ) ? $residenceData->ehpadPrice->prixHebTempCd : "NA";

        echo "NODE ID : " . $chambre->nid . "\n";
        echo "NODE : " . $chambre->field_date_de_modification[LANGUAGE_NONE][0]['value'] . "\n";
        echo "JSON : " . $residenceData->updatedAt . "\n";
        echo "OLD PRICE : " . $oldPrice . "\n";
        echo "NEW PRICE : " . $newPrice . "\n";

        $residenceData->updatedAt = date("Y-m-d h:i:s", strtotime($residenceData->updatedAt));


        // if( empty($chambre->field_date_de_modification[LANGUAGE_NONE][0]['value']) ||
        //     (
        //         !empty($residenceData->updatedAt) &&
        //         (strtotime($residenceData->updatedAt) >= strtotime($chambre->field_date_de_modification[LANGUAGE_NONE][0]['value']))
        //     )
        //   ) {

          if( !empty($newPrice) && $oldPrice != $newPrice ) {

            echo "Saved \n";

            $chambre->field_date_de_modification[LANGUAGE_NONE][0]['value'] = $residenceData->updatedAt;

            $chambre->revision = TRUE;
            $chambre->is_current = TRUE;

            node_save($chambre);

            addResidencePricingUpdate( $node->nid, $oldPrice, $newPrice );

            $OK_DIR  = DRUPAL_RESIDENCE_DATA_OUTPUT . "/" . date("Y-m-d") . "/OK";

            mkdir($OK_DIR, 755, true);

            $source_file = DRUPAL_RESIDENCE_DATA . "/$residenceFileName";
            $destination_path = $OK_DIR . "/$residenceFileName";
            rename($source_file, $destination_path);

        } else {

            echo "Not saved \n";

            $NOK_DIR  = DRUPAL_RESIDENCE_DATA_OUTPUT  . "/" . date("Y-m-d") . "/NOK";

            mkdir($NOK_DIR, 755, true);

            $source_file = DRUPAL_RESIDENCE_DATA . "/$residenceFileName";
            $destination_path = $NOK_DIR . "/$residenceFileName";
            rename($source_file, $destination_path);

        }

    } else {

        echo "Not found \n";

        $NOTEXIST_DIR  = DRUPAL_RESIDENCE_DATA_OUTPUT  . "/" . date("Y-m-d") . "/NOTEXIST";

        mkdir($NOTEXIST_DIR, 755, true);

        $source_file = DRUPAL_RESIDENCE_DATA . "/$residenceFileName";
        $destination_path = $NOTEXIST_DIR . "/$residenceFileName";
        rename($source_file, $destination_path);

    }


}

echo "------------------------- END ----------------------- \n";

exit();
