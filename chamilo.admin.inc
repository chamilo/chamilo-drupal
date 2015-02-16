<?php

/**
 * @file
 * Module settings UI.
 */

function chamilo_admin_settings() {
  /**
   * Space construct aditional variables, do validation etc.
   */
  return drupal_get_form('chamilo_admin_settings_form');
}

function chamilo_admin_settings_form() {
  $form['chamilo_sso_protocol'] = array(
    '#type' => 'radios',
    '#title' => t('SSO Server Protocol'),
    '#options' => array('http://', 'https://'),
    '#default_value' => variable_get('chamilo_sso_protocol', 0),
  );

  $form['chamilo_server'] = array(
    '#type' => 'textfield',
    '#title' => t('Application URL and Path'),
    '#description' => t('NOTICE: Do NOT use trailing slash nor http://. i.e: yourchamilosite.com'),
    '#default_value' => variable_get('chamilo_server', ''),
  );

  $form['chamilo_user'] = array(
    '#type' => 'textfield',
    '#title' => t('Username'),
    '#description' => t('User ID (example: user1). This user should be admin in Chamilo in order for you to get the most information out of this module. Note that this is only used to ask for a larger set of results from Chamilo, and the admin account information is never used directly.'),
    '#default_value' => variable_get('chamilo_user', ''),
  );
  $form['account']['chamilo_appkey'] = array(
    '#type' => 'textfield',
    '#title' => t('Security Key'),
    '#default_value' => variable_get('chamilo_appkey', ''),
    '#description' => t('You can get the Chamilo security key from your Chamilo configuration file (main/inc/conf/configuration.php). Look for the value of the $_configuration[\'security_key\'] value. This is NOT your Chamilo administrator\'s password'),
    '#size' => 15,
  );
  return system_settings_form($form);
}
