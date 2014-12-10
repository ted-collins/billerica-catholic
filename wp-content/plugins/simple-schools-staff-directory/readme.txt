===  Simple Schools Staff Directory  ===
Contributors: charlwood
Donate link: http://www.simpleintranet.org/simple-schools 
Website: http://www.simpleintranet.org/simple-schools 
Tags: schools, school, university directory, college directory, staff directory, employee directory
Requires at least: 3.0.1
Tested up to: 3.6.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple staff directory for colleges, universities and schools. 

== Description ==

Simple Schools Staff Directory is an easy to use plugin for schools. It includes;

* a searchable staff directory with photos and extended staff profile fields
* custom HTML profile biographies using a custom post type: Biography
* staff listing sidebar widget with photos
* away from school notifications and sidebar widget

Credit goes Jake Goldman, Avatars Plugin, (http://www.10up.com/) for contributing to this code that allows for user photo uploads.

Upgrade at http://www.simpleintranet.org/simple-schools to the full version of Simple Schools which includes;

* school events calendar with a grid or event listing views and sidebar widget
* online forms with drag and drop setup, and back-end viewing and downloads
* Facebook-like activity feed for sharing comments in real-time
* featured staff sidebar widget (Employee of the Month)
* Dropbox-like front-end file management using Media Library
* most popular content tracking sidebar widget
* vacation request workflow
* instant organization charts using Google Org Chart API
* polls for surveying students or staff
* wiki with front-end editing
* real-time chat function
* appointment or room bookings function
* Active Directory & Google SSO integration

== Installation ==

Thank you for downloading our Simple Schools Staff Directory plugin.  Here is a quick primer on the installation and setup for installing our plugin-in.   Upgrade at http://www.simpleintranet.org/simple-schools to the full version of Simple Schools for more features and functionality.

1. Download and unzip the plugin and copy/extract the "simple-schools" folder and  upload all of its child files to the "wp-content/plugins" directory of your WordPress.org installation.  

2. You will then need to activate the Simple Schools Staff Directory plugin in the "Plugins" area of the Dashboard. 

3. It is advised that you name pages URLs after their post names (vs IDs), so go to "Settings / Permalinks" in the Dashboard and select "Post name" under Common Settings.

4. For showing the Staff Directory (with a custom search bar to find people by name) you can include the [staff] shortcode in the HTML of any page you wish to create yourself.  The recommended size for the Staff Photos is 100 x 100 pixels.  

== Shortcodes ==

- To add a searchable staff directory to a page or post, insert the [staff] shortcode in a post/page. The default number of staff shown per page is 25, but you can limit the number of staff shown per page by adding a limit parameter in the shortcode, such as [staff limit="10"] for 10 staff per page. You may exclude staff in their user profile area.

== Widgets == 

- Display a list of staff using the Staff widget. You may exclude staff in their user profile area. Use the "number" field in the widget settings to limit to a set number of staff to show.
- Display away notifications in the staff directory (set in Your Profile) using the Away From School widget.


== Frequently Asked Questions ==

= Why are Staff Photos not showing? =

This is typically due to a folder or permissions issue on your server.  You need to ensure you assign "write" permissions (see chmod settings on some applications) to your upload folder using your FTP client (e.g. Filezilla) or HTML editor.  Be sure also to check you have the right folder, especially if you are using a subdomain. 

= Why doesn't the search function or paging work for my Staff Directory? =

You need to set your Settings / Permalinks to Post Name (rather than the Default ID). 

== Screenshots ==

1. This screen shot shows the Simple School Staff Directory with user photos/avatars.

== Changelog ==
= 1.0 =
* This is the first version. 

== Upgrade Notice ==
Upgrade at http://www.simpleintranet.org/simple-schools to the full version of Simple Schools for more features and functionality.