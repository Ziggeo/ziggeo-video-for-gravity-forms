<?php

//Helps us with the options that we offer with Gravity Forms

// Index
//	1. Hooks
//		1.1. admin_init
//		1.2. admin_menu
//	2. Fields and sections
//		2.1. ziggeogravityforms_show_form()
//		2.2. ziggeogravityforms_d_hooks()
//		2.3. ziggeogravityforms_o_forum_content()
//		2.4. ziggeogravityforms_o_topic_content()
//		2.5. ziggeogravityforms_o_reply_content()

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();



/////////////////////////////////////////////////
//	1. HOOKS
/////////////////////////////////////////////////

	//Add plugin options
	add_action('admin_init', function() {
		//Register settings
		register_setting('ziggeogravityforms', 'ziggeogravityforms', 'ziggeogravityforms_validate');

		//Active hooks
		add_settings_section('ziggeogravityforms_section_hooks', '', 'ziggeogravityforms_d_hooks', 'ziggeogravityforms');


			// The type of data that is captured once the video is recorded
			add_settings_field('ziggeogravityforms_captured_content',
								__('Choose the data that is saved once video is recorded', 'ziggeogravityforms'),
								'ziggeogravityforms_g_captured_content',
								'ziggeogravityforms',
								'ziggeogravityforms_section_hooks');

	});

	add_action('admin_menu', function() {
		ziggeo_p_add_addon_submenu(array(
			'page_title'	=> 'Ziggeo Video for Gravity Forms',	//page title
			'menu_title'	=> 'Ziggeo Video for Gravity Forms',	//menu title
			'capability'	=> 'manage_options',					//min capability to view
			'slug'			=> 'ziggeogravityforms',				//menu slug
			'callback'		=> 'ziggeogravityforms_show_form')		//function
		);
	}, 12);




/////////////////////////////////////////////////
//	2. FIELDS AND SECTIONS
/////////////////////////////////////////////////

	//Dashboard form
	function ziggeogravityforms_show_form() {
		?>
		<div>
			<h2>Ziggeo Video for Gravity Forms</h2>

			<form action="options.php" method="post" class="ziggeogravityforms_form">
				<?php
				wp_nonce_field('ziggeogravityforms_nonce_action', 'ziggeogravityforms_video_nonce');
				get_settings_errors();
				settings_fields('ziggeogravityforms');
				do_settings_sections('ziggeogravityforms');
				submit_button('Save Changes');
				?>
			</form>
		</div>
		<?php
	}

		function ziggeogravityforms_d_hooks() {
			?>
			<h3><?php _e('Parse Locations', 'ziggeogravityforms'); ?></h3>
			<?php
			_e('Use settings bellow to fine tune how some settings specific for Ziggeo within Gravity Forms should be set.', 'ziggeogravityforms');
		}

			function ziggeogravityforms_g_captured_content() {
				$option = ziggeogravityforms_get_plugin_options('capture_content');
				?>
				<select id="ziggeogravityforms_capture_content" name="ziggeogravityforms[capture_content]">
					<option value="embed_wp" <?php ziggeo_echo_selected($option, 'embed_wp'); ?>>WP Embed code</option>
					<option value="embed_html" <?php ziggeo_echo_selected($option, 'embed_html'); ?>>HTML Embed code</option>
					<option value="video_url" <?php ziggeo_echo_selected($option, 'video_url'); ?>>Video URL</option>
					<option value="video_token" <?php ziggeo_echo_selected($option, 'video_token'); ?>>Video Token</option>
				</select>
				<label for="ziggeogravityforms_capture_content"><?php _e('Depending on your choice here you will change what is captured once the video is recorded'); ?></label>
				<?php
			}

?>