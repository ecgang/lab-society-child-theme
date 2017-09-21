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
			<div class="text text-center">
				<h1>Welcome to Lab Society!</h1>
				<h2>We offer professional scientific supplies and laboratory equipment.<br/><strong>American made and manufactured</strong></h2>
				<a class="button add_to_cart_button" href="/shop">Shop Now</a>
			</div>
			<a class="mobile-absolute-bottom-arrow" href="#About"></a>
		</div>	
	</section>
	<section class="section" id="section1">
	<a class="bg-overlay-link" href="/lab-equipment/executive-short-path-distillation-kit-12l/"></a>
		<div class="text left mobile-top text-center">
			<h1>Purchase your custom short path distillation kit online today.</h1>
			<a class="button add_to_cart_button mobile_hidden" href="/lab-equipment/executive-short-path-distillation-kit-12l/">Shop Now</a>
		</div>
		<!--<a class="mobile-absolute-bottom-arrow mobile_hidden" href="#Catalog"></a>-->
		<a class="button add_to_cart_button mobile-absolute-bottom" href="/lab-equipment/executive-short-path-distillation-kit-12l/">Shop Now</a>
	</section>
	<section class="section">
		<div class="text">
			<h2>Lab Society is your industry-leading science equipment supplier and laboratory supply co.</h2><br/>
			<p>At Lab Society, we constantly strive to manufacture and source the highest quality and most affordable scientific equipment on the market. We’ve done all of the hard work for you, so you can shop with confidence.</p>
			<p>We’ve got a wide selection of <a href="/lab-equipment-category/vacuum-pumps/" name="Lab Society Vacuum Pumps Lab Equipment Category">vacuum pump products</a>, <a href="/lab-equipment-category/rotary-evaporators/" name="Lab Society rotovap (Rotary Evaporators) Lab Equipment Category">rotovaps (rotary evaporators)</a>, extraction tools, and complete systems.</p>
			<p>Our goal is to be your #1 laboratory equipment supplier — and you can be sure that you are getting the best deals on industry-leading equipment.</p>	
		</div>
		<!--<a class="mobile-absolute-bottom-arrow mobile_hidden" href="#Short-Path-Distillation"></a>-->
	</section>
	
	<section class="section">
		<div class="text wide text-center">
			<h1>Browse our catalog</h1>
			<div class="columns">
				<div class="one-third">
					<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/rotary-evaporators-category.jpg'; ?>" alt="Buy Rotovap Supplies Online from Lab Society Rotary Evaporators" />
					<a class="button add_to_cart_button" href="/lab-equipment-category/rotary-evaporators/">Shop Rotary Evaporators</a>
				</div>
				<div class="one-third">
					<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/short-path-distillation-category.jpg'; ?>" alt="Shop for Vacuum Distillation Kits and Fractional Distillation Gear Online" />
					<a class="button add_to_cart_button" href="/lab-equipment-category/short-path-distillation/">Shop Short Path Distillation</a>
				</div>
				<div class="one-third">
					<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/vacuum-pumps-category.jpg'; ?>" alt="Purchase Vacuum Pumps and Vacuum Pump Accessories" />
					<a class="button add_to_cart_button" href="/lab-equipment-category/vacuum-pumps/">Shop Vacuum Pumps</a>
				</div>

			</div>	
		</div>
		<!--<a class="mobile-absolute-bottom-arrow mobile_hidden" href="#Need-Help"></a>-->
	</section>
	<section class="section">
		<div class="text">
			<h1>Not sure where to start?</h1>
			<h2>Contact us today and we’ll help find the custom solution that’s right for you.</h2>
			<h3>Call us at: <a href="tel:7206002037" name="Lab Society Telephone Number">(720) 600-2037</a></h3>
			<p>We are based in Longmont, Colorado, and we serve all of Denver and its surrounding areas. We are proud to ship to countries around the world.</p>
		</div>	
	</section>
	
</div>
<?php
get_footer();
?>