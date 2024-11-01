=== Plugin Name ===
Social Feeder
Contributors: 10quality
Tags: social media, feed, feeds, social networks, social feed, social feeder, social, twitter, instagram, customize, customizable, widget, social network, facebook, shortcode
Requires at least: 3.2
Requires PHP: 5.4
Tested up to: 5.8
Stable tag: 1.0.8
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Integrate your social media (Twitter, Facebook, and Instagram networks) in one feed, and displays them using a widget or a shortcode.

== Description ==

**Fast**, optimized and powerful Social Media feed (Widget or Shortcode); designed with full-customization in mind.

**Social Feeder** connects with multiple social network APIs to extract your feed and display it in your Wordpress setup.

> [Documentation](https://www.10quality.com/docs/social-feeder/) | [PRO](https://www.10quality.com/product/social-feeder-pro/)

== Feed Display ==

The feed can be merged or not (by date) between all social networks configured, providing a consolidated section in your website to display them.

*Social Feeder* provides its own **Theming** system, that will allow you to instantly switch and select the look-and-feel of the feed.

== Supported Social Network ==

Current version supports: Facebook, Twitter and Instagram (more to come...). **Social Feeder** provides you with various pages to configure API authorization with the social media described.

== Fast And Optimized ==

The plugin is super lightweight in comparison to the competition, plus, comes built-in with its own cache system that allows it to store fetched data without affecting your site's loading speed.

== Media Support ==

**Social Feeder** will read the incoming social media data and will detect if images and/or youtube videos are found to display them in the feed.

== Customization ==

The plugin comes with templates that can be customized and modified by copying them into your Wordpress theme. Hooks have been coded all over the place so you can customize the functionality as desired.

== Listed Features ==

* Display your social media activity in your Wordpress.
* Merge all your social media into one feed or separate them.
* Displays images coming from social networks.
* Internal file cache for speed optimization.
* Fully customizable templates.
* Facebook pages support.
* YouTube embeded on facebook feed.
* Documentation.
* NO-Javascript.
* Un-enqueuable styles to prevent theme conflicts.
* Ability to append "follow us" link buttons.

== PRO Features ==

* Additional themes.
* Ability to assign different themes per instance (Widget or Shortcode).
* Ability to highlight content in order to create engagement links from urls, mentions and hashtags.
* Additional feed information (profile data).

== Installation ==

1. Head to your Wordpress Admin Dashboard and click at the options **Plugins** then **Add new**.
2. Search for this plugin usign the search input or if have downloaded the zip file, upload it manually.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Configure the plugin at "Settings->Social Feeder".

== Changelog ==

= 1.0.8 =
*Release Date - 5 August 2021*

* Facebook and Instagram brand complicts.
* Framework files updated.
* Compatibility check.

= 1.0.7 =
*Release Date - 27 June 2020*

* Settings updated (Instagram scopes need approval now).
* Framework files updated.
* Code refactoring.

= 1.0.6 =
*Release Date - 20 December 2019*

* Framework files updated.

= 1.0.5 =
*Release Date - 5 December 2019*

* Framework files updated.

= 1.0.4 =
*Release Date - 4 December 2019*

* Facebook shared links support.

= 1.0.3 =
*Release Date - 4 December 2019*

* Twitter SSL notice.
* Prevents to load Twitter feed if site does not have SLL.
* Framework update.

= 1.0.2 =
*Release Date - 31 May 2019*

* Added documentation and other reference links.
* Updated plugin description.
* Added customization hooks and global functions.
* Bug fixes.

= 1.0.1 =
*Release Date - 30 May 2019*

* Vertical and horizontal display.
* Additinal hooks.
* Limit and cache fixes.

= 1.0.0 =
*Release Date - 29 May 2019*

* Framework upgrade.
* Facebook SDK updated.
* Twitter SDK updated.
* Instagram SDK updated.
* Refactored views.
* Custom hooks added.
* Bug fixes.
* Localization support.
* Facebook v3.3 support.
* Youtube support on facebook feed.

= 0.7.2 =
*Release Date - 13 July 2016*

* Session bug fix. [reported](https://wordpress.org/support/topic/facebook-v26-not-working)
* Facebook SDK updated.

= 0.7.1 =
*Release Date - 21 April 2016*

* Framework [Wordpress Development Templates](http://wordpress-dev.evopiru.com/) updated to latest verion.

= 0.7.0 =
*Release Date - 19 April 2016*

* Added Facebook support.
* Styles updated.
* Wordpress.org assets updated.

= 0.6.0 =
*Release Date - 27 March 2016*

* Tested on Wordpress 4.5.

== Screenshots ==

1. All your social feed in one place and with multiple theme support. Widget displayed in sidebar.
2. YouTube videos shared on facebook are embeded. Widget displayed in sidebar.
3. Admin dashboard with theme settings.
4. Using shortcode `[socialfeeder]` to display it with a different direction.
5. Widget settings.

== Frequently Asked Questions ==

= Setup? =

Once activated, **Social Feeder** requires an initial setup in which you will need configure each social network connectivity before you can use the widget.

The settings page is located at the **Settings** option in the admin dashboard. Here you can configure general and individual social network settings.

= Documentation? =

Visit the [official documentation](https://www.10quality.com/docs/social-feeder/).

= How to modify the template? =

The templates is located inside the plugin at the following path: **social-feeder/assets/views/**

To modify it, simply copy and paste the template inside your **theme**. The template at your theme should be located at: **[your-theme]/socialfeeder/**

You might want to un-check the styles that come with the plugin at the settings page as well, this will prevent from overloading your page with additional and un-used files.

= Which WordPress versions are supported? =

At the time this document was created, we only tested on Wordpress 4.4.1, we believe, based on the software requirements, that any Wordpress version above 3.2 will work.

= Which PHP versions are supported? =

Any greater or equal to **5.4** is supported.

= Which Facebook SDK version are supported? =

SDK updated to support up till **v3.3**.

= While developing, got a weird SSL error, what to do? =

This error occurs because your local php configuration is missing the SSL configuration, which is required for certain functionality within the package.

To solve this, follow these steps:

1. Create the **cacert.pem** file somewhere in your machine. Here is one you can [download](http://curl.haxx.se/ca/cacert.pem).
2. Modify your php.ini file and add the following lines at the very bottom (example in Windows, modify the path to point to the cacert.pem file):

[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an absolute path.
curl.cainfo = "C:\path\to\cacert.pem"

Finally restart your web server and the problem will be solved.

== Who do I thank for all of this? ==

* [Alejandro Mostajo](http://about.me/amostajo)
* [Wordpress Development Templates](http://wordpress-dev.evopiru.com/)
* [James Mallison](https://github.com/J7mbo/twitter-api-php)
* [Galen Grover](https://github.com/galen/PHP-Instagram-API)