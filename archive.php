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

		<?//php query_posts($query_string . '&orderby=title&order=ASC'); ?>
			<?php $i=1; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php 
				echo "<div class=\"art-wrap\">";				
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
				$url = $thumb['0'];
				if ($i > 4) {
					echo "<img class=\"lazy\" data-original=\"{$url}\" />"; 
				} else {
					echo "<img src=\"{$url}\" />"; 
				}
				echo "<div class=\"art-meta\">";
				if (!has_term( 'diversity-of-nature', 'art_series', $post->ID )) {
					echo the_title() . "<br />";
				}
				echo get_post_meta($post->ID,"medium",true) . "<br />";
				echo get_post_meta($post->ID,"size",true) . "\"";
				echo "</div>";
				echo "</div>";
				$i++;
				?>
			
			<?php endwhile; ?>

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
