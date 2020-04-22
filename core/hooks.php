<?php

//Output the info about the gravity forms that can help us with the form
add_action('ziggeo_add_to_ziggeowp_object', function() {
	$options = ziggeogravityforms_get_plugin_options();
	$format = '';

	if($options['capture_content'] === 'embed_wp') {
		$format = '[ziggeoplayer]{token}[/ziggeoplayer]';
	}
	elseif($options['capture_content'] === 'embed_html') {
		$format = htmlentities('<ziggeoplayer ' . ziggeo_get_player_code('integrations') . ' ziggeo-video="{token}"></ziggeoplayer>');
	}
	elseif($options['capture_content'] === 'video_url') {
		$format = 'https://ziggeo.io/p/{token}';
	}
	elseif($options['capture_content'] === 'video_token') {
		$format = '{token}';
	}

	//Filter to allow you to change the format yourself regardless of the setting
	//Please place {token} where video token should be placed, everything else is up to you
	$format = apply_filters('ziggeo_gravity_forms_capture_content', $format);

	?>
	gravity_forms: {
		capture_content: "<?php echo $options['capture_content']; ?>",
		capture_format: "<?php echo $format; ?>"
	},
	<?php
});

//Creates the section with Ziggeo fields
add_filter( 'gform_add_field_buttons', function($field_groups) {
	$field_groups[] = array( 'name' => 'ziggeo_fields', 'label' => __( 'Ziggeo Fields', 'ziggeowpforms' ), 'fields' => array(
		array( 'class' => 'button', 'data-type' => 'ZiggeoVideoRecorder', 'value' => GFCommon::get_field_type_title( 'ZiggeoVideoRecorder' ) ),
		array( 'class' => 'button', 'data-type' => 'ZiggeoVideoPlayer', 'value' => GFCommon::get_field_type_title( 'ZiggeoVideoPlayer' ) ),
		array( 'class' => 'button', 'data-type' => 'ZiggeoVideoWall', 'value' => GFCommon::get_field_type_title( 'ZiggeoVideoWall' ) ),
		array( 'class' => 'button', 'data-type' => 'ZiggeoTemplates', 'value' => GFCommon::get_field_type_title( 'ZiggeoTemplates' ) ),
	));
	return $field_groups;
} );

?>