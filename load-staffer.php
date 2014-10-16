<?php
/*
	Plugin Name: Staffer
	Plugin URI: https://www.edwardrjenkins.com/wordpress-plugins/staffer/
	Description: A WordPress plugin that adds staff management and custom staff profile pages.
	Author: Edward R. Jenkins
	Version: 1.2
	Author URI: https://edwardrjenkins.com
	Text Domain: staffer
	Domain Path: /lang
 */
add_action('admin_init', 'staffer_init' );
add_action('admin_menu', 'staffer_add_page');
// staffer init
function staffer_init(){
	register_setting( 'staffer_options', 'staffer', 'staffer_validate' );
}
// adds menu page
function staffer_add_page() {
	add_options_page('Staffer Options', 'Staffer Options', 'manage_options', 'staffer', 'staffer_do_page');
}
// writes the menu page
function staffer_do_page() {
	$supportsite = 'https://www.edwardrjenkins.com';
		_e('<h4>For paid support or customizations, please contact me at <a href="'.$supportsite.'" target="_blank">edwardrjenkins.com</a></h4>','staffer');
		?>
	<div class="wrap">
		<h2><?php _e ('Staffer Options Panel', 'staffer'); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields('staffer_options'); ?>
			<?php $stafferoptions = get_option('staffer'); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row"><?php _e ('Staff Layout'); ?></th>
				<td><input name="staffer[gridlayout]" type="checkbox" value="1" <?php checked(true, $stafferoptions['gridlayout']); ?> />
					<p class="description"><?php _e('Check this to use the staff grid layout.'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Listings per page'); ?></th>
				<td><input type="number" size="80" max="99" name="staffer[perpage]" value='<?php echo $stafferoptions['perpage']; ?>' />
					<p class="description"><?php _e('Set the number of staff members per page. Leave blank for the default of 9.', 'staffer'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Staffer Page Title'); ?></th>
				<td><input type="text" size="80" name="staffer[ptitle]" value='<?php echo $stafferoptions['ptitle']; ?>' />
					<p class="description"><?php _e('Set a custom Staffer page title, if desired. The default title is <code>Staff</code>. This title will be used as the archive page title and within breadcrumbs. Leave blank to use the default.', 'staffer'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Staffer Label'); ?></th>
				<td><input type="text" size="80" name="staffer[label]" value='<?php if ( isset ($stafferoptions['label'] ) ) { echo $stafferoptions['label']; } ?>' />
					<p class="description"><?php _e('Set a custom label, if desired. This is shown in the admin panel and is used in the <code>title</code> tag. The default label is <code>Staff</code>. Leave blank to use the default.', 'staffer'); ?></p>
				</td>
				</tr>				
				<tr valign="top"><th scope="row"><?php _e ('Staffer URL slug'); ?></th>
				<td><input type="text" size="80" name="staffer[slug]" value='<?php echo $stafferoptions['slug']; ?>' />
					<p class="description"><?php _e('Set a custom URL slug, if desired. The default slug is <code>staff</code>.<strong>Notice:</strong> Use lowercase only, and use no spaces, i.e., instead of using <code>Staff Pages</code>, use <code>staff-pages</code>. Leave blank to use the default.', 'staffer'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Disable CSS'); ?></th>
				<td><input name="staffer[disablecss]" type="checkbox" value="1" <?php checked(true, $stafferoptions['disablecss']); ?> />
					<p class="description"><?php _e('Check this box to disable all Staffer CSS.'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Use custom wrappers'); ?></th>
				<td><input name="staffer[customwrapper]" type="checkbox" value="1" <?php checked(true, $stafferoptions['customwrapper']); ?> />
					<p class="description"><?php _e('Check this box and enter your wrappers below to use custom content wrappers. See the documentation for details. You may need to use custom wrappers if Staffer pages do not flow well with your theme.'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Custom start wrapper'); ?></th>
				<td><input type="text" size="80" name="staffer[startwrapper]" value='<?php echo $stafferoptions['startwrapper']; ?>' />
					<p class="description"><?php _e('Enter your custom start wrapper.', 'staffer'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Custom end wrapper'); ?></th>
				<td><input type="text" size="80" name="staffer[endwrapper]" value='<?php echo $stafferoptions['endwrapper']; ?>' />
					<p class="description"><?php _e('Enter your custom ending wrapper. This should close out the wrapper started above.', 'staffer'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Enable Staff Sidebar'); ?></th>
				<td><input name="staffer[sidebar]" type="checkbox" value="1" <?php checked(true, $stafferoptions['sidebar']); ?> />
					<p class="description"><?php _e('*Experimental feature. Does not work with all layouts. Create a custom Staffer template for better sidebar control.'); ?></p>
				</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e ('Custom CSS'); ?></th>
				<td>
				<textarea rows="20" class="large-text" type="text" name="staffer[customcss]" cols="50" rows="10" /><?php echo $stafferoptions['customcss']; ?></textarea>
				<p class="description"><?php _e('Input your custom style rules here.', 'staffer'); ?></p>
				</td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
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
// sanitize and validate input
function staffer_validate($input) {
	// Our first value is either 0 or 1
	if ( ! isset( $input['disablecss'] ) )
	$input['disablecss'] = null;
	if ( ! isset( $input['sidebar'] ) )
	$input['sidebar'] = null;
	if ( ! isset( $input['label'] ) )
	$input['label'] = 'Staff';
	if ( ! isset ($input['customwrapper']) )
	$input['customwrapper'] = null;
	if ( ! isset ($input['gridlayout']) )
	$input['gridlayout'] = null;
	// Say our second option must be safe text with no HTML tags
	$input['perpage'] =  esc_html( $input['perpage'] );
	//if ( ! isset ($input['slug'] ) ) {
	$input['slug'] = sanitize_title_with_dashes ($input['slug']);
	$input['ptitle'] = ucfirst ($input['ptitle']);
	$input['label'] = ucfirst ($input['label']);
	//} else {
	//$input['slug'] = 'staff';
	//}
	$input['startwrapper'] =  wp_kses_post( $input['startwrapper'] );
	$input['endwrapper'] =  wp_kses_post ( $input['endwrapper'] );
	$input['customcss'] = wp_kses_post ( $input['customcss'] );
		return $input;
	// in case of slug change
	flush_rewrite_rules();
}
	// custom post type for staff
	function create_staff_cpt_staffer() {
		$stafferoptions = get_option ('staffer');
		$stafferslug = $stafferoptions['slug'];
		// fixes title tag issue and adds label option
		if ( !empty ($stafferoptions['label'] ) ) {
		$stafferlabel = $stafferoptions['label'];
		} else {
		$stafferlabel = 'Staff';
		}
		$rewrite = array(
		'slug'                => $stafferslug,
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
		);
		register_post_type('staff', array(
			'labels' => array(
			'name' => $stafferlabel,
			// future release 'taxonomy' => 'department',
			'singular_name' => __('Staff Member'),
			'add_new_item' => __('Add New Staff Member'),
			'edit_item' => 'Edit Staff Member',
			'new_item' => 'New Staff Member',
			'all_items' => 'All Staff Members',
			'view_item' => 'View Staff Member',
			'search_items' => 'Search Staff Members',
			'not_found' => 'No Staff Members Found',
			'not_found_in_trash' => 'No Staff Members in Trash',
			),
			'public' => true,
			'has_archive' => true,
			'show_in_menu' => true,
			'menu_order' => '4',
			'rewrite' => $rewrite,
			'menu_icon' => 'dashicons-id',
			'supports' => array(
				'title',
				'editor',
				'revisions',
				'custom-fields',
				'thumbnail',
				'excerpt'
				)
				));
				}
add_action ('init', 'create_staff_cpt_staffer' );

// adds meta box to member post types

add_action('add_meta_boxes', 'staffer_staff_meta_box', 0);

add_action('save_post_staff', 'staffer_staff_save_postdata');
// Adds a box to the main column on the Post and Page edit screens
function staffer_staff_meta_box() {
				$post_types = array(
					'staff',
				);
				foreach ($post_types as $post_type) {
								add_meta_box('staffer_details', __('Staff Member Details', 'staffer'), 'staffer_staff_role_box', $post_type, 'side', 'high', $post_types);
						}
		}
// prints the staffer post type boxes
function staffer_staff_role_box($post) {
				// Use nonce for verification
				wp_nonce_field(plugin_basename(__FILE__), 'cpt_noncename');
				// Use get_post_meta to retrieve an existing value from the database and use the value for the form
				$value = get_post_meta($post->ID, 'staffer_staff_title', true);
				echo '<label for="staffer_staff_title"><strong>Title</strong></label>';
				echo '<input id="staffer_staff_title" name="staffer_staff_title" size="28" value="' . esc_attr($value) . '"><br>';
				$value = get_post_meta($post->ID, 'staffer_staff_fb', true);
				echo '<label for="staffer_staff_fb"><strong>Facebook</strong></label>';
				echo '<input id="staffer_staff_fb" name="staffer_staff_fb" size="28" value="' . esc_attr($value) . '"><br>';
				$value = get_post_meta($post->ID, 'staffer_staff_gplus', true);
				echo '<label for="staffer_staff_gplus"><strong>Google+</strong></label>';
				echo '<input id="staffer_staff_gplus" name="staffer_staff_gplus" size="28" value="' . esc_attr($value) . '"><br>';
				$value = get_post_meta($post->ID, 'staffer_staff_twitter', true);
				echo '<label for="staffer_staff_twitter"><strong>Twitter</strong></label>';
				echo '<input id="staffer_staff_twitter" name="staffer_staff_twitter" size="28" value="' . esc_attr($value) . '"><br>';
				$value = get_post_meta($post->ID, 'staffer_staff_linkedin', true);
				echo '<label for="staffer_staff_linkedin"><strong>LinkedIn</strong></label>';
				echo '<input id="staffer_staff_linkedin" name="staffer_staff_linkedin" size="28" value="' . esc_attr($value) . '"><br>';
				$value = get_post_meta($post->ID, 'staffer_staff_website', true);
				echo '<label for="staffer_staff_website"><strong>Website</strong></label>';
				echo '<input id="staffer_staff_website" name="staffer_staff_website" size="28" value="' . esc_attr($value) . '"><br>';
				$value = get_post_meta($post->ID, 'staffer_staff_email', true);
				echo '<label for="staffer_staff_email"><strong>Email</strong></label>';
				echo '<input id="staffer_staff_email" name="staffer_staff_email" size="28" value="' . esc_attr($value) . '"><br>';
		}
// saves the staffer post type details
function staffer_staff_save_postdata($post_id) {
				if (!current_user_can('edit_page', $post_id)) {
								return;
						}
				else {
								if (!current_user_can('edit_post', $post_id))
												return;
						}
				if (!isset($_POST['cpt_noncename']) || !wp_verify_nonce($_POST['cpt_noncename'], plugin_basename(__FILE__)))
								return;
				// get ID and save data
				$post_ID      = $_POST['post_ID'];
				//sanitize user input
				$title = ($_POST['staffer_staff_title']);
				$fb = ($_POST['staffer_staff_fb']);
				$gplus = ($_POST['staffer_staff_gplus']);
				$twitter = ($_POST['staffer_staff_twitter']);
				$linkedin = ($_POST['staffer_staff_linkedin']);
				$website = ($_POST['staffer_staff_website']);
				$email = ($_POST['staffer_staff_email']);
				update_post_meta($post_ID, 'staffer_staff_title', $title);
				update_post_meta($post_ID, 'staffer_staff_fb', $fb);
				update_post_meta($post_ID, 'staffer_staff_gplus', $gplus);
				update_post_meta($post_ID, 'staffer_staff_twitter', $twitter);
				update_post_meta($post_ID, 'staffer_staff_linkedin', $linkedin);
				update_post_meta($post_ID, 'staffer_staff_website', $website);
				update_post_meta($post_ID, 'staffer_staff_email', $email);
		}
// sets template override for custom template use
function staffer_staff_templates( $template ) {
    $post_types = array( 'staff' );
    if ( is_post_type_archive( $post_types ) && ! file_exists( get_stylesheet_directory() . '/archive-staff.php' ) )
        $template = plugin_dir_path (__FILE__) . 'archive-staff.php';
    if ( is_singular( $post_types ) && ! file_exists( get_stylesheet_directory() . '/single-staff.php' ) )
        $template = plugin_dir_path (__FILE__) . 'single-staff.php';

    return $template;
}
add_filter( 'template_include', 'staffer_staff_templates' );

// loads the default css
function staffer_load_css() {
	wp_register_style ('staffer-style', plugins_url( 'styles/staffer-styles.css', __FILE__) );
	wp_register_style ('staffer-font-awesome', plugins_url( 'styles/font-awesome.min.css', __FILE__) );
	$stafferoptions = get_option('staffer');
	if ($stafferoptions['disablecss'] != '1') {
	wp_enqueue_style ('staffer-style');
	}
	wp_enqueue_style ('staffer-font-awesome');
	}
add_action ('wp_enqueue_scripts','staffer_load_css');

// loads up any custom css
function staffer_custom_styles() {
	$stafferoptions = get_option ('staffer');
		if ($stafferoptions['customcss'] != '' ) {
			$staffercustomcss = $stafferoptions['customcss'];
			print ( '<!-- Staffer Custom CSS --><style>' . $staffercustomcss . '</style>');
						}
						}
add_action ('wp_head', 'staffer_custom_styles' );

// flush rewrite rules on activation and deactivation
function staffer_activate() {
	create_staff_cpt_staffer();
	// flush rewrite rules to prevent 404s
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'staffer_activate' );

function staffer_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'staffer_deactivate' );