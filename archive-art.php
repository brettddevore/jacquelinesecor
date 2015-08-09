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
	<div class="small-12 large-12 columns" role="main">

	<?php

// no default values. using these as examples

	echo "<div class=\"row\">";
	$tax =  'art_series';
	$terms = get_terms( 'art_series', array( 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		foreach ($terms as $term) {		
			$term_link = get_term_link( $term );			
				$args = array(       
					'post_type' => 'attachment',
					'post_status' => 'inherit',
					$tax => $term->name,
				);
				$query = new WP_Query( $args );
					foreach ($query->posts as $quer) {
						echo "<div class=\"columns small-6 large-4\">";
						echo "<p><a href=\"" . esc_url( $term_link ) . "\">" . $term->name . "</a></p>";
						echo "<div>";	
						echo "<a href=\"" . esc_url( $term_link ) . "\">";
						echo "<img src=\"$quer->guid\">";
						echo "</a>";
						echo '</div>';
						echo "</div>";
					}						
		}
	}
	echo "</div>";
	?>

	<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if ( function_exists( 'foundationpress_pagination' ) ) { foundationpress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
		</nav>
	<?php } ?>
	</div>
		<?//php get_sidebar(); ?>

</div>
<?php get_footer(); ?>
