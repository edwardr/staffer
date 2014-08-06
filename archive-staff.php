<?php get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php //get_template_part( 'content', get_post_format() ); ?>

	<h3><a href="<?php the_permalink(); ?>">
		<?php echo the_title(); ?>
		</a>
	</h3>
	<?php
	if ( get_post_meta ($post->ID,'staffer_staff_title', true) != '' ) {
		echo '<em>';
		echo get_post_meta ($post->ID,'staffer_staff_title', true) . '</em><br>';
		}
	the_post_thumbnail ( 'thumbnail', array ('class' => 'alignleft') );
	echo '<br>';
	if ( get_post_meta ($post->ID,'staffer_staff_about', true) != '' ) {
		$stafferbio = get_post_meta ($post->ID,'staffer_staff_about', true); ?>
		<div class="entry-content">
		<?php
		echo wpautop( $stafferbio ); ?>
		</div>
		<?php } ?>

			<?php endwhile;
			global $wp_query;
			if ($wp_query->max_num_pages > 1) { ?>
			<div class="staffer-navigation">
			<?php posts_nav_link(); ?>
			</div>
			<?php } ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>