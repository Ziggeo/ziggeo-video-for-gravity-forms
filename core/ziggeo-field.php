<?php

//
//	This file creates the Ziggeo field
//

// Index


//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//We create and set how the ZiggeoVideo field will work and behave in the Gravity Forms forms
class Ziggeo_GF_Field extends GF_Field {

	public $type = 'ZiggeoVideo';

	//Field title
	public function get_form_editor_field_title() {
		return esc_attr__( 'Ziggeo Video Field', 'ziggeogravityforms' );
	}

	//Making the field shown under Advanced fields option
	public function get_form_editor_button() {
		return array(
			'group' => 'advanced_fields',
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
			'default_value_setting', //@here - lets make this a field that we use as video token or source if any value is present
			'visibility_setting',
			'conditional_logic_field_setting',
			'ziggeo_template_setting' //Adds our own setting
		);
	}

	//We are supporting conditions so we return true here
	public function is_conditional_logic_supported() {
		return true;
	}

	//Adds the code to save the selections in the settings of the field
	public function get_form_editor_inline_script_on_page_render() {

		// set the default field label for the simple type field
		//Note: SetDefaultValues_ZiggeoVideo is Gravity Forms function where
		// "ZiggeoVideo" would be the same as the $type of field
		$script = 'function SetDefaultValues_ZiggeoVideo(field) { field.label = "' . $this->get_form_editor_field_title() . '";}';

		// initialize the fields custom settings
		$script .= "
		jQuery(document).bind(
			'gform_load_field_settings', function (event, field, form) {" .
				"var ziggeo_template_setting = field.ziggeo_template_setting === undefined ? 'Select a template' : field.ziggeo_template_setting;" .
				"jQuery('#ziggeo_template_setting').val(ziggeo_template_setting);" .
			"});";

		// saving the simple setting
		//Note: Setziggeo_template_settingSetting is Gravity Forms function
		$script .= 'function Setziggeo_template_settingSetting(value) { SetFieldProperty(\'ziggeo_template_setting\', value); }';

		return $script;
	}
	
	//Handles field drawing on the form itself (not in preview)
	public function get_field_input( $form, $value = '', $entry = null ) {

		$id              = absint( $this->id );
		$form_id         = absint( $form['id'] );
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();

		// Prepare the value of the input ID attribute.
		$field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		$videoToken = esc_attr( $value );

		// Get the value of the inputClass property for the current field.
		$inputClass = $this->inputClass;

		// Prepare the input classes.
		$size         = $this->size;
		$class_suffix = $is_entry_detail ? '_admin' : '';
		$class        = $size . $class_suffix . ' ' . $inputClass;

		// Prepare the other input attributes.
		$tabindex               = $this->get_tabindex();
		$logic_event            = !$is_form_editor && !$is_entry_detail ? $this->get_conditional_logic_event( 'keyup' ) : '';
		$placeholder_attribute  = $this->get_field_placeholder_attribute();
		$required_attribute     = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute      = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
		$disabled_text          = $is_form_editor ? 'disabled="disabled"' : '';
		$ziggeo_embedding_id    = 'embedding_' . $id;

		// Prepare the input tag for this field.
		$field = '<div class="ginput_container ginput_container_' . $this->type . '">';
		//we are adding id to div, so that it is available if needed for conditions and other things in GravityForms
		$field .= '<div id="' . $field_id . '" class="' . $class . '" ' . $tabindex . ' ' . $logic_event . ' ' . $placeholder_attribute . ' ' . $invalid_attribute . ' ' . $disabled_text . '>';

			//Loads the template based on the selection in our dropdown..
			$tmp = ziggeo_p_content_parse_templates(array($this->ziggeo_template_setting, $this->ziggeo_template_setting));

			if(strpos($tmp, 'ZiggeoWall') > -1) {
				//we have video wall, most likely we will not do anything with it..
			}
			else {
				//We now add the ID to the embedding so that we can have it fire up on the submitted event and fill out this field.. so if there are multiple ones on the form by any chance, we always update the one that the recording was made for..
				$tmp = ziggeo_p_template_add_replace_parameter_value($tmp, 'ziggeo-id', $ziggeo_embedding_id, 'replace');

				$tmp = ziggeo_p_template_add_replace_parameter_value($tmp, 'ziggeo-input-bind', $ziggeo_embedding_id, 'replace');
			}

			// We include the prepared $tmp into the field.
			$field .= $tmp;

			//the input field ID is changed so that there is just one ID field.
			$field .= '<input id="input_' . $id . '_field" name="input_' . $id . '" type="hidden" value="' . $videoToken . '" ' . $required_attribute . ' >';

			/*$field .= '<script type="text/javascript">' .
							//'ziggeo_app.embed_events.on("verified", function (embedding) {' .
							//@here - this is a good example of using our events on specific embeddings automatically..
							/*'ZiggeoApi.Events.on("submitted", function (data) {' .
								'if(data.id && ( data.id === "' . $ziggeo_embedding_id . '" || data.id.indexOf("' . $ziggeo_embedding_id . '") > -1 ) ) {' .
									'document.getElementById("input_' . $id . '_field").value = data.video.token;' .
								'} ' .
							'});' .
						'</script>';*/
		$field .= '</div></div>';

		//@NOTE: The embedding will keep its value on refresh unless it is a cold refresh - while this is default browser behaviour, it is good to point it out in case someone has any issues with the same. I presume that at that time we could output a JS function as well that clears the fields out, otherwise since fields are hidden people will not be able to clear them out manually.

		return $field;
	}
}

//Needed to register the field within the Gravity Forms
GF_Fields::register( new Ziggeo_GF_Field() );