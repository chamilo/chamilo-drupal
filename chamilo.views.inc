<?php
/**
* Implementation of hook_views_plugins().
*/
function chamilo_views_plugins() {
  $plugin = array();
  $plugin['query']['chamilo_plugin_query'] = array(
    'title' => t('Chamilo Query'),
    'help' => t('Chamilo query object.'),
    'handler' => 'chamilo_plugin_query',
  );
  return $plugin;
}

/**
* Implementation of hook_views_data().
*/
function chamilo_views_data() {
  $data = array();

  // Base data
  $data['chamilo_ws']['table']['group']  = t('Chamilo courses');
  $data['chamilo_ws']['table']['base'] = array(
    'title' => t('Chamilo courses'),
    'help' => t('Get courses from chamilo ws.'),
    'query class' => 'chamilo_plugin_query'
  );

  // Fields
  $data['chamilo_ws']['id'] = array(
    'title' => t('Id'),
    'help' => t('Code chamilo session.'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['name'] = array(
    'title' => t('Name'),
    'help' => t('Name chamilo session.'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['short_description'] = array(
    'title' => t('Description'),
    'help' => t('Description chamilo session.'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['mode'] = array(
    'title' => t('mode'),
    'help' => t('The mode chamilo session.'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['date_start'] = array(
    'title' => t('Date Start'),
    'help' => t('Date start chamilo session'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['date_end'] = array(
    'title' => t('Date End'),
    'help' => t('Date end chamilo session'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['duration'] = array(
    'title' => t('Duration'),
    'help' => t('Duration chamilo session'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['vacancies'] = array(
    'title' => t('Vacancies'),
    'help' => t('Vacancies chamilo session'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['schedule'] = array(
    'title' => t('Schedule'),
    'help' => t('Schedule chamilo session'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  $data['chamilo_ws']['link'] = array(
    'title' => t('Link'),
    'help' => t('Link detail chamilo course.'),
    'field' => array(
      'handler' => 'chamilo_handler_field',
    ),
  );

  return $data;
}
