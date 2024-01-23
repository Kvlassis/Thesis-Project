<?php

/*
 * Plugin Name: Get-database-info
 */

 //Creating a custom plugin to send the database data to an endpoint, so that the esp can fetch them.

add_action( 'rest_api_init', 'my_register_form_submission_endpoint' );
function my_register_form_submission_endpoint() {
  register_rest_route( 'my-plugin/v1', '/form-submissions', array(
    'methods' => 'GET',
    'callback' => 'my_get_form_submissions',
  ) );
}

function my_get_form_submissions() {
  global $wpdb;
  $submissions = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}orders" );
  return rest_ensure_response( $submissions );
}
