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
<?php	
	//$stuff = get_terms("art_series");
	//echo "<pre>";
	//var_dump($stuff);
	$tax =  'art_series';
	$terms = 'diversity-of-nature';
	$args = array (
		'post_type'             => array( 'art' ),
		'order'                 => 'ASC',
		'orderby'               => 'title',
		'posts_per_page' 		=> '-1',
		'tax_query' 			=>  array(
									array(
									'taxonomy' => $tax,
									'terms' => 5,
									)
									)
	);
	$pqs = new WP_Query( $args );
	echo "<ul class=\"example-orbit\" data-orbit data-options=\"bullets:false;variable_height;false\">";
	foreach ($pqs->posts as $pq) {
		echo "<li>";
		echo get_the_post_thumbnail ($pq->ID);
		echo "</li>";
	}
	echo "</ul>";

	// foreach( $terms as $term ){
 //    while( $my_query->have_posts() ){
 //        $my_query->the_post();
 //        if( has_term( $term ) ){
 //            // output post
 //        }
 //    }
 //    $my_query->rewind_posts();
	// }
	
?>


		
				<?php 
				// echo "<li>";
				// if ( has_post_thumbnail() ) {
				// 	the_post_thumbnail('large');
				// }
				// echo "</li>";
				?>

		
		

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
