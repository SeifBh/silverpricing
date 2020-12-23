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

    $residences = fetchAll($query);

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

    $residences = fetchAll($query);

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

    $residences = fetchAll($query);

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

  $residences = fetchAll($query);

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
    $newResidence->language = LANGUAGE_NONE;#und
    node_object_prepare($newResidence);
    if($residenceData->finess){
        $newResidence->field_finess[$newResidence->language][0]['value'] = $residenceData->finess;
    }
    if($residenceData->groupe) {
        $newResidence->field_groupe[$newResidence->language][0]['tid'] = 102;#residenceData->groupe
    }

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
        if($chambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'] != $data['tarif_chambre_simple']){
            $k2v=[];
            $k2v['date']=$k2v['btime']=time();
            $k2v['rid']=$chambre->field_residence['und'][0]['target_id'];
            $k2v['cs_0']=$chambre->field_tarif_chambre_simple[LANGUAGE_NONE][0]['value'];
            $k2v['cs_1']=$data['tarif_chambre_simple'];
            $sql='insert into z_variations '.Alptech\Wip\fun::insertValues($k2v);
            $insertId=Alptech\Wip\fun::sql($sql);#
            $b=1;
        }
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

function synchronizeChambre( $entityId, $data,$finess=null) {
    $residence=null;
    $chambre = node_load($entityId);

    if( !empty($data) ) {
        // Tarifs
        #if(isset($data->tarif['csa']))$chambre->field_tarif_cs_aide_sociale[LANGUAGE_NONE][0]['value'] = $data->tarif['csa'];
        #if(isset($data->tarif['cda']))$chambre->field_tarif_cd_aide_sociale[LANGUAGE_NONE][0]['value'] = $data->tarif['cda'];

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
            if( empty($residence->field_url_source[LANGUAGE_NONE][0]['value']) and isset($data->urlSource) ) {
                $residence->field_url_source[LANGUAGE_NONE][0]['value'] = $data->urlSource;
                node_save($residence);
            }
        }
    }
    return;
    #return [$chambre,$residence];
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
//     $residences = fetchAll($query);

//     return $residences;

// }
function getRankingResidenceConcurrente($residenceId) {return getRankingOfResidence($residenceId);}

