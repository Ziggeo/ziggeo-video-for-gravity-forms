This file contains the change log info for the `Ziggeo - Gravity Forms` Bridge plugin


=======

= 1.11 =
* Added: Added support for WP Core plugin Lazyload feature
* Improvement: Removed dependency on jQuery which could lead to console error in the preview page

= 1.10 =
* Added: Hooks for verified event
* Added: Dynamic custom data support, allowing you to create custom data based on the fields on your Gravity Forms form.

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