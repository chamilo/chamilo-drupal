<?php
/**
 * Function to display the results of the search courses.
 */
function chamilo_search_course($text_search) {
  $params = array(
    'term' => $text_search,
    'extrafields' => 'short_description, mode, vacancies, schedule',
    'secret_key' => chamilo_get_signature(CHAMILO_SECRET_KEY),
  );
  $chamilo_search_course_list = chamilo_soap_call('registration', 'WSSearchSession', $params);

  foreach ($chamilo_search_course_list as $course) {
    $view_more = array(
      '#type' => 'link',
      '#title' => t('View more'),
      '#href' => 'course-detail-ajax/nojs/' . $course->id,
      '#ajax' => array(
        'effect' => 'fade',
      ),
    );
    $course->link = drupal_render($view_more);
  }

  $variables = array(
    'output' => $chamilo_search_course_list,
  );
  $output = theme('chamilo_search_course_page', $variables);

  return $output;
}
