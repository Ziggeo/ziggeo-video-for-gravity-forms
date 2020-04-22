<?php

//Function to create the options in the form builder
function ziggeogravityforms_create_builder_option_field($id, $label, $field_info) {
	?>
	<li class="<?php echo $id; ?> field_setting">
		<label for="<?php echo $id; ?>"><?php echo $label; ?> <?php gform_tooltip($id); ?></label>
		<?php
		if($field_info['html_type'] === 'select') {
			?>
			<select id="<?php echo $id; ?>" class="fieldwidth-1" onchange="ziggeogravityformsOptionSelect(this)">
				<?php
					for($i = 0, $c = count($field_info['options']); $i < $c; $i++) {
						?><option value="<?php echo strtolower($field_info['options'][$i]); ?>"><?php echo $field_info['options'][$i]; ?></option><?php
					}
				?>
			</select>
			<?php
		}
		elseif($field_info['html_type'] === 'input') {

			if($field_info['type'] === 'checkbox') {
				?>
				<input id="<?php echo $id; ?>"
						type="<?php echo $field_info['type']; ?>"
						placeholder="<?php echo $field_info['placeholder']; ?>"
						onclick="ziggeogravityformsOptionCheckbox(this);"
						onkeypress="ziggeogravityformsOptionCheckbox(this);"
						>
				<?php
			}
			else {
				?>
				<input id="<?php echo $id; ?>"
						type="<?php echo $field_info['type']; ?>"
						placeholder="<?php echo $field_info['placeholder']; ?>"
						onfocusout="ziggeogravityformsOptionInput(this);"
						>
				<?php
			}
		}
		elseif($field_info['html_type'] === 'textarea') {
			?>
			<textarea id="<?php echo $id; ?>"
					placeholder="<?php echo $field_info['placeholder']; ?>"
					onfocusout="ziggeogravityformsOptionTextarea(this);"
					>
			</textarea>
			<?php
		}
		?>
	</li>
	<?php
}

//Helper function to get the right field
function ziggeogravityforms_get_field_from_fields($form, $id) {

	for($i = 0, $c = count($form['fields']); $i < $c; $i++) {
		if($form['fields'][$i]['id'] == $id) {
			return $form['fields'][$i];
		}
	}

	return false;
}

//Helper function to create the script that is output to the page
function ziggeogravityforms_create_builder_option_scripts($fields, $script) {

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
			$script .= 'jQuery("#' . $fields[$i]['name'] . '").val(ziggeoRestoreTextValues(' . $fields[$i]['name'] . '));';
		}
	}

	$script .= '});';

	return $script;
}

//Function that helps with our preferences
function ziggeogravityforms_get_plugin_options($specific = null) {
	$options = get_option('ziggeogravityforms');

	$defaults = array(
		'capture_content'	=> 'embed_wp'
	);

	//in case we need to get the defaults
	if($options === false || $options === '') {
		// the defaults need to be applied
		$options = $defaults;
	}

	// In case we are after a specific one.
	if($specific !== null) {
		if(isset($options[$specific])) {
			return $options[$specific];
		}
		elseif(isset($defaults[$specific])) {
			return $defaults[$specific];
		}
	}
	else {
		return $options;
	}

	return false;
}

?>