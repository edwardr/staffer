<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://codewrangler.io
 * @since      1.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Staffer
 * @subpackage Staffer/includes
 * @author     codeWrangler, Inc. <edward@codewrangler.io>
 */
class Staffer_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
