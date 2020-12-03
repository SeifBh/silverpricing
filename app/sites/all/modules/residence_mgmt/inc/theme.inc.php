<?php


/**
 * Implements hook_preprocess_page()
 */
function residence_mgmt_preprocess_page(&$variables, $hook) {
    $path = drupal_get_path_alias();
    $user_path = array('user', 'user/login', 'user/password', 'user/register');
    if (user_is_anonymous()) {
        if ( in_array($path, $user_path) ) {
            $variables['theme_hook_suggestions'][] = 'user_login';
        }
    }
}

/**
 * Implements hook_theme_registry_alter().
 */
function residence_mgmt_theme_registry_alter(&$theme_registry) {
  $module_path = drupal_get_path('module', 'residence_mgmt');
  $theme_registry['user_login'] = array(
      'template' => $module_path . '/templates/user_login',
      'type' => 'theme_engine',
      'theme path' => $module_path . '/templates',
      'render element' => 'page',
  );
}

function render_view($templatePath, $variables = array())
{
    $template = NULL;
    if( file_exists($templatePath) ){
        extract($variables);
        ob_start();
        include $templatePath;
        $template = ob_get_clean();
    }

    return $template;
}

function create_link($text, $url, $active = true) {
    return ( $active ) ? "<a href='$url'>" . htmlspecialchars($text) . "</a>" : $text;
}
