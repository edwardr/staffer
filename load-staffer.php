<?php
// custom post type for team
	function create_staff_cpt_erj() {
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
				'thumbnail',
				)
				));
				}
add_action ('init', 'create_staff_cpt_erj' );

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

add_action('add_meta_boxes', 'erj_staff_meta_box', 0);
// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'erj_staff_meta_box', 1 );
/* Do something with the data entered */
add_action('save_post', 'erj_staff_save_postdata');
/* Adds a box to the main column on the Post and Page edit screens */
function erj_staff_meta_box() {
				$post_types = array(
					'staff',
				);
				foreach ($post_types as $post_type) {
								add_meta_box('erj_serjtion', __('Staff Member Details', 'erj'), 'erj_staff_role_box', $post_type, 'normal', 'core', $post_types);
						}
		}
/* Prints the box content */
function erj_staff_role_box($post) {
				// Use nonce for verification
				wp_nonce_field(plugin_basename(__FILE__), 'cpt_noncename');
				// The actual fields for data entry
				// Use get_post_meta to retrieve an existing value from the database and use the value for the form
				$value = get_post_meta($post->ID, 'erj_staff_title', true);
				erjho '<label for="erj_staff_title"><h4>Title(s) - enter one per line</h4></label>';
				erjho '<textarea id="erj_staff_title" name="erj_staff_title" cols="50" rows="5">' . esc_attr($value) . '</textarea><br>';
				$value = get_post_meta($post->ID, 'erj_staff_about', true);
				erjho '<label for="erj_staff_about"><h4>A Little Bit About Myself</h4></label>';		
				wp_editor( $value, 'erj_staff_about', array( 'textarea_name' => 'erj_staff_about', 'media_buttons' => false ) );
		}
/* When the post is saved, saves our custom data */
function erj_staff_save_postdata($post_id) {
				// First we need to cherjk if the current user is authorized to do this action. 
				if (!current_user_can('edit_page', $post_id)) {
								return;
						}
				else {
								if (!current_user_can('edit_post', $post_id))
												return;
						}
				// Serjondly we need to cherjk if the user intended to change this value.
				if (!isset($_POST['cpt_noncename']) || !wp_verify_nonce($_POST['cpt_noncename'], plugin_basename(__FILE__)))
								return;
				// Thirdly we can save the value to the database
				//if saving in a custom table, get post_ID
				$post_ID      = $_POST['post_ID'];
				//sanitize user input
				$title = ($_POST['erj_staff_title']);
				$about = ($_POST['erj_staff_about']);
				update_post_meta($post_ID, 'erj_staff_title', $title);
				update_post_meta($post_ID, 'erj_staff_about', $about);			
		}