
function ziggeo_integration_gravityforms_admin_select(sel) {

	ziggeoDevReport('`ziggeo_integration_gravityforms_admin_select` is going to be renamed in next version of plugin. Write to us on forum if you are using it to stay updated.');

	var field = document.getElementById('field_settings').parentElement.id;
	field = field.replace('field_', 'input_');

	//Lets grab the element that we will update..
	var elem = document.getElementById(field);

	//It should be ziggeo element, but just in case, better not to change the wrong element, than to do so
	if(elem) {
		elem.innerHTML = '<h3>Processing template</h3>'; //maybe replace this with graphical process bar

		var template = sel.options[sel.selectedIndex].value;

		//Gravity Forms settings
		Setziggeo_template_settingSetting(template);

		//calling ajax request to get the right data..
		ziggeoAjax({ integration: 'GravityForms', template: template },
			function() {
				elem.innerHTML = response;
				if(elem.getElementsByClassName('runMe'))
				{
					var el = elem.getElementsByClassName('runMe');
					var scr = document.createElement('script');

					for(i = 0, c = el.length; i < c; i++) {
						var tmp = el[i].innerHTML.toString().replace(/(\n)+/g, ' ').replace(/  +/g, ' ');
						scr.innerHTML += tmp;
					}
					document.body.appendChild(scr);
				}
		});
	}
	else {
		ziggeoDevReport('seems that something went wrong here..');
	}
}