function getRankingOfResidence( $residenceNid, $rankingTypes = array() ) {

    // $types = array( "CONCURRENCE_DIRECTE", "DEPARTEMENT" );
    // $residence = entity_load('node', array($residenceNid), array( 'type' => 'residence' ));
    $residenceRanking = array( 'departement' => 'NA', 'concurrence_directe' => 'NA' );

if('elle même'){// RANKED RESIDENCE
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->condition('n.nid', $residenceNid, '=');
    $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid', array());
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid', array());
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
    $query->fields('n', array('nid'));
    $query->fields('d', array('field_departement_tid'));
    $query->fields('s', array('field_statut_value'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->addExpression(0, 'distance', array());
    $rankedResidence = fetchObject($query);
}
    // varDebug($rankedResidence);
    // exit();

    if( in_array("CONCURRENCE_DIRECTE", $rankingTypes) ) {
#todo: greffer z_geo
        $x=Alptech\Wip\fun::sql("select list from z_geo where rid=".$residenceNid);#
        $closests=trim($x[0]['list'],',');
        if(!$closests){
            \Alptech\Wip\fun::dbm('missing zgeo for:'.$residenceNid,'zgeo');
        }else{


if(0 and 'oldway'){// POSITION PAR RAPPORT A LA CONCURRENCE
    $query = db_select('distance_indexation', 'di');
    $query->condition('di.primary_nid', $residenceNid, "=");
    $query->join('node', 'r', 'di.secondary_nid = r.nid', array());
    $query->join('field_data_field_statut', 's', 's.entity_id = r.nid and s.field_statut_value = :statut', array(':statut'=> $rankedResidence->field_statut_value ));
    $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = r.nid', array());
    $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
    $query->fields('r', array('nid'));
    $query->fields('cs', array('field_tarif_chambre_simple_value'));
    $query->fields('di', array('distance'));
    $query->orderBy('distance', 'ASC');
    $query->range(0, 10);
    $residences = fetchAll($query);
    $limit10a="SELECT r.nid AS nid, cs.field_tarif_chambre_simple_value AS field_tarif_chambre_simple_value, di.distance AS distance FROM distance_indexation di INNER JOIN node r ON di.secondary_nid = r.nid
INNER JOIN field_data_field_statut s ON s.entity_id = r.nid and s.field_statut_value = 'Privé'
INNER JOIN field_data_field_residence rc ON rc.field_residence_target_id = r.nid
INNER JOIN field_data_field_tarif_chambre_simple cs ON cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> 'NA'
WHERE  (di.primary_nid = 40233) 
ORDER BY distance ASC
LIMIT 10 OFFSET 0";
}

$a="select entity_id from field_data_field_statut where field_statut_value='".$rankedResidence->field_statut_value."' and entity_id in(".$closests.") ORDER BY FIELD(entity_id,$closests) limit 0,10";
$having=[];$x=Alptech\Wip\fun::sql($a);foreach($x as $t){$having[]=$t['entity_id'];}###"
#field_departement_tid
$limit10b="SELECT r.nid AS nid, cs.field_tarif_chambre_simple_value AS field_tarif_chambre_simple_value FROM  node r 
-- INNER JOIN field_data_field_statut s ON s.entity_id = r.nid -- and s.field_statut_value = '".$rankedResidence->field_statut_value."'
INNER JOIN field_data_field_residence rc ON rc.field_residence_target_id = r.nid
INNER JOIN field_data_field_tarif_chambre_simple cs ON cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> 'NA'
WHERE  r.nid in (".implode(',',$having).")";#order by id
$residences=Alptech\Wip\fun::sql($limit10b);##
foreach($residences as &$t){$t=(object)$t;}unset($t);

        array_unshift($residences, $rankedResidence);#remove::self
#['distance'=>0,'field_departement_tid'=>60,'field_statut_value'=>'privé','field_tarif_chambre_value'=>1,'nid'=>1];
        // varDebug($residences);
        // exit();

        usort($residences, function($r1, $r2) {
            $firstResidenceTarif = (double) $r1->field_tarif_chambre_simple_value;
            $secondResidenceTarif = (double) $r2->field_tarif_chambre_simple_value;
            if( $firstResidenceTarif == $secondResidenceTarif ) {
                return 0;
            }
            return ( $firstResidenceTarif > $secondResidenceTarif ) ? -1 : 1;
        });

        foreach( $residences as $position => $r ) {
            if( $r->nid == $residenceNid ) {
                $residenceRanking["concurrence_directe"] = $position + 1;
                break;
            }
        }
        }
    }#end concurrencedirecte
    
    if( in_array("DEPARTEMENT", $rankingTypes) ) {

        // POSITION PAR RAPPORT AU DEPARTEMENT
        $query = db_select('node', 'n');
        $query->condition('n.type', "residence", '=');
        $query->join('field_data_field_departement', 'd', 'd.entity_id = n.nid and d.field_departement_tid = :departement', array( ':departement' => $rankedResidence->field_departement_tid ));
        $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = n.nid', array());
        $query->join('field_data_field_tarif_chambre_simple', 'cs', 'cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> :tarif', array( ':tarif' => 'NA' ));
        $query->fields('n', array('nid'));
        $query->fields('cs', array('field_tarif_chambre_simple_value'));
        $query->orderBy('CAST(cs.field_tarif_chambre_simple_value AS DECIMAL(6, 2) )', 'DESC');
        $residences = fetchAll($query);

        foreach( $residences as $position => $r ) {
            if( $r->nid == $residenceNid ) {
                $residenceRanking["departement"] = $position + 1;
                break;
            }
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
    #$_ENV['stop']=__FILE__.__line__;
    $residences = fetchAll($query);
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

    $residences = fetchAll($query);

    return $residences;
}

function getResidencesByUser( $userId ) {

    $queryAccessResidence = db_select('node', 'r');
    $queryAccessResidence->condition('r.type', 'residence', '=');    
    $queryAccessResidence->join('field_data_field_acces_residences', 'ar', 'ar.field_acces_residences_target_id = r.nid and ar.entity_id = :currentUser', array( ':currentUser' => $user->uid ));
    $queryAccessResidence->fields('r', array('nid', 'title'));

    $query = db_select('node', 'r');
    $query->condition('r.type', 'residence', '=');    
    $query->join('field_data_field_acces_groupes', 'ag', 'ag.entity_id = :currentUser', array( ':currentUser' => $userId ));
    $query->join('field_data_field_groupe', 'g', 'g.field_groupe_tid = ag.field_acces_groupes_target_id and g.entity_id = r.nid', array());
    $query->fields('r', array('nid', 'title'));
    $query->union($queryAccessResidence);

    $residences = $query->execute()->fetchCol("nid");

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

  $residences = fetchAll($query);

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
    $residenceCourante = fetchAll($query);
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
    $residences = fetchAll($query);

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
    $residencesConcurrentes = fetchAll($query);

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
    $tel=$groupe=$lits=$adresse=$aidesoc=$tarifs=$alz=$ids=[];foreach($historyData['body']['response'] as $t){$ids[]=intval($t->nid);}
#$r2c=res2ch($ids);$tarifs=chprix($r2c,1);foreach($tarifs as &$t){$t=end($t);}unset($t);#dernière historique $historiquePrix=implode(',',$chp[$rid]);
    $sql="select entity_id as k,field_telephone_value as v from field_data_field_telephone where entity_id in (".implode(',',$ids).") and bundle='residence'";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t)$tel[$t['k']]=$t['v'];
    $sql="select entity_id as k,field_alzheimer_value as v from field_data_field_alzheimer where entity_id in (".implode(',',$ids).") and bundle='residence'";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t)$alz[$t['k']]=$t['v'];
    $sql="select entity_id as k,field_aide_sociale_value as v from field_data_field_aide_sociale where entity_id in (".implode(',',$ids).") and bundle='residence'";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t)$aidesoc[$t['k']]=$t['v'];
    $sql="select entity_id as k,field_capacite_value as v from field_data_field_capacite where entity_id in (".implode(',',$ids).") and bundle='residence'";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t)$lits[$t['k']]=$t['v'];
    $sql="select entity_id as k,field_location_thoroughfare as v from field_data_field_location where entity_id in (".implode(',',$ids).") and bundle='residence'";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t)$adresse[$t['k']]=$t['v'];
    $sql="select entity_id as k,b.name as v from field_data_field_groupe a inner join taxonomy_term_data b on a.field_groupe_tid=b.tid where a.entity_id in (".implode(',',$ids).") and a.bundle='residence'";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t)$groupe[$t['k']]=$t['v'];
