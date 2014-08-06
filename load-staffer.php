<?php
/*
	Plugin Name: Staffer
	Plugin URI: http://edwardrjenkins.com
	Description: Adds a staff management system via custom post types
	Author: Edward R. Jenkins
	Version: 0.1-alpha
	Author URI: http://edwardrjenkins.com
	Text Domain: staffer
	Domain Path: /lang
 */
	// custom post type for staff
	function create_staff_cpt_staffer() {
		register_post_type('staff', array(
			'labels' => array(
			'name' => __('Staff'),
			'taxonomy' => 'role',
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
			'menu_icon' => 'dashicons-id',
			'supports' => array(
				'title',
				'revisions',
				'taxonomy',
				'custom-fields',
				'thumbnail',
				)
				));
				}
add_action ('init', 'create_staff_cpt_staffer' );

add_action( 'init', 'create_staff_tax' );
function create_staff_tax() {
	register_taxonomy(
		'role',
		'staff',
		array(
			'label' => __( 'Roles' ),
			'rewrite' => array( 'slug' => 'role' ),
			'hierarchical' => true,
		)
	);
}
// adds meta box to member post types

add_action('add_meta_boxes', 'staffer_staff_meta_box', 0);
// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'staffer_staff_meta_box', 1 );
/* Do something with the data entered */
add_action('save_post_staff', 'staffer_staff_save_postdata');
/* Adds a box to the main column on the Post and Page edit screens */
function staffer_staff_meta_box() {
				$post_types = array(
					'staff',
				);
				foreach ($post_types as $post_type) {
								add_meta_box('staffer_details', __('Staff Member Details', 'staffer'), 'staffer_staff_role_box', $post_type, 'normal', 'core', $post_types);
						}
		}
/* Prints the box content */
function staffer_staff_role_box($post) {
				// Use nonce for verification
				wp_nonce_field(plugin_basename(__FILE__), 'cpt_noncename');
				// The actual fields for data entry
				// Use get_post_meta to retrieve an existing value from the database and use the value for the form
				$value = get_post_meta($post->ID, 'staffer_staff_title', true);
				echo '<label for="staffer_staff_title"><h4>Title(s) - enter one per line</h4></label>';
				echo '<textarea id="staffer_staff_title" name="staffer_staff_title" cols="50" rows="5">' . esc_attr($value) . '</textarea><br>';
				$value = get_post_meta($post->ID, 'staffer_staff_about', true);
				echo '<label for="staffer_staff_about"><h4>Staff Member Bio</h4></label>';		
				wp_editor( $value, 'staffer_staff_about', array( 'textarea_name' => 'staffer_staff_about', 'media_buttons' => false ) );
		}
/* When the post is saved, saves our custom data */
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
				// Thirdly we can save the value to the database
				//if saving in a custom table, get post_ID
				$post_ID      = $_POST['post_ID'];
				//sanitize user input
				$title = ($_POST['staffer_staff_title']);
				$about = ($_POST['staffer_staff_about']);
				update_post_meta($post_ID, 'staffer_staff_title', $title);
				update_post_meta($post_ID, 'staffer_staff_about', $about);			
		}
function staffer_staff_templates( $template ) {
    $post_types = array( 'staff' );
    if ( is_post_type_archive( $post_types ) && ! file_exists( get_stylesheet_directory() . '/archive-staff.php' ) )
        $template = plugin_dir_path (__FILE__) . 'archive-staff.php';
    if ( is_singular( $post_types ) && ! file_exists( get_stylesheet_directory() . '/single-staff.php' ) )
        $template = plugin_dir_path (__FILE__) . 'single-staff.php';

    return $template;
}
add_filter( 'template_include', 'staffer_staff_templates' );

function staffer_load_css() {
	wp_register_style ('staffer-foundation-style', plugins_url( 'css/staffer-styles.css', __FILE__) );
	wp_enqueue_style ('staffer-foundation-style');
	}
add_action ('wp_enqueue_scripts','staffer_load_css');