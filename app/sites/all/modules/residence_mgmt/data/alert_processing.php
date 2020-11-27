<?php
#£ phpx "C:\Users\ben\home\ehpad\app\sites\all\modules\residence_mgmt\data\alert_processing.php"
// $_SERVER['REMOTE_ADDR'] = "https://residence-management.dev";
$_SERVER['REMOTE_ADDR'] = "http://ehpad.silverpricing.fr";

// define('DRUPAL_ROOT', "C:\laragon\www\\residence-management\\");
define('DRUPAL_ROOT', "/home/ubuntu/SilverPricing/public_html/app.silverpricing.fr");

require_once DRUPAL_ROOT . 'includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo "------------------------ START ---------------------- \n";

$query = db_select('node', 'a');
$query->condition('a.type', "alert", '=');
$query->join('field_data_body', 'b', 'b.entity_id = a.nid', array());
$query->join('field_data_field_plans', 'p', 'p.entity_id = a.nid', array());
$query->join('taxonomy_term_data', 't', 't.tid = p.field_plans_target_id', array());
$query->leftJoin('field_data_field_scheduled', 's', 's.entity_id = a.nid', array());
$query->fields('a', array('nid', 'title'));
$query->fields('b', array('body_value'));
$query->fields('s', array('field_scheduled_value'));#<-
$query->fields('p', array('field_plans_target_id'));
$query->fields('t', array('name'));
$alertSchedule = $query->execute()->fetchAll();#£ Plan Luxe : permet d'avertir les utilisateurs si la concurrence bouge

// echo "<pre>";
// var_dump($alertSchedule);
// echo "</pre>";
// exit();

echo "------------------------ USER ---------------------- \n";

$allUsers = entity_load('user');
$userWithAlerts = [];

foreach( $allUsers as $u ) {
    $userPlan = ( !empty($u->field_plan['und'][0]) ) ? $u->field_plan['und'][0]['target_id'] : null;
    if( $userPlan != null ) {
        $user = new stdClass();
        $user->uid = $u->uid;
        $user->name = $u->name;
        $user->mail = $u->mail;
        $user->plan = $userPlan;
        $userWithAlerts[] = $user;
    }
}

$a='array_intersect';
/* Logique Métier ::
définir un intervalle en nombre de jour :
A) pour le cron déclencher les alerte
B) charger les résidence de cet
C) coordonnées gps
D) les 10 résidences les plus proches ( base de données globale, de la même catégorie :: implicitement :: ehpad privées )
E) racine de la somme des carrés diff ( lat, lon ) distances
*/
// echo "<pre>";
// var_dump($userWithAlerts);
// echo "</pre>";
// exit();

echo "------------------------ ALERT ---------------------- \n";

//SELECT ABS(DATEDIFF('2014-01-27 11:41:14', '2014-01-30 12:10:08')) AS days;
$dataResidencePricingUpdates = array();

echo "------------------------ PROCESS ---------------------- \n";

