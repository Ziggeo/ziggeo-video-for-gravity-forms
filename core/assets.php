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

add_action('wp_enqueue_scripts', "ziggeogravityforms_assets");
add_action('admin_enqueue_scripts', "ziggeogravityforms_assets");

?>