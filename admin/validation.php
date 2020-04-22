<?php

//
// Settings validation
//

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();




function ziggeogravityforms_validate($input) {
	$options = ziggeogravityforms_get_plugin_options();

	if(isset($input['capture_content'])) {
		if($input['capture_content'] === 'embed_wp' ||
			$input['capture_content'] === 'embed_html' ||
			$input['capture_content'] === 'video_url' ||
			$input['capture_content'] === 'video_token') {
			$options['capture_content'] = $input['capture_content'];
		}
	}

	return $options;
}

?>