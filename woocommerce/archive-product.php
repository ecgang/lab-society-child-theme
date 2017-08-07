<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

	<?php if(is_shop() && !is_search()): ?>
		<header class="woocommerce-products-header">
			<div class="flexslider">
				<ul class="slides">
					<li class="slide1">
						<div class="text right">
							<h1>Lab Society</h1>
							<h2><a href="/lab-equipment/buy-terpene-distillation-kit/">Buy a Terpene Distillation Kit Online</h2>
							<a class="button add_to_cart_button" href="/lab-equipment/buy-terpene-distillation-kit/">Shop Now</a>
						</div>
						<a href="/lab-equipment/buy-terpene-distillation-kit/">
							<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shop-page/buy-terpene-disitllation-kit.jpg" alt="Buy Terpene Distillation Kit" />
							<img class="desktop_hidden" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shop-page/buy-terpene-disitllation-kit-mobile-square.jpg" />
							
						</a>
					</li>
					<li class="slide2">
						<a href="/lab-equipment-category/scientific-glassware/">
							<div class="text center-top">
								<h1>Your Source For Scientific Glassware</h1>
								<a class="button add_to_cart_button desktop_hidden" href="/lab-equipment-category/scientific-glassware/">Shop Now</a>
							</div>
							<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/shop-page/buy-laboratory-equipment-online.jpg" alt="Buy Scientific Glassware Online" />
						</a>	
					</li>
					<li class="slide3">
						<a href="/lab-equipment-category/clearance-section/">
							<div class="text center-bottom">
								<h1>End of Summer Sale</h1>
								<h2>25% Off Select Items!</h2>
								<a class="button add_to_cart_button" href="/lab-equipment/clearance-section">Shop Now</a>
							</div>
							<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/shop-page/lab-society-summer-sale.jpg" alt="Lab Society Summer Sale" />
						</a>
					</li>
				</ul>
			</div>
	    </header>
	<section class="content-section first">
    <div class="flex-columns">
    	<div class="one-half">
    		<a href="" class="hover-link">
    			<div class="text"><h3>Short Path Distillation</h3></div>
    			<img src="/wp-content/uploads/2017/07/short-path-distillation-head-medium.jpg" alt="Buy Short Path Distillation Products Online" />
    		</a>	
    	</div>
    	<div class="one-half">
    		<a href="" class="hover-link">
    			<div class="text"><h3>Rotary Evaporators</h3></div>
    			<img src="/wp-content/uploads/2017/07/buy-rotary-evaportors.jpg" alt="Buy Rotary Evaporators Online" />
    		</a>
    	</div>
    </div>
    </section>
    <section class="content-section">
    	<h2>Featured Products</h2>
    	<ul class="products">
		<?php 

		$meta_query  = WC()->query->get_meta_query();
		$tax_query   = WC()->query->get_tax_query();
		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
			);

		$bandproduct_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'posts_per_page'      => 5,
			'orderby'             => 'modified',
			'order'               => 'DESC',
			'meta_query'          => $meta_query,
			'tax_query'           => $tax_query,
		);
		$loop = new WP_Query( $bandproduct_args );
	    while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>		    
	       <li class="product one-fifth">    
	            <a class="woocommerce-LoopProduct-link" href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

	                <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

	                <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>
	                <h3><?php the_title(); ?></h3>
	                <span class="price"><?php echo $product->get_price_html(); ?></span>                    
	            </a>
	            <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
	        </li>
		<?php 
		    endwhile;
		    wp_reset_query(); 
		?>
	</ul>
	</section>
	<div class="flex-columns">
    	<div class="full">
    		<div class="text">
				<h1><a class="dark" href="/lab-equipment/buy-terpene-distillation-kit/">Safe, Fast, Secure. The Lab Society Guarantee!</h1>
			</div>
    		<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/shop-page/scientific-supplies.jpg" />
    		<img class="desktop_hidden" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/shop-page/trust-lab-society-mobile-2.jpg" />
    	</div>
    </div>
	<section class="content-section">
    	<h2>Complete Kits</h2>
    	<ul class="products">
		<?php 

		$bandproduct_args = array(
			'post_type'           => 'product',
			'product_tag'		  => 'Complete Kit',
			'post_status'         => 'publish',
			'posts_per_page'      => 3,
			'orderby'             => 'modified',
			'order'               => 'DESC'
		);
		$loop = new WP_Query( $bandproduct_args );
	    while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>	    
	       <li class="product">    
	            <a class="woocommerce-LoopProduct-link" href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

	                <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

	                <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>
	                <h3><?php the_title(); ?></h3>
	                <span class="price"><?php echo $product->get_price_html(); ?></span>                    
	            </a>
	            <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
	        </li>
	<?php 
	    endwhile;
	    wp_reset_query(); 
	?>
	</ul>
	</section>
	<section>
	<h2>Product Categories</h2>
		<ul class="category-listing">
		<?php
		  $taxonomy     = 'product_cat';
		  $orderby      = 'name';  
		  $show_count   = 0;      // 1 for yes, 0 for no
		  $pad_counts   = 0;      // 1 for yes, 0 for no
		  $hierarchical = 1;      // 1 for yes, 0 for no  
		  $title        = '';  
		  $empty        = 1;

		  $args = array(
		         'taxonomy'     => $taxonomy,
		         'orderby'      => $orderby,
		         'show_count'   => $show_count,
		         'pad_counts'   => $pad_counts,
		         'hierarchical' => $hierarchical,
		         'title_li'     => $title,
		         'hide_empty'   => $empty
		  );
		 $all_categories = get_categories( $args );
		 foreach ($all_categories as $cat) {
		    if($cat->category_parent == 0) {
		        $category_id = $cat->term_id;       
		        echo '<li><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></li>'; ?>
		        <?php 
		        $args2 = array(
		                'taxonomy'     => $taxonomy,
		                'child_of'     => 0,
		                'parent'       => $category_id,
		                'orderby'      => $orderby,
		                'show_count'   => $show_count,
		                'pad_counts'   => $pad_counts,
		                'hierarchical' => $hierarchical,
		                'title_li'     => $title,
		                'hide_empty'   => $empty
		        );
		        $sub_cats = get_categories( $args2 );
		        if($sub_cats) {
		        	?>
		        	<ul>
		        	<?php
		            foreach($sub_cats as $sub_category) {
		                echo '<li><a class="sub-category" href="'. $sub_category->slug .'">' . $sub_category->name . '</a></li>';
		            } ?>
		            </ul>
		            <?php    
		        }
		    }       
		}
		?>
		</ul>
	</section>
<?php else: ?>
    <header class="woocommerce-products-header">

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

    </header>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/**
						 * woocommerce_shop_loop hook.
						 *
						 * @hooked WC_Structured_Data::generate_product_data() - 10
						 */
						do_action( 'woocommerce_shop_loop' );
					?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>
	<?php endif; ?>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
