<?php
/**
 * Template used to display post content.
 *
 * @package storefront
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to storefront_loop_post action.
	 *
	 * @hooked storefront_post_header          - 10
	 * @hooked storefront_post_meta            - 20
	 * @hooked storefront_post_content         - 30
	 * @hooked storefront_init_structured_data - 40
	 */
	?>
	<div class="post-image"><?php the_post_thumbnail('medium');?></div>
	<div class="post-content">
		<header class="entry-header">
			<span class="posted-on">Posted on: <?php the_time('l, F jS, Y') ?></span>
			<h1>
				<a href="<?php echo the_permalink(); ?>"><?php the_title();?></a>
			</h1>
		</header>
		<?php the_excerpt();	?>
	</div>

</article><!-- #post-## -->
