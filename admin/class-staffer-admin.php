<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codewrangler.io
 * @since      2.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Staffer
 * @subpackage Staffer/admin
 * @author     codeWrangler, Inc. <edward@codewrangler.io>
 */
class Staffer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Adds the staff profile meta box
	 *
	 * @since    2.0.0
	 */
	public function add_meta_boxes() {

		add_meta_box('staffer_meta',
			__('Profile Details', 'staffer'),
			array( $this, 'staffer_meta_callback' ),
			'staff',
			'normal',
			'high'
		);

	}

	/**
	 * Callback to generate meta box markup
	 *
	 * @since    2.0.0
	 */

	public function staffer_meta_callback( $post ) {

		$staffer = new Staffer();
		$options = $staffer->get_options();

		wp_nonce_field( 'staffer_meta', 'staffer_meta_nonce' );

		$keys = array(
			'staffer_staff_title',
			'staffer_staff_fb',
			'staffer_staff_gplus',
			'staffer_staff_twitter',
			'staffer_staff_linkedin',
			'staffer_staff_youtube',
			'staffer_staff_instagram',
			'staffer_staff_github',
			'staffer_staff_website',
			'staffer_staff_email',
			'staffer_staff_phone',
		);

		$field_values = array();

		foreach( $keys as $k ) {
			$v = get_post_meta( $post->ID, $k, true );
			$field_values[$k] = $v;
		}

		$main_page_id = $options['main_page_id'];

		echo '<p><label for="staffer_id">
						<strong>' . __('Staff ID', 'staffer' ) . '</strong>
						<input style="cursor: not-allowed;" type="text" id="staffer_id" name="staffer_id" class="widefat" value="' . $post->ID . '" disabled>
					</label></p>';

		if( $main_page_id ) {
			$main_page = get_post( $main_page_id );
			if( $main_page ) {

			$url = get_site_url() . '/' . $main_page->post_name . '/' . '?uid=' . $post->post_name;
			echo '<p><label for="staffer_slug">
							<strong>' . __('Staff Member URL', 'staffer' ) . '</strong><br>
							<a href="' . $url . '" target="_blank">' . $url . '</a>
						</label></p>';
			}
		}

		echo '<p><label for="staffer_slug">
						<strong>' . __('Staff Permalink Slug</strong> (<em>auto-generated if left blank</em>)', 'staffer' ) . '</strong>
						<input type="text" id="staffer_slug" name="staffer_slug" class="widefat" value="' . $post->post_name . '">
					</label></p>';


		echo '<p><label for="staffer_staff_title">
						<strong>' . __('Title', 'staffer' ) . '</strong>
						<input type="text" id="staffer_staff_title" name="staffer_staff_title" class="widefat" value="' . $field_values['staffer_staff_title'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_fb">
						<strong>' . __('Facebook', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_fb" name="staffer_staff_fb" class="widefat" value="' . $field_values['staffer_staff_fb'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_gplus">
						<strong>' . __('Google+', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_gplus" name="staffer_staff_gplus" class="widefat" value="' . $field_values['staffer_staff_gplus'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_twitter">
						<strong>' . __('Twitter', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_twitter" name="staffer_staff_twitter" class="widefat" value="' . $field_values['staffer_staff_twitter'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_linkedin">
						<strong>' . __('LinkedIn', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_linkedin" name="staffer_staff_linkedin" class="widefat" value="' . $field_values['staffer_staff_linkedin'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_instagram">
						<strong>' . __('Instagram', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_instagram" name="staffer_staff_instagram" class="widefat" value="' . $field_values['staffer_staff_instagram'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_youtube">
						<strong>' . __('YouTube', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_youtube" name="staffer_staff_youtube" class="widefat" value="' . $field_values['staffer_staff_youtube'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_github">
						<strong>' . __('Github', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_github" name="staffer_staff_github" class="widefat" value="' . $field_values['staffer_staff_github'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_website">
						<strong>' . __('Website', 'staffer' ) . '</strong>
						<input type="url" id="staffer_staff_website" name="staffer_staff_website" class="widefat" value="' . $field_values['staffer_staff_website'] . '">
					</label></p>';

		echo '<p><label for="staffer_staff_email">
						<strong>' . __('Email', 'staffer' ) . '</strong>
						<input type="email" id="staffer_staff_email" name="staffer_staff_email" class="widefat" value="' . $field_values['staffer_staff_email'] . '">
					</label></p>';

			echo '<p><label for="staffer_staff_phone">
						<strong>' . __('Phone Number', 'staffer' ) . '</strong>
						<input type="tel" id="staffer_staff_phone" name="staffer_staff_phone" class="widefat" value="' . $field_values['staffer_staff_phone'] . '">
					</label></p>';

	}

	/**
	 * Saves the staff profile meta
	 *
	 * @since    2.0.0
	 */

	public function save_staffer_meta( $post_id ) {

		if ( ! isset( $_POST['staffer_meta_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['staffer_meta_nonce'], 'staffer_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && 'staff' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		$data = array(
			'staffer_staff_title' => esc_attr( $_POST['staffer_staff_title'] ),
			'staffer_staff_fb' => esc_url( $_POST['staffer_staff_fb'] ),
			'staffer_staff_gplus' => esc_url( $_POST['staffer_staff_gplus'] ),
			'staffer_staff_twitter' => esc_url( $_POST['staffer_staff_twitter'] ),
			'staffer_staff_linkedin' => esc_url( $_POST['staffer_staff_linkedin'] ),
			'staffer_staff_website' => esc_url( $_POST['staffer_staff_website'] ),
			'staffer_staff_instagram' => esc_url( $_POST['staffer_staff_instagram'] ),
			'staffer_staff_youtube' => esc_url( $_POST['staffer_staff_youtube'] ),
			'staffer_staff_github' => esc_url( $_POST['staffer_staff_github'] ),
			'staffer_staff_email' => esc_attr( $_POST['staffer_staff_email'] ),
			'staffer_staff_phone' => esc_attr( $_POST['staffer_staff_phone'] ),
		);

		foreach( $data as $k => $v ) {
			update_post_meta( $post_id, $k, $v );
		}


		/**
		 * @since  2.1.0 Saves staff slug, removes action to avoid infinite loop
		 */

		$slug = sanitize_title_with_dashes( $_POST['staffer_slug'] );

		$r = array(
			'ID' => $post_id,
			'post_name' => $slug,
		);

		// Temporarily remove the action to avoid an infinite loop
		remove_action('save_post_staff', array($this, 'save_staffer_meta' ) );
		wp_update_post( $r );
		add_action('save_post_staff', array($this, 'save_staffer_meta' ) );

	}

	/**
	 * Adds an admin menu link to the main staff page
	 *
	 * @since    2.0.0
	 */

	public function staffer_admin_menu() {

		$staffer = new Staffer();
		$options = $staffer->get_options();

		if( !$options['manual_mode'] ) {
			global $submenu;
			$permalink = get_the_permalink( $options['main_page_id'] );
			$submenu['edit.php?post_type=staff'][] = array(
				__('View Staff Page', 'staffer'),
				'edit_posts',
				$permalink
			);
		}

	}

	/**
	 * Registers the setting
	 *
	 * @since    2.0.0
	 */

	public function register_settings() {
		register_setting( 'staffer_options', 'staffer', array( $this, 'staffer_validate_options' ) );
	}

	/**
	 * Adds the options page
	 *
	 * @since    2.0.0
	 */

	public function staffer_options_page() {
		add_options_page('Staffer ' . __('Options', 'staffer'), 'Staffer ' . __('Options', 'staffer'), 'manage_options', 'staffer', array( $this, 'staffer_output_options' ) );
	}

	/**
	 * Outputs the options content
	 *
	 * @since    2.0.0
	 */

	public function staffer_output_options() {

		$staffer = new Staffer();
		$options = $staffer->get_options();

			echo '<h4>';
			_e('For paid support or customizations, please contact me at', 'staffer' );
			echo ' <a href="https://codewrangler.io" target="_blank">codewrangler.io</a>';
			echo '</h4>';
			?>
			<div class="wrap">
				<h2><?php _e ('Staffer Options Panel', 'staffer'); ?></h2>
				<form method="post" action="options.php">
					<?php settings_fields('staffer_options'); ?>
					<?php //$stafferoptions = get_option('staffer'); ?>
					<table class="form-table">

						<tr valign="top"><th scope="row"><?php _e('Staff Page ID', 'staffer'); ?></th>
						<td><input name="staffer[main_page_id]" type="text" value="<?php echo $options['main_page_id']; ?>" />
							<p class="description"><?php _e('The ID of the main staff page. Do not change this unless you know what you are doing.', 'staffer'); ?></p>
						</td>
						</tr>

						<tr valign="top">
							<th scope="row">
								<?php _e ('Staff Layout', 'staffer'); ?>
							</th>
							<td>
								<?php
									$select_opts = array('Grid Layout' => 'grid', 'List Layout' => 'list' );
									echo '<select id="" name="staffer[gridlayout]">';
									foreach( $select_opts as $k => $v ) {
										$selected = $options['layout'] == $v ? 'selected' : '';
										echo '<option value="' . $v . '"' . $selected . '>' . $k . '</option>';
									}
									echo '</select>';
								?>
							</td>
						</tr>
					<?php /**
						<tr valign="top"><th scope="row"><?php _e ('Manual Mode', 'staffer'); ?></th>
						<td><input name="staffer[manual_mode]" type="checkbox" value="1" <?php checked(true, $options['manual_mode']); ?> />
							<p class="description"><?php _e('Check to disable the main Staffer archive page. Useful if you want to solely use shortcodes to display lists of staff members. For more information on shortcodes, please read the <a href="https://wordpress.org/plugins/staffer/">Staffer documentation</a>.', 'staffer'); ?></p>
						</td>
						</tr>
						**/ ?>
					</table>
					<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'staffer') ?>" />
					</p>
				</form>

				<?php esc_attr_e('Thank you for using Staffer. A lot of time went into development. Donations small or large are always appreciated.' , 'staffer'); ?></p>
				<form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="QD8ECU2CY3N8J">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
			</div>
		<?php	
	}

	/**
	 * Validates the Staffer options data
	 *
	 * @since    2.0.0
	 */

	public function staffer_validate_options( $input ) {

		$staffer = new Staffer();
		$options = $staffer->get_options();

		// Preserve this deprecated value for now
		if( '' != $options['custom_css'] ) {
			$input['customcss'] = $options['custom_css'];
		}

		if( $input['gridlayout'] == 'list' ) {
			$input['gridlayout'] = '';
		} else {
			$input['gridlayout'] = true;
		}

		if( !isset( $input['manual_mode'] ) ) {
			$input['manual_mode'] = '';
		}
		
		return $input;

	}

}
