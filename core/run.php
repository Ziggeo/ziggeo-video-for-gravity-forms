<?php

//
//	This file represents the integration module for Gravity Forms and Ziggeo
//

// Index
//	1. Hooks
//		1.1. ziggeo_list_integration
//		1.2. plugins_loaded
//	2. Functionality
//		2.1. ziggeogravityforms_get_version()
//		2.2. ziggeogravityforms_init()
//		2.3. ziggeogravityforms_run()

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//Show the entry in the integrations panel
add_action('ziggeo_list_integration', function() {

	$data = array(
		//This section is related to the plugin that we are combining with the Ziggeo, not the plugin/module that does it
		'integration_title'		=> 'Gravity Forms', //Name of the plugin
		'integration_origin'	=> 'http://www.gravityforms.com/', //Where you can download it from

		//This section is related to the plugin or module that is making the connection between Ziggeo and the other plugin.
		'title'					=> 'Ziggeo Video for Gravity Forms', //the name of the module
		'author'				=> 'Ziggeo', //the name of the author
		'author_url'			=> 'https://ziggeo.com/', //URL for author website
		'message'				=> 'Add video to your forms', //Any sort of message to show to customers
		'status'				=> true, //Is it turned on or off?
		'slug'					=> 'ziggeo-video-for-gravity-forms', //slug of the module
		//URL to image (not path). Can be of the original plugin, or the bridge
		'logo'					=> ZIGGEOGRAVITYFORMS_ROOT_URL . 'assets/images/logo.png'
	);

	//Check current Ziggeo version
	if(ziggeogravityforms_run() === true) {
		$data['status'] = true;
	}
	else {
		$data['status'] = false;
	}

	echo zigeo_integration_present_me($data);
});

add_action('plugins_loaded', function() {
	ziggeogravityforms_run();
});

//Checks if the Gravity Forms exists and returns the version of it
function ziggeogravityforms_get_version() {
	if(class_exists('GFForms')) {
		return GFForms::$version;
	}

	return 0;
}

//We add all of the hooks we need
function ziggeogravityforms_init() {

	$options = get_option('ziggeogravityforms');

	//Add our addon in such a way that it only runs if Gravity Forms was initiallized properly
	add_action('gform_loaded', function() {
		//We need the addon framework to be available
		if( !method_exists('GFForms', 'include_addon_framework') ) {
			return;
		}

		//include the addon class
		include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/ziggeo-addon.php');

		//Register the Addon class we included above
		GFAddOn::register( 'Ziggeo_GFAddon' );
	}, 5);

	include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/assets.php');
}

//Function that we use to run the module 
function ziggeogravityforms_run() {

	//Needed during activation of the plugin
	if(!function_exists('ziggeo_get_version')) {
		return false;
	}

	//Check current Ziggeo version
	if( version_compare(ziggeo_get_version(), '2.0') >= 0 ) {
		//check the Gravity Forms version
		if(version_compare(ziggeogravityforms_get_version(), '1.9') >= 0) {
			if(ziggeo_integration_is_enabled('ziggeo-video-for-gravity-forms')) {
				ziggeogravityforms_init();
				return true;
			}
		}
	}

	return false;
}


?>