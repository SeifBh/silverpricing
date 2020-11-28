<?php

/**
 * Residences
 */

function findAllResidences() {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->leftjoin('field_data_field_finess', 'ff', 'ff.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_gestionnaire', 'g', 'g.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->leftjoin('node', 'c', 'rc.entity_id = c.nid', array());
    $query->leftjoin('field_data_field_tarif_chambre_simple', 't', 't.entity_id = c.nid and t.field_tarif_chambre_simple_value != :tarif', array( ':tarif' => 'NA' ));
    $query->fields('n', array('nid', 'title'));
    $query->fields('ff', array('field_finess_value'));
    $query->fields('l', array('field_location_locality'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('g', array('field_gestionnaire_value'));
    $query->fields('c', array('title'));
    $query->fields('t', array('field_tarif_chambre_simple_value'));

    $residences = $query->execute()->fetchAll();

    return $residences;
}

function findResidenceByDepartment($departmentId) {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->innerjoin('field_data_field_departement', 'd', 'd.entity_id = n.nid and d.field_departement_tid = :departmentId', array( ':departmentId' => $departmentId ));
    $query->leftjoin('field_data_field_finess', 'ff', 'ff.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_gestionnaire', 'g', 'g.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_url_source', 'src', 'src.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->leftjoin('node', 'c', 'rc.entity_id = c.nid', array());
    $query->leftjoin('field_data_field_tarif_chambre_simple', 't', 't.entity_id = c.nid and t.field_tarif_chambre_simple_value != :tarif', array( ':tarif' => 'NA' ));
    $query->fields('n', array('nid', 'title'));
    $query->fields('ff', array('field_finess_value'));
    $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('g', array('field_gestionnaire_value'));
    $query->fields('src', array('field_url_source_value'));
    $query->fields('c', array('nid','title'));
    $query->fields('t', array('field_tarif_chambre_simple_value'));

    $residences = $query->execute()->fetchAll();

    return $residences;
}

function findResidencesByGroup( $groupId ) {
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_groupe', 'grp', 'grp.entity_id = n.nid and grp.field_groupe_tid = :groupId', array( ':groupId' => $groupId ));
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    $query->join('field_data_field_finess', 'ff', 'ff.entity_id = n.nid', array());
    $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
    $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
    $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid', array());
    $query->join('field_data_field_capacite', 'capacite', 'capacite.entity_id =  n.nid', array());
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 't', 't.entity_id = rc.entity_id', array());
    $query->fields('n', array('nid', 'title'));
    $query->fields('ff', array('field_finess_value'));
    $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
    $query->fields('lat', array('field_latitude_value'));
    $query->fields('lng', array('field_longitude_value'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('t', array('field_tarif_chambre_simple_value'));
    $query->fields('capacite', array('field_capacite_value'));

    $residences = $query->execute()->fetchAll();

    return $residences;
}

function searchResidencesByGroup($groupeId = null, $dataForm = array()) {

  $query = db_select('node', 'n');
  $query->condition('n.type', "residence", '=');
  $query->join('field_data_field_groupe', 'g', 'g.entity_id = n.nid and g.field_groupe_tid = :groupeId', array( ':groupeId' => $groupeId ));
  $query->join('field_data_field_finess', 'ff', 'ff.entity_id = n.nid', array());
  $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
  $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
  $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
  $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
  $query->join('field_data_field_capacite', 'capacite', 'capacite.entity_id =  n.nid', array());
  $query->join('field_data_field_departement', 'dn', 'dn.entity_id = n.nid', array());
  $query->join('taxonomy_term_data', 'd', 'd.tid = dn.field_departement_tid', array());
  $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
  $query->join('field_data_field_tarif_chambre_simple', 't', 't.entity_id = rc.entity_id', array());
  $query->leftjoin('taxonomy_term_data', 'grp', 'g.field_groupe_tid = grp.tid', array());
  $query->leftjoin('field_data_field_logo', 'logo', 'logo.entity_id = grp.tid', array());

  $query->fields('n', array('nid', 'title'));
  $query->fields('ff', array('field_finess_value'));
  $query->fields('d', array('name'));
  $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
  $query->fields('lng', array('field_longitude_value'));
  $query->fields('lat', array('field_latitude_value'));
  $query->fields('s', array('field_statut_value'));
  $query->fields('grp', array('name'));
  $query->fields('logo', array('field_logo_fid'));
  $query->fields('t', array('field_tarif_chambre_simple_value'));
  $query->fields('capacite', array('field_capacite_value'));

  if( isset($dataForm['residence']) && !empty($dataForm['residence']) ) {
      $query->condition('n.title', '%' . $dataForm['residence'] . '%', 'LIKE');
  }

  if(  isset($dataForm['ville']) && !empty($dataForm['ville']) ) {
      $query->condition('l.field_location_locality', '%' . $dataForm['ville'] . '%', 'LIKE');
  }

  if( isset($dataForm['departement']) && !empty($dataForm['departement']) ) {
      $query->condition('dn.field_departement_tid', $dataForm['departement'], 'IN');
  }

  $residences = $query->execute()->fetchAll();

  return $residences;

}

function findResidenceById($residenceId) {
    $residence = null;
    if( $residenceId != null ) {
        $residence = entity_load('node', array($residenceId), array( 'type' => 'residence' ));
    }
    return $residence;
}

function addResidenceByJsonObject( $residenceData = null ) {

    $statuses = array("Privé commercial" => "Privé", "Privé non lucratif" => "Associatif", "Public" => "Public");

    $newResidence = new stdClass();
    $newResidence->type = 'residence';
    $newResidence->title = $residenceData->title;
    $newResidence->body = "";
    $newResidence->language = LANGUAGE_NONE;
    node_object_prepare($newResidence);

    $newResidence->field_finess[$newResidence->language][0]['value'] = $residenceData->noFinesset;

    $newResidence->field_email[$newResidence->language][0]['value'] = $residenceData->coordinates->emailContact;
    $newResidence->field_site[$newResidence->language][0]['value'] = $residenceData->coordinates->website;
    $newResidence->field_telephone[$newResidence->language][0]['value'] = $residenceData->coordinates->phone;
    $newResidence->field_gestionnaire[$newResidence->language][0]['value'] = $residenceData->coordinates->gestionnaire;

    $newResidence->field_alzheimer[$newResidence->language][0]['value'] = (int) $residenceData->IsALZH;
    $newResidence->field_accueil_de_jour[$newResidence->language][0]['value'] = (int) $residenceData->IsACC_JOUR;
    $newResidence->field_aide_sociale[$newResidence->language][0]['value'] = (int) $residenceData->IsHAB_AIDE_SOC;

    $newResidence->field_capacite[$newResidence->language][0]['value'] = $residenceData->capacity;
    $newResidence->field_statut[$newResidence->language][0]['value'] = $statuses[$residenceData->legal_status];

    $newResidence->field_tarif_gir_1_2[$newResidence->language][0]['value'] = $residenceData->ehpadPrice->tarifGir12;
    $newResidence->field_tarif_gir_3_4[$newResidence->language][0]['value'] = $residenceData->ehpadPrice->tarifGir34;
    $newResidence->field_tarif_gir_5_6[$newResidence->language][0]['value'] = $residenceData->ehpadPrice->tarifGir56;

    $newResidence->field_location[$newResidence->language][0]['country'] = "FR";
    $newResidence->field_location[$newResidence->language][0]["thoroughfare"] =$residenceData->coordinates->street;
    $newResidence->field_location[$newResidence->language][0]['locality'] = $residenceData->coordinates->city;
    $newResidence->field_location[$newResidence->language][0]['postal_code'] = $residenceData->coordinates->postcode;
    $newResidence->field_latitude[$newResidence->language][0]['value'] = $residenceData->coordinates->latitude;
    $newResidence->field_longitude[$newResidence->language][0]['value'] = $residenceData->coordinates->longitude;

    $residenceDep = findDepartmentByNumber($residenceData->coordinates->deptcode);
    $newResidence->field_departement[$newResidence->language][0]['tid'] = $residenceDep->tid;

    $newResidence->field_groupe[$newResidence->language][0]['tid'] = 102;

    node_save($newResidence);

    $newChambre = new stdClass();
    $newChambre->type = 'chambre';
    $newChambre->title = $residenceData->title;
    $newChambre->language = LANGUAGE_NONE;
    node_object_prepare($newChambre);

    $newChambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'] = $residenceData->ehpadPrice->prixHebPermCs;
    $newChambre->field_tarif_chambre_double[LANGUAGE_NONE][0]['value'] = $residenceData->ehpadPrice->prixHebPermCd;
    $newChambre->field_tarif_chambre_simple_tempo[LANGUAGE_NONE][0]['value'] = $residenceData->ehpadPrice->prixHebTempCs;
    $newChambre->field_tarif_chambre_double_tempo[LANGUAGE_NONE][0]['value'] = $residenceData->ehpadPrice->prixHebTempCd;
    $newChambre->field_residence[LANGUAGE_NONE][0]['target_id'] = $newResidence->nid;

    if( $residenceData->ehpadPrice->updatedAt != "NA" ) {
        $newChambre->field_date_de_modification[LANGUAGE_NONE][0]["value"]["date"] = date_format(date_create($residenceData->ehpadPrice->updatedAt), 'Y-m-d H:i:s');
    } else {
        $newChambre->field_date_de_modification[LANGUAGE_NONE][0]["value"]["date"] = date('Y-m-d H:i:s');
    }

    node_save($newChambre);

}

function addResidenceSrcXls( $residenceData = null ) {

    $statuses = array("Privé commercial" => "Privé", "Privé non lucratif" => "Associatif", "Public" => "Public");

    echo "FINESS : " . $residenceData['nofinesset'] . "<br />";

    $newResidence = new stdClass();
    $newResidence->type = 'residence';
    $newResidence->title = $residenceData['raison_sociale'];
    $newResidence->body = "";
    $newResidence->language = LANGUAGE_NONE;
    node_object_prepare($newResidence);

    $newResidence->field_finess[$newResidence->language][0]['value'] = $residenceData['nofinesset'];
    $newResidence->field_email[$newResidence->language][0]['value'] = $residenceData['courriel'];
    $newResidence->field_site[$newResidence->language][0]['value'] = $residenceData['site'];
    $newResidence->field_telephone[$newResidence->language][0]['value'] = $residenceData['tel'];
    $newResidence->field_gestionnaire[$newResidence->language][0]['value'] = $residenceData['gestionnaire'];
    $newResidence->field_alzheimer[$newResidence->language][0]['value'] = $residenceData['is_alzh'];
    $newResidence->field_accueil_de_jour[$newResidence->language][0]['value'] = $residenceData['is_acc_jour'];
    $newResidence->field_aide_sociale[$newResidence->language][0]['value'] = $residenceData['is_aide_soc'];
    $newResidence->field_capacite[$newResidence->language][0]['value'] = $residenceData['capa_totale'];
    $newResidence->field_statut[$newResidence->language][0]['value'] = $statuses[$residenceData['statut_jur']];
    $newResidence->field_tarif_gir_1_2[$newResidence->language][0]['value'] = $residenceData['tarifGir12'];
    $newResidence->field_tarif_gir_3_4[$newResidence->language][0]['value'] = $residenceData['tarifGir34'];
    $newResidence->field_tarif_gir_5_6[$newResidence->language][0]['value'] = $residenceData['tarifGir56'];
    $newResidence->field_location[$newResidence->language][0]['country'] = "FR";
    $newResidence->field_location[$newResidence->language][0]["thoroughfare"] = $residenceData['adr_num_voie'] . " " . $residenceData['adr_type_voie'] . " " . $residenceData['adr_nom_voie'] . " " . $residenceData['adr_lieu_dit'];
    $newResidence->field_location[$newResidence->language][0]['locality'] = $residenceData['adr_ville'];
    $newResidence->field_location[$newResidence->language][0]['postal_code'] = $residenceData['adr_cp'];
    $newResidence->field_latitude[$newResidence->language][0]['value'] = $residenceData['adr_y'];
    $newResidence->field_longitude[$newResidence->language][0]['value'] = $residenceData['adr_x'];

    $newResidence->field_departement[$newResidence->language][0]['tid'] = convertPostalCodeToDepartment($residenceData['adr_cp']);

    $newResidence->field_groupe[$newResidence->language][0]['tid'] = 102;

    node_save($newResidence);

    $newChambre = new stdClass();
    $newChambre->type = 'chambre';
    $newChambre->title = $residenceData['raison_sociale'];
    $newChambre->language = LANGUAGE_NONE;
    node_object_prepare($newChambre);

    $newChambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'] = $residenceData['prixHebPermCs'];
    $newChambre->field_tarif_chambre_double[LANGUAGE_NONE][0]['value'] = $residenceData['prixHebPermCd'];
    $newChambre->field_tarif_chambre_simple_tempo[LANGUAGE_NONE][0]['value'] = $residenceData['prixHebTempCs'];
    $newChambre->field_tarif_chambre_double_tempo[LANGUAGE_NONE][0]['value'] = $residenceData['prixHebTempCd'];
    $newChambre->field_residence[LANGUAGE_NONE][0]['target_id'] = $newResidence->nid;

    if( $residenceData['dateMaj'] != "NA" ) {
        $newChambre->field_date_de_modification[LANGUAGE_NONE][0]["value"]["date"] = date('Y-m-d H:i:s', $residenceData['dateMaj']);
    } else {
        $newChambre->field_date_de_modification[LANGUAGE_NONE][0]["value"]["date"] = date('Y-m-d H:i:s');
    }

    node_save($newChambre);

}

function addResidence($residenceData = null, $departmentNumber) {

    $departmentId = findDepartmentByNumber($departmentNumber);

    $newResidence = new stdClass();
    $newResidence->type = 'residence';
    $newResidence->title = $residenceData->title;
    $newResidence->body = "";
    $newResidence->language = LANGUAGE_NONE;
    node_object_prepare($newResidence);

    //$newResidence->field_finess[$newResidence->language][0]['value'] = "";
    $newResidence->field_email[$newResidence->language][0]['value'] = $residenceData->email;
    $newResidence->field_site[$newResidence->language][0]['value'] = $residenceData->website;
    $newResidence->field_telephone[$newResidence->language][0]['value'] = $residenceData->phone;
    $newResidence->field_gestionnaire[$newResidence->language][0]['value'] = $residenceData->gestionnaire;
    // $newResidence->field_accueil_de_jour[$newResidence->language][0]['value'] = "";
    // $newResidence->field_aide_sociale[$newResidence->language][0]['value'] = "";
    // $newResidence->field_capacite[$newResidence->language][0]['value'] = "";
    $newResidence->field_statut[$newResidence->language][0]['value'] = $residenceData->statut;
    $newResidence->field_tarif_gir_1_2[$newResidence->language][0]['value'] = $residenceData->tarif[2]["tarif-gir-1-2"];
    $newResidence->field_tarif_gir_3_4[$newResidence->language][0]['value'] = $residenceData->tarif[2]["tarif-gir-3-4"];
    $newResidence->field_tarif_gir_5_6[$newResidence->language][0]['value'] = $residenceData->tarif[2]["tarif-gir-5-6"];
    $newResidence->field_departement[$newResidence->language][0]['tid'] = $departmentId;

    // $newResidence->field_groupe[$newResidence->language][0]['value'] = "";
    $newResidence->field_location[$newResidence->language][0]['country'] = "FR";
    $newResidence->field_location[$newResidence->language][0]['locality'] = $residenceData->location[0]['address']['city'];
    $newResidence->field_location[$newResidence->language][0]['postal_code'] = $residenceData->location[0]['address']['postcode'];
    $newResidence->field_latitude[$newResidence->language][0]['value'] = $residenceData->location[0]['lat'];
    $newResidence->field_longitude[$newResidence->language][0]['value'] = $residenceData->location[0]['lon'];

    node_save($newResidence);

    return $newResidence;
}

function updateResidence($entityId  = null) {
    $residence = node_load($entityId);

    varDebug($residence);
    exit();
}

function addChambre($chambreData = null, $residence = null) {

    $newChambre = new stdClass();
    $newChambre->type = 'chambre';
    $newChambre->title = $residence->title;
    $newChambre->language = LANGUAGE_NONE;
    node_object_prepare($newChambre);

    $newChambre->field_tarif_chambre_simple[$newChambre->language][0]['value'] = $chambreData[0]['chambre-seule'];
    $newChambre->field_tarif_chambre_double[$newChambre->language][0]['value'] = $chambreData[0]['chambre-double'];
    $newChambre->field_tarif_chambre_simple_tempo[$newChambre->language][0]['value'] = $chambreData[1]['chambre-seule'];
    $newChambre->field_tarif_chambre_double_tempo[$newChambre->language][0]['value'] = $chambreData[1]['chambre-double'];
    $newChambre->field_residence[$newChambre->language][0]['target_id'] = $residence->nid;

    node_save($newChambre);

    return $newChambre;

}

function updateChambre($entityId = null, $data) {
    $chambre = node_load($entityId);

    if( !empty($data) ) {
        // Tarifs
        $chambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_simple'];
        $chambre->field_tarif_chambre_double[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_double'];
        $chambre->field_tarif_chambre_simple_tempo[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_simple_temporaire'];
        $chambre->field_tarif_chambre_double_tempo[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_double_temporaire'];
        $chambre->field_tarif_cs_aide_sociale[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_simple_aide_sociale'];
        $chambre->field_tarif_cd_aide_sociale[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_double_aide_sociale'];

        // Nombre de chambres
        $chambre->field_nombre_cs_entre_de_gamme[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cs_entree_de_gamme']);
        $chambre->field_nombre_cs_standard[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cs_standard']);
        $chambre->field_nombre_cs_superieur[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cs_superieur']);
        $chambre->field_nombre_cs_luxe[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cs_luxe']);
        $chambre->field_nombre_cs_alzheimer[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cs_alzheimer']);
        $chambre->field_nombre_cs_aide_sociale[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cs_aide_sociale']);
        $chambre->field_nombre_cd_standard[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cd_standard']);
        $chambre->field_nombre_cd_aide_sociale[LANGUAGE_NONE][0]['value'] = intval($data['nombre_cd_aide_sociale']);

        // Date de modification
        $chambre->field_date_de_modification[LANGUAGE_NONE][0]['value'] = date("Y-m-d H:i:s");

        $chambre->revision = TRUE;
        $chambre->is_current = TRUE;

        // varDebug($chambre->field_nombre_cs_entre_de_gamme);
        // exit();

        node_save($chambre);

    }

}

function synchronizeChambre( $entityId, $data) {

    $chambre = node_load($entityId);

    if( !empty($data) ) {
        // Tarifs
        if(isset($data->tarif['csa']))$chambre->field_tarif_cs_aide_sociale[LANGUAGE_NONE][0]['value'] = $data->tarif['csa'];
        if(isset($data->tarif['cda']))$chambre->field_tarif_cd_aide_sociale[LANGUAGE_NONE][0]['value'] = $data->tarif['cda'];

        $chambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'] = ( is_numeric($data->tarif[0]['chambre-seule']) ) ? $data->tarif[0]['chambre-seule'] : "NA";
        $chambre->field_tarif_chambre_double[LANGUAGE_NONE][0]['value'] = ( is_numeric($data->tarif[0]['chambre-double']) ) ? $data->tarif[0]['chambre-double'] : "NA";

        $chambre->field_tarif_chambre_simple_tempo[LANGUAGE_NONE][0]['value'] = ( is_numeric($data->tarif[1]['chambre-seule']) ) ? $data->tarif[1]['chambre-seule'] : "NA";
        $chambre->field_tarif_chambre_double_tempo[LANGUAGE_NONE][0]['value'] = ( is_numeric($data->tarif[1]['chambre-double']) ) ? $data->tarif[1]['chambre-double'] : "NA";

        // Date de modification
        if( empty($chambre->field_date_de_modification[LANGUAGE_NONE][0]['value']) || (!empty($data->modificationDate) && (strtotime($data->modificationDate) >= strtotime($chambre->field_date_de_modification[LANGUAGE_NONE][0]['value']))) ) {

            $chambre->field_date_de_modification[LANGUAGE_NONE][0]['value'] = $data->modificationDate;

            $chambre->revision = TRUE;
            $chambre->is_current = TRUE;

            node_save($chambre);

            $residence = node_load($chambre->field_residence[LANGUAGE_NONE][0]['target_id']);
            if( empty($residence->field_url_source[LANGUAGE_NONE][0]['value']) ) {
                $residence->field_url_source[LANGUAGE_NONE][0]['value'] = $data->urlSource;
                node_save($residence);
            }

        }

    }

}

// function getResidencesConcurrentes($currentLatitude, $currentLongitude, $currentResidenceId, $currentStatut = NULL) {

//     $query = db_select('node', 'n');
//     $query->condition('n.type', "residence", '=');
//     $query->condition('n.nid', $currentResidenceId, '<>');
//     if($currentStatut != NULL) {
//         $query->join('field_data_field_statut', 's', 's.entity_id = n.nid and s.field_statut_value = :statut', array(':statut'=> $currentStatut));
//     } else {
//         $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
//     }
//     $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
//     $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
//     $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array(':tarif' => 'NA'));
//     $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
//     $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
//     $query->fields('n', array('nid', 'title'));
//     $query->fields('s', array('field_statut_value'));
//     $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
//     $query->fields('cs', array('field_tarif_chambre_simple_value'));
//     $query->fields('lat', array('field_latitude_value'));
//     $query->fields('lng', array('field_longitude_value'));
//     $query->addExpression('(6371 * acos(cos(radians(lat.field_latitude_value)) * cos(radians(:latitude) ) * cos(radians(:longitude) -radians(lng.field_longitude_value)) + sin(radians(lat.field_latitude_value)) * sin(radians(:latitude))))', 'distance', array( ':latitude' => $currentLatitude, ':longitude' => $currentLongitude ));
//     $query->orderBy('distance', 'ASC');
//     $query->range(0, 10);
//     $residences = $query->execute()->fetchAll();

//     return $residences;

// }

function getRankingResidenceConcurrente($residenceId) {

    $residence = entity_load('node', array($residenceId), array( 'type' => 'residence' ));
    $residenceRanking = [ 'departement' => 'NA', 'concurrence_direct' => 'NA' ];

    // POSITION PAR RAPPORT AU DEPARTEMENT
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid and d.field_departement_tid = :departement', array( ':departement' => $residence[$residenceId]->field_departement['und'][0]['tid'] ));
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
    $query->fields('n', array('nid'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->orderBy('CAST(cs.field_tarif_chambre_simple_value AS DECIMAL(6, 2) )', 'DESC');
    $residences = $query->execute()->fetchAll();

    foreach( $residences as $position => $r ) {
        if( $r->nid == $residenceId ) {
            $residenceRanking['departement'] = $position + 1;
            break;
        }
    }

    // POSITION PAR RAPPORT AUX RESIDENCES CONCURRENTES
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid and s.field_statut_value = :statut', array(':statut'=> $residence[$residenceId]->field_statut['und'][0]['value']));
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
    $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
    $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
    $query->fields('n', array('nid'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->addExpression('(6371 * acos(cos(radians(lat.field_latitude_value)) * cos(radians(:latitude) ) * cos(radians(:longitude) -radians(lng.field_longitude_value)) + sin(radians(lat.field_latitude_value)) * sin(radians(:latitude))))', 'distance', array( ':latitude' => $residence[$residenceId]->field_latitude['und'][0]['value'], ':longitude' => $residence[$residenceId]->field_longitude['und'][0]['value'] ));
    $query->orderBy('distance', 'ASC');
    $query->range(0, 11);
    $residences = $query->execute()->fetchAll();

    foreach( $residences as $key => $r ) {
        $residences[$key]->field_tarif_chambre_simple_value = (double) $r->field_tarif_chambre_simple_value;
    }

    usort($residences, function($r1, $r2) {
        if( $r1->field_tarif_chambre_simple_value == $r2->field_tarif_chambre_simple_value ) {
            return 0;
        }
        return ( $r1->field_tarif_chambre_simple_value > $r2->field_tarif_chambre_simple_value ) ? -1 : 1;
    });

    foreach( $residences as $position => $r ) {
        if( $r->nid == $residenceId ) {
            $residenceRanking['concurrence_direct'] = $position + 1;
            break;
        }
    }

    return $residenceRanking;
}

function getResidencesConcurrentesOnAddress($latitude, $longitude, $perimetre = 5, $statut = null) {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    if( $statut != null ) {
      $query->join('field_data_field_statut', 's', 's.entity_id = n.nid and s.field_statut_value = :statut', array(':statut'=> $statut));
    } else {
      $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    }
    $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
    $query->join('field_data_field_gestionnaire', 'g', 'g.entity_id = n.nid', array());
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id', array());
    $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
    $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());

    // DEPARTEMENT
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid', array());
    $query->join('taxonomy_term_data', 't', 'd.field_departement_tid = t.tid', array());

    // GROUPE
    $query->join('field_data_field_groupe', 'grp', 'grp.entity_id = n.nid', array());
    $query->join('taxonomy_term_data', 'grp_term', 'grp.field_groupe_tid = grp_term.tid', array());
    $query->join('field_data_field_logo', 'grp_logo', 'grp_logo.entity_id = grp_term.tid', array());

    $query->fields('n', array('nid', 'title'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->fields('g', array('field_gestionnaire_value'));
    $query->fields('lat', array('field_latitude_value'));
    $query->fields('lng', array('field_longitude_value'));
    $query->fields('t', array('name'));

    $query->fields('grp_term', array('name'));
    $query->fields('grp_logo', array('field_logo_fid'));

    $query->addExpression('(6371 * acos(cos(radians(lat.field_latitude_value)) * cos(radians(:latitude) ) * cos(radians(:longitude) -radians(lng.field_longitude_value)) + sin(radians(lat.field_latitude_value)) * sin(radians(:latitude))))', 'distance', array( ':latitude' => $latitude, ':longitude' => $longitude ));
    $query->where('(6371 * acos(cos(radians(lat.field_latitude_value)) * cos(radians(:latitude) ) * cos(radians(:longitude) -radians(lng.field_longitude_value)) + sin(radians(lat.field_latitude_value)) * sin(radians(:latitude)))) <= :perimetre', array( ':perimetre' => $perimetre, ':latitude' => $latitude, ':longitude' => $longitude ));
    $query->orderBy('distance', 'ASC');
    $residences = $query->execute()->fetchAll();

    return $residences;

}

function getAllDepartmentsRelatedToResidences($groupes, $residenceIds) {

    $groupes = ( count($groupes) >= 1 ) ? $groupes : null;
    $residenceIds = ( count($residenceIds) >= 1 ) ? $residenceIds : null;

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_groupe', 'gr', 'gr.entity_id = n.nid', array());
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid', array());
    $query->fields('d', array('field_departement_tid'));
    $query->where("n.nid IN (:residenceIds) or gr.field_groupe_tid IN (:groupes)", array( ':residenceIds' => $residenceIds, ':groupes' => $groupes ));
    $query->distinct();

    $departments = $query->execute()->fetchCol();

    return $departments;

}

function findResidencesByUserAccess($groupes, $residenceIds, $departement = null) {

    $groupes = ( count($groupes) >= 1 ) ? $groupes : null;
    $residenceIds = ( count($residenceIds) >= 1 ) ? $residenceIds : null;

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
    $query->join('field_data_field_gestionnaire', 'g', 'g.entity_id = n.nid', array());
    $query->join('field_data_field_capacite', 'c', 'c.entity_id = n.nid', array());
    $query->join('field_data_field_groupe', 'gr', 'gr.entity_id = n.nid', array());
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id', array());

    if( $departement != null ) {
        $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid and d.field_departement_tid = :departementId', array( ':departementId' => $departement ));
    }

    // LEFT JOIN / NOMBRE TOTAL DE CHAMBRES
    // $query->leftjoin('field_data_field_nombre_cs_entre_de_gamme', 'nombre_cs_entre_de_gamme', 'nombre_cs_entre_de_gamme.entity_id = rc.entity_id', array());
    // $query->leftjoin('field_data_field_nombre_cs_standard', 'nombre_cs_standard', 'nombre_cs_standard.entity_id = rc.entity_id', array());
    // $query->leftjoin('field_data_field_nombre_cs_superieur', 'nombre_cs_superieur', 'nombre_cs_superieur.entity_id = rc.entity_id', array());
    // $query->leftjoin('field_data_field_nombre_cs_luxe', 'nombre_cs_luxe', 'nombre_cs_luxe.entity_id = rc.entity_id', array());
    // $query->leftjoin('field_data_field_nombre_cs_alzheimer', 'nombre_cs_alzheimer', 'nombre_cs_alzheimer.entity_id = rc.entity_id', array());
    // $query->leftjoin('field_data_field_nombre_cs_aide_sociale', 'nombre_cs_aide_sociale', 'nombre_cs_aide_sociale.entity_id = rc.entity_id', array());
    // $query->leftjoin('field_data_field_nombre_cd_standard', 'nombre_cd_standard', 'nombre_cd_standard.entity_id = rc.entity_id', array());
    // $query->leftjoin('field_data_field_nombre_cd_aide_sociale', 'nombre_cd_aide_sociale', 'nombre_cd_aide_sociale.entity_id = rc.entity_id', array());

    $query->fields('n', array('nid', 'title'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->fields('g', array('field_gestionnaire_value'));
    $query->fields('c', array('field_capacite_value'));
    // $query->addExpression('nombre_cs_entre_de_gamme.field_nombre_cs_entre_de_gamme_value + nombre_cs_standard.field_nombre_cs_standard_value + nombre_cs_superieur.field_nombre_cs_superieur_value + nombre_cs_luxe.field_nombre_cs_luxe_value + nombre_cs_alzheimer.field_nombre_cs_alzheimer_value + nombre_cs_aide_sociale.field_nombre_cs_aide_sociale_value + nombre_cd_standard.field_nombre_cd_standard_value * 2 + nombre_cd_aide_sociale.field_nombre_cd_aide_sociale_value * 2', 'nombre_lits');

    $query->where("n.nid IN (:residenceIds) or gr.field_groupe_tid IN (:groupes)", array( ':residenceIds' => $residenceIds, ':groupes' => $groupes ));

    $residences = $query->execute()->fetchAll();

    return $residences;
}

function findResidence($departementId = null, $dataForm = array()) {

  $query = db_select('node', 'n');
  $query->condition('n.type', "residence", '=');
  $query->join('field_data_field_finess', 'ff', 'ff.entity_id = n.nid', array());
  $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
  $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
  $query->join('field_data_field_groupe', 'g', 'g.entity_id = n.nid', array());
  $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
  $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
  $query->join('taxonomy_term_data', 'grp', 'g.field_groupe_tid = grp.tid', array());
  $query->leftJoin('field_data_field_logo', 'logo', 'logo.entity_id = grp.tid', array());
  $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid and d.field_departement_tid = :departementId', array( ':departementId' => $departementId ));
  $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
  $query->innerjoin('node', 'c', 'rc.entity_id = c.nid', array());
  $query->join('field_data_field_tarif_chambre_simple', 't', 't.entity_id = c.nid and t.field_tarif_chambre_simple_value != :tarif', array( ':tarif' => 'NA' ));
  $query->fields('n', array('nid', 'title'));
  $query->fields('ff', array('field_finess_value'));
  $query->fields('l', array('field_location_locality'));
  $query->fields('lng', array('field_longitude_value'));
  $query->fields('lat', array('field_latitude_value'));
  $query->fields('s', array('field_statut_value'));
  $query->fields('grp', array('name'));
  $query->fields('logo', array('field_logo_fid'));
  $query->fields('c', array('title'));
  $query->fields('t', array('field_tarif_chambre_simple_value'));

  if( isset($dataForm['residence']) && !empty($dataForm['residence']) ) {
      $query->condition('n.title', '%' . $dataForm['residence'] . '%', 'LIKE');
  }

  if(  isset($dataForm['code_postale']) && !empty($dataForm['code_postale']) ) {
      $query->condition('l.field_location_postal_code', '%' . $dataForm['code_postale'] . '%', 'LIKE');
  }

  if(  isset($dataForm['ville']) && !empty($dataForm['ville']) ) {
      $query->condition('l.field_location_locality', '%' . $dataForm['ville'] . '%', 'LIKE');
  }

  if( $dataForm['statut'] && !empty($dataForm['statut']) ) {
      $query->condition('s.field_statut_value', $dataForm['statut'], 'IN');
  }

  if( $dataForm['tarif_min'] && !empty( $dataForm['tarif_min']) ) {
      $query->condition('t.field_tarif_chambre_simple_value',  $dataForm['tarif_min'], ">=");
  }

  if(  $dataForm['tarif_max'] && !empty($dataForm['tarif_max']) ) {
      $query->condition('t.field_tarif_chambre_simple_value', $dataForm['tarif_max'], "<=");
  }

  $residences = $query->execute()->fetchAll();

  return $residences;

}

function getMonthlyEvolutionDataChart($residenceId = null) {

    // RESIDENCE
    $residence = entity_load('node', array($residenceId), array( 'type' => 'residence' ));
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->condition('n.nid', $residenceId, '=');
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
    $query->fields('n', array('nid'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $residenceCourante = $query->execute()->fetchAll();
    // $revisions = node_revision_list(node_load($residenceId));

    // DEPARTEMENT
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid and d.field_departement_tid = :departement', array( ':departement' => $residence[$residenceId]->field_departement['und'][0]['tid'] ));
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
    $query->fields('n', array('nid'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    //$query->addExpression("DATE_FORMAT(FROM_UNIXTIME(n.created),'%Y-%m')", "created_at");
    //$query->groupBy('created_at');
    $residences = $query->execute()->fetchAll();

    // RESIDENCES CONCURRENTES
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->condition('n.nid', $residenceId, '<>');
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid and s.field_statut_value = :statut', array(':statut'=> $residence[$residenceId]->field_statut['und'][0]['value']));
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
    $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
    $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
    $query->fields('n', array('nid'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->addExpression('(6371 * acos(cos(radians(lat.field_latitude_value)) * cos(radians(:latitude) ) * cos(radians(:longitude) -radians(lng.field_longitude_value)) + sin(radians(lat.field_latitude_value)) * sin(radians(:latitude))))', 'distance', array( ':latitude' => $residence[$residenceId]->field_latitude['und'][0]['value'], ':longitude' => $residence[$residenceId]->field_longitude['und'][0]['value'] ));
    $query->orderBy('distance', 'ASC');
    $query->range(0, 10);
    $residencesConcurrentes = $query->execute()->fetchAll();

    $rTarifs = [];
    $rcTarifs = [];

    foreach( $residences as $r ) {
        $rTarifs[] = (double) $r->field_tarif_chambre_simple_value;
    }

    foreach( $residencesConcurrentes as $r ) {
        $rcTarifs[] = (double) $r->field_tarif_chambre_simple_value;
    }

    $dataMonthlyEvolution = array(
        'tarif' => $residenceCourante[0]->field_tarif_chambre_simple_value,
        'tarif_moyen_departement' => moyen($rTarifs),
        'tarif_moyen_concurrence' => moyen($rcTarifs),
    );

    return $dataMonthlyEvolution;
}

/**
 * TMH Maquette
 */

function getMaquettesOfResidences( $residenceIds ) {

  $query = new EntityFieldQuery();
  $result = $query->entityCondition('entity_type', 'node')
      ->entityCondition('bundle', 'tmh_maquette')
      ->fieldCondition('field_residence', 'target_id', $residenceIds, 'IN')
      ->execute();

  if (!empty($result['node'])) {
      $nids = array_keys($result['node']);
      $nodes = node_load_multiple($nids);

      return $nodes;
  }

  return [];
}

function countMaquettes( $residenceId ) {

  $query = new EntityFieldQuery();
  $result = $query->entityCondition('entity_type', 'node')
      ->entityCondition('bundle', 'tmh_maquette')
      ->fieldCondition('field_residence', 'target_id', $residenceId, '=')
      ->count()
      ->execute();

  return $result;
}

function getAllMaquettes( $residenceId ) {

    $query = new EntityFieldQuery();
    $result = $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', 'tmh_maquette')
        ->fieldCondition('field_residence', 'target_id', $residenceId, '=')
        ->execute();

    if (!empty($result['node'])) {
        $nids = array_keys($result['node']);
        $nodes = node_load_multiple($nids);

        return $nodes;
    }

    return [];
}

function addTMHMaquette( $maquette, $residenceId ) {

    $newMaquette = new stdClass();
    $newMaquette->type = 'tmh_maquette';
    $newMaquette->title = "TMH " . date('d-m-Y');
    $newMaquette->language = LANGUAGE_NONE;
    node_object_prepare($newMaquette);

    $newMaquette->field_residence[LANGUAGE_NONE][0]['target_id'] = $residenceId;
    $newMaquette->field_tmh[LANGUAGE_NONE][0]['value'] = $maquette->tmh;

    $newMaquette->field_cs_entree_de_gamme_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->entreeDeGamme->tarif;
    $newMaquette->field_cs_entree_de_gamme_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->entreeDeGamme->nombreDeLits;
    $newMaquette->field_cs_standard_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->standard->tarif;
    $newMaquette->field_cs_standard_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->standard->nombreDeLits;
    $newMaquette->field_cs_superieur_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->superieur->tarif;
    $newMaquette->field_cs_superieur_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->superieur->nombreDeLits;
    $newMaquette->field_cs_luxe_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->luxe->tarif;
    $newMaquette->field_cs_luxe_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->luxe->nombreDeLits;
    $newMaquette->field_cs_alzheimer_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->alzheimer->tarif;
    $newMaquette->field_cs_alzheimer_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->alzheimer->nombreDeLits;
    $newMaquette->field_cs_aide_sociale_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->aideSociale->tarif;
    $newMaquette->field_cs_aide_sociale_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresSimples->aideSociale->nombreDeLits;

    $newMaquette->field_cd_standard_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresDoubles->standard->tarif;
    $newMaquette->field_cd_standard_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresDoubles->standard->nombreDeLits;
    $newMaquette->field_cd_aide_sociale_tarif[LANGUAGE_NONE][0]['value'] = $maquette->chambresDoubles->aideSociale->tarif;
    $newMaquette->field_cd_aide_sociale_lits[LANGUAGE_NONE][0]['value'] = $maquette->chambresDoubles->aideSociale->nombreDeLits;

    node_save($newMaquette);
}

function removeTMHMaquette( $maquetteId ) {
    $maquette = node_load($maquetteId);
    if( $maquette->type == "tmh_maquette" ) {
        node_delete( $maquetteId );
        return $maquette;
    }
}

function addTMHMaquetteToFavoris( $fieldFavoris, $maquetteId ) {

  $maquette = node_load($maquetteId);

  $query = new EntityFieldQuery();
  $result = $query->entityCondition('entity_type', 'node')
      ->entityCondition('bundle', 'tmh_maquette')
      ->fieldCondition('field_residence', 'target_id', $maquette->field_residence[LANGUAGE_NONE][0]['target_id'], '=')
      ->fieldCondition('field_favoris', 'value', 1, '=')
      ->execute();

  $nids = array_keys($result['node']);

  foreach( $nids as $nid ) {
      $maquetteUpdated =  node_load($nid);
      $maquetteUpdated->field_favoris[LANGUAGE_NONE][0]['value'] = 0;
      node_save($maquetteUpdated);
  }

  $maquette->field_favoris[LANGUAGE_NONE][0]['value'] = $fieldFavoris;
  node_save($maquette);

}

/**
 *  History
 */

function addHistory($historyData = array()) {

  $history = new stdClass();
  $history->type = 'history';
  $history->title = $historyData['title'];
  $history->uid = $historyData['creator'];
  $history->language = LANGUAGE_NONE;
  node_object_prepare($history);

  $history->body[$history->language][0]['value'] = json_encode($historyData['body']);
  $history->field_balance_consumed[$history->language][0]['value'] = $historyData['balance_consumed'];

  node_save($history);#£

}

function getHistories() {

  global $user;

  $query = db_select('node', 'n');
  $query->condition('n.type', "history", '=');
  $query->condition('n.uid', $user->uid, '=');
  $query->join('field_data_field_balance_consumed', 'b', 'b.entity_id = n.nid', array());
  $query->leftjoin('field_data_body', 'body', 'body.entity_id = n.nid', array());

  $query->fields('n', array('nid', 'title', 'created'));
  $query->fields('b', array('field_balance_consumed_value'));
  $query->fields('body', array('body_value'));
  $query->orderBy('n.created', 'DESC');

  $histories = $query->execute()->fetchAll();

  return $histories;

}

/**
 * Departments
 */

function getAllDepartments() {
    $vocabulary = taxonomy_vocabulary_machine_name_load('departement');
    $tree = taxonomy_get_tree($vocabulary->vid);

    return $tree;
}

function getAllDepartmentsByNumberAndName() {
    $departments = array();
    $vocabulary = taxonomy_vocabulary_machine_name_load('departement');
    $tree = taxonomy_get_tree($vocabulary->vid);

    foreach($tree as $term) {
        $numDepartment = substr($term->name, 0, stripos($term->name, " - "));
        $departments[$numDepartment] = $term->name;
    }

    asort($departments);

    return $departments;
}

function findDepartmentsByGroup($groupId) {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_groupe', 'gr', 'gr.entity_id = n.nid', array());
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid', array());
    $query->join('taxonomy_term_data', 't', 't.tid = d.field_departement_tid', array());
    $query->fields('d', array('field_departement_tid'));
    $query->fields('t', array('name'));
    $query->where("gr.field_groupe_tid = :groupId", array( ':groupId' => $groupId ));
    $query->groupBy("d.field_departement_tid");
    $query->orderBy("d.field_departement_tid");

    $results = $query->execute()->fetchAll();

    return $results;
}

function findDepartmentById($departmentId) {
    return taxonomy_term_load($departementId);
}

function findDepartmentByNumber($departmentNumber) {
    $vocabulary = taxonomy_vocabulary_machine_name_load('departement');
    $tree = taxonomy_get_tree($vocabulary->vid);

    foreach($tree as $term) {
        $numDepartment = substr($term->name, 0, stripos($term->name, " - "));
        if( $numDepartment == $departmentNumber ) {
            return $term->tid;
        }
    }

    return FALSE;
}

function codepostalExist() {

}

function convertPostalCodeToDepartment( $postalCode = null ) {
    $codePostal = null;
    $departementId = null;
    $numDepartement = null;
    $otherDepartments = array(
        '2A' => ["20167","20000","20090","20167","20167","20128","20112","20151","20167","20110","20160","20140","20151","20116","20190","20121","20160","20119","20129","20110","20100","20166","20136","20169","20111","20142","20151","20170","20133","20190","20130","20164","20111","20140","20117","20134","20160","20118","20123","20135","20168","20138","20148","20126","20167","20117","20126","20144","20114","20100","20190","20143","20157","20100","20100","20100","20128","20160","20128","20153","20137","20160","20170","20139","20165","20141","20112","20140","20171","20160","20117","20140","20113","20113","20112","20125","20147","20134","20147","20121","20167","20140","20115","20131","20166","20123","20144","20117","20125","20166","20138","20150","20140","20137","20110","20142","20122","20160","20121","20121","20118","20144","20112","20190","20121","20134","20170","20151","20137","20143","20151","20145","20167","20100","20140","20127","20147","20125","20140","20152","20146","20135","20134","20167","20163","20100","20117","20133","20128","20167","20172","20160","20118","20110","20167","20116","20173","20132","20190","20124","20112"],
        '2B' => ["20243","20270","20243","20244","20212","20224","20270","20220","20230","20270","20212","20272","20270","20220","20260","20276","20225","20253","20290","20228","20200","20600","20226","20252","20620","20235","20290","20222","20230","20212","20228","20224","20214","20260","20244","20229","20270","20290","20252","20230","20217","20235","20229","20229","20244","20237","20215","20224","20290","20250","20620","20270","20217","20213","20212","20235","20218","20218","20218","20236","20225","20238","20221","20230","20240","20256","20224","20250","20226","20237","20290","20212","20244","20275","20253","20212","20234","20225","20237","20230","20212","20213","20236","20600","20245","20218","20240","20227","20237","20251","20243","20220","20237","20218","20244","20225","20252","20230","20215","20224","20290","20240","20260","20228","20248","20245","20270","20259","20212","20287","20240","20200","20270","20218","20229","20214","20290","20214","20220","20230","20230","20218","20238","20243","20219","20239","20225","20225","20229","20219","20217","20234","20226","20226","20217","20217","20232","20217","20232","20259","20290","20236","20234","20290","20226","20251","20229","20253","20290","20213","20234","20230","20272","20270","20215","20234","20229","20229","20251","20229","20218","20229","20230","20233","20218","20200","20243","20251","20234","20242","20246","20220","20290","20228","20234","20259","20232","20240","20250","20237","20230","20229","20218","20290","20215","20218","20290","20243","20221","20213","20237","20229","20246","20250","20247","20248","20219","20244","20239","20260","20240","20217","20218","20213","20213","20243","20246","20230","20230","20244","20200","20230","20212","20221","20220","20250","20230","20200","20221","20220","20230","20228","20246","20250","20213","20290","20212","20243","20215","20233","20240","20213","20246","20250","20226","20229","20230","20230","20270","20234","20219","20248","20270","20250","20240","20218","20234","20229","20221","20235","20232","20259","20290","20230","20231","20240","20215","20229","20224","20215","20242","20290","20279","20200","20219","20219","20290","20272","20214","20272"]
    );
    if( $postalCode != null ) {

        if( strlen($postalCode) == 4 ) {
            $codePostal = "0" . $postalCode;
        } else {
            $codePostal = $postalCode;
        }

        if( in_array($codePostal, $otherDepartments['2A']) ) {
            $numDepartement = "2A";
        } else if(in_array($codePostal, $otherDepartments['2B'])) {
            $numDepartement = "2B";
        } else if(substr($codePostal, 0, 2) ==  "97" ) {
            $numDepartement = substr($codePostal, 0, 3);
        } else {
            $numDepartement = substr($codePostal, 0, 2);
        }

        $departementId = findDepartmentByNumber($numDepartement);

        // echo "Code postal : $postalCode <br />";
        // echo "Code postal : $codePostal <br />";
        // echo "Numéro de departement: $numDepartement <br />";
        // echo "Department tid : $departementId <br />";

        return $departementId;
    }
}

function getLatLngResidencesByDepartment( $departementId ) {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('field_data_field_finess', 'ff', 'ff.entity_id = n.nid', array());
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
    $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid and d.field_departement_tid = :departementId', array( ':departementId' => $departementId ));
    $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->innerjoin('node', 'c', 'rc.entity_id = c.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 't', 't.entity_id = c.nid and t.field_tarif_chambre_simple_value != :tarif', array( ':tarif' => 'NA' ));

    $query->leftjoin('field_data_field_groupe', 'g', 'g.entity_id = n.nid', array());
    $query->leftjoin('taxonomy_term_data', 'grp', 'g.field_groupe_tid = grp.tid', array());
    $query->leftjoin('field_data_field_logo', 'logo', 'logo.entity_id = grp.tid', array());

    $query->fields('n', array('nid', 'title'));
    $query->fields('ff', array('field_finess_value'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('lng', array('field_longitude_value'));
    $query->fields('lat', array('field_latitude_value'));
    $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
    $query->fields('t', array('field_tarif_chambre_simple_value'));
    $query->fields('logo', array('field_logo_fid'));

    $residences = $query->execute()->fetchAll();

    return $residences;

}

/**
 * RESIDENCE PRICING UPDATES
 */
function addResidencePricingUpdate( $nid, $oldPrice, $newPrice ) {
    // NEW, ARCHIVED
    $newPricingResidence = null;
    try {
      $newPricingResidence = db_insert('residence_pricing_updates')
        ->fields(array('residence_nid', 'old_price', 'new_price', 'status', 'created_at'))
        ->values(array(
            'residence_nid' => $nid,
            'old_price' => $oldPrice,
            'new_price' => $newPrice,
            'status' => 'NEW',
            'created_at' => date('Y-m-d H:m:s'),
        ))
        ->execute();
    } catch( Exception $e ) {
        echo "Error : " . $e->getMessage() . "\n";
    }

    return $newPricingResidence;
}

function archiveResidencePricingUpdate( $id ) {

  $archivePricingResidence = null;
  try {
    $archivePricingResidence = db_update('residence_pricing_updates')
      ->fields(array(
          'status' => 'ARCHIVED',
          'updated_at' => date('Y-m-d H:m:s'),
      ))
      ->condition('id', $id, '=')
      ->execute();
  } catch( Exception $e ) {
      echo "Error : " . $e->getMessage() . "\n";
  }

  return $archivePricingResidence;
}

/**
 * INDEXATION / SEARCH
 */
function indexDistanceBetweenTwoPoints( $primaryNid, $secondaryNid ) {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->condition('n.nid', array($primaryNid, $secondaryNid), 'IN');
    $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
    $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
    $query->fields('n', array('nid', 'title'));
    $query->fields('lat', array('field_latitude_value'));
    $query->fields('lng', array('field_longitude_value'));
    $residences = $query->execute()->fetchAllAssoc('nid');

    $distance = getDistance(
      $residences[$primaryNid]->field_latitude_value,
      $residences[$primaryNid]->field_longitude_value,
      $residences[$secondaryNid]->field_latitude_value,
      $residences[$secondaryNid]->field_longitude_value
    );

    try {
      $residence = db_insert('distance_indexation')
        ->fields(array('primary_nid', 'secondary_nid', 'distance'))
        ->values(array(
            'primary_nid' => $primaryNid,
            'secondary_nid' => $secondaryNid,
            'distance' => $distance
            ))
        ->execute();
    } catch( Exception $e ) {
        echo "Error : " . $e->getMessage() . "\n";
    }

}

function indexationExist( $pnid, $snid ) {

  $indexationExist = db_query(
        "SELECT count(*) from {distance_indexation} WHERE primary_nid = :primary_nid and secondary_nid = :secondary_nid",
        array( ":primary_nid" => $pnid, ":secondary_nid" => $snid )
      )->fetchField();

  return ($indexationExist >= 1) ? true : false;

}

function getResidencesByRadius( $residenceNid, $radius = 5) {

    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('distance_indexation', 'di', 'di.secondary_nid = n.nid and di.primary_nid = :pnid and distance <= :radius', array( ':pnid' => $residenceNid, ':radius' => $radius ));
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array(':tarif' => 'NA'));
    $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
    $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());
    $query->fields('n', array('nid', 'title'));
    $query->fields('di', array('primary_nid', 'distance'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->fields('lat', array('field_latitude_value'));
    $query->fields('lng', array('field_longitude_value'));
    $query->orderBy('di.distance', 'ASC');
    $residences = $query->execute()->fetchAll();

    return $residences;

}

function getResidencesProchesByStatus( $residenceNid, $statuses = array(), $limit = 10) {

  if( empty($statuses) ) { $statuses = array('Public', 'Associatif', 'Privé'); }

  $query = db_select('node', 'n');
  $query->condition('n.type', "residence", '=');
  $query->join('distance_indexation', 'di', 'di.secondary_nid = n.nid and di.primary_nid = :pnid', array( ':pnid' => $residenceNid ));
  $query->join('field_data_field_statut', 's', 's.entity_id = n.nid and s.field_statut_value IN (:statuses)', array(':statuses'=> $statuses));
  $query->join('field_data_field_location', 'l', 'l.entity_id = n.nid', array());
  $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
  $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array(':tarif' => 'NA'));
  $query->join('field_data_field_latitude', 'lat', 'lat.entity_id = n.nid', array());
  $query->join('field_data_field_longitude', 'lng', 'lng.entity_id = n.nid', array());

  $query->fields('n', array('nid', 'title'));
  $query->fields('di', array('primary_nid', 'distance'));
  $query->fields('s', array('field_statut_value'));
  $query->fields('l', array('field_location_locality', 'field_location_postal_code'));
  $query->fields('cs', array('field_tarif_chambre_simple_value'));
  $query->fields('lat', array('field_latitude_value'));
  $query->fields('lng', array('field_longitude_value'));
  $query->orderBy('di.distance', 'ASC');
  $query->range(0, $limit);
  $residences = $query->execute()->fetchAll();

  return $residences;
}
