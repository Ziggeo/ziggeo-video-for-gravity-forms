=== Ziggeo Video for Gravity Forms ===
Contributors: oliverfriedmann, baned, carloscsz409
Tags: ziggeo, video, video field, gravity forms, video submission
Requires at least: 3.0.1
Tested up to: 5.3.2
Stable tag: 1.7
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

= How can I get some support =

We provide active support to all that have any questions or need any assistance with our plugin or our service.
To submit your questions simply go to our [Help Center](https://support.ziggeo.com/hc/en-us). Alternatively just send us an email to [support@ziggeo.com](mailto:support@ziggeo.com).

= I have an idea or suggestion =

Please go to our [WordPress forum](https://support.ziggeo.com/hc/en-us/community/topics/200753347-WordPress-plugin) and add your suggestion within it. This allows everyone to see and vote on it and us to determine what should be next.

== Upgrade Notice ==


== Changelog ==

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