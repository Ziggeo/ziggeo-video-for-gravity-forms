<?php

//
//	This file creates the Ziggeo Video Recorder field
//


//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//We create and set how the ZiggeoVideo field will work and behave in the Gravity Forms forms
class Ziggeo_GF_VideoRecorder extends GF_Field {

	public $type = 'ZiggeoVideoRecorder';
	public $type_title = 'Video Recorder';
	public $simple_type = 'videorecorder';

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

			'ziggeogravityforms_' . $this->simple_type . '_theme_setting',
			'ziggeogravityforms_' . $this->simple_type . '_themecolor_setting',
			'ziggeogravityforms_' . $this->simple_type . '_width_setting',
			'ziggeogravityforms_' . $this->simple_type . '_height_setting',
			'ziggeogravityforms_' . $this->simple_type . '_popup_setting',
			'ziggeogravityforms_' . $this->simple_type . '_popupwidth_setting',
			'ziggeogravityforms_' . $this->simple_type . '_popupheight_setting',
			'ziggeogravityforms_' . $this->simple_type . '_faceoutline_setting',

			'admin_label_setting',
			'visibility_setting',
			'conditional_logic_field_setting',
			'ziggeogravityforms_' . $this->simple_type . '_recordingwidth_setting',
			'ziggeogravityforms_' . $this->simple_type . '_recordingheight_setting',
			'ziggeogravityforms_' . $this->simple_type . '_recordingtimemax_setting',
			'ziggeogravityforms_' . $this->simple_type . '_recordingtimemin_setting',
			'ziggeogravityforms_' . $this->simple_type . '_recordingcountdown_setting',
			'ziggeogravityforms_' . $this->simple_type . '_recordingamount_setting',
			'ziggeogravityforms_' . $this->simple_type . '_effectprofiles_setting',
			'ziggeogravityforms_' . $this->simple_type . '_videoprofiles_setting',
			'ziggeogravityforms_' . $this->simple_type . '_metaprofiles_setting',
			'ziggeogravityforms_' . $this->simple_type . '_clientauth_setting',
			'ziggeogravityforms_' . $this->simple_type . '_serverauth_setting',
			'ziggeogravityforms_' . $this->simple_type . '_mediatitle_setting',
			'ziggeogravityforms_' . $this->simple_type . '_mediadescription_setting',
			'ziggeogravityforms_' . $this->simple_type . '_mediatags_setting',
			'ziggeogravityforms_' . $this->simple_type . '_mediacustomdata_setting'
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
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_theme_setting',
				'value'	=> 'modern',
				'type'	=> 'select'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_themecolor_setting',
				'value'	=> 'green',
				'type'	=> 'select'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_width_setting',
				'value'	=> '100%',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_height_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_popup_setting',
				'value'	=> 'false',
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_popupwidth_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_popupheight_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_faceoutline_setting',
				'value'	=> 'true',
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_recordingwidth_setting',
				'value'	=> '640',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_recordingheight_setting',
				'value'	=> '480',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_recordingtimemax_setting',
				'value'	=> '0',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_recordingtimemin_setting',
				'value'	=> '0',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_recordingcountdown_setting',
				'value'	=> '3',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_recordingamount_setting',
				'value'	=> '0',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_effectprofiles_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_videoprofiles_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_metaprofiles_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_clientauth_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_serverauth_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_mediatitle_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_mediadescription_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_mediatags_setting',
				'value'	=> '',
				'type'	=> 'input'
			),
			array(
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_mediacustomdata_setting',
				'value'	=> '',
				'type'	=> 'input'
			)
		);
/*
		$c = count($fields);
		// initialize the fields custom settings
		$script .= 'jQuery(document).bind("gform_load_field_settings", function (event, field, form) {';

		for($i = 0; $i < $c; $i++ ) {
			$script .= 'var ' . $fields[$i]['name'] .' = (field.' . $fields[$i]['name'] . ' == undefined) ? "" : field.' . $fields[$i]['name'] . ';';

			if($fields[$i]['type'] === 'checkbox') {
				//$fields[$i]['name'] = $fields[$i]['name'] because we now have a JS variable with that name
				$script .= 'jQuery("#' . $fields[$i]['name'] . '")[0].checked = ' . $fields[$i]['name'] . ';';
			}
			else {
				$script .= 'jQuery("#' . $fields[$i]['name'] . '").val(' . $fields[$i]['name'] . ');';
			}
		}

		$script .= '});';
*/

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

			$field .= '<ziggeorecorder ' .
							'data-id="' . $field_id . ' "' . ' data-is-gf="true" ' .
							'ziggeo-theme="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_theme_setting'] . '" ' .
							'ziggeo-themecolor="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_themecolor_setting'] . '" ';
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_width_setting'] !== '') {
				$field .=	'ziggeo-width="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_width_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_height_setting'] !== '') {
				$field .=	'ziggeo-height="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_height_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_effectprofiles_setting'] !== '') {
				$field .=	'ziggeo-effect-profile="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_effectprofiles_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_videoprofiles_setting'] !== '') {
				$field .=	'ziggeo-video-profile="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_videoprofiles_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_mediatitle_setting'] !== '') {
				$field .=	'ziggeo-title="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_mediatitle_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_popupwidth_setting'] !== '') {
				$field .=	'ziggeo-popup-width="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_popupwidth_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_popupheight_setting'] !== '') {
				$field .=	'ziggeo-popup-height="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_popupheight_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_recordingwidth_setting'] !== '') {
				$field .=	'ziggeo-recordingwidth="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_recordingwidth_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_recordingheight_setting'] !== '') {
				$field .=	'ziggeo-recordingheight="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_recordingheight_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_recordingtimemax_setting'] !== '' &&
				$field_data['ziggeogravityforms_' . $this->simple_type . '_recordingtimemax_setting'] >= 0) {
				$field .=	'ziggeo-timelimit="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_recordingtimemax_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_recordingtimemin_setting'] !== '' &&
				$field_data['ziggeogravityforms_' . $this->simple_type . '_recordingtimemin_setting'] >= 0) {
				$field .=	'ziggeo-mintimelimit="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_recordingtimemin_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_recordingcountdown_setting'] !== '' &&
				$field_data['ziggeogravityforms_' . $this->simple_type . '_recordingcountdown_setting'] >= 0) {
				$field .=	'ziggeo-countdownt="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_recordingcountdown_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_recordingamount_setting'] !== '' &&
				$field_data['ziggeogravityforms_' . $this->simple_type . '_recordingamount_setting'] >= 1) {
				$field .=	'ziggeo-recordings="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_recordingamount_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_mediadescription_setting'] !== '') {
				$field .=	'ziggeo-description="' . $field_data['ziggeogravityforms_' . $this->simple_type . '_mediadescription_setting'] . '" ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_popup_setting'] === true) {
				$field .=	'ziggeo-popup ';
			}
			if($field_data['ziggeogravityforms_' . $this->simple_type . '_faceoutline_setting'] === true) {
				$field .=	'ziggeo-faceoutline ';
			}

			$field .= '></ziggeorecorder>';

		$field .= '</div></div>';

		return $field;
	}
}
