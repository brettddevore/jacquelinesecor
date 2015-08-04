<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */

get_header(); ?>

<div class="row">
	<div class="small-12 large-8 columns" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
			</header>
			<div class="entry-content">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="row">
					<div class="column">
						<?php the_post_thumbnail(); ?>
					</div>
				</div>
			<?php endif; ?>
			<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile;?>
	</div><!--/columns-->
	<div class="small-12 large-4 columns">
		<h1 class="art"><?php the_title(); ?></h1>
		<p>medium</p>
		<p>size</p>
		<p>buy options</p>
		<button>add cart</button>
	</div><!--/row-->

</div><!--/row-->
<?php get_footer(); ?>