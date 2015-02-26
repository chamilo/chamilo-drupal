<?php
/**
* @file
*   Views query plugin for Chamilo WS.
*/

/**
* Views query plugin for the Chamilo.
*/
class chamilo_plugin_query extends views_plugin_query {

  function query($get_count = FALSE) {

  } 

  function execute(&$view) { 
    $params = array(
      'id' => $this->options['chamilo_course_category_id'],
      'name' => $this->options['chamilo_course_category'],
      'target' => $this->options['chamilo_course_target_audience'],
      'secret_key' => chamilo_get_signature(CHAMILO_SECRET_KEY), 
    );

    $chamilo_list_courses_by_category = chamilo_soap_call('registration', 'HookAdvancedSubscription..WSSessionListInCategory', $params);

    $default_text_link = t('See detail');
    foreach ($chamilo_list_courses_by_category as $session) { 
      $row = new stdClass; 
      $row->id = $session->id; 
      $row->name = $session->name; 
      $row->short_description = $session->short_description; 
      $row->mode = $session->mode; 
      $row->date_start = $session->date_start; 
      $row->date_end = $session->date_end; 
      $row->duration = $session->duration; 
      $row->vacancies = $session->vacancies; 
      $row->schedule = $session->schedule; 
      $row->link = $default_text_link; 
      $view->result[] = $row;
    } 
  } 

  function option_definition() { 
    $options = parent::option_definition(); 
 
    $options['chamilo_course_category'] = array( 
      'default' => '' , 
    ); 

    $options['chamilo_course_category_id'] = array( 
      'default' => '' , 
    ); 

    $options['chamilo_course_target_audience'] = array( 
      'default' => '' , 
    ); 

    return $options ; 
  }

  function options_form(&$form, &$form_state) { 
    $form = parent::options_form($form, $form_state);

    $form['chamilo_course_category'] = array(
      '#type' => 'textfield',
      '#title' => t('Chamilo course category'), 
      '#description' => t('add the name of the category.' ), 
      '#default_value' => $this->options['chamilo_course_category'], 
    ); 

    $form['chamilo_course_category_id'] = array(
      '#type' => 'textfield',
      '#title' => t('Chamilo course category id'), 
      '#description' => t('add the id of the category.' ), 
      '#default_value' => $this->options['chamilo_course_category_id'], 
    ); 

    $form['chamilo_course_target_audience'] = array(
      '#type' => 'textfield',
      '#title' => t('Chamilo course target audience'), 
      '#description' => t('add the target audience of the category.' ), 
      '#default_value' => $this->options['chamilo_course_target_audience'], 
    ); 
  }  
}
