<?php

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

function ziggeogravityforms_assets() {

	//local assets
	//wp_register_style('ziggeogravityforms-css', ZIGGEOGRAVITYFORMS_ROOT_URL . 'assets/css/styles.css', array());    
	//wp_enqueue_style('ziggeogravityforms-css');

	wp_register_script('ziggeogravityforms-js', ZIGGEOGRAVITYFORMS_ROOT_URL . 'assets/js/codes.js', array());
	wp_enqueue_script('ziggeogravityforms-js');
}

function ziggeogravityforms_admin_assets() {

	//It will need the common assets as well
	ziggeogravityforms_assets();

	wp_register_script('ziggeogravityforms-admin-js', ZIGGEOGRAVITYFORMS_ROOT_URL . 'assets/js/admin-codes.js', array());
	wp_enqueue_script('ziggeogravityforms-admin-js');
}

add_action('wp_enqueue_scripts', "ziggeogravityforms_assets");
add_action('admin_enqueue_scripts', "ziggeogravityforms_admin_assets");

// Gravity Forms specific assets

add_filter( 'gform_preview_styles', 'ziggeogravityforms_include_assets', 10, 2 );
add_filter( 'gform_print_styles', 'ziggeogravityforms_include_assets', 10, 2 );
add_action( 'gform_enqueue_scripts', 'ziggeogravityforms_include_assets', 10, 2 );

add_action('gform_preview_footer', function() {
	ziggeo_p_page_header();
});

function ziggeogravityforms_include_assets($to_return, $additional) {
	ziggeo_p_assets_global();
	ziggeogravityforms_assets();
	return $to_return;
}


?>