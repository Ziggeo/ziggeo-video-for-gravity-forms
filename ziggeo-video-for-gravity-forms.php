<?php
/*
Plugin Name: Ziggeo Video for Gravity Forms
Plugin URI: https://ziggeo.com/integrations/wordpress
Description: Add the Powerful Ziggeo video service platform to your Gravity Forms
Author: Ziggeo
Version: 1.6
Author URI: https://ziggeo.com
*/

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


//rooth path
define('ZIGGEOGRAVITYFORMS_ROOT_PATH', plugin_dir_path(__FILE__) );

//Setting up the URL so that we can get/built on it later on from the plugin root
define('ZIGGEOGRAVITYFORMS_ROOT_URL', plugins_url('', __FILE__) . '/');

//plugin version - this way other plugins can get it as well and we will be updating this file for each version change as is
define('ZIGGEOGRAVITYFORMS_VERSION', '1.6');

//Include files
include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/simplifiers.php');
include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/run.php');

//We only really need these if we are in the backend, regardless of their rights at this time
if(is_admin()) {
	include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'admin/dashboard.php');
	include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'admin/validation.php');
	include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'admin/plugins.php');
}


?>