#£:todo: Date de construction
# / Groupe /
$a=1;

      $history = new stdClass();
      $history->type = 'history';
      $history->title = $historyData['title'];
      $history->uid = $historyData['creator'];
      $history->language = LANGUAGE_NONE;
        #$history->field_name = $historyData['name'];#[$history->language][0]['value']
         if($historyData['name']) {$history->field_name[LANGUAGE_NONE][0]['value'] = $historyData['name'];}#
      node_object_prepare($history);
    if($historyData['name'] and 1 and 'excel'){
        $fn=$historyData['body']['request']['adresse'].'-'.$historyData['body']['request']['perimetre'];
        $t=(array)$historyData['body']['response'][0];unset($t['nid'],$t['field_logo_fid'],$t['grp_term_name']);
        $headers=array_merge(array_keys($t),['Addresse','Telephone',/*'Tarifs',*/'Alzeihmer','Aide sociale','Lits','Groupe']);#
        $translate=['title'=>'Nom','field_statut_value'=>'type','field_location_locality'=>'ville','field_location_postal_code'=>'code postal','field_tarif_chambre_simple_value'=>'tarif chambre','field_gestionnaire_value'=>'gestionnaire','field_latitude_value'=>'latitude','field_longitude_value'=>'longitude','name'=>'département','distance'=>'distance en km'];
        foreach($headers as &$v){
            if(isset($translate[$v])){$v=$translate[$v];}
            $v=str_replace(['field_','_value',],'',$v);
        }unset($v);
        $lines=[$headers];

        foreach($historyData['body']['response'] as $k=>$t){
            if(is_object($t))$t=(array)$t;$id=$t['nid'];
            unset($t['nid'],$t['field_logo_fid'],$t['grp_term_name']);

            $t['adresse']=(isset($adresse[$id])?$adresse[$id]:'');
            $t['tel']=(isset($tel[$id])?$tel[$id]:'');
            #$t['tarif']=(isset($tarifs[$id])?$tarifs[$id]:'');#déjà listés
            $t['alz']=(isset($alz[$id])?($alz[$id]==1?'oui':'non'):'');
            $t['aids']=(isset($adresse[$id])?($aidesoc[$id]==1?'oui':'non'):'');
            $t['lits']=(isset($lits[$id])?$lits[$id]:'');
            $t['groupe']=(isset($groupe[$id])?$groupe[$id]:'');
            $lines[]=array_values($t);
        }#
        $lines=array_filter($lines);

        try{
#1ère ligne:nom complet de la recherche
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle(substr(preg_replace('~[^a-z0-9 \.]+~is','',$historyData['body']['request']['adresse']),0,31));#31 max chars '.$historyData['body']['request']['adresse'].','.$historyData['body']['request']['perimetre']);
            $cols=[];$letter = 'A';while ($letter !== 'AAA') {$cols[] = $letter++;}
            $sheet->getCell('A1')->setValue($historyData['name']);
            if ('parcours des données') {
                foreach ($lines as $l => $t) {
                    foreach ($t as $c => $v) {
                        $x = $cols[$c];
                        $coord = $x . '' . ($l + 2);#démarre à la seconde ligne
                        $sheet->getCell($coord)->setValue($v);
                    }
                }
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $rp='z/xls/'.$fn.'-'.$GLOBALS['user']->uid.'-'.$GLOBALS['user']->name.'-'.uniqid().'.xlsx';
#could not close
            $writer->save(rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/'.$rp);#$GLOBALS['user']???
            $history->field_excel['und'][0]['value'] =  '/'.$rp;##
        }catch(\Exception $e){
            file_put_contents(ini_get('error_log'),"\n\n}{".print_r($e,1),8);
            $err=1;
        }
    }#end excel
      $history->body[$history->language][0]['value'] = json_encode($historyData['body']);

      $history->field_balance_consumed[$history->language][0]['value'] = $historyData['balance_consumed'];
    node_save($history);
    $_SESSION['public']=['hid'=>$history->nid];
    $_SESSION['hid']=$history->nid;
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

    $query->leftjoin('field_data_field_name', 'name', 'name.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_map', 'map', 'map.entity_id = n.nid', array());
    $query->leftjoin('field_data_field_excel', 'excel', 'excel.entity_id = n.nid', array());

    $query->fields('excel', array('excel'=>'field_excel_value'));
    $query->fields('map', array('name'=>'field_map_value'));
    $query->fields('name', array('name'=>'field_name_value'));

  $query->orderBy('n.created', 'DESC');

  $histories = fetchAll($query);

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

    $results = fetchAll($query);

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

    $residences = fetchAll($query);

    return $residences;

}

/**
 * RESIDENCE PRICING UPDATES
 */
function addResidencePricingUpdate( $nid, $oldPrice, $newPrice ) {

    // NEW, ARCHIVED
    $newPricingResidence = null;

    try {

        $archivePricingResidence = archiveResidencePricingUpdate( $nid );

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

function archiveResidencePricingUpdate( $nid ) {

  $archivePricingResidence = null;
  try {

    $archivePricingResidence = db_update('residence_pricing_updates')
        ->fields(array(
            'status' => 'ARCHIVED',
            'updated_at' => date('Y-m-d H:m:s'),
        ))
        ->condition('residence_nid', $nid, '=')
        ->condition('status', 'NEW', '=')
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
    $residences = fetchAllAssoc($query,'nid');

    $distance = getDistance($residences[$primaryNid]->field_latitude_value, $residences[$primaryNid]->field_longitude_value, $residences[$secondaryNid]->field_latitude_value, $residences[$secondaryNid]->field_longitude_value);

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
    $residences = fetchAll($query);

    return $residences;

}

function getClosests($residenceNid){
    $x=Alptech\Wip\fun::sql("select list from z_geo where rid=".$residenceNid);#
    return trim($x[0]['list'],',');
    #return explode(',',trim($x[0]['list'],','));
}

function getDistances($residenceNid)
{
    $x=Alptech\Wip\fun::sql("select closest from z_geo where rid=".$residenceNid);#
    return json_decode($x[0]['closest'],1);
}

function getResidencesProchesByStatus( $residenceNid, $statuses = [], $limit = 10)
{
if(isset($_COOKIE['old']) and $_COOKIE['old']){#simple commutateur le piu simple ever !
    if (empty($statuses))$statuses = array('Public', 'Associatif', 'Privé');
    $query = db_select('node', 'n');
    $query->condition('n.type', "residence", '=');
    $query->join('distance_indexation', 'di', 'di.secondary_nid = n.nid and di.primary_nid = :pnid', array(':pnid' => $residenceNid));
    $query->join('field_data_field_statut', 's', 's.entity_id = n.nid and s.field_statut_value IN (:statuses)', array(':statuses' => $statuses));
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
    $residences = fetchAll($query);#->execute()->fetchAll();
    return $residences;
}

$clo = getClosests($residenceNid);#sans limites, as a list
$distances=getDistances($residenceNid);
$r2dist=[];foreach($distances as $km=>$rids){foreach($rids as $rid){$r2dist[$rid]=$km;}}

if (!$statuses) {
    $clo=explode(',',$clo);
}else{
    $s = "select entity_id from field_data_field_statut where field_statut_value IN ('" . implode("','", $statuses) . "') and entity_id in($clo) ORDER BY FIELD(entity_id,$clo) limit $limit";#
    $clo = [];
    $x = Alptech\Wip\fun::sql($s);
    foreach ($x as $t) {
        $clo[] = $t['entity_id'];
    }
}

$clo1 = array_slice($clo, 0, $limit);#anyways, ordinary love, mais trimme
if(!$clo1){
    Alptech\Wip\fun::dbm($residenceNid,'noClosestPoints');
    $err=1;
}
asort($r2dist);
$dist=[];foreach($clo as $rid){$dist[$rid]=$r2dist[$rid];}
#dans quel ordre sont-elles présentées ?

$sql="SELECT n.nid AS nid, n.title AS title, $residenceNid AS primary_nid,  s.field_statut_value AS field_statut_value, l.field_location_locality AS field_location_locality, l.field_location_postal_code AS field_location_postal_code, cs.field_tarif_chambre_simple_value AS field_tarif_chambre_simple_value, lat.field_latitude_value AS field_latitude_value, lng.field_longitude_value AS field_longitude_value
FROM node n
-- INNER JOIN distance_indexation di ON di.secondary_nid = n.nid and di.primary_nid = $residenceNid
INNER JOIN field_data_field_statut s ON s.entity_id = n.nid -- and s.field_statut_value IN ('')
INNER JOIN field_data_field_location l ON l.entity_id = n.nid
INNER JOIN field_data_field_residence rc ON rc.field_residence_target_id = n.nid
INNER JOIN field_data_field_tarif_chambre_simple cs ON cs.entity_id = rc.entity_id and cs.field_tarif_chambre_simple_value <> 'NA'
INNER JOIN field_data_field_latitude lat ON lat.entity_id = n.nid
INNER JOIN field_data_field_longitude lng ON lng.entity_id = n.nid
WHERE n.type = 'residence' and n.nid in(".implode(',',$clo).") order by FIELD(n.nid,".implode(',',$clo).") limit $limit";
    $residences = Alptech\Wip\fun::sql($sql);
    foreach ($residences as &$t) {
        $a=1;#$r2dist
        if(isset($r2dist[$t['nid']]))$t['distance']=$r2dist[$t['nid']];
        $t=(object)$t;
    }unset($t);
  return $residences;
}

function distance($lat1,$lat2,$lng1,$lng2)
{
    $r = 6372.797;$pi80 = M_PI / 180;/*1rad*/$lat1 *= $pi80;$lng1 *= $pi80;$lat2 *= $pi80;$lng2 *= $pi80;
    $dlat = $lat2 - $lat1;$dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;
    return $km;
}
