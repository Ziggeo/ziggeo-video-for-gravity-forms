<?php

GFForms::include_addon_framework();

class Ziggeo_GF_VideoRecorder_Addon extends GFAddOn {

	protected $_version = 1.0;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'ziggeogravityforms';
	protected $_path = 'ziggeo-video-for-gravity-forms/ziggeo-video-for-gravity-forms.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Ziggeo Video Recorder';
	protected $_short_title = 'Ziggeo Video Recorder';
	protected $simple_type = 'videorecorder';

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
			require_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-video-recorder.php');
			//We register it
			GF_Fields::register( new Ziggeo_GF_VideoRecorder() );
		}
	}

	public function init_admin() {
		parent::init_admin();

		//Handles tooltips on our fields
		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );


		add_action( 'gform_field_appearance_settings', array( $this, 'field_appearance_settings' ), 10, 2 );
		add_action( 'gform_field_advanced_settings', array( $this, 'field_advanced_settings' ), 10, 2 );
	}


	//Add the custom setting for the Simple field to the Appearance tab.
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

			//recorder width
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_width_setting', __('Set recorder width:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set recorder width', 'ziggeogravityforms')
			]);

			//recorder height
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_height_setting', __('Set recorder height:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set recorder height', 'ziggeogravityforms')
			]);

			//recorder as popup
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_popup_setting', __('Set recorder as popup:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'checkbox'
			]);

			//recorder popup width
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_popupwidth_setting', __('Set recorder popup width:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set recorder popup width', 'ziggeogravityforms')
			]);

			//recorder popup height
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_popupheight_setting', __('Set recorder popup height:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Set recorder popup height', 'ziggeogravityforms')
			]);

			//recorder with faceoutline
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_faceoutline_setting', __('Set recorder with faceoutline:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'checkbox'
			]);
		}
	}


	public function field_advanced_settings( $position, $form_id ) {
		if( $position == 250) {
			//Recording width
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_recordingwidth_setting', __('Set recording width:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Set recording width'
			]);

			//Recording height
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_recordingheight_setting', __('Set recording height:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Set recording height'
			]);

			//Recording time max
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_recordingtimemax_setting', __('Longest time in seconds to record:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'number',
				'placeholder'	=> '0 = unlimited'
			]);

			//Recording time min
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_recordingtimemin_setting', __('Minimal time of recording:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'number',
				'placeholder'	=> '0 = unlimited'
			]);

			//Recording countdown before recording starts
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_recordingcountdown_setting', __('Countdown time before recording starts', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'number',
				'placeholder'	=> 'in seconds'
			]);

			//Recording and rerecording number allowed
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_recordingamount_setting', __('Number of recording + rerecordings possible', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'number',
				'placeholder'	=> '0 = unlimited'
			]);

			//Effect profile to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_effectprofiles_setting', __('Effect Profile to apply to video', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Effect Profile token'
			]);

			//Video profile to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_videoprofiles_setting', __('Video Profile to apply to video', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Video Profile token'
			]);

			//Meta profile to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_metaprofiles_setting', __('Meta Profile to apply to video', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Meta Profile token'
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

			// data type
			// **********

			//Title to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_mediatitle_setting', __('Media Title', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Title'
			]);

			//Description to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_mediadescription_setting', __('Media Description', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Description'
			]);

			//Tags to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_mediatags_setting', __('Media Tags', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'comma separated tags'
			]);

			//JSON Data to be applied
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_mediacustomdata_setting', __('Media Custom Data', 'ziggeogravityforms'), [
				'html_type' 	=> 'textarea',
				'placeholder'	=> 'valid JSON DATA'
			]);

			//Custom Tags to be added
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_gf_custom_tags_setting', __('Custom tags from fields', 'ziggeogravityforms'), [
				'html_type' 	=> 'textarea',
				'placeholder'	=> 'field_id,field_id2,field_idN'
			]);

			//Custom Tags to be added
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_gf_custom_data_setting', __('Custom data from fields', 'ziggeogravityforms'), [
				'html_type' 	=> 'textarea',
				'placeholder'	=> 'field_key:field_element_id,field_keyN:field_element_idN'
			]);
		}
	}


	//The tooltip that is shown on our field (in admin only)
	public function tooltips( $tooltips ) {
		$tooltips['ziggeogravityforms_' . $this->simple_type . '_theme_setting'] = '<h6>' . __('Embedding Theme', 'ziggeogravityforms') . '</h6>' . __('Select the theme you would like to use', 'ziggeogravityforms');
		$tooltips['ziggeogravityforms_' . $this->simple_type . '_themecolor_setting'] = '<h6>' . __('Embedding Theme Color', 'ziggeogravityforms') . '</h6>' . __('Select the theme color to be applied', 'ziggeogravityforms');
		$tooltips['ziggeogravityforms_' . $this->simple_type . '_gf_custom_tags_setting'] = '<h6>' . __('Custom tags from fields data', 'ziggeogravityforms') . '</h6>' . __('Separate the ID of different fields on the form (even on the page outside of the form) with comma. These fields would then be used to make the video\'s tags.', 'ziggeogravityforms');
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