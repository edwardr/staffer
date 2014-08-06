<?php get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php //get_template_part( 'content', get_post_format() ); ?>

<?php 
	echo '<h2>';
	echo the_title();
	echo '</h2>';
	if ( get_post_meta ($post->ID,'staffer_staff_title', true) != '' ) {
		echo '<em>';
		echo get_post_meta ($post->ID,'staffer_staff_title', true) . '</em><br>';
		}
	the_post_thumbnail ( array ('200', '300') );
	echo '<br>';
	if ( get_post_meta ($post->ID,'staffer_staff_about', true) != '' ) {
		$stafferbio = get_post_meta ($post->ID,'staffer_staff_about', true); ?>
		<div class="entry-content">
		<?php
		echo wpautop( $stafferbio ); ?>
		</div>
		<?php } ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>