<?php
/*
	Plugin Name: Staffer
	Plugin URI: https://www.edwardrjenkins.com/wordpress-plugins/staffer/
	Description: A WordPress plugin that adds staff management and custom staff profile pages.
	Author: Edward R. Jenkins
	Version: 1.3.3
	Author URI: https://www.edwardrjenkins.com/
	Text Domain: staffer
	Domain Path: /languages
 */

// loads language pack
function staffer_load_textdomain() {
  load_plugin_textdomain( 'staffer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
add_action( 'init', 'staffer_load_textdomain' );

// staffer init
function staffer_init(){
	if (delete_transient('staffer_flush_rules')) {
		 flush_rewrite_rules();
		}
	register_setting( 'staffer_options', 'staffer', 'staffer_validate' );
}
add_action('admin_init', 'staffer_init' );

// adds menu page
function staffer_add_page() {
	add_options_page('Staffer Options', 'Staffer Options', 'manage_options', 'staffer', 'staffer_do_page');
}
add_action('admin_menu', 'staffer_add_page');

// writes the menu page
function staffer_do_page() {
	$supportsite = 'https://www.edwardrjenkins.com';
		echo '<h4>';
		_e('For paid support or customizations, please contact me at', 'staffer' );
		echo ' <a href="'.$supportsite.'" target="_blank">edwardrjenkins.com</a>';
		echo '</h4>';
		?>
		<div class="wrap">
			<h2><?php _e ('Staffer Options Panel', 'staffer'); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields('staffer_options'); ?>
				<?php $stafferoptions = get_option('staffer'); ?>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e ('Staff Layout', 'staffer'); ?></th>
					<td><input name="staffer[gridlayout]" type="checkbox" value="1" <?php checked(true, $stafferoptions['gridlayout']); ?> />
						<p class="description"><?php _e('Check this to use the staff grid layout.', 'staffer'); ?></p>
					</td>
					</tr>

					<tr valign="top"><th scope="row"><?php _e ('Manual Mode', 'staffer'); ?></th>
					<td><input name="staffer[manual_mode]" type="checkbox" value="1" <?php checked(true, $stafferoptions['manual_mode']); ?> />
						<p class="description"><?php _e('Check to disable the main Staffer archive page. Useful if you want to solely use shortcodes to display lists of staff members. For more information on shortcodes, please read the <a href="https://www.edwardrjenkins.com/wordpress-plugins/staffer/">Staffer documentation</a>.', 'staffer'); ?></p>
					</td>
					</tr>

					<tr valign="top"><th scope="row"><?php _e ('Excerpt Style', 'staffer'); ?></th>
					<td>
					<?php $staffer_estyle = $stafferoptions['estyle']; ?>
					<select name="staffer[estyle]">
						<option value="excerpt" <?php if ($staffer_estyle == "excerpt") echo ('selected="selected"'); ?> ><?php _e ('Excerpt', 'staffer' ); ?></option>
						<option value="full" <?php if ($staffer_estyle == "full") echo ('selected="selected"'); ?> ><?php _e ('Full', 'staffer' ); ?></option>
						<option value="none" <?php if ($staffer_estyle == "none") echo ('selected="selected"'); ?> ><?php _e ('Disabled', 'staffer' ); ?></option>
					</select>
						<p class="description"><?php _e('Choose your staff listing excerpt style.', 'staffer'); ?></p>
					</td>
					</tr>

					<tr valign="top"><th scope="row"><?php _e ('Staffer Main Page Description', 'staffer'); ?></th>
					<td>
					<?php 
						$text =  $stafferoptions['sdesc'];
						wp_editor( $text, 'sdesc', array( 'textarea_name' => 'sdesc', 'media_buttons' => true, 'textarea_rows' => '10' ) ); ?>
						<p class="description"><?php _e('Add a description for the Staffer directory, which will appear below the main directory title.', 'staffer'); ?></p>
					</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e ('Listings per page', 'staffer'); ?></th>
					<td><input type="number" size="80" max="99" name="staffer[perpage]" value='<?php echo $stafferoptions['perpage']; ?>' />
						<p class="description"><?php _e('Set the number of staff members per page. Leave blank to inherit the Settings->Reading.', 'staffer'); ?></p>
					</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e ('Staffer Page Title', 'staffer'); ?></th>
					<td><input type="text" size="80" name="staffer[ptitle]" value='<?php echo $stafferoptions['ptitle']; ?>' />
						<p class="description"><?php _e('Set a custom Staffer page title, if desired. The default title is <code>Staff</code>. This title will be used as the archive page title and within breadcrumbs. Leave blank to use the default.', 'staffer'); ?></p>
					</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e ('Staffer Label', 'staffer'); ?></th>
					<td><input type="text" size="80" name="staffer[label]" value='<?php if ( isset ($stafferoptions['label'] ) ) { echo $stafferoptions['label']; } ?>' />
						<p class="description"><?php _e('Set a custom label, if desired. This is shown in the admin panel and is used in the <code>title</code> tag. The default label is <code>Staff</code>. Leave blank to use the default.', 'staffer'); ?></p>
					</td>
					</tr>				
					<tr valign="top"><th scope="row"><?php _e ('Staffer URL slug', 'staffer'); ?></th>
					<td><input type="text" size="80" name="staffer[slug]" value='<?php echo $stafferoptions['slug']; ?>' />
						<p class="description"><?php _e('Set a custom URL slug, if desired. The default slug is <code>staff</code>.<strong>Notice:</strong> Use lowercase only, and use no spaces, i.e., instead of using <code>Staff Pages</code>, use <code>staff-pages</code>. Leave blank to use the default.', 'staffer'); ?></p>
					</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e ('Disable CSS', 'staffer'); ?></th>
					<td><input name="staffer[disablecss]" type="checkbox" value="1" <?php checked(true, $stafferoptions['disablecss']); ?> />
						<p class="description"><?php _e('Check this box to disable all Staffer CSS.', 'staffer'); ?></p>
					</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e ('Use custom wrappers', 'staffer'); ?></th>
					<td><input name="staffer[customwrapper]" type="checkbox" value="1" <?php checked(true, $stafferoptions['customwrapper']); ?> />
						<p class="description"><?php _e('Check this box and enter your wrappers below to use custom content wrappers. See the documentation for details. You may need to use custom wrappers if Staffer pages do not flow well with your theme.', 'staffer'); ?></p>
					</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e ('Custom start wrapper', 'staffer'); ?></th>
					<td><input type="text" size="80" name="staffer[startwrapper]" value='<?php echo $stafferoptions['startwrapper']; ?>' />
						<p class="description"><?php _e('Enter your custom start wrapper.', 'staffer'); ?></p>
					</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e ('Custom end wrapper', 'staffer'); ?></th>
					<td><input type="text" size="80" name="staffer[endwrapper]" value='<?php echo $stafferoptions['endwrapper']; ?>' />
						<p class="description"><?php _e('Enter your custom ending wrapper. This should close out the wrapper started above.', 'staffer'); ?></p>
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

// sanitize and validate input
function staffer_validate($input) {
	// Our first value is either 0 or 1
	if ( ! isset( $input['disablecss'] ) )
	$input['disablecss'] = null;
	if ( ! isset( $input['label'] ) )
	$input['label'] = 'Staff';
	if ( ! isset ($input['customwrapper']) )
	$input['customwrapper'] = null;
	if ( ! isset ($input['gridlayout']) )
	$input['gridlayout'] = null;
	if ( ! isset ($input['manual_mode'] ) )
	$input['manual_mode'] = null;
	if ( ! isset ($input['estyle']) )
	$input['estyle'] = 'excerpt';
	// Say our second option must be safe text with no HTML tags
	$input['perpage'] =  esc_html( $input['perpage'] );
	//if ( ! isset ($input['slug'] ) ) {
	$input['slug'] = sanitize_title_with_dashes ($input['slug']);
	$input['ptitle'] = ucfirst ($input['ptitle']);
	$input['label'] = ucfirst ($input['label']);
	$input['sdesc'] = stripslashes ( $_POST['sdesc'] );
	//} else {
	//$input['slug'] = 'staff';
	//}
	$input['startwrapper'] =  wp_kses_post( $input['startwrapper'] );
	$input['endwrapper'] =  wp_kses_post ( $input['endwrapper'] );
	$input['customcss'] = wp_kses_post ( $input['customcss'] );
	// in case of slug change
	set_transient('staffer_flush_rules', true);
		return $input;
}

// sets up the taxonomy
function staffer_taxonomy () {
	$stafferoptions = get_option ('staffer');
	if ( $stafferoptions['slug'] == '' ) {
		$stafferslug = 'staff';
	} else {
		$stafferslug = $stafferoptions['slug'];
	}
	$taxslug = $stafferslug . '/department';

	register_taxonomy(
		'department',
		'staff',
		array(
			'hierarchical' => true,
			'label' => __( 'Departments' ),
			'rewrite' => array( 'slug' => $taxslug, 'hierarchical' => true),
			'query_var'    => 'department',
			'public' => true,
		)
	);
	}
add_action ('init', 'staffer_taxonomy');

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

	if ( isset( $stafferoptions['manual_mode'] ) ) {
		$archive = false;
	} else {
		$archive = true;
	}
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
		'has_archive' => $archive,
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
function staffer_staff_meta_box() {
				$post_types = array(
					'staff',
				);
				foreach ($post_types as $post_type) {
								add_meta_box('staffer_details', __('Staff Member Details', 'staffer'), 'staffer_staff_role_box', $post_type, 'side', 'high', $post_types);
						}
		}
add_action('add_meta_boxes', 'staffer_staff_meta_box', 0);

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
	$value = get_post_meta($post->ID, 'staffer_staff_phone', true);
	echo '<label for="staffer_staff_phone"><strong>Phone Number</strong></label>';
	echo '<input id="staffer_staff_phone" name="staffer_staff_phone" size="28" value="' . esc_attr($value) . '"><br>';
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
	$phone = ($_POST['staffer_staff_phone']);
	update_post_meta($post_ID, 'staffer_staff_title', $title);
	update_post_meta($post_ID, 'staffer_staff_fb', $fb);
	update_post_meta($post_ID, 'staffer_staff_gplus', $gplus);
	update_post_meta($post_ID, 'staffer_staff_twitter', $twitter);
	update_post_meta($post_ID, 'staffer_staff_linkedin', $linkedin);
	update_post_meta($post_ID, 'staffer_staff_website', $website);
	update_post_meta($post_ID, 'staffer_staff_email', $email);
	update_post_meta($post_ID, 'staffer_staff_phone', $phone);
}
add_action('save_post_staff', 'staffer_staff_save_postdata');

// sets template override for custom template use
function staffer_staff_templates( $template ) {
	$post_types = array( 'staff' );
	$staff_tax = 'department';
	if ( is_post_type_archive( $post_types ) && ! file_exists( get_stylesheet_directory() . '/archive-staff.php' ) ) {
		$template = plugin_dir_path (__FILE__) . 'archive-staff.php';
	}
	if ( is_singular( $post_types ) && ! file_exists( get_stylesheet_directory() . '/single-staff.php' ) ) {
		$template = plugin_dir_path (__FILE__) . 'single-staff.php';
	}

	$staffer_options = get_option ('staffer');

	if ( !isset ( $staffer_options['manual_mode'] ) ) {
		if ( is_tax( $staff_tax ) && ! file_exists( get_stylesheet_directory() . '/taxonomy-staffer-department.php' ) ) {
			$template = plugin_dir_path (__FILE__) . 'taxonomy-staffer-department.php';
		}
	}
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

//enables thumbnail support if the theme does not
function staffer_thumbnail_check() {
	if ( ! current_theme_supports ('post-thumbnails') ) {
		add_theme_support ('post-thumbnails' );
		}
		}
add_action ('after_setup_theme', 'staffer_thumbnail_check' );
 
// adds link to main staff archive
// too many people confused about accessing the page
function staffer_admin_menu() {
	$stafferoptions = get_option ('staffer');
	if ( ! isset( $stafferoptions['manual_mode'] ) ) {

		global $submenu;
		$url = home_url('/');
		$stafferoptions = get_option('staffer');
		if ( $stafferoptions['slug'] == '' ) {
			$slug = 'staff';
		} else {
			$slug = $stafferoptions['slug'];
		}
		if ( get_option ('permalink_structure') ) {
		$url = $url . $slug;
		} else {
			$url = $url . '?post_type=staff';
		}
		$submenu['edit.php?post_type=staff'][] = array(__('View Staff Page', 'staffer'), 'manage_options', $url);

	} else {
		// nah
	}
}
add_action('admin_menu', 'staffer_admin_menu');

// pre get posts allows modification of posts per page without affecting non-staffer pages
function staffer_per_page_mod($query) {
	$stafferoptions = get_option ('staffer');
	$perpage = $stafferoptions['perpage'];
	$post_type = 'staff';
	$taxonomy = 'department';
		if ( $query->is_main_query() && !is_admin() && is_post_type_archive( $post_type ) ) {
				$query->set( 'posts_per_page', $perpage );
			} elseif ( $query->is_main_query() && !is_admin() && is_tax ($taxonomy) ) {
				$query->set( 'posts_per_page', $perpage );
		}

	}

$stafferoptions = get_option ('staffer');
$perpage = $stafferoptions['perpage'];

// if per page option is set, hooks into pre get posts
if ($perpage != '' ) {
	add_action ('pre_get_posts', 'staffer_per_page_mod' );
}

// adds staff shortcode
function staffer_shortcode( $atts ) {
	ob_start();
	extract( shortcode_atts( array (
		'order' => 'DESC',
		'orderby' => 'date',
		'number' => -1,
		'department' => '',
	), $atts ) );

	if ( $department != '' ) { 
		$tax_query = array ( 
			array (
				'taxonomy'	=> 'department',
				'field'		=> 'slug',
				'terms'		=> $department,
				),
			);
	} else {
		$tax_query = null;
	}
	$args = array(
		'post_type' => 'staff',
		'order' => $order,
		'orderby' => $orderby,
		'posts_per_page' => $number,
		'tax_query' => $tax_query,
	);
	$staff_query = new WP_Query( $args );
	if ( $staff_query->have_posts() ) { 
		global $post;
		$stafferoptions = get_option ( 'staffer' );

	if (isset ($stafferoptions['gridlayout']) ) { ?>
		<ul class="staffer-archive-grid">
			<?php } else { ?>
				<ul class="staffer-archive-list">
				<?php }

			while ( $staff_query->have_posts() ) : $staff_query->the_post(); ?>
			<li>
				<header class="staffer-staff-header">
				<h3 class="staffer-staff-title"><a href="<?php the_permalink(); ?>">
					<?php echo the_title(); ?>
					</a>
				</h3>
				<?php
				if ( get_post_meta ($post->ID,'staffer_staff_title', true) != '' ) {
					echo '<em>';
					echo get_post_meta ($post->ID,'staffer_staff_title', true) . '</em><br>';
					}
					?>
				
				</header>
					<div class="staff-content">
				<?php if (isset ($stafferoptions['gridlayout']) ) { ?>
					<?php the_post_thumbnail ( 'medium', array ('class' => 'aligncenter') ); ?>
						<?php } else { ?>
						<?php the_post_thumbnail ( 'medium', array ('class' => 'alignleft') ); ?>
						<?php }
						if ($stafferoptions['estyle'] == null or $stafferoptions['estyle'] == 'excerpt' ) {
							the_excerpt();
						} elseif ($stafferoptions['estyle'] == 'full' ) {
							the_content();
						} elseif ($stafferoptions['estyle'] == 'none' ) {
							// nothing to see here
						} 
						?>
					</div>
				</li>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</ul>
	<?php $output = ob_get_clean();
	return $output;
	}	
}
add_shortcode( 'staffer', 'staffer_shortcode' );