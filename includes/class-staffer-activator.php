<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codewrangler.io
 * @since      2.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2.0.0
 * @package    Staffer
 * @subpackage Staffer/includes
 * @author     codeWrangler, Inc. <edward@codewrangler.io>
 */
class Staffer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    2.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();
		$staffer = new Staffer();

		$staffer->create_staff_page();
	}

}
