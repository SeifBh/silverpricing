
<?php

/**
* implement hook_menu()
* create menu residences
*/
function residence_mgmt_menu() {
    global $menuItems;
/**  } END BEN{*****/


    $menuItems['profile/%'] = array(
        'title'             =>  'Profile',
        'page callback'     =>  'residence_mgmt_profile',
        'page arguments'    => array( 1 ),
        'access callback'   =>  true,
    );

    $menuItems['dashboard'] = array(
        'title'             =>  'Dashboard',
        'page callback'     =>  'residence_mgmt_dashboard',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DASHBOARD'),
    );

    $menuItems['quick_win'] = array(
        'title'             =>  'Quick win',
        'page callback'     =>  'residence_mgmt_get_quick_win',
        'access callback'   =>  true,
    );

    $menuItems['mes_maquettes'] = array(
        'title'             =>  'Mes maquettes',
        'page callback'     =>  'residence_mgmt_get_mes_maquettes',
        'access callback'   =>  true,
    );

    $menuItems['maquette/%'] = array(
        'title'             =>  'Ma maquette',
        'page callback'     =>  'residence_mgmt_get_ma_maquette',
        'page arguments'    => array( 1 ),
        'access callback'   =>  true,
    );

    $menuItems['departements'] = array(
        'title'             =>  'Departements',
        'page callback'     =>  'residence_mgmt_departements',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEPARTEMENTS'),
    );

    $menuItems['departement/%'] = array(
        'title'             =>  'Département',
        'page callback'     =>  'residence_mgmt_residences',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEPARTEMENT'),
    );

    $menuItems['groupes'] = array(
        'title'             =>  'Groupes',
        'page callback'     =>  'residence_mgmt_get_groupes',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_GROUPES'),
    );

    $menuItems['groupe/%'] = array(
        'title'             =>  'Groupe',
        'page callback'     =>  'residence_mgmt_get_groupe_details',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_GROUPE'),
    );

    $menuItems['residence/%'] = array(
        'title'             =>  'Residence',
        'page callback'     =>  'residence_mgmt_get_residence_details',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DETAIL_RESIDENCE'),
    );

    $menuItems['mes-residences'] = array(
        'title'             =>  'Residence',
        'page callback'     =>  'residence_mgmt_get_my_residences',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_RESIDENCES'),
    );

    $menuItems['edit-residence/%'] = array(
        'title'             =>  'Modifier la résidence',
        'page callback'     =>  'residence_mgmt_edit_residence',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_RESIDENCES'),
    );

    $menuItems['mes-groupes'] = array(
        'title'             =>  'Mes Groupes',
        'page callback'     =>  'residence_mgmt_get_my_groups',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_GROUPES'),
    );

    $menuItems['edit-groupe/%'] = array(
        'title'             =>  'Modifier le groupe',
        'page callback'     =>  'residence_mgmt_edit_groupe',
        'page arguments'    => array( 1 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_MES_GROUPES'),
    );

    $menuItems['development-tools'] = array(
        'title'             =>  'Développement tools',
        'page callback'     =>  'residence_mgmt_development_tools',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEVELOPPEMENT_TOOLS'),
    );

    $menuItems['recherche-silverex'] = array(
        'title'             =>  'Recherche SilverPricing',
        'page callback'     =>  'residence_mgmt_recherche_silverex',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_RESIDENCES'),
    );

    $menuItems['histories'] = array(
        'title'             =>  'Historiques',
        'page callback'     =>  'residence_mgmt_get_my_histories',
        'access callback'   =>  true,
    );

    $menuItems['history/%'] = array(
        'title'             =>  'Historique',
        'page callback'     =>  'residence_mgmt_get_history',
        'page arguments'    => array( 1 ),
        'access callback'   => true
    );

    // AJAX

    $menuItems['ajax/geocoding-silverex'] = array(
        'title'             =>  'Geocoding Silverex',
        'page callback'     =>  'residence_mgmt_geocoding_silverex',
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_RESIDENCES'),
    );

    $menuItems['ajax/departement-info/%'] = array(
        'title'             =>  'Departement Info',
        'page callback'     =>  'residence_mgmt_departement_info',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEPARTEMENTS'),
    );

    $menuItems['ajax/add-tmh-maquette/%'] = array(
        'title'             =>  'TMH Maquette',
        'page callback'     =>  'residence_mgmt_add_tmh_maquette',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $menuItems['ajax/remove-tmh-maquette/%'] = array(
        'title'             =>  'TMH Maquette',
        'page callback'     =>  'residence_mgmt_remove_tmh_maquette',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $menuItems['ajax/historique-maquettes/%'] = array(
        'title'             =>  'Historique des maquettes',
        'page callback'     =>  'residence_mgmt_get_historique_maquettes',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $menuItems['ajax/nbre-maquettes/%'] = array(
        'title'             =>  'Count des maquettes',
        'page callback'     =>  'residence_mgmt_nbre_maquettes',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $menuItems['ajax/add-maquette-to-favoris/%'] = array(
        'title'             =>  'TMH Maquette',
        'page callback'     =>  'residence_mgmt_add_maquette_to_favoris',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('OPTIMISATION_RESIDENCE_TMH'),
    );

    $menuItems['ajax/get-evolution-menusuelle-des-tarifs/%'] = array(
        'title'             =>  'Evolution Mensuelle des tarifs',
        'page callback'     =>  'residence_mgmt_get_evolution_menusuelle_des_tarifs',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DETAIL_RESIDENCE'),
    );

    $menuItems['ajax/get-geojson-of-cities-by-department'] = array(
        'title'             =>  'Geojson de communes par département',
        'page callback'     =>  'residence_mgmt_get_geojson_of_cities_by_department',
        'page arguments'    => array(),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEVELOPPEMENT_TOOLS'),
    );

    $menuItems['ajax/get-dvf-of-commune/%'] = array(
        'title'             =>  'DVF de commune',
        'page callback'     =>  'residence_mgmt_get_dvf_of_commune',
        'page arguments'    => array( 2 ),
        'access callback'   => 'residence_mgmt_user_plan_has_access',
        'access arguments' => array('PAGE_DEVELOPPEMENT_TOOLS'),
    );

    // GED
    $menuItems['ged/%/document/%'] = array(
        'title'             =>  'SilverPricing Documents',
        'page callback'     =>  'residence_mgmt_generate_document',
        'page arguments'    => array( 1, 3 ),
        'access callback'   => true,
    );

    // TOOLS
    $menuItems['scrapping'] = array(
        'title'             =>  'Scrapping',
        'page callback'     =>  'residence_mgmt_scrapping',
        // 'access callback'   => 'residence_mgmt_user_has_role',
        'access arguments'  => array(array('administrator')),
    );

    $menuItems['importation_excel'] = array(
        'title'             =>  'Importation Excel',
        'page callback'     =>  'residence_mgmt_import_residence_xls',
        // 'access callback'   => 'residence_mgmt_user_has_role',
        'access arguments'  => array(array('administrator')),
    );

    // CONFIGURATION
    $menuItems['admin/config/content/residences_management'] = array(
        'title' => t('Residence Management Configuration'),
        'description' => t('La configuration du module residence management.'),
        'page callback' => 'drupal_get_form',
        'page arguments' => array('residence_mgmt_admin_form'),
        'access arguments' => array('administer users'),
        'type' => MENU_NORMAL_ITEM,
    );

    $menuItems['admin/config/content/import_residence_by_finess'] = array(
        'title' => t('Import residence by Finess'),
        'description' => t('This feature give you the possibility to import a new single residence with just finess.'),
        'page callback' => 'drupal_get_form',
        'page arguments' => array('residence_mgmt_get_residence_by_finess'),
        'access arguments' => array('administer users'),
        'type' => MENU_NORMAL_ITEM,
    );

    // METHOD FOR TEST
    $menuItems['test'] = array(
        'title'             =>  'Residences',
        'page callback'     =>  'update_residences_latlong',
        'access callback'   =>  true,
    );

    // METHOD FOR DISTANCE INDEXATION
    $menuItems['distance-indexation'] = array(
        'title'             =>  'Distance Indexation',
        'page callback'     =>  'residence_mgmt_distance_indexation',
        'access callback'   =>  true,
    );

    // METHOD RESIDENCE PRICE UPDATED
    $menuItems['nearby-residence/price-updated/%'] = array(
        'title'             =>  'Distance Indexation',
        'page callback'     =>  'residence_mgmt_nearby_residences_updated',
        'page arguments'    => array( 2 ),
        'access callback'   =>  true,
    );

    return $menuItems;
}

?>
