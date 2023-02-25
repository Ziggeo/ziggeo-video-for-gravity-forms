<?php

GFForms::include_addon_framework();

class Ziggeo_GF_VideoPlayer_Addon extends GFAddOn {

	protected $_version = 1.0;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'ziggeogravityforms';
	protected $_path = 'ziggeo-video-for-gravity-forms/ziggeo-video-for-gravity-forms.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Ziggeo Video Player';
	protected $_short_title = 'Ziggeo Video Player';
	protected $simple_type = 'videoplayer';

	private static $_instance = null;

	//Returns the handle to this instance of our addon
	public static function get_instance() {
		if(self::$_instance == null) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function pre_init() {
		parent::pre_init();

		if($this->is_gravityforms_supported() && class_exists('GF_Field')) {
			//We include our field codes
			require_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-video-player.php');
			//We register it
			GF_Fields::register( new Ziggeo_GF_VideoPlayer() );
		}
	}

	public function init_admin() {
		parent::init_admin();

		//Handles tooltips on our fields
		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );


		add_action( 'gform_field_standard_settings', array( $this, 'field_standard_settings' ), 10, 2 );
		add_action( 'gform_field_appearance_settings', array( $this, 'field_appearance_settings' ), 10, 2 );
		add_action( 'gform_field_advanced_settings', array( $this, 'field_advanced_settings' ), 10, 2 );
	}

	//Add the custom setting for the field to the General tab.
	public function field_standard_settings( $position, $form_id ) {
		// Add our custom setting just before the 'Custom CSS Class' setting.
		if( $position == 250 ) {
			//Create theme option
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_videotoken_setting', __('Add your video token:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Video Token'
			]);
		}
	}

	//Add the custom setting for the field to the Appearance tab.
	public function field_appearance_settings( $position, $form_id ) {

		// Add our custom setting just before the 'Custom CSS Class' setting.
		if( $position == 250 ) {
			//Create theme option
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_theme_setting', __('Choose your theme:', 'ziggeogravityforms'), [
				'html_type' 	=> 'select',
				'options'		=> array('Default', 'Modern', 'Cube', 'Space', 'Minimalist', 'Elevate', 'Theatre')
			]);

			//create theme color option
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_themecolor_setting', __('Choose your theme color:', 'ziggeogravityforms'), [
				'html_type' 	=> 'select',
				'options'		=> array('Red', 'Green', 'Blue')
			]);

			//player width
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_width_setting', __('Set player width:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set player width', 'ziggeogravityforms')
			]);

			//player height
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_height_setting', __('Set player height:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set player height', 'ziggeogravityforms')
			]);

			//player as popup
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_popup_setting', __('Set player as popup:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'checkbox'
			]);

			//player popup width
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_popupwidth_setting', __('Set player popup width:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set player popup width', 'ziggeogravityforms')
			]);

			//player popup height
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_popupheight_setting', __('Set player popup height:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set player popup height', 'ziggeogravityforms')
			]);
		}
	}

	//Add the custom setting for the field to the Advanced tab.
	public function field_advanced_settings( $position, $form_id ) {
		if( $position == 250) {

			//Effect profile to be used
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_effectprofiles_setting', __('Effect Profile stream to pull', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Effect Profile token'
			]);

			//Video profile to be used
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_videoprofiles_setting', __('Video Profile stream to pull', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Video Profile token'
			]);

			//Client Auth to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_clientauth_setting', __('Client Auth token', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Auth token'
			]);

			//Server Auth to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_serverauth_setting', __('Server Auth token', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Auth token'
			]);
		}
	}


	//The tooltip that is shown on our field (in admin only)
	public function tooltips( $tooltips ) {
		$tooltips['ziggeogravityforms_' . $this->simple_type . '_theme_setting'] = '<h6>' . __('Embedding Theme', 'ziggeogravityforms') . '</h6>' . __('Select the theme you would like to use', 'ziggeogravityforms');
		$tooltips['ziggeogravityforms_' . $this->simple_type . '_themecolor_setting'] = '<h6>' . __('Embedding Theme Color', 'ziggeogravityforms') . '</h6>' . __('Select the theme color to be applied', 'ziggeogravityforms');
		return $tooltips;
	}

	//Adding Ziggeo script if the preview is used
	public function scripts() {
		//Only if this is preview will we add a script to the head
		if($this->is_preview() || $this->is_form_editor()) {

			$scripts = array(
				//The WordPress core plugin admin file
				array(
					'handle'  => 'ziggeo-plugin-js',
					'src'     => ZIGGEO_ROOT_URL . 'assets/js/ziggeo_plugin.js',
					'version' => $this->_version,
					'enqueue' => array(
						'field_types' => array('ZiggeoVideo')
					)
				)
			);

			// Support for Lazyload
			$lazy_load = ziggeo_get_plugin_options('lazy_load');
			if($lazy_load === ZIGGEO_YES) {

				// To include the header info
				ziggeo_p_page_header();

				// Support for Lazyload
				if(!defined('ZIGGEO_FOUND')) {
					define('ZIGGEO_FOUND', true);
				}

				echo ziggeo_p_get_lazyload_activator();

				if(!defined('ZIGGEO_FOUND_POST')) {
					define('ZIGGEO_FOUND_POST', true);
				}
			}

			//return the combined scripts of the ones that did exist and the ones we added above
			return array_merge( parent::scripts(), $scripts );
		}

		//we send back the existing ones to make sure that GravityForms is not showing any errors due to no output
		return parent::scripts();
	}

	//Adding Ziggeo CSS if the preview is used.
	public function styles() {
		//Lets check if we are in preview pages
		if($this->is_preview() || $this->is_form_editor()) { //needs a check for form editor / builder on some setups, as it does not post JS and CSS files
			//We are in the preview page
			$styles = array(
				array(
					'handle'  => 'ziggeo-styles-css',
					'src'     => ZIGGEO_ROOT_URL . 'assets/css/styles.css',
					'version' => $this->_version,
					'enqueue' => array(
						'field_types' => array('ZiggeoVideo')
					)
				)
			);

			return array_merge( parent::styles(), $styles );            
		}

		//we send back the existing ones to make sure that GravityForms is not showing any errors due to no output
		return parent::styles();
	}
}

?>