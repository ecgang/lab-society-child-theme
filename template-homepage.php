<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>
<?php do_action( 'storefront_sidebar' ); ?>
<div id="fullPage"> 
	<section class="section" id="section0">
		<div class="container">
			<div class="text">
				<h1>Professional scientific supplies and laboratory equipment manufactured and sourced with diligence.</h1>
				<a class="button add_to_cart_button" href="/lab-equipment-category/rotary-evaporators/">Shop Now</a>
			</div>
		</div>	
	</section>
	<section class="section" id="section1">
		<div class="text left mobile-top">
			<h1>Purchase your custom short path distillation kit online today.</h1>
			<a class="button add_to_cart_button mobile_hidden" href="/lab-equipment/executive-short-path-distillation-kit-5l/">Shop Now</a>
		</div>
		<a class="button add_to_cart_button mobile-absolute-bottom" href="/lab-equipment-category/short-path-distillation/">Shop Now</a>
	</section>
</div>
<?php
get_footer();
?>

<?php /* <h2 class="text-center">Featured Products</h2>
					<ul class="products">
					    <?php
					        $args = array( 'post_type' => 'product', 'posts_per_page' => 6, 'product_cat' => 'featured', 'orderby' => 'manual', 'order' => 'asc' );
					        $loop = new WP_Query( $args );
					        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

				                <li class="product">    

				                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

				                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

				                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

				                        <h3><?php the_title(); ?></h3>

				                        <span class="price"><?php echo $product->get_price_html(); ?></span>                    

				                    </a>

				                    <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>

				                </li>

					    <?php endwhile; ?>
					    <?php wp_reset_query(); ?>
					</ul>--><!--/.products--> */?>