<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */

get_header(); ?>

<div class="row">
<!-- Row for main content area -->
	<div class="small-12 large-8 columns" role="main">

	<?php if ( have_posts() ) : ?>

		<?php /* Start the Loop */ ?>

		<ul class="example-orbit" data-orbit data-options="bullets:false">
<?php

	$args = array(
				'post_type' => array('art'),
				'orderby' => 'title',
				'order' => 'asc',
				'category_name'          => 'vaginas',
				'showposts' => -1000,
				'posts_per_page' => 1000,

	);
	$myPosts = new WP_Query($args);
	$content  = '';
	while ($myPosts->have_posts()) : $myPosts->the_post();
		echo "<li>";
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		}
		echo "</li>";
	endwhile;
	echo $content;
?>
	</ul>

<!--   <li class="active">
    <?php the_post_thumbnail(); ?>
    <div class="orbit-caption">
    <?php get_the_title();?>
    </div>
  </li> -->


		


	<?php else : ?>
		<?php get_template_part( 'content', 'none' ); ?>
	<?php endif; // End have_posts() check. ?>

	<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if ( function_exists( 'foundationpress_pagination' ) ) { foundationpress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
		</nav>
	<?php } ?>

	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
