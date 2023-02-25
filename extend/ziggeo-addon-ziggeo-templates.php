<?php

GFForms::include_addon_framework();

class Ziggeo_GF_ZiggeoTemplates_Addon extends GFAddOn {

	protected $_version = 1.0;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'ziggeogravityforms';
	protected $_path = 'ziggeo-video-for-gravity-forms/ziggeo-video-for-gravity-forms.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Ziggeo Templates';
	protected $_short_title = 'Ziggeo Templates';
	protected $simple_type = 'ziggeotemplates';

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
			require_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-templates.php');
			//We register it
			GF_Fields::register( new Ziggeo_GF_ZiggeoTemplates() );
		}
	}

	public function init_admin() {
		parent::init_admin();

		//Handles tooltips on our fields
		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );

		add_action( 'gform_field_advanced_settings', array( $this, 'field_advanced_settings' ), 10, 2 );
	}

	public function field_advanced_settings( $position, $form_id ) {
		if( $position == 250) {

			$list = ziggeo_p_templates_index();
			$_options = array();

			if($list) {
				foreach($list as $template => $value) {
					$_options[] = $template;
				}
			}

			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_template_id_setting', __('Choose your template', 'ziggeogravityforms'), [
				'html_type' 	=> 'select',
				'options'		=> $_options
			]);
		}
	}


	//The tooltip that is shown on our field (in admin only)
	public function tooltips( $tooltips ) {
		$tooltips['ziggeogravityforms_' . $this->simple_type . '_template_setting_template_id_setting'] = '<h6>' . __('Template', 'ziggeogravityforms') . '</h6>' . __('Select the template that should be rendered in this location', 'ziggeogravityforms');
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