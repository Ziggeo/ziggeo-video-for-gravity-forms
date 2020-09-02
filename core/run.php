<?php

//
//	This file represents the integration module for Gravity Forms and Ziggeo
//

// Index
//	1. Hooks
//		1.1. ziggeo_list_integration
//		1.2. gform_loaded
//	2. Functionality
//		2.1. ziggeogravityforms_get_version()
//		2.2. ziggeogravityforms_init()
//		2.3. ziggeogravityforms_run()


//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

/////////////////////////////////////////////////
// 1. HOOKS                                    //
/////////////////////////////////////////////////

	//Show the entry in the integrations panel
	add_filter('ziggeo_list_integration', function($integrations) {

		$current = array(
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
			'logo'					=> ZIGGEOGRAVITYFORMS_ROOT_URL . 'assets/images/logo.png',
			'version'				=> ZIGGEOGRAVITYFORMS_VERSION
		);

		//Check current Ziggeo version
		if(ziggeogravityforms_run() === true) {
			$current['status'] = true;
		}
		else {
			$current['status'] = false;
		}

		$integrations[] = $current;

		return $integrations;
	});

	//plugins_loaded is one hook too late for GravityForms to have the field present
	add_action('gform_loaded', function() {
		ziggeogravityforms_run();
	}, 5);




/////////////////////////////////////////////////
// 2. FUNCTIONALITY                            //
/////////////////////////////////////////////////

	//Checks if the Gravity Forms exists and returns the version of it
	function ziggeogravityforms_get_version() {
		if(class_exists('GFForms')) {
			return GFForms::$version;
		}

		return 0;
	}

	//We add all of the hooks we need
	function ziggeogravityforms_init() {

		$options = ziggeogravityforms_get_plugin_options();

		//Add our addon in such a way that it only runs if Gravity Forms was initiallized properly
		//We need the addon framework to be available
		if( !method_exists('GFForms', 'include_addon_framework') ) {
			return;
		}

		//Include the required codes
		require_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/simplifiers.php');

		//include the addon classes
		include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-addon-video-recorder.php');
		GFAddOn::register( 'Ziggeo_GF_VideoRecorder_Addon' );

		include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-addon-video-player.php');
		GFAddOn::register( 'Ziggeo_GF_VideoPlayer_Addon' );

		include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-addon-ziggeo-templates.php');
		GFAddOn::register( 'Ziggeo_GF_ZiggeoTemplates_Addon' );

		//This will not work if the videowalls-for-ziggeo is not installed.
		//Get from: https://wordpress.org/plugins/videowalls-for-ziggeo/
		include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-addon-video-wall.php');
		GFAddOn::register( 'Ziggeo_GF_VideoWall_Addon' );


		include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/assets.php');
		include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/hooks.php');

		/*add_action('gform_entry_detail_content_before', function($form, $lead) {

			//We check the form fields for our own field types and check the content submitted on them
			//for($i = 0, $c = count($form['fields']); $i < $c; $i++) {
			//	if($form['fields'][$i]['type'] === 'ZiggeoRecorder') {
			//		$lead[$form['fields'][$i]['id']] = ziggeo_p_content_filter($lead[$form['fields'][$i]['id']], $lead[$form['fields'][$i]['id']]);
			//	}
			//}
			//The code works to find things, however not to change them
			//We could use this to pass JS function that would replace the value in preview..

			//
		}, 10, 2);*/

	}

	//Function that we use to run the module 
	function ziggeogravityforms_run() {

		//Needed during activation of the plugin
		if(!function_exists('ziggeo_get_version')) {
			add_action( 'admin_notices', function() {
				?>
				<div class="error notice">
					<p><?php _e( 'Please install <a href="https://wordpress.org/plugins/ziggeo/">Ziggeo plugin</a>. It is required for this plugin (Ziggeo Video for Gravity Forms) to work properly!', 'ziggeogravityforms' ); ?></p>
				</div>
				<?php
			});

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