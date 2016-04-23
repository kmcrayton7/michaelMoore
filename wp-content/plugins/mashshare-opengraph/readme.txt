=== Mashshare - Open Graph Add-On===
Author: Rene Hermenau
Tags: open graph, wp, opengraph, open, graph, seo, metadata, facebook, facebook open graph, protocol
Requires at least: 3.3
Tested up to: 4.3.1
Stable tag: 1.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Credit: This software is based on WP Open Graph by Nick Yurov https://wordpress.org/plugins/wp-open-graph

This plugin allows you to add facebook open graph protocol to your blog

== Description ==

You can add facebook meta data (open graph protocol) to any post/page/content type, edit it and enjoy your blog sharing.
WP Open Graph automaticly extract data from post title, excerpt, "All In One Seo Pack" or "Wordpress Seo by Yoast" plugins. It uses post thumbnails(featured image) or presetted default image as og:image.

Also you can edit this data for any post, static home page and index blog page.
Plugin automatically adds data for any taxonomy archives(tags, categories, custom taxonomies) from term title and description.

== Installation ==

1. Upload plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Edit open graph data in any post
4. Enjoy!

== Frequently asked questions ==

= What is Open Graph Protocol ? =

The Open Graph protocol enables any web page to become a rich object in a social graph. For instance, this is used on Facebook to allow any web page to have the same functionality as any other object on Facebook.
http://ogp.me/

== Screenshots ==

1. Editing Post
2. Open Graph HTML code

== Changelog ==

= 1.0.8 =
* Fix change site_url() to home_url()

= 1.0.7 =
* Tweak: Remove licensing code
* New: Tested up to WP 4.3.1

= 1.0.6 =
* Fix: Use the_title_attribute('echo=0') instead get_the_title() when this plugin is activated but open graph title is empty. -> Removes item prop arguments

= 1.0.5 =
* New: Optional loading of scripts and styles into footer. See new option in Mashshare->Settings->General settings
* Info: No longer compatible to older versions than WordPress 3.6

= 1.0.4 =
* Test up to WP 4.1
* Fix a problem where images can not be embeded in posts

= 1.0.3 =
* New: Add separate field for Twitter Share text. Use hashtags in the share text.
* New: Warning when Yoast OG Tags are enabled.
* Tweak: Use OG default Description and OG default images on One-Pager themes

= 1.0.2 =
* Fix: non static declaration error
* Fix: undefined var

= 1.0.1 =
* Fix: Use WPSEO_Meta::get_value
* Fix: check if mashsb_is_admin_page exists in script.php
* Fix: remove deprecated js files

= 1.0.0 = 
* Initial version.

== Upgrade notice ==

The current version of WP Open Graph requires WordPress 3.3 or higher.