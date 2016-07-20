<?php
// load composer, put it into the main root folder (example: c:\wamp\www\nameOfSite\vendor
require ABSPATH. '/vendor/autoload.php';

// REST API example 1 function handler
function my_awesome_func( WP_REST_Request $request  ) {
	$data = array( 'some', 'response', 'data' );

	// Create the response object
	$response = new WP_REST_Response( $data );
	return $response;
}

// REST API example 2 function handler
function route2_func( WP_REST_Request $request ) {
	$response = new WP_REST_Response( array( 'some', 'response', 'data' ) );
	$response->add_links( array(
		'author' => array(
			'href' => rest_url( '/wp/v2/users/42' ),
		),
		'related' => array(
			array(
				'href' => rest_url( '/wp/v2/custom/firstobject' ),
			),
			array(
				'href' => rest_url( '/wp/v2/custom/secondobject' ),
				'customattr' => true,
			)
		),
	) );
	return $response;
}

// register routes
add_action( 'rest_api_init', function () {
	register_rest_route( 'myplugin/v1', '/author/', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func',
	) );

	register_rest_route( 'myplugin/v1', '/route2/', array(
		'methods' => 'GET',
		'callback' => 'route2_func',
	) );
} );

function load_scripts_and_styles() {
	// Load the html5 shiv only for less-than Internet Explorer 9
	wp_enqueue_script( 'html5-shiv', get_template_directory_uri() . '/library/html5shiv/html5shiv.min.js', array(), '3.7.3' );
	wp_script_add_data( 'html5-shiv', 'conditional', 'lt IE 9' );

    // bootstrap
    wp_enqueue_style( 'bootstrap-3.3.6-css', get_template_directory_uri() . '/library/bootstrap-3.3.6/css/bootstrap.min.css', array(), '3.3.6', 'all' );
	wp_enqueue_script( 'bootstrap-3.3.6-js', get_template_directory_uri() . '/library/bootstrap-3.3.6/js/bootstrap.min.js', array('jquery'), '3.3.6' );

    // tubular
    wp_enqueue_script( 'tubular-js', get_template_directory_uri() . '/library/tubular/js/jquery.tubular.1.0.js', array('jquery'), '3.3.6' );

}
add_action( 'wp_enqueue_scripts', 'load_scripts_and_styles' );