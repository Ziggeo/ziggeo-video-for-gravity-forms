<?php

GFForms::include_addon_framework();

class Ziggeo_GF_VideoWall_Addon extends GFAddOn {

	protected $_version = 1.0;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'ziggeogravityforms';
	protected $_path = 'ziggeo-video-for-gravity-forms/ziggeo-video-for-gravity-forms.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Ziggeo Video Walls';
	protected $_short_title = 'Ziggeo Video Walls';
	protected $simple_type = 'videowall';

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
			require_once(ZIGGEOGRAVITYFORMS_ROOT_PATH . 'extend/ziggeo-video-wall.php');
			//We register it
			GF_Fields::register( new Ziggeo_GF_VideoWall() );
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
			//Autoplay
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_autoplay_setting', __('Autoplay videos in videowall:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'checkbox'
			]);

			//What videos to show
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_videos_to_show_setting', __('Video tag should be added here:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'POST ID or other video tags'
			]);
		}
	}

	//Add the custom setting for the field to the Appearance tab.
	public function field_appearance_settings( $position, $form_id ) {

		// Add our custom setting just before the 'Custom CSS Class' setting.
		if( $position == 250 ) {
			//Create videowall title
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_title_setting', __('Videowall title:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Leave empty for none'
			]);

			//create video wall design option
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_wall_design_setting', __('Videowall design:', 'ziggeogravityforms'), [
				'html_type' 	=> 'select',
				'options'		=> array('Default', 'Slide wall', 'Show Pages', 'Chessboard Grid', 'Mosaic Grid')
			]);

			//player width
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_videowidth_setting', __('Set players width:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Players width', 'ziggeogravityforms')
			]);

			//player height
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_videoheight_setting', __('Set players height:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> __('Players height', 'ziggeogravityforms')
			]);

			//videowall shows right away instead of when video comment is made
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_show_setting', __('Show on page load:', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'checkbox'
			]);
		}
	}

	//Add the custom setting for the field to the Advanced tab.
	public function field_advanced_settings( $position, $form_id ) {
		if( $position == 250) {

			//Videos per page
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_videos_per_page_setting', __('Number of videos per page', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> 'Videos per page'
			]);

			//Videos to shown in wall
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_show_videos_setting', __('What videos to show', 'ziggeogravityforms'), [
				'html_type' 	=> 'select',
				'options'		=> array('Default', 'All', 'Approved', 'Rejected', 'Pending')
			]);

			//What happens when no videos are found
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_on_no_videos_setting', __('What to do when there are no videos', 'ziggeogravityforms'), [
				'html_type' 	=> 'select',
				'options'		=> array('Default', 'ShowMessage', 'ShowTemplate', 'HideWall')
			]);

			//Message to show
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_message_setting', __('Add message if there are no videos', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> ''
			]);

			//Template to use
			ziggeogravityforms_create_builder_option_field('ziggeogravityforms_' . $this->simple_type . '_template_name_setting', __('ID of template to use if there are no videos', 'ziggeogravityforms'), [
				'html_type' 	=> 'input',
				'type'			=> 'text',
				'placeholder'	=> ''
			]);
		}
	}


	//The tooltip that is shown on our field (in admin only)
	public function tooltips( $tooltips ) {
		$tooltips['ziggeogravityforms_' . $this->simple_type . '_autoplay_setting'] = '<h6>' . __('Autoplay videos', 'ziggeogravityforms') . '</h6>' . __('Select if you wish that videos start playing as soon as video wall is created.', 'ziggeogravityforms');

		$tooltips['ziggeogravityforms_' . $this->simple_type . '_videos_to_show_setting'] = '<h6>' . __('What video tag to search for?', 'ziggeogravityforms') . '</h6>' . __('When recorded videos can be given tags. Plugin adds post ID. We have placeholder "%CURRENT_ID%" for it for you to use, or you should add actual post ID number, or any other textual tag associated with your videos', 'ziggeogravityforms');

		$tooltips['ziggeogravityforms_' . $this->simple_type . '_title_setting'] = '<h6>' . __('Videowall title', 'ziggeogravityforms') . '</h6>' . __('If you want to showcase a title over your videowall this is how you would do it', 'ziggeogravityforms');

		$tooltips['ziggeogravityforms_' . $this->simple_type . '_wall_design_setting'] = '<h6>' . __('Videowall design', 'ziggeogravityforms') . '</h6>' . __('Each design has its own merrits, choose the one that best fits your theme', 'ziggeogravityforms');

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