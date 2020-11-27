<?php


/**
 * USER HAS ACCESS
 */

function residence_mgmt_user_plan_has_access($access) {

  if (user_is_logged_in()) {

      global $user;

      if( in_array('administrator', array_values($user->roles)) ) {
          return TRUE;
      }

      $account = user_load($user->uid);
      $plan = taxonomy_term_load($account->field_plan['und'][0]['target_id']);
      $features = $plan->field_features['und'];

      foreach( $features as $feature ) {
          if( $feature['value'] == $access ) { return TRUE; }
      }

      return FALSE;

  } else {
      return FALSE;
  }
}


/**
 * USER HAS ACCESS
 */

function residence_mgmt_user_has_access($access) {

  if (user_is_logged_in()) {

      global $user;

      foreach( $user->roles as $role ) {

          $userRole = user_role_load_by_name($role);
          $permissions = user_role_permissions(array( $userRole->rid => $userRole->name ));

          foreach( $access as $permission ) {
              if( in_array($permission, array_keys($permissions[$userRole->rid])) ) {
                  return TRUE;
              }
          }

      }

      return FALSE;

  } else {
      return FALSE;
  }
}

/**
 * PERMISSIONS
 */

function residence_mgmt_permission() {

    $permissions = [
        'role_access_dashboard' => [ 'title' => t('Consulter le tableau de bord') ],
        'role_access_departements' => [ 'title' => t('Consulter la page départements') ],
        'role_access_departement' => [ 'title' => t('Consulter la page département') ],
        'role_access_groupes' => [ 'title' => t('Consulter la page groupes') ],
        'role_access_groupe' => [ 'title' => t('Consulter la page groupe') ],
        'role_access_yeelder_tools' => [ 'title' => t('Consulter la page Yeelder Tools') ],
        'role_access_residences' => [ 'title' => t('Consulter la page résidences') ],
        'role_access_residence' => [ 'title' => t('Consulter la page résidence') ],
        'role_access_residence_tmh' => [ 'title' => t('Optimiser le TMH de votre résidence') ],
        'role_access_mes_groupes' => [ 'title' => t('Consulter la page de mes groupes') ],
        'role_access_mes_residences' => [ 'title' => t('Consulter la page de mes résidences') ],
    ];

    return $permissions;

}

/**
 * HAS ENOUGH USER BALANCE
 */

function residence_mgmt_has_enough_user_balance( $pageRequest, $options = array() ) {

  if (user_is_logged_in()) {

      global $user;

      $account = user_load($user->uid);
      $plan = taxonomy_term_load($account->field_plan['und'][0]['target_id']);
      $balance = $account->field_balance['und'][0]['value'];
      $hasEnoughBalance = FALSE;


      switch( $pageRequest ) {
          case "DEPARTMENT_REQUEST":
            if( $balance >= $plan->field_department_request['und']['0']['value'] ) {
                $hasEnoughBalance =  TRUE;
            }
          break;
          case "GROUP_REQUEST":
            if( $balance >= $plan->field_group_request['und']['0']['value'] ) {
                $hasEnoughBalance =  TRUE;
            }
          break;
          case "RESIDENCES_REQUEST":
            if( $balance >= ($plan->field_residence_request['und']['0']['value'] * $options['perimetre'] ) ) {
                $hasEnoughBalance =  TRUE;
            }
          break;
          case "DEVELOPMENT_TOOLS_REQUEST":
            if( $balance >= $plan->field_developpement_tool_request['und']['0']['value'] ) {
                $hasEnoughBalance =  TRUE;
            }
          break;
      }

      return $hasEnoughBalance;

  } else {
      return FALSE;
  }
}

/**
 * UPDATE USER BALANCE
 */

function residence_mgmt_update_user_balance( $pageRequest, $options = array(), $request = array(), $response = array() ) {

  if (user_is_logged_in()) {

      global $user;

      $history = array( 'title' => $pageRequest, 'creator' => $user->uid );
      $history['body'] = array( 'request' => $request, 'response' => $response );
      $account = user_load($user->uid);
      $plan = taxonomy_term_load($account->field_plan['und'][0]['target_id']);
      $balance = $account->field_balance['und'][0]['value'];
      $updatedBalance = null;
#£:balance décrementation crédit
      switch( $pageRequest ) {
          case "DEPARTMENT_REQUEST":
              $updatedBalance = ($balance - $plan->field_department_request['und']['0']['value']);
              $history['balance_consumed'] = $plan->field_department_request['und']['0']['value'];
          break;
          case "GROUP_REQUEST":
              $updatedBalance = ($balance - $plan->field_group_request['und']['0']['value']);
              $history['balance_consumed'] = $plan->field_group_request['und']['0']['value'];
          break;
          case "RESIDENCES_REQUEST":
              $updatedBalance = ($balance - ($plan->field_residence_request['und']['0']['value'] * $options['perimetre']));
              $history['balance_consumed'] = ($plan->field_residence_request['und']['0']['value'] * $options['perimetre']);
          break;
          case "DEVELOPMENT_TOOLS_REQUEST":
              $updatedBalance = ($balance - $plan->field_developpement_tool_request['und']['0']['value']);
              $history['balance_consumed'] = $plan->field_developpement_tool_request['und']['0']['value'];
          break;
      }

      if( $updatedBalance != null ) {

          $edit = array(
            'field_balance' => array( 'und' => array( 0 => array( 'value' => $updatedBalance )))
          );

          user_save( $account, $edit );
          addHistory($history) ;

          return TRUE;

      }

      return FALSE;

  } else {
      return FALSE;
  }
}
