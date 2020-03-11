jQuery( document ).ready(function() {
	//Handling video recorders
	ziggeo_app.embed_events.on("verified", function (embedding_object) {
		//lets get the embedding element
		var embedding = embedding_object.activeElement();

		if(!ziggeogravityformsIsOfForm(embedding)) {
			//Not to be handled by us
			return false;
		}

		var element = document.getElementById( embedding.getAttribute('data-id').trim() );
		element.value = "[ziggeoplayer]" + embedding_object.get("video") + "[/ziggeoplayer]"
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
});

// Just a simple function to check for signs of this embedding actually being part of Gravity Forms form
function ziggeogravityformsIsOfForm(embedding) {

	if(embedding.getAttribute("data-is-gf")) {
		return true;
	}

	return false;
}