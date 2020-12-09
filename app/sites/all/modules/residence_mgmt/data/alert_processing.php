<?php

require_once __DIR__ . "/../vendor/autoload.php";

include __DIR__ . "/data_config.php";

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo "------------------------ INIT ---------------------- \n";

$SchedulingTypes = array( "DAILY" => 1, "WEEKLY" => 7, "MONTHLY" => 30, "QUARTERLY" => 90 );

echo "------------------------ START ---------------------- \n";

$query = db_select('node', 'a');
$query->condition('a.type', "alert", '=');
$query->join('field_data_body', 'b', 'b.entity_id = a.nid', array());
$query->join('field_data_field_plans', 'p', 'p.entity_id = a.nid', array());
$query->join('taxonomy_term_data', 't', 't.tid = p.field_plans_target_id', array());
$query->leftJoin('field_data_field_scheduled', 's', 's.entity_id = a.nid', array());
$query->fields('a', array('nid', 'title'));
$query->fields('b', array('body_value'));
$query->fields('s', array('field_scheduled_value'));
$query->fields('p', array('field_plans_target_id'));
$query->fields('t', array('name'));
$alertes = fetchAll($query);

// echo "<pre>";
// var_dump($alertes);
// echo "</pre>";
// exit();

echo "------------------------ USER ---------------------- \n";

$allUsers = array_map(function( $u ) {
    $user = new stdClass();
    $user->uid = $u->uid;
    $user->name = $u->name;
    $user->mail = $u->mail;
    $user->plan = $u->field_plan;
    $user->groupes = $u->field_acces_groupes;
    $user->residences = $u->field_acces_residences;
    $user->status = $u->status;
    return $user;
}, entity_load('user'));

$users = array_filter($allUsers, function( $u ) {
    if( empty($u->plan) || !$u->status  ) { return FALSE; }
    return TRUE;
});

// varDebug($users);
// exit();

foreach( $users as $ku => $user ) {

    echo "USER / $user->uid : \n";
    
    // GET ALL MY RESIDENCES BY USER
    $queryAccessResidence = db_select('node', 'r');
    $queryAccessResidence->condition('r.type', 'residence', '=');    
    $queryAccessResidence->join('field_data_field_acces_residences', 'ar', 'ar.field_acces_residences_target_id = r.nid and ar.entity_id = :currentUser', array( ':currentUser' => $user->uid ));
    $queryAccessResidence->fields('r', array('nid', 'title'));

    $query = db_select('node', 'r');
    $query->condition('r.type', 'residence', '=');    
    $query->join('field_data_field_acces_groupes', 'ag', 'ag.entity_id = :currentUser', array( ':currentUser' => $user->uid ));
    $query->join('field_data_field_groupe', 'g', 'g.field_groupe_tid = ag.field_acces_groupes_target_id and g.entity_id = r.nid', array());
    $query->fields('r', array('nid', 'title'));
    $query->union($queryAccessResidence);

    $users[$ku]->myResidences = $query->execute()->fetchCol("nid");

    // GET ALL NEARBY RESIDENCES BY USER
        
    $nearbyResidences = array();
    foreach( $users[$ku]->myResidences as $rnid ) {

        $nearbyResidences[$rnid] =  db_select('distance_indexation', 'di')
            ->fields('di', array( 'secondary_nid'))
            ->condition('primary_nid', $rnid)
            ->orderBy('distance', "ASC")
            ->range(0, DRUPAL_RESIDENCE_ALERT_PRICE_UPDATED)->execute()->fetchCol("secondary_nid");
        
    }

    $users[$ku]->nearbyResidences = $nearbyResidences;

}


echo "------------------------ ALERT ---------------------- \n";

$updatedDate = new DateTime();
$updatedDate->sub(new DateInterval("P" . $SchedulingTypes["WEEKLY"] . "D"));

echo $updatedDate->format("Y-m-d H:m:s") . "\n";

foreach( $users as $ku => $user ) {

    $nearbyResidencesUpdated = array();

    foreach( $users[$ku]->nearbyResidences as $rnid => $nearbyResidences ) {

        $query = db_select('residence_pricing_updates', 'rpu');
        $query->condition('rpu.status', 'NEW');
        $query->condition('rpu.created_at', $updatedDate->format("Y-m-d H:m:s"), '>=');
        $query->condition('residence_nid', $nearbyResidences, 'IN');
        $query->join('node', 'r', 'r.type = :type and r.nid = rpu.residence_nid', array( ':type' => 'residence' ));
        $query->join('distance_indexation', 'di', 'di.primary_nid = :rnid and di.secondary_nid = r.nid', array( ':rnid' => $rnid ));
        $query->join('node', 'pr', 'pr.type = :type and pr.nid = di.primary_nid', array( ':type' => 'residence' ));
        $query->join('field_data_field_residence', 'rc', 'rc.field_residence_target_id = di.primary_nid', array());
        $query->join('field_data_field_tarif_chambre_simple', 't', 't.entity_id = rc.entity_id', array());
        $query->join('field_data_field_departement', 'd', 'd.entity_id = r.nid', array());
        $query->join('taxonomy_term_data', 'department', 'department.tid = d.field_departement_tid', array());
        $query->addField('r', 'title', 'concurrent_residence_name');
        $query->addField('department', 'name', 'department_name');
        $query->fields('rpu', array('residence_nid', 'old_price', 'new_price', 'created_at'));
        $query->fields('di', array('primary_nid', 'distance'));
        $query->addField('pr', 'title', 'notre_residence_name');
        $query->addField('t', 'field_tarif_chambre_simple_value', 'notre_tarif');
        $result = fetchAll($query);

        $nearbyResidencesUpdated = array_merge($nearbyResidencesUpdated, $result);
    }

    $users[$ku]->nearbyResidencesUpdated = $nearbyResidencesUpdated;

}

// varDebug($users);
// exit();

echo "------------------------ EMAIL ---------------------- \n";

$from = "noreply@silverpricing.fr";
$to = $user->mail;
$subject = $alertSchedule->title;
$message = $alertSchedule->body_value;
$message = str_replace("[name]", $user->name, $message);
$message = str_replace("[mail]", $user->mail, $message);
$headers = "From:" . $from;
$result = mail( $to, $subject, $message, $headers );

echo "EMAIL RESULT : " . $result . "\n";
