=== Staffer ===
Contributors: cardiganmedia
Tags: staff, staff directory, profile, business
Donate link: http://www.edwardrjenkins.com
Requires at least: 3.5
Tested up to: 4.1
Stable tag: 1.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin that adds staff management and custom staff profile pages.

== Description ==
Staffer uses custom post types for staff/employee management, allowing users to easily create and manage an onsite staff directory. Staffer works immediately with many popular WordPress themes, but also allows for custom template use and custom content wrappers. These settings make it easy to use with almost any WordPress theme. Staffer also supports the display of staff members via a shortcode.

== Installation ==
1. Upload the \'staffer\' folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the \'Plugins\' menu in WordPress
3. Visit the Settings panel to set up Staffer.

== Frequently Asked Questions ==
= How Do I Set Up a Custom Template? =

Staffer uses two main templates: archive-staff.php and single-staff.php. If these files are present within your theme directory, Staffer will load your custom files rather than the plugin's default files. So, to create a custom template, you might start by copying archive-staff.php and single-staff.php into your theme's template. Then you could proceed to customize the template to your satisfaction. Some basic HTML/PHP skills will generally be needed for this. If you aren't comfortable with this, I suggest reaching out to a competent developer. I'm also available for paid support and customization, so please contact me through my website should you need assistance.

Using some combination of custom templates and custom wrappers, Staffer should work with most any WordPress theme.

= How Do I Use Staffer’s Shortcodes? =

There are two ways to use shortcodes: 1) standard method. 2) manual method.

In the default method, you can use shortcodes while keeping Staffer’s archive pages enabled. If you want to use shortcodes exclusively, check the “Manual Method” option in the Staffer Options panel to disable the main “Staff” page.

Follow this format for shortcodes:

[staffer]

The above example would output all of the staff listings in default order.

To fine-tune, you can use parameters:

[staffer number="5" department="slug"]

In the above example, “number” refers to the number of entries to retrieve, and “department” refers to the department name slug. For instance, if you only wanted to show a list of members in department term with the “management” slug, you would pass “management” as a parameter.

Other parameters include “order” and “orderby” — and all parameters are optional.

Using the extra parameters, you could reorder the entries using WP_Query’s order and orderby parameters.

For example, if you wanted to display 50 staff members, ordered by name alphabetically, you would do the following:

[staffer number="50" order="ASC" orderby="name"]

= How Can I Set the Order of Staff Profiles? =

For now, use a custom ordering plugin, such as Post Types Order, available in the WordPress plugin repository. I plan on adding this functionality to Staffer in the future.

= How Do I Use Custom Content Wrappers? =

Custom content wrappers are used when Staffer doesn't flow well with your theme. Due to the incredible diversity of WordPress themes, I've included this option for folks that find the default wrappers do not work for them. You will need to utilize Chrome's Developer Tools or a Firefox add-on like Firebug to inspect the page elements to find your theme's content wrappers. For example, here is the start of the content wrapper for the Twenty-Twelve theme:

<code><div id="primary" class="site-content"><div id="content" role="main"></code>

And here is the end wrapper:

<code></div></div></code>

= What Size Should the Staff Images Be? =

The ideal size, as shown in the plugin screenshots, is 250x200. However a variety of image sizes will work. To preserve the formatting, make sure all your images are uniform in size, particularly if you are using the Staffer grid layout.

= Where Can I Get Support? =

You may seek community support within the WordPress.org forums. I will try to monitor and assist as needed. If you need immediate, hands-on, paid support, please contact me through my website: www.edwardrjenkins.com

== Screenshots ==
1. Staffer options panel
2. Staffer archive page
3. Staffer single profile
4. Staff profile editor

== Changelog ==
= 1.3.3 =
= February 8, 2015=
* added manual mode option
* adding shortcode support
* added thumb archive link
* fix for overflowing content wrappers
= 1.3.1 =
= December 10, 2014 =
* fixed department slug 404 issue
= 1.3 =
= November 25, 2014 =
* fixed issue with permalinks not refreshing automatically
* added full bio option
* fixed blank breadcrumbs issue
* added phone number field
* added German and Spanish translations
* fixed post per page issue
* fixed issue when pretty permalinks are disabled
* added link to main page from admin menu
* added taxonomy
* removed sidebar option
= 1.2 =
= October 11, 2014 =
* fixes custom post type conflict
= 1.1 =
= October 10, 2014 =
* Moved register_post_type to activation hook
* Added custom label field for proper title tag handling
* Added website field to profiles
* Changed <section> to <div> in single-staff.php for validation
* Added built-in wrappers for most of top 20 popular WordPress themes
= 1.0 =
* Initial release

== Upgrade Notice ==
= 1.3.3=
Adds shortcode option
= 1.3 =
Adds taxonomy, fixes permalink bugs
Other misc. fixes.
= 1.2 =
Fixes custom post type conflict
= 1.1 =
Cleans up activation and adds new website field and custom labeling. Adds more built-in wrappers for better theme support.
