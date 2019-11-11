<?php
/*
Plugin Name: Ziggeo Video for Gravity Forms
Plugin URI: https://ziggeo.com
Description: Add the Powerful Ziggeo video service platform to your Gravity Forms
Author: Ziggeo
Version: 1.0
Author URI: https://ziggeo.com
*/

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


//rooth path
define('ZIGGEOGRAVITYFORMS_ROOT_PATH', plugin_dir_path(__FILE__) );

//Setting up the URL so that we can get/built on it later on from the plugin root
define('ZIGGEOGRAVITYFORMS_ROOT_URL', plugins_url() . '/ziggeo-video-for-gravity-forms/' );

//plugin version - this way other plugins can get it as well and we will be updating this file for each version change as is
define('ZIGGEOGRAVITYFORMS_VERSION', '1.0');

//Include files
include_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'core/run.php');


?>