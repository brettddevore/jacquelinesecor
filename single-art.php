<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */
get_header();
?>
<?php

 // 	$args = array('post_type' => array('art', 'attachment') );
	// $myPosts = new WP_Query($args);
	// $content  = '';
	// while ($myPosts->have_posts()) : $myPosts->the_post();
	// 	$content .= "<li>";
	// 	$content .= $post->post_title . "<br>";
	// 	$content .= $post->ID . "<br>";
	// 	$content .= get_post_meta($post->ID, 'medium', true)  . "<br>";
	// 	$content .= get_post_meta($post->ID, 'size', true)  . "<br>";
	// 	$content .= "</li>";
	// endwhile;
	//echo $content;

?>


<div class="row">
	<div class="small-12 large-8 columns" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
			<div class="entry-content">

			<?php do_action('before_art_piece');?>

			<?php the_content(); ?>

			<?php do_action('after_art_piece');?>

			</div><!--/.entry-content-->
		</article>
	<?php endwhile;?>
	<?php $post_stored_meta = get_post_meta( $post->ID ); ?>

	</div><!--/columns-->
	<div class="small-12 large-4 columns">
		<h1 class="art"><?php the_title(); ?></h1>	
		<div class="art-info">
		<div><?php echo $post_stored_meta['medium'][0]; ?></div>	
		<div><?php
				if (strpos($post_stored_meta['size'][0], '"') === false ) {
					echo $post_stored_meta['size'][0] . '"';
				} else {
					echo $post_stored_meta['size'][0];
				}
		  ?>
		</div>

		<?php 
			$prevID = get_previous_post()->ID;
			$href = get_permalink( $prevID );			
			$thumb_id = get_post_thumbnail_id($prevID);
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'fill', true);
			$thumb_url = $thumb_url_array[0];
			echo "<link rel=\"prerender\" href=\"{$href}\" />";
			echo "<link rel=\"prefetch\" href=\"{$thumb_url}\" />";

		?>
		<div class="art-nav">

		<div class="previous-art"><?php previous_post_link( '%link', 'Previous Piece', FALSE ); ?>
</div>
		<div class="next-art"><?php next_post_link( '%link', 'Next Piece', FALSE ); ?>
</div>
		</div><!--/.end post nav-->
	</div><!--/row-->

</div><!--/row-->
<?php get_footer(); ?>