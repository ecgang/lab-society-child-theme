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
				<h2>We offer professional lab supplies and laboratory equipment.<br/><strong>American made and manufactured.</strong></h2>
				
				<a class="button add_to_cart_button" href="/shop">Shop Lab Equipment</a>

			</div>
			<a class="mobile-absolute-bottom-arrow" href="#About"></a>
		</div>	
	</section>
	<section class="section" id="section1" style="background-repeat: no-repeat;">
	<a class="bg-overlay-link" href="/lab-equipment-category/short-path-distillation/"></a>
		<div class="text left mobile-top text-center">
			<h1><span class="mobile_hidden">Purchase your custom </span>Short Path Distillation<span class="mobile_hidden"> kit online today.</span></h1>
			<a class="button add_to_cart_button mobile_hidden" href="/lab-equipment-category/short-path-distillation/">Shop Short Path Distillation</a>
		</div>
		<!--<a class="mobile-absolute-bottom-arrow mobile_hidden" href="#Catalog"></a>-->
		<a class="button add_to_cart_button mobile-absolute-bottom" href="/lab-equipment-category/short-path-distillation/">Shop Short Path Distillation</a>
	</section>
	<section class="section" id="section2">
		<div class="text">
			<h2><span class="mobile_hidden">Lab Society is your</span> <span class="desktop_hidden">I</span><span class="mobile_hidden">i</span>ndustry-leading laboratory glassware supplier and laboratory supply co.</h2>
			<p>At Lab Society, we constantly strive to manufacture and source the highest quality and most affordable scientific equipment on the market. We’ve done all of the hard work for you, so you can shop with confidence.</p>
			<p>We’ve got a wide selection of <a href="/lab-equipment-category/vacuum-pumps/" name="Lab Society Vacuum Pumps Lab Equipment Category">vacuum pump products</a>, <a href="/lab-equipment-category/rotary-evaporators/" name="Lab Society rotovap (Rotary Evaporators) Lab Equipment Category">rotovaps (rotary evaporators)</a>, extraction tools, and laboratory glassware.</p>
			<p>Our goal is to be your #1 laboratory equipment supplier — and you can be sure that you are getting the best deals on industry-leading equipment.</p>	
		</div>
		<!--<a class="mobile-absolute-bottom-arrow mobile_hidden" href="#Short-Path-Distillation"></a>-->
	</section>	
	<section class="section" id="section3">
		<div class="text" style="text-align:center;">
			<a href="/price-match/"><img style="margin: auto; width: 60%;" src="https://labsociety.com/wp-content/uploads/vectors/laboratory-supply-co-lab-equipment.svg" alt="Lab Equipment & Laboratory Supply Co. - Fractional Distillation" width=60%></a>
			<br><h2>We'll match <strong>ANY</strong> product's price!</h2>
			<p><i>(With a valid quote for the same model - some restrictions apply.)</i></p>
				</div>
		<!--<a class="mobile-absolute-bottom-arrow mobile_hidden" href="#Short-Path-Distillation"></a>-->
	</section>	
	<section class="section">
		<div class="text wide text-center">
			<h1>Browse our lab supplies:</h1>
			<div class="columns">
				<div class="one-third">
					<img class="mobile_hidden" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/rotary-evaporators-category.jpg'; ?>" alt="Buy Rotovap Supplies Online from Lab Society Rotary Evaporators" />
					<a class="button add_to_cart_button" href="/lab-equipment-category/rotary-evaporators/">Rotary Evaporators</a>
				</div>
				<div class="one-third">
					<img class="mobile_hidden" src="https://labsociety.com/wp-content/uploads/2017/11/lab-supplies-laboratory-glassware.jpg" alt="Shop for Lab Supplies and Laboratory Glassware Online" />
					<a class="button add_to_cart_button" href="/lab-equipment-category/scientific-glassware/">Laboratory Glassware</a>
				</div>
				<div class="one-third">
					<img class="mobile_hidden" src="https://labsociety.com/wp-content/uploads/2017/11/vacuum-pumps-vacuum-pump.jpg" alt="Purchase Vacuum Pumps and Vacuum Pump Accessories" />
					<a class="button add_to_cart_button" href="/lab-equipment-category/vacuum-pumps/">Vacuum Pumps</a>
				</div>

			</div>	
		</div>
		
	</section>
	<section class="section">
		<div class="text">
			<h1>Not sure where to start?</h1>
			<h2>Contact us today and we’ll help find the custom solution that’s right for you.</h2>
			<h3>Call us at: <a href="tel:7206002037" name="Lab Society Telephone Number">(720) 600-2037</a></h3>
			<p>We are a laboratory supply co. based in Boulder, Colorado, and we serve all of Denver and its surrounding areas. We are proud to ship to countries around the world.</p>
		</div>	
	</section>
	
</div>
<?php
get_footer();
?>