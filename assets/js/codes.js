//
// INDEX
//********
// 1. Helper functions
//		* onload
//		* ziggeogravityformsIsOfForm()
// 2. Ziggeo Hooks
//		* ziggeofluentformsSaveToken()
//		* ziggeofluentformsAddCustomTags()
//		* ziggeofluentformsAddCustomData()


/////////////////////////////////////////////////
// 1. HELPER FUNCTIONS                         //
/////////////////////////////////////////////////

	
	window.addEventListener('load', function() {

		//Check if the ziggeo_app was defined
		if(typeof ziggeo_app === 'undefined') {
			return false;
		}

		//Handling video recorders
		ziggeo_app.embed_events.on("verified", function (embedding_object) {
			//lets get the embedding element
			var embedding = embedding_object.activeElement();

			if(!ziggeogravityformsIsOfForm(embedding)) {
				//Not to be handled by us
				return false;
			}

			var element = document.getElementById( embedding.getAttribute('data-id').trim() );
			var value_prepared = '';

			if(ZiggeoWP && ZiggeoWP.gravity_forms) {
				//Capture the video token
				value_prepared = ZiggeoWP.gravity_forms.capture_format.replace('{token}', embedding_object.get("video"));
			}
			else {
				//Capture the video token
				value_prepared = "[ziggeoplayer]" + embedding_object.get("video") + "[/ziggeoplayer]"
			}

			ZiggeoWP.hooks.fire('ziggeogravityforms_verified', {
				'embedding_element': embedding,
				'embedding_object': embedding_object,
				'value_prepared': value_prepared,
				'save_to_element': element
			});

		});

		//Handling video players
		ziggeo_app.embed_events.on("ended", function (embedding_object) {
			//lets get the embedding element
			var embedding = embedding_object.activeElement();

			if(embedding.nodeName === "ZIGGEORECORDER") {
				return false;
			}

			if(!ziggeogravityformsIsOfForm(embedding)) {
				//Not to be handled by us
				return false;
			}

			var element = document.getElementById( embedding.getAttribute('data-id').trim() );
			element.value = "Video was seen";
		});

		ziggeogravityformsSaveToken();
		ziggeogravityformsAddCustomTags();
		ziggeogravityformsAddCustomData();
	});

	// Just a simple function to check for signs of this embedding actually being part of Gravity Forms form
	function ziggeogravityformsIsOfForm(embedding) {

		if(embedding.getAttribute("data-is-gf")) {
			return true;
		}

		return false;
	}




/////////////////////////////////////////////////
// 2. ZIGGEO HOOKS                             //
/////////////////////////////////////////////////

	//Helper to set the hook to capture and save the video token.
	function ziggeogravityformsSaveToken() {
		ZiggeoWP.hooks.set('ziggeogravityforms_verified', 'ziggeogravityformsSaveToken',
			function(data) {
				//Save the video token
				data.save_to_element.value = data.value_prepared;
			});
	}

	//Handling save of custom (dynamic) tags
	function ziggeogravityformsAddCustomTags() {
		ZiggeoWP.hooks.set('ziggeogravityforms_verified', 'ziggeogravityformsAddCustomTags',
			function(data) {
				//Get tags
				var tags = data.embedding_element.getAttribute('data-custom-tags');

				if(tags) {
					var _tags = [];
					tags = tags.split(',');

					for(i = 0, c = tags.length; i < c; i++) {
						try {
							var value = document.getElementById(tags[i]);

							if(value) {
								value = value.value.trim();
							}

							if(value.trim() !== '') {
								_tags.push(value);
							}
						}
						catch(err) {
							console.log(err);
						}
					}

					if(_tags.length > 0) {

						if(data.embedding_object.get('tags') !== '' && data.embedding_object.get('tags') !== null) {
							_tags.concat(data.embedding_object.get('tags'));
						}

						//Create tags for the video
						ziggeo_app.videos.update(data.embedding_object.get("video"), { tags: _tags });
					}
				}
			});
	}

	//Handling save of dynamic custom data
	function ziggeogravityformsAddCustomData() {
		ZiggeoWP.hooks.set('ziggeogravityforms_verified', 'ziggeogravityformsAddCustomData',
			function(data) {
				//Get custom data
				var c_data = data.embedding_element.getAttribute('data-custom-data');
				//Example: first_name:input_1_2,last_name:input_1_3

				if(c_data) {
					var prepared_data = {};
					var _found = false;

					c_data = c_data.split(',');
					//Example: Array [ "first_name:input_1_2", "last_name:input_1_3" ]

					for(i = 0, c = c_data.length; i < c; i++) {
						try {

							var _temp = c_data[i].split(':');
							//Example: "Array [ "first_name", "input_1_2" ]"

							var value = document.getElementById(_temp[1]);

							if(value) {
								value = value.value.trim();
							}
							else {
								value = '';
							}

							prepared_data[_temp[0]] = value;
							_found = true;
						}
						catch(err) {
							console.log(err);
						}
					}

					if(_found === true) {

						//We do not want to touch custom data that was there previosuly, so we either use one or the other.

						//Create tags for the video
						ziggeo_app.videos.update(data.embedding_object.get("video"), { data: prepared_data });
					}
				}
			});
	}