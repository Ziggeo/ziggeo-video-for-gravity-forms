<?php

//
//	This file creates the Ziggeo Video Wall field
//


//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//We create and set how the ZiggeoVideo field will work and behave in the Gravity Forms forms
class Ziggeo_GF_VideoWall extends GF_Field {

	public $type = 'ZiggeoVideoWall';
	public $type_title = 'Video Wall';
	public $simple_type = 'videowall';

	public function get_field_type_title() {
		return $this->type_title;
	}

	//Field title
	public function get_form_editor_field_title() {
		return $this->type_title;
	}

	//Making the field shown under Ziggeo fields option
	public function get_form_editor_button() {
		return array(
			'group' => 'ziggeo_fields',
			'text'  => $this->get_form_editor_field_title()
		);
	}

	//Settings that we want to allow to be changed about our field on form
	function get_form_editor_field_settings() {
		return array(
			'label_setting',
			'description_setting',
			'rules_setting',
			'ziggeogravityforms_' . $this->simple_type . '_autoplay_setting',
			'ziggeogravityforms_' . $this->simple_type . '_videos_to_show_setting',

			'ziggeogravityforms_' . $this->simple_type . '_title_setting',
			'ziggeogravityforms_' . $this->simple_type . '_wall_design_setting',
			'ziggeogravityforms_' . $this->simple_type . '_videowidth_setting',
			'ziggeogravityforms_' . $this->simple_type . '_videoheight_setting',
			'ziggeogravityforms_' . $this->simple_type . '_show_setting',

			'admin_label_setting',
			'visibility_setting',
			'conditional_logic_field_setting',
			'ziggeogravityforms_' . $this->simple_type . '_videos_per_page_setting',
			'ziggeogravityforms_' . $this->simple_type . '_show_videos_setting',
			'ziggeogravityforms_' . $this->simple_type . '_on_no_videos_setting',
			'ziggeogravityforms_' . $this->simple_type . '_message_setting',
			'ziggeogravityforms_' . $this->simple_type . '_template_name_setting'
		);
	}

	//We are supporting conditions so we return true here
	public function is_conditional_logic_supported() {
		return true;
	}

	//Adds the code to save the selections in the settings of the field
	//We need to add each setting ID and the function that handles it
	public function get_form_editor_inline_script_on_page_render() {

		// set the default field label for the simple type field
		//Note: SetDefaultValues_ZiggeoVideo is Gravity Forms function where
		// "ZiggeoVideo" would be the same as the $type of field
		$script = 'function SetDefaultValues_' . $this->type . '(field) { field.label = "' . $this->get_form_editor_field_title() . '";}';

		$fields = array(
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_autoplay_setting',
				'value'	=> 'false',
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_videos_to_show_setting',
				'value'	=> '%CURRENT_ID%',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_title_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_wall_design_setting',
				'value'	=> 'default',
				'type'	=> 'select'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_videowidth_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_videoheight_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_show_setting',
				'value'	=> 'true',
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_videos_per_page_setting',
				'value'	=> '2',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_show_videos_setting',
				'value'	=> 'default',
				'type'	=> 'select'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_on_no_videos_setting',
				'value'	=> 'default',
				'type'	=> 'select'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_message_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_template_name_setting',
				'value'	=> '',
				'type'	=> 'input'
			)
		);

		$script .= ziggeogravityforms_create_builder_option_scripts($fields, $script);

		return $script;
	}
	
	//Handles field drawing on the form itself (not in preview)
	public function get_field_input( $form, $value = '', $entry = null ) {

		$id              = absint( $this->id );
		$form_id         = absint( $form['id'] );
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();

		$field_data = ziggeogravityforms_get_field_from_fields($form, $id);

		$current_value = esc_attr( $value );

		// Prepare the value of the input ID attribute.
		$field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		// Prepare the input classes.
		$size         = $this->size;
		$class_suffix = $is_entry_detail ? '_admin' : '';
		$class        = $size . $class_suffix;

		// Prepare the other input attributes.
		$tabindex               = $this->get_tabindex();
		$logic_event            = !$is_form_editor && !$is_entry_detail ? $this->get_conditional_logic_event( 'keyup' ) : '';
		$placeholder_attribute  = $this->get_field_placeholder_attribute();
		$required_attribute     = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute      = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
		$disabled_text          = $is_form_editor ? 'disabled="disabled"' : '';

		// Prepare the input tag for this field.
		$field = '<div class="ginput_container ginput_container_' . $this->type . '">';
		//we are adding id to div, so that it is available if needed for conditions and other things in GravityForms
		$field .= '<div id="' . $field_id . '_placeholder" class="' . $class . '" ' . $tabindex . ' ' . $logic_event . ' ' . $placeholder_attribute . ' ' . $invalid_attribute . ' ' . $disabled_text . '>';
			$field .= '<input id="' . $field_id . '" type="hidden" value="' . $current_value . '" name="input_' . $id . '" >';

			if($is_form_editor) {
				if(defined('VIDEOWALLSZ_VERSION')) {
					$field .= '<p>' . 'Video walls are not loaded within the editor' . '</p>';
					$field .= '<p>' . 'they will be shown on page and preview' . '</p>';
				}
				else {
					ziggeo_notification_create('Please install "VideoWalls for Ziggeo" to use VideoWall field. You can find it on: https://wordpress.org/plugins/videowalls-for-ziggeo/');
					$field .= '<p>' . 'Video walls plugin does not seem to be installed.' . '</p>';
					$field .= '<p>' . 'Please check Notifications under Ziggeo Video for more details' . '</p>';
				}
			}
			else {
				//Walls are processed on backend and entire code is placed on the front page, unlike the player and recorder which are processed by JavaScript.
				$wall = '[ziggeovideowall ' .
								'data-id="' . $field_id . '"' . ' data-is-gf="true" ';

				if($field_data['ziggeogravityforms_' . $this->simple_type . '_wall_design_setting'] !== '') {
					$wall .=	'wall_design="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_wall_design_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_videos_per_page_setting'] !== '') {
					$wall .=	'videos_per_page="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_videos_per_page_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_videos_to_show_setting'] !== '') {
					$wall .=	'videos_to_show="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_videos_to_show_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_message_setting'] !== '') {
					$wall .=	'message="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_message_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_on_no_videos_setting'] !== '') {
					$wall .=	'on_no_videos="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_on_no_videos_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_show_videos_setting'] !== '') {
					$wall .=	'show_videos="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_show_videos_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_show_setting'] !== '') {
					$wall .=	'show="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_show_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_autoplay_setting'] !== '') {
					$wall .=	'autoplay="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_autoplay_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_title_setting'] !== '') {
					$wall .=	'title="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_title_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_videowidth_setting'] !== '') {
					$wall .=	'video_width="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_videowidth_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_videoheight_setting'] !== '') {
					$wall .=	'video_height="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_videoheight_setting'] . '" ';
				}
				if($field_data['ziggeogravityforms_' . $this->simple_type . '_template_name_setting'] !== '') {
					$wall .=	'template_name="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_template_name_setting'] . '" ';
				}

				$field .= videowallsz_content_parse_videowall($wall, false);
			}

		$field .= '</div></div>';

		return $field;
	}
}
