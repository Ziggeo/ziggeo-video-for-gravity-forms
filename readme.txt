=== Ziggeo Video for Gravity Forms ===
Contributors: oliverfriedmann, baned, carloscsz409, natashacalleia
Tags: ziggeo, video, video field, gravity forms, video submission
Requires at least: 3.0.1
Tested up to: 5.6
Stable tag: 1.10
Requires PHP: 5.2.4
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin is providing an easy and simple way for you to add Ziggeo to your Gravity Forms forms through special Ziggeo fields.

= Who is this for? =

Do you need to grab video and other personal details?
Need or want to allow screen or video recording of issue that is submitted?
Form fields missing video?

If any of the above was yes, you want this plugin!

= Benefits =

Bringing the power of Ziggeo to your forms you can be sure that your forms will allow you to capture all info you need. Video can and should be easy and with this plugin that becomes true.

== Screenshots ==

1. Dashboard Setting
2. Ziggeo Fields
3. Ziggeo Video Recorder Field
4. Ziggeo Video Player Field
5. Ziggeo VideoWall Field
6. Ziggeo Templates Field
7. How data is saved in entries (you pick format)

== Installation ==
 
1. Upload plugin zip file to your plugins directory. Usually that would be to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. That is it or
1. Use the Plugins Add new section to find the plugin and install
 
== Frequently Asked Questions ==

= How does it work? =

The plugin combines and extends the reach of Ziggeo plugin to your Gravity Forms forms. It brings the video to your forms in an easy to use and simple manner. It allow you to add any template you have created from a single field and have video on your form.

Depending on the template you can capture screen or camera or both at the same time. All you want and so easy to get.

= Where does integration happen? =

This plugin will add the code that works in the back. It uses Gravity Forms Addon framework to bring you the addon. This addon then adds the field that you will see in the Gravity Form.

= How to use Dynamic Custom Data =

Ziggeo internally supports the ability of adding custom data to your videos. This can be anything as long as it is provided as valid JSON field. Now with form builders you might want to add custom data based on the data in the fields as well. To do this, we bring you dynamic custom data field.

* Please note that this field should not be used in combination with the custom data. You should use either `Custom Data` or `Dynamic Custom Data`.

The way you would set it up is by using key:field_id. For example if you want your JSON to be formed as:

[javascript]
{
	"first_name": "Mike",
	"last_name": "Wazowski"
}
[/javascript]

and let's say that your first name has `<input id="input_1_2" ...>` and last name has `<input id="input_1_3" ...>`. It means that we need `input_1_2` and `input_1_3` to get those values. So our field can be set as:

`first_name:input_1_2,last_name:input_1_3`

As you save your recorder field it will remember this and try to find the values. If the fields with ID are not found, the value will be saved as "" (empty string)

= How can I get some support =

We provide active support to all that have any questions or need any assistance with our plugin or our service.
To submit your questions simply go to our [Help Center](https://support.ziggeo.com/hc/en-us). Alternatively just send us an email to [support@ziggeo.com](mailto:support@ziggeo.com).

= I have an idea or suggestion =

Please go to our [WordPress forum](https://support.ziggeo.com/hc/en-us/community/topics/200753347-WordPress-plugin) and add your suggestion within it. This allows everyone to see and vote on it and us to determine what should be next.

== Upgrade Notice ==

= 1.10 =
* Added: Hooks for verified event
* Added: Dynamic custom data support, allowing you to create custom data based on the fields on your Gravity Forms form.

== Changelog ==

= 1.9 =
* Added the option to set tags to video based on other fields on form. The same happens once the video is verified.
* Added the check for the conditional logic so that notices are not outputted in cases when your server does not hide them (you should if not dev site ;) ).
* Improvement: API calls are now using V2 flavor.
* Improvement: Submenu calls are now checking if core plugin is relatively fresh and available to support the call. otherwise it does not use it.
* Improvement: Added a check when the plugin is loading to see if core plugin is available or not. Instead of skipping loading silently, we now show a warning about this in admin dashboard.

= 1.8 =
* Utilizing the function Ziggeo Core plugin provides to add the page as addon
* Removed the notification that would be made each time you request the plugin and the Videowalls plugin is not installed or activated. Now fires only in editor. Also shows notice in the form builder that it is missing.

= 1.7.2 =
* Fixed videowall assets loading

= 1.7.1 =
* Fixed the issue with the templates submission where if you used recorder or player through a template you might not get the value in because of new validation that was added.

= 1.6 =
* Added the option to select what type of value you want to get once the video is recorded, which is made available through dashboard page under Ziggeo Video > Ziggeo Video for Gravity Forms.
* Also added a filter to allow this to change this through your own code regardless of the setting
* Any time video is recorded it will add +1 new video in the video list

= 1.5 =
* Added a check to avoid error if the application token was not provided. It also helps if core plugin was not installed.

= 1.4 =
* Fixed an issue caused by the space character in video recorder.

= 1.3 =
* Added support for No Conflict mode of Gravity Forms editor.

= 1.2. =
* Improved support for core plugin
* Field for templates have been modified to provide better support for all templates
* Additional fields have been added (Recorder, Player and VideoWalls)
* All buttons are now within Ziggeo fields group of fields

= 1.1 =
* Upgrading versions
* Support for new Ziggeo core plugin (v2.0)

= 1.0 =
* Initial commit