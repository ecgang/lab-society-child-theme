<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area"> 
		<main id="main" class="site-main" role="main">
			<?php /* ?>
			<header class="woocommerce-products-header">
			<div class="flexslider">
				<ul class="slides">
					<li class="slide1">
						<div class="text left">
							<h1 class="no-wrap-mobile">More Output. Less Time.</h1>
							<h2><a href="/lab-equipment/executive-short-path-distillation-kit-12l/">G2 Executive Short Path<br>Distillation Kit (12L)</h2>
							<a class="button add_to_cart_button" href="/lab-equipment/executive-short-path-distillation-kit-12l/">Shop Now</a>
						</div>
						<a href="/lab-equipment/executive-short-path-distillation-kit-12l/">
							<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shop-page/Buy-Lab-Society-G2-Executive-Short-Path-Distillation-Kit-12.jpg" alt="Buy a G2 Executive Short Path Distillation Kit (12L)" />
							<img class="desktop_hidden" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shop-page/Buy-Lab-Society-G2-Executive-Short-Path-Distillation-Kit-12-square.jpg" alt="Buy a G2 Executive Short Path Distillation Kit (12L)" />
							
						</a>
					</li>
					<li class="slide2">
						<div class="text right">
							<h1>Fresh From The Lab</h1>
							<h2><a href="/lab-equipment/distillation-head/">Upgraded Packable Distillation Head</h2>
							<a class="button add_to_cart_button" href="/lab-equipment/distillation-head/">Shop Now</a>
						</div>
						<a href="/lab-equipment/distillation-head/">
							<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shop-page/pdh-1a-packable-distillation-head-and-structured-packing.jpg" alt="Buy a PDH-1A Packable Distillation Head and Structured Packing" />
							<img class="desktop_hidden" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shop-page/buy-pdh-1a-and-structured-packing-mobile-square.jpg" alt="Buy a PDH-1A Packable Distillation Head and Structured Packing" />
							
						</a>
					</li>
					<li class="slide3">
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

					<li class="slide4">
						
							<div class="text center-top">
								<h1>Your Source For Scientific Glassware</h1>
								<a class="button add_to_cart_button desktop_hidden" href="/lab-equipment-category/scientific-glassware/">Shop Now</a>
							</div>
							<a href="/lab-equipment-category/scientific-glassware/">
								<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/shop-page/buy-laboratory-equipment-online.jpg" alt="Buy Scientific Glassware Online" />
							</a>	
					</li>
					<!--
					<li class="slide4">
						<a href="/lab-equipment-category/clearance-section/">
							<div class="text center-bottom">
								<h1>End of Summer Sale</h1>
								<h2>25% Off Select Items!</h2>
								<a class="button add_to_cart_button" href="/lab-equipment-category/clearance-section">Shop Now</a>
							</div>
							<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/shop-page/lab-society-summer-sale.jpg" alt="Lab Society Clearance Section" />
						</a>
					</li>
					-->
				</ul>
			</div>
	    </header><?php */ ?>
		<?php if ( have_posts() ) : ?>
<?php /*
			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
*/ ?>
			<?php get_template_part( 'loop' );

		else :

			get_template_part( 'content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
