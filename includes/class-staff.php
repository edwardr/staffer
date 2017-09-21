<?php

/**
 * Defines the Staff profile class
 *
 *
 * @link       https://codewrangler.io
 * @since      2.0.0
 *
 * @package    Staffer
 * @subpackage Staffer/includes
 */

/**
 * @since      2.0.0
 * @package    Staffer
 * @subpackage Staffer/includes
 * @author     codeWrangler, Inc. <edward@codewrangler.io>
 */
class CW_Staff {

	public $ID;
	public $name;
	public $title;
	public $bio;
	public $excerpt;
	public $email;
	public $phone;
	public $facebook;
	public $twitter;
	public $linkedin;
	public $google_plus;
	public $website;
	public $github;
	public $youtube;
	public $instagram;

	public function __construct( $post_id ) {

		$post = get_post( $post_id );

		$this->ID = $post->ID;
		$this->name = $post->post_title;
		$this->title = get_post_meta( $post_id, 'staffer_staff_title', true );
		$this->bio = esc_attr( $post->post_content );
		$this->departments = wp_get_post_terms( $post_id, 'department' );
		$excerpt = $post->post_excerpt;
		$this->excerpt = empty( $excerpt ) ? wp_trim_words( $post->post_content, 55 ) : $excerpt;
		$this->phone = get_post_meta( $post_id, 'staffer_staff_phone', true );
		$this->email = get_post_meta( $post_id, 'staffer_staff_email', true );
		$this->facebook = get_post_meta( $post_id, 'staffer_staff_fb', true );
		$this->twitter = get_post_meta( $post_id, 'staffer_staff_twitter', true );
		$this->linkedin = get_post_meta( $post_id, 'staffer_staff_linkedin', true );
		$this->google_plus = get_post_meta( $post_id, 'staffer_staff_gplus', true );
		$this->website = get_post_meta( $post_id, 'staffer_staff_website', true );

		$this->instagram = get_post_meta( $post_id, 'staffer_staff_instagram', true );
		$this->youtube = get_post_meta( $post_id, 'staffer_staff_youtube', true );
		$this->github = get_post_meta( $post_id, 'staffer_staff_github', true );
	}
}