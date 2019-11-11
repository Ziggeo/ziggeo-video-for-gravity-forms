<?php

GFForms::include_addon_framework();

class Ziggeo_GFAddon extends GFAddOn {

	protected $_version = 1.0;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'ziggeogravityforms';
	protected $_path = 'ziggeo-video-for-gravity-forms/ziggeo-video-for-gravity-forms.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Ziggeo Video Field';
	protected $_short_title = 'Ziggeo Video Field';

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
			require_once('ziggeo-field.php');
			//We register it
			GF_Fields::register( new Ziggeo_GF_Field() );
		}
	}

	public function init_admin() {
		parent::init_admin();

		//Handles tooltips on our fields
		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );


		add_action( 'gform_field_appearance_settings', array( $this, 'field_appearance_settings' ), 10, 2 );
	}

	//Add the custom setting for the Simple field to the Appearance tab.
	public function field_appearance_settings( $position, $form_id ) {
		// Add our custom setting just before the 'Custom CSS Class' setting.
		if( $position == 250 ) {
			?>
			<li class="ziggeo_template_setting field_setting">
				<label for="ziggeo_template_setting"><?php _e('Choose your template:', 'ziggeogravityforms'); ?>
					<?php gform_tooltip( 'ziggeo_template_setting' ) ?>
				</label>
				<select id="ziggeo_template_setting" class="fieldwidth-1" onchange="ziggeo_integration_gravityforms_admin_select(this)">
					<?php //fill out the templates ?>
					<option disabled=disabled>Select a template</option>

					<?php
					//index function changes " to ' to make sure that we do not have issues with TinyMCE, so we can use it here as well.
					$list = ziggeo_p_templates_index();
					if($list) {
						foreach($list as $template => $value)
						{
							?><option value="<?php echo $template; ?>"><?php echo $template; ?></option><?php
						}
					}
					?>
				</select>
			</li>

			<?php
		}
	}

	//The tooltip that is shown on our field (in admin only)
	public function tooltips( $tooltips ) {
		$tooltips['ziggeo_template_setting'] = '<h6>' . __('Ziggeo Templates', 'ziggeogravityforms') . '</h6>' . __('Select the template in the dropdown best matching your requirements', 'ziggeogravityforms');
		return $tooltips;
	}

	//Adding Ziggeo script if the preview is used
	public function scripts() {
		//Only if this is preview will we add a script to the head
		if($this->is_preview() || $this->is_form_editor()) {
			$scripts = array(
				array(
					'handle'  => 'ziggeo-js', //Same as handle of our core so we do not add them 2 times
					'src'     => 'https://assets-cdn.ziggeo.com/v1-stable/ziggeo.js',
					'version' => $this->_version,
					'enqueue' => array(
						'field_types' => array('ZiggeoVideo')
					)
				),
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
					'handle'  => 'ziggeo-css', //Same as handle of our core so we do not add them 2 times
					'src'     => 'https://assets-cdn.ziggeo.com/v1-stable/ziggeo.css',
					'version' => $this->_version,
					'enqueue' => array(
						'field_types' => array('ZiggeoVideo')
					)
				),
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