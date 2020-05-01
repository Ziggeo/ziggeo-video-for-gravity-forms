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

	if(defined('VIDEOWALLSZ_VERSION')) {
		videowallsz_p_assets_global();
	}

	return $to_return;
}


//Support for the no-conflict setup

//Scripts
add_filter( 'gform_noconflict_scripts', function($scripts) {
	$scripts[] = 'ziggeo-js';
	$scripts[] = 'ziggeo-plugin-js';
	$scripts[] = 'ziggeo-admin-js';

	$scripts[] = 'videowallsz-plugin-js';

	$scripts[] = 'ziggeogravityforms-js';
	$scripts[] = 'ziggeogravityforms-admin-js';

	return $scripts;
}, 50);

//Styles
add_filter( 'gform_noconflict_styles', function($styles) {
	$styles[] = 'ziggeo-css';
	$styles[] = 'ziggeo-styles-css';
	$styles[] = 'ziggeo-admin-css';

	$styles[] = 'videowallsz-styles-css';
	$styles[] = 'videowallsz-admin-css';

	return $styles;
}, 50);

?>