<?php

/**
* implement hook_menu()
* create menu residences
*/
function residence_mgmt_menu() {$items = array();
/**  } START BEN {*****/
#drushy cc all
    $items['ra'] = array(#uuid#/%
        'title'             =>  'Evolution des prix',
        'page callback'     =>  'fullAlert2',
        'page arguments'    => array( 1 ),
        'access callback'   => true,
        #'access callback'   => 'fastAccess','access arguments' => array('PAGE_MES_RESIDENCES'),
    );

    $items['updateAllRoomsUuid'] = array(
        'title'             =>  'updateAllRoomsUuid',
        'page callback'     =>  'updateAllRoomsUuid',
        'access callback'   => 'fastAccess',
    );#drushy cc all

    $items['capretraite'] = array(
        'title'             =>  'capretraite',
        'page callback'     =>  'capretraite',
        'access callback'   => 'fastAccess',
    );#drushy cc all

    $items['er/%'] = array(#uuid
        'title'             =>  'Modifier la résidence',
        'page callback'     =>  'editChambreByUuid',
        'page arguments'    => array( 1 ),
        'access callback'   => true,
        #'access callback'   => 'fastAccess','access arguments' => array('PAGE_MES_RESIDENCES'),
    );
    $items['updateAllResidencesByJson'] = array(
        'title'             =>  'updateAllResidencesByJson',
        'access callback'   =>  'fastAccess',
        'page callback'     =>  'residence_mgmt_yo',#residence_mgmt_yo,#drushy cc all
        #'yo/%'=> 'page arguments'    => array( 1 ),
        #'access arguments'  => array(array('administrator')),
    );

    $items['updateHistory'] = array('title' => 'updateHistory', 'access callback' => true, 'page callback' => 'updateHistory');
/**  } END BEN{*****/


    $items['profile/%'] = array(
        'title'             =>  'Profile',
        'page callback'     =>  'residence_mgmt_profile',
        'page arguments'    => array( 1 ),
        'access callback'   =>  true,
    );

    $items['dashboard'] = array(
        'title'             =>  'Dashboard',
        'page callback'     =>  'residence_mgmt_dashboard',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DASHBOARD'),
    );

    $items['quick_win'] = array(
        'title'             =>  'Quick win',
        'page callback'     =>  'residence_mgmt_get_quick_win',
        'access callback'   =>  true,
    );

    $items['mes_maquettes'] = array(
        'title'             =>  'Mes maquettes',
        'page callback'     =>  'residence_mgmt_get_mes_maquettes',
        'access callback'   =>  true,
    );

    $items['maquette/%'] = array(
        'title'             =>  'Ma maquette',
        'page callback'     =>  'residence_mgmt_get_ma_maquette',
        'page arguments'    => array( 1 ),
        'access callback'   =>  true,
    );

    $items['departements'] = array(
        'title'             =>  'Departements',
        'page callback'     =>  'residence_mgmt_departements',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEPARTEMENTS'),
    );

    $items['departement/%'] = array(
        'title'             =>  'Département',
        'page callback'     =>  'residence_mgmt_residences',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEPARTEMENT'),
    );

    $items['groupes'] = array(
        'title'             =>  'Groupes',
        'page callback'     =>  'residence_mgmt_get_groupes',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_GROUPES'),
    );

    $items['groupe/%'] = array(
        'title'             =>  'Groupe',
        'page callback'     =>  'residence_mgmt_get_groupe_details',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_GROUPE'),
    );

    $items['residence/%'] = array(
        'title'             =>  'Residence',
        'page callback'     =>  'residence_mgmt_get_residence_details',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DETAIL_RESIDENCE'),
    );

    $items['mes-residences'] = array(
        'title'             =>  'Residence',
        'page callback'     =>  'residence_mgmt_get_my_residences',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_RESIDENCES'),
    );

    $items['edit-residence/%'] = array(
        'title'             =>  'Modifier la résidence',
        'page callback'     =>  'residence_mgmt_edit_residence',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_RESIDENCES'),
    );

    $items['mes-groupes'] = array(
        'title'             =>  'Mes Groupes',
        'page callback'     =>  'residence_mgmt_get_my_groups',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_GROUPES'),
    );

    $items['edit-groupe/%'] = array(
        'title'             =>  'Modifier le groupe',
        'page callback'     =>  'residence_mgmt_edit_groupe',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_GROUPES'),
    );

    $items['development-tools'] = array(
        'title'             =>  'Développement tools',
        'page callback'     =>  'residence_mgmt_development_tools',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEVELOPPEMENT_TOOLS'),
    );

    $items['recherche-silverex'] = array(
        'title'             =>  'Recherche SilverPricing',
        'page callback'     =>  'residence_mgmt_recherche_silverex',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_RESIDENCES'),
    );

    $items['histories'] = array(
        'title'             =>  'Historiques',
        'page callback'     =>  'residence_mgmt_get_my_histories',
        'access callback'   =>  true,
    );

    $items['history/%'] = array(
        'title'             =>  'Historique',
        'page callback'     =>  'residence_mgmt_get_history',
        'page arguments'    => array( 1 ),
        'access callback'   => true
    );

    // AJAX

    $items['ajax/geocoding-silverex'] = array(
        'title'             =>  'Geocoding Silverex',
        'page callback'     =>  'residence_mgmt_geocoding_silverex',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_RESIDENCES'),
    );

    $items['ajax/departement-info/%'] = array(
        'title'             =>  'Departement Info',
        'page callback'     =>  'residence_mgmt_departement_info',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEPARTEMENTS'),
    );

    $items['ajax/add-tmh-maquette/%'] = array(
        'title'             =>  'TMH Maquette',
        'page callback'     =>  'residence_mgmt_add_tmh_maquette',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $items['ajax/remove-tmh-maquette/%'] = array(
        'title'             =>  'TMH Maquette',
        'page callback'     =>  'residence_mgmt_remove_tmh_maquette',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $items['ajax/historique-maquettes/%'] = array(
        'title'             =>  'Historique des maquettes',
        'page callback'     =>  'residence_mgmt_get_historique_maquettes',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $items['ajax/nbre-maquettes/%'] = array(
        'title'             =>  'Count des maquettes',
        'page callback'     =>  'residence_mgmt_nbre_maquettes',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $items['ajax/add-maquette-to-favoris/%'] = array(
        'title'             =>  'TMH Maquette',
        'page callback'     =>  'residence_mgmt_add_maquette_to_favoris',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $items['ajax/get-evolution-menusuelle-des-tarifs/%'] = array(
        'title'             =>  'Evolution Mensuelle des tarifs',
        'page callback'     =>  'residence_mgmt_get_evolution_menusuelle_des_tarifs',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DETAIL_RESIDENCE'),
    );

    $items['ajax/get-geojson-of-cities-by-department'] = array(
        'title'             =>  'Geojson de communes par département',
        'page callback'     =>  'residence_mgmt_get_geojson_of_cities_by_department',
        'page arguments'    => array(),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEVELOPPEMENT_TOOLS'),
    );

    $items['ajax/get-dvf-of-commune/%'] = array(
        'title'             =>  'DVF de commune',
        'page callback'     =>  'residence_mgmt_get_dvf_of_commune',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEVELOPPEMENT_TOOLS'),
    );

    // GED
    $items['ged/%/document/%'] = array(
        'title'             =>  'SilverPricing Documents',
        'page callback'     =>  'residence_mgmt_generate_document',
        'page arguments'    => array( 1, 3 ),
        'access callback'   => true,
    );

    // TOOLS
    $items['scrapping'] = array(
        'title'             =>  'Scrapping',
        'page callback'     =>  'residence_mgmt_scrapping',
        // 'access callback'   => 'residence_mgmt_user_has_role',
        'access arguments'  => array(array('administrator')),
    );

    $items['importation_excel'] = array(
        'title'             =>  'Importation Excel',
        'page callback'     =>  'residence_mgmt_import_residence_xls',
        // 'access callback'   => 'residence_mgmt_user_has_role',
        'access arguments'  => array(array('administrator')),
    );

    // CONFIGURATION
    $items['admin/config/content/residences_management'] = array(
        'title' => t('Residence Management Configuration'),
        'description' => t('La configuration du module residence management.'),
        'page callback' => 'drupal_get_form',
        'page arguments' => array('residence_mgmt_admin_form'),
        'access arguments' => array('administer users'),
        'type' => MENU_NORMAL_ITEM,
    );

    $items['admin/config/content/import_residence_by_finess'] = array(
        'title' => t('Import residence by Finess'),
        'description' => t('This feature give you the possibility to import a new single residence with just finess.'),
        'page callback' => 'drupal_get_form',
        'page arguments' => array('residence_mgmt_get_residence_by_finess'),
        'access arguments' => array('administer users'),
        'type' => MENU_NORMAL_ITEM,
    );

    // METHOD FOR TEST
    $items['test'] = array(
        'title'             =>  'Residences',
        'page callback'     =>  'update_residences_latlong',
        'access callback'   =>  true,
    );

    // METHOD FOR DISTANCE INDEXATION
    $items['distance-indexation'] = array(
        'title'             =>  'Distance Indexation',
        'page callback'     =>  'residence_mgmt_distance_indexation',
        'access callback'   =>  true,
    );

    // METHOD RESIDENCE PRICE UPDATED
    $items['nearby-residence/price-updated/%'] = array(
        'title'             =>  'Distance Indexation',
        'page callback'     =>  'residence_mgmt_nearby_residences_updated',
        'page arguments'    => array( 2 ),
        'access callback'   =>  true,
    );

    return $items;
}

?>
