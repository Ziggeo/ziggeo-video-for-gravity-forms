<?php

//
//	This file creates the Ziggeo Templates
//


//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//We create and set how the ZiggeoVideo field will work and behave in the Gravity Forms forms
class Ziggeo_GF_ZiggeoTemplates extends GF_Field {

	public $type = 'ZiggeoTemplates';
	public $type_title = 'Ziggeo Templates';
	public $simple_type = 'ziggeotemplates';

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
			'size_setting',
			'admin_label_setting',
			'visibility_setting',
			'conditional_logic_field_setting',
			'ziggeogravityforms_' . $this->simple_type . '_template_id_setting' //Adds our own setting=
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
				'name'	=> 'ziggeogravityforms_' . $this->simple_type . '_template_id_setting',
				'value'	=> '',
				'type'	=> 'select'
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
				$field .= '<p>' . 'Templates are not loaded within the editor' . '</p>';
				$field .= '<p>' . 'they will be shown on page and preview' . '</p>';
			}
			else {
				if(ziggeo_p_template_exists($field_data['ziggeogravityforms_' . $this->simple_type . '_template_id_setting'])) {

					$_tmp_field = ziggeo_p_content_filter(ziggeo_p_template_exists($field_data['ziggeogravityforms_' . $this->simple_type . '_template_id_setting']));

					$_slice_point = stripos($_tmp_field, ' ', stripos($_tmp_field, '<ziggeo'));
					$_tmp_field = substr($_tmp_field, 0, $_slice_point) . ' data-id="' . $field_id . '"' .
									' data-is-gf="true" ' . substr($_tmp_field, $_slice_point);

					$field .= $_tmp_field;
				}
				else {
					$field .= ziggeo_p_content_filter('[ziggeo data-is-gf="true" ' . $field_data['ziggeogravityforms_' . $this->simple_type . '_template_id_setting']);
				}
			}

		$field .= '</div></div>';

		return $field;
	}
}
