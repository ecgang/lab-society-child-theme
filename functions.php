<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */

add_action( 'wp_enqueue_scripts', 'sf_child_theme_deregister_style', 999 );
function sf_child_theme_deregister_style() {
    $child_my_theme_data = wp_get_theme();
    wp_deregister_style( 'storefront-child-style' );
    wp_deregister_style( 'storefront-fonts' );
    wp_deregister_style( 'wc-composite-css' );
    wp_deregister_style( 'wc-composite-single-css' );
    wp_deregister_style( 'storefront-woocommerce-composite-products-style' );
    wp_deregister_style( 'storefront-woocommerce-bundles-style' );
    wp_deregister_style( 'wc-bundle-style' );    
    wp_enqueue_style('storefront-child-style-custom', get_stylesheet_directory_uri() . '/assets/css/style.css', false, filemtime(get_stylesheet_directory() . '/assets/css/style.css'));
    if (function_exists('is_shop')):
    wp_enqueue_style('flexsider-css', get_stylesheet_directory_uri() . '/assets/css/flexslider.css', false, filemtime(get_stylesheet_directory() . '/assets/css/flexslider.css'));
    endif;
    wp_enqueue_script('storefront-child-scripts', get_stylesheet_directory_uri() . '/assets/js/app.js', false, filemtime(get_stylesheet_directory() . '/assets/js/app.js'));
    if (function_exists('is_front_page')):
     wp_enqueue_style('fullpage-css', get_stylesheet_directory_uri() . '/assets/css/jquery.fullPage.css', false, filemtime(get_stylesheet_directory() . '/assets/css/jquery.fullPage.css'));
    endif;
}

add_filter( 'body_class', 'woo_add_tags_to_body_class' );
function woo_add_tags_to_body_class( $classes ){
    $custom_terms = get_the_terms(0, 'product_tag');
    if ($custom_terms) {
        foreach ($custom_terms as $custom_term) {
            $classes[] = '' . $custom_term->slug;
        }
    }
    return $classes;
}


add_filter( 'woocommerce_component_options_hide_incompatible', 'wc_cp_component_options_hide_incompatible', 10, 3 );
function wc_cp_component_options_hide_incompatible( $hide, $component_id, $composite ) {
    return true;
}

add_action( 'wp_head', 'add_google_fonts', 99 );
function add_google_fonts() { ?>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet" />
    <script type="text/JavaScript">
window.zESettings = {
  webWidget: {
    position: {
      horizontal: 'left',
      vertical: 'top'     
    }
  }
};
</script> 
   
    
<?php 
}

add_action('wp_head', 'add_flexslider', 99);

function add_flexslider(){
    
    if (function_exists('is_shop')):
    ?>
     <script>    
        jQuery(window).load(function() {
            jQuery('.flexslider').flexslider({
                controlNav: false,
                prevText: '',
                nextText: ''
            });
        });
    </script>
    <?php endif;
}


add_filter( 'storefront_credit_link', 'hide_storefront_credit_link', 10, 1 );
function hide_storefront_credit_link( $bool ){
   return false;
}


add_action('woocommerce_after_customer_login_form', 'login_show_hide');
function login_show_hide(){
    echo '<a href="#" class="btn login-toggle"><span>Sign Up</span></a>';
}

add_filter( 'storefront_handheld_footer_bar_links', 'jk_remove_handheld_footer_links',99 );
function jk_remove_handheld_footer_links( $links ) {
    unset( $links['cart'] );
    return $links;
}

add_filter( 'storefront_handheld_footer_bar_links', 'jk_add_home_link',98);
function jk_add_home_link( $links ) {
    $new_links = array(
        'mobile_menu' => array(
            'priority' => 0,
            'callback' => 'jk_home_link',
        ),
        'chat' => array(
            'priority' => 0,
            'callback' => 'jk_chat_link',
        ),
         'phone' => array(
            'priority' => 0,
            'callback' => 'jk_phone_link',
        ),
    );

    $links = array_merge( $new_links, $links );

    return $links;
}

function jk_home_link() {
    echo '<a href="#">' . __( 'Menu' ) . '</a>';
}
function jk_chat_link(){
    echo '<a href="javascript:$zopim.livechat.window.show();"></a>';
}
function jk_phone_link(){
    echo '<a href="tel:7206002037"></a>';
}

add_action( 'init', 'child_remove_parent_functions', 99 );
function child_remove_parent_functions() {
    remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper',42);
    remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper_close',68);
    remove_action( 'storefront_header', 'storefront_primary_navigation',50);
    remove_action( 'storefront_header', 'storefront_header_cart', 60);
    remove_action( 'storefront_header', 'storefront_product_search',40);
    remove_action( 'storefront_page', 'storefront_page_header',10);
    remove_action( 'storefront_single_post', 'storefront_post_header',10);
    remove_action( 'storefront_single_post', 'storefront_post_meta',20);
    remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );  
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_variation','woocommerce_single_variation', 10);
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action( 'wp_footer', 'woocommerce_demo_store' );
    add_action( 'storefront_before_header', 'woocommerce_demo_store' );
    add_action('woocommerce_single_variation','woocommerce_single_variation', 50);
    add_action( 'storefront_single_post', 'storefront_post_meta',40);
    add_action( 'storefront_before_content', 'wc_print_notices' );
    add_action('storefront_after_footer', 'mobile_menu');
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
    
    remove_action( 'homepage', 'storefront_best_selling_products', 70 );
    remove_action( 'homepage', 'storefront_product_categories', 20 );
	remove_action( 'homepage', 'storefront_recent_products', 30 );
	remove_action( 'homepage', 'storefront_featured_products', 40 );
	remove_action( 'homepage', 'storefront_popular_products', 50 );
	remove_action( 'homepage', 'storefront_on_sale_products', 60 );
    add_action( 'woocommerce_after_add_to_cart_button', 'woocommerce_template_single_price', 10);
    remove_theme_support( 'wc-product-gallery-zoom' );
    remove_theme_support( 'wc-product-gallery-slider' );     
    add_action( 'storefront_header', 'storefront_primary_navigation_wrapper',97);
    add_action( 'storefront_header', 'storefront_primary_navigation', 98);
    add_action( 'storefront_footer', 'custom_storefront_footer', 30);
    add_action( 'storefront_header', 'storefront_primary_navigation_wrapper_close',100);
}


add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 99 );

function dequeue_woocommerce_styles_scripts() {
    if ( function_exists( 'is_woocommerce' ) ) {
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
            # Styles
            wp_dequeue_style( 'woocommerce-general' );
            wp_dequeue_style( 'woocommerce-layout' );
            wp_dequeue_style( 'woocommerce-smallscreen' );
            wp_dequeue_style( 'woocommerce_frontend_styles' );
            wp_dequeue_style( 'woocommerce_fancybox_styles' );
            wp_dequeue_style( 'woocommerce_chosen_styles' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
            # Scripts
            wp_dequeue_script( 'wc_price_slider' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-cart' );
            wp_dequeue_script( 'wc-chosen' );
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
            wp_dequeue_script( 'fancybox' );
            wp_dequeue_script( 'jqueryui' );
        }
    }
}


function themeslug_postmeta_form_keys() {
    return false;
}
add_filter('postmeta_form_keys', 'themeslug_postmeta_form_keys');


add_action( 'storefront_loop_post', 'shop_landing_page_content', 99 );

function shop_landing_page_content() {
    echo 'test';
}



function mobile_menu(){
    echo '<div class="mobile_menu_container">';
    
    echo dynamic_sidebar();
    echo '</div>';

}


function custom_storefront_footer() {
    wp_nav_menu( array('menu' => 'Footer Menu') );
    ?>
    <div class="social">
    <a href="http://instagram.com/labsociety" target="_blank" class="fa fa-instagram" aria-hidden="true"></a>
    <a href="http://facebook.com/labsociety" target="_blank" class="fa fa-facebook" aria-hidden="true"></a>
    </div>
    <?php
    
}

function storefront_primary_navigation() {
        ?>
    <nav id="site-navigation" class="main-navigation" role="navigation">
        <button class="menu-toggle"><?php _e( 'Primary Menu', 'storefront' ); ?></button>
        <?php
            if(is_front_page()):
                wp_nav_menu( array('menu' => 'Home Anchors')); 
            else:

                ?><div><ul id="menu-home-anchors" class="menu"><li class="menu-item"><a class="call-number" href="tel:7206002037" name='Call Lab Society (720) 600-2037'>Need Help? Call: (720) 600-2037</a></li><!--<li class="menu-item"><a href="javascript:$zopim.livechat.window.show();">Live Chat Now!</a></li>--></ul></div>
            <?php
            endif;
        ?>
        <div class="search-container">
        <?php storefront_product_search(); ?>
        </div>
        <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
        <?php /*storefront_header_cart();*/ ?>
    </nav>
    <?php
}

add_filter('woocommerce_sale_flash', 'woo_custom_hide_sales_flash');
function woo_custom_hide_sales_flash()
{
    return false;
}


add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );
function woo_hide_page_title() { return false; }

add_filter( 'woocommerce_composite_force_old_style_price_html', '__return_true' );

add_filter( 'wp_nav_menu_items', 'my_account_loginout_link', 10, 2 );

function my_account_loginout_link( $items, $args ) {
    $current_user = wp_get_current_user();
    if (is_user_logged_in() && $args->theme_location == 'primary') { //change your theme location menu to suit
        $items .= '<li><a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">' .  $current_user->display_name . '</a></li>'; //change logout link, here it goes to 'shop', you may want to put it to 'myaccount'
    }
    elseif (!is_user_logged_in() && $args->theme_location == 'primary') {//change your theme location menu to suit
        $items .= '<li><a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">Log In</a></li>';
    }
    return $items;
}

/*// Separete Login form and registration form */
add_action('woocommerce_before_customer_login_form','load_registration_form', 2);

function load_registration_form(){
    if(isset($_GET['action'])=='register'){
        woocommerce_get_template( 'myaccount/form-registration.php' );
    }
}


add_action( 'login_enqueue_scripts', 'my_login_logo_one' );
function my_login_logo_one() { 
?> 
<style type="text/css"> 
body.login div#login h1 a {
background-image: url(<?php echo get_stylesheet_directory_uri() . '/logo.png';?>);  //Add your own logo image in this url 
padding-bottom: 30px; 
} 
</style>
<?php 
} 


add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );

function custom_woocommerce_product_add_to_cart_text() {

global $product;

$product_type = $product->product_type;

switch ( $product_type ) {
case 'external':
return __( 'Buy product', 'woocommerce' );
break;
case 'grouped':
return __( 'View products', 'woocommerce' );
break;
case 'simple':
return __( 'Add to cart', 'woocommerce' );
break;
case 'variable':
return __( 'Select options', 'woocommerce' );
break;
case 'composite':
return __( 'Select options', 'woocommerce' );
break;
default:
return __( 'Add to cart', 'woocommerce' );
}

}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
 
function addWooCommerceProductBodyClasses($classes){
 
    if ( is_product() ) {
        global $post;
        $product = wc_get_product( $post->ID );
 
        if ( $product->product_type == 'simple' ) {
            $classes[] = 'simple-product';
        } elseif ( $product->product_type == 'variable' ) {
            $classes[] = 'variable-product';
        } elseif ( $product->product_type == 'external' ) {
            $classes[] = 'external-product';
        } elseif ( $product->product_type == 'bto' || $product->product_type == 'composite' ) {
            $classes[] = 'page-template-template-fullwidth-php';
        } elseif ( $product->product_type == 'bundle' ) {
            $classes[] = 'bundle-product';
        }
    }
 
    return $classes;
}
add_filter( 'body_class', 'addWooCommerceProductBodyClasses' );

function woo_custom_cart_button_text() {
 
        return __( 'Add To Cart', 'woocommerce' );
 
}

/**
* Show all product attributes on the product page
*/

//add_action('woocommerce_after_shop_loop_item_title', 'isa_woocommerce_all_pa', 25);
function isa_woocommerce_all_pa(){
   
   global $product; 

    // Get product attributes
    $attributes = $product->get_attributes();

    if ( ! $attributes ) {
        echo "No attributes";
    }

    foreach ( $attributes as $attribute ) {

            echo $attribute['name'] . "<br/>";
    }
}

add_action('woocommerce_after_shop_loop','category_description_footer',99);
add_action('woocommerce_before_shop_loop','category_description_header',99);

function category_description_header(){
    global $wp_query, $product;
    $cat = $wp_query->get_queried_object();
    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
    $image = wp_get_attachment_url( $thumbnail_id );
    if (is_product_category()):
        if( !empty(get_term_meta( get_queried_object_id(), '_cmb2_cat_subheader', true ))):
        ?>
        <section class="content-section category-header">
            <h2>
            <?php
            
                $cat_subtitle = get_term_meta( get_queried_object_id(), '_cmb2_cat_subheader', true );
                echo $cat_subtitle;

            ?>
            </h2>
            <?php
            if( !empty(get_term_meta( get_queried_object_id(), '_cmb2_cat_subheader_content', true ))):
                $cat_subtitle = get_term_meta( get_queried_object_id(), '_cmb2_cat_subheader_content', true );
                echo $cat_subtitle;
                endif;
             ?>

        </section>
        <?php
        endif;
    endif;
}

function category_description_footer(){
    global $wp_query, $product;
    $cat = $wp_query->get_queried_object();
    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
    $image = wp_get_attachment_url( $thumbnail_id );
    if (is_product_category()):
       
    if ( $image ) { ?>
    <div class="col left category-banner">
        <?php
                echo '<img src="' . $image . '" alt="' . $cat->name . '" width="100%" />';
        ?>
        </div>
           <?php  }
         if( !empty(get_term_meta( get_queried_object_id(), '_cmb2_cat_subfooter_title', true ))):    
        ?> 
        <section class="content-section category-footer">
        
        <div class="col right">
            <h2>
            <?php
           
                $cat_subtitle = get_term_meta( get_queried_object_id(), '_cmb2_cat_subfooter_title', true );
                echo $cat_subtitle;
                ?>
           
            </h2>
            <?php woocommerce_taxonomy_archive_description(); ?>
        </div>
        </section>

        <?php
         endif;
    endif;
}


add_action('storefront_header','header_title',39);
function header_title(){
    
    if (!is_front_page()): ?>
        <div class="title-and-breadcrumbs">
            <h1 class="product_title entry-title">
                <?php
                    if (is_product_category()):
                        single_term_title();
                    elseif (is_search()):
                        echo 'Results for: ' . get_search_query();
                    elseif (is_product()):
                         echo str_replace('- Web Kit', '', the_title('', false));
                    elseif (is_shop()):
                        printf( Shop );
                    elseif (is_page() || is_single()):
                        the_title();
                    elseif (is_archive()):
                        the_archive_title();
                    endif;    
                ?>
            </h1>
            <?php if (is_single() && !is_product()): ?>
                <p>
                    <?php the_time('l, F jS, Y') ?>
                </p>
            <?php endif;?>
            <?php
            if(is_product()):
                global $product, $woocommerce, $post;
                $product = wc_get_product( $post->ID );
                ?>
                <h3><?php echo $product->get_price_html();?></h3>
                <?php 

                    global $wpdb;
                    global $post;
                    $count = $wpdb->get_var("
                    SELECT COUNT(meta_value) FROM $wpdb->commentmeta
                    LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                    WHERE meta_key = 'rating'
                    AND comment_post_ID = $post->ID
                    AND comment_approved = '1'
                    AND meta_value > 0
                ");

                $rating = $wpdb->get_var("
                    SELECT SUM(meta_value) FROM $wpdb->commentmeta
                    LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                    WHERE meta_key = 'rating'
                    AND comment_post_ID = $post->ID
                    AND comment_approved = '1'
                ");

                if ( $count > 0 ) {

                    $average = number_format($rating / $count, 2);

                    echo '<div class="starwrapper" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

                    echo '<span class="star-rating" title="'.sprintf(__('Rated %s out of 5', 'woocommerce'), $average).'"><span style="width:'.($average*16).'px"><span itemprop="ratingValue" class="rating">'.$average.'</span> </span></span>';

                    echo '</div>';
                    }

                ?>
            <?php endif;?>
        </div>
    <?php 
    
    endif;
    if ( is_front_page() & in_the_loop() ):
      add_filter( 'the_title', '__return_false' );
    endif;
   
}


 add_filter( 'woocommerce_product_tabs', 'remove_specific_product_tabs', 98 );
function remove_specific_product_tabs( $current_tabs ) {
   unset( $current_tabs['description'] );       /* Remove the description tab */ 
   unset( $current_tabs['reviews'] );           /* Remove the reviews tab  */
   unset( $current_tabs['additional_information'] );    /* Remove the additional information tab  */
   return $current_tabs;            /* Return the remaining  tabs to display */
}


add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_sample_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_cmb2_';

    /**
     * Initiate the metabox
     */

    $cmb_cat = new_cmb2_box( array(
        'id'            => 'cat_metabox',
        'title'         => __( 'Extra Category Fields', 'category_metabox' ),
        'object_types' => array('term'),
        'taxonomies' => array('product_cat'),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $cmb_cat->add_field( array(
        'name'       => __( 'Category Footer Subtitle', 'category_metabox' ),
        'desc'       => __( '(optional)', 'category_metabox' ),
        'id'         => $prefix . 'cat_subfooter_title',
        'type'       => 'text',
         // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

     $cmb_cat->add_field( array(
        'name'       => __( 'Category Header Subtitle', 'category_metabox' ),
        'desc'       => __( '(optional)', 'category_metabox' ),
        'id'         => $prefix . 'cat_subheader',
        'type'       => 'text',
         // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );
      $cmb_cat->add_field( array(
        'name'       => __( 'Category Header Content', 'category_metabox' ),
        'desc'       => __( '(optional)', 'category_metabox' ),
        'id'         => $prefix . 'cat_subheader_content',
        'type'       => 'text',
         // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );



    $cmb = new_cmb2_box( array(
        'id'            => 'accordion_metabox',
        'title'         => __( 'Product Accordion', 'cmb2' ),
        'object_types'  => array( 'product', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $custom_attributes = new_cmb2_box( array(
        'id'            => 'custom_attributes',
        'title'         => __( 'Custom Attribute Labels', 'cmb_attributes' ),
        'object_types'  => array( 'product', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

     $custom_attributes->add_field( array(
        'name'       => __( 'Attribute 1', 'cmb_attributes' ),
        'desc'       => __( '(optional)', 'cmb_attributes' ),
        'id'         => $prefix . 'attribute_1',
        'type'       => 'text',
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );
      $custom_attributes->add_field( array(
        'name'       => __( 'Attribute 2', 'cmb_attributes' ),
        'desc'       => __( '(optional)', 'cmb_attributes' ),
        'id'         => $prefix . 'attribute_2',
        'type'       => 'text',
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );
       $custom_attributes->add_field( array(
        'name'       => __( 'Attribute 3', 'cmb_attributes' ),
        'desc'       => __( '(optional)', 'cmb_attributes' ),
        'id'         => $prefix . 'attribute_3',
        'type'       => 'text',
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );


    // Regular text field
    $cmb->add_field( array(
        'name'       => __( 'System Specifications', 'cmb2' ),
        'desc'       => __( '(optional)', 'cmb2' ),
        'id'         => $prefix . 'system_specs',
        'type'       => 'wysiwyg',
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    // URL text field
    $cmb->add_field( array(
        'name' => __( 'System Requirements', 'cmb2' ),
        'desc' => __( '(optional)', 'cmb2' ),
        'id'   => $prefix . 'system_reqs',
        'type' => 'wysiwyg',
        // 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
        // 'repeatable' => true,
    ) );

    // Email text field
    $cmb->add_field( array(
        'name' => __( 'System and Electrical Parameters', 'cmb2' ),
        'desc' => __( '(optional)', 'cmb2' ),
        'id'   => $prefix . 'system_params',
        'type' => 'wysiwyg',
        // 'repeatable' => true,
    ) );

     $cmb->add_field( array(
        'name' => __( 'Certifications', 'cmb2' ),
        'desc' => __( '(optional)', 'cmb2' ),
        'id'   => $prefix . 'system_certs',
        'type' => 'wysiwyg',
        // 'repeatable' => true,
    ) );
       $cmb->add_field( array(
        'name' => __( 'What\'s in the box?', 'cmb2' ),
        'desc' => __( '(optional)', 'cmb2' ),
        'id'   => $prefix . 'system_box',
        'type' => 'wysiwyg',
        // 'repeatable' => true,
    ) );

      $cmb->add_field( array(
        'name' => __( 'PDF Dowload link', 'cmb2' ),
        'desc' => __( '(optional)', 'cmb2' ),
        'id'   => $prefix . 'pdf_download_link',
        'type' => 'file',
        // 'repeatable' => true,
    ) );

    
}

add_action('woocommerce_single_product_summary','product_description',20);
function product_description(){
      global $product;
      if(is_product() && !$product -> is_type('composite')):
    ?>
    <h3>Product Information</h3>
    <div class="description">
        <?php echo the_content();
        $_text_field = get_post_meta( get_the_ID(),'lightspeed_custom_sku');
        if(!empty( $_text_field)){
            echo 'SKU: ' . get_post_meta( get_the_ID(),'lightspeed_custom_sku', true);
        }
        ?>

    </div>
    <?php
    endif;
}


add_action('woocommerce_single_product_summary','product_accordion',70);
function product_accordion(){ 
    global $product;
    if(is_product() && !$product -> is_type('composite')):
        $classes = get_body_class();
        if(is_product() && $product -> is_type('composite') && !in_array('composite-variant',$classes) ):
            add_filter( 'body_class', 'woa_remove_sidebar_class_body', 10 );
        endif;
        if(is_product()): ?>
        <div class="accordion-container">
            <dl class="accordion store-accordion">
                <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_specs', true ))): ?>
                    <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>System Specifications</h4></dt>
                    <dd>
                        <div class="section">
                            <?php
                            // Grab the metadata from the database
                            $specs = get_post_meta( get_the_ID(), '_cmb2_system_specs', true );

                            // Echo the metadata
                            echo $specs;
                            ?>
                        </div>
                    </dd>
                <?php endif;?>
                    <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_reqs', true ))): ?>
                    <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>System Requirements</h4></dt>
                    <dd>
                        <div class="section">
                           <?php
                            // Grab the metadata from the database
                            $system_reqs = get_post_meta( get_the_ID(), '_cmb2_system_reqs', true );

                            // Echo the metadata
                            echo $system_reqs;
                            ?>
                        </div>
                    </dd>
                <?php endif; ?>
                <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_params', true ))): ?>
                    <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>System And Electrical Parameters</h4></dt>
                        <dd>
                            <div class="section">
                                <?php
                                // Grab the metadata from the database
                                $system_params= get_post_meta( get_the_ID(), '_cmb2_system_params', true );

                                // Echo the metadata
                                echo $system_params;
                                ?>
                            </div>
                        </dd>
                    <?php endif; ?>    
                     <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_certs', true ))): ?>   
                        <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>Certifications</h4></dt>
                        <dd>
                            <div class="section">
                                <?php
                                // Grab the metadata from the database
                                $system_certs = get_post_meta( get_the_ID(), '_cmb2_system_certs', true );

                                // Echo the metadata
                                echo nl2br($system_certs);
                                ?>
                            </div>
                        </dd>
                    <?php endif; ?>
                     <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_box', true ))): ?>   
                        <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>What's in the Box?</h4></dt>
                        <dd>
                            <div class="section">
                                <?php
                                // Grab the metadata from the database
                                $system_certs = get_post_meta( get_the_ID(), '_cmb2_system_box', true );

                                // Echo the metadata
                                echo $system_certs;
                                ?>
                            </div>
                        </dd>
                        <?php endif; ?>
                        <?php if ( comments_open() ): ?>
                            <?php
                                if( !empty(get_post_meta( get_the_ID(), '_cmb2_pdf_download_link', true ))):
                                    $pdf_download_link = get_post_meta( get_the_ID(), '_cmb2_pdf_download_link', true );
                            ?>
                                    <dt><div class="border-separate"></div><br/><a target="_blank" href="<?php echo $pdf_download_link; ?>">Download the Data Sheet</a></dt>
                        <?php endif; ?>
                        <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>Customer Reviews</h4></dt>
                        <dd>
                            <div class="section">
                                <?php
                                comments_template();
                                ?>
                            </div>
                        </dd>
                    <?php endif; ?>

                    </dl>
                </div> 
            <?php endif;
        endif;
}

add_action('woocommerce_after_main_content','product_accordion_composite');
function product_accordion_composite(){ 
    global $product;
    if(is_product() && $product -> is_type('composite')):
        $classes = get_body_class();
        if(is_product() && $product -> is_type('composite') && !in_array('composite-variant',$classes) ):
            add_filter( 'body_class', 'woa_remove_sidebar_class_body', 10 );
        endif;
        if(is_product()): ?>
        
        <div class="accordion-container">

        <dl class="accordion store-accordion">
            <h3>Product Information</h3>
            <div class="description">
                <?php echo the_content(); ?>
            </div>
            <?php if($product -> is_type('composite')): ?>
            <button class="btn options-button"><span>Show Options</span></button>
        <?php endif; ?>
            <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_specs', true ))): ?>
                <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>System Specifications</h4></dt>
                <dd>
                    <div class="section">
                        <?php
                        // Grab the metadata from the database
                        $specs = get_post_meta( get_the_ID(), '_cmb2_system_specs', true );

                        // Echo the metadata
                        echo $specs;
                        ?>
                    </div>
                </dd>
            <?php endif;?>
                <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_reqs', true ))): ?>
                <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>System Requirements</h4></dt>
                <dd>
                    <div class="section">
                       <?php
                        // Grab the metadata from the database
                        $system_reqs = get_post_meta( get_the_ID(), '_cmb2_system_reqs', true );

                        // Echo the metadata
                        echo $system_reqs;
                        ?>
                    </div>
                </dd>
            <?php endif; ?>
            <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_params', true ))): ?>
                <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>System And Electrical Parameters</h4></dt>
                    <dd>
                        <div class="section">
                            <?php
                            // Grab the metadata from the database
                            $system_params= get_post_meta( get_the_ID(), '_cmb2_system_params', true );

                            // Echo the metadata
                            echo $system_params;
                            ?>
                        </div>
                    </dd>
                <?php endif; ?>    
                 <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_certs', true ))): ?>   
                    <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>Certifications</h4></dt>
                    <dd>
                        <div class="section">
                            <?php
                            // Grab the metadata from the database
                            $system_certs = get_post_meta( get_the_ID(), '_cmb2_system_certs', true );

                            // Echo the metadata
                            echo $system_certs;
                            ?>
                        </div>
                    </dd>
                <?php endif; ?>
                 <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_system_box', true ))): ?>   
                    <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>What's in the Box?</h4></dt>
                    <dd>
                        <div class="section">
                            <?php
                            // Grab the metadata from the database
                            $system_certs = get_post_meta( get_the_ID(), '_cmb2_system_box', true );

                            // Echo the metadata
                            echo $system_certs;
                            ?>
                        </div>
                    </dd>
                
                 <?php endif; ?>
                    <?php
                        if( !empty(get_post_meta( get_the_ID(), '_cmb2_pdf_download_link', true ))):
                            $pdf_download_link = get_post_meta( get_the_ID(), '_cmb2_pdf_download_link', true );
                    ?>
                        <dt><div class="border-separate"></div><br/><a target="_blank" href="<?php echo $pdf_download_link; ?>">Download the Data Sheet</a></dt>
                <?php endif; ?>
                </dl>
            </div> 
        <?php
        endif;
    endif;
}

 
foreach ( array( 'term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_kses_data' );
}

function cs_my_wc_custom_variable_price_html( $price, $product ) {
    $prices = $product->get_variation_prices( true );
    $min_price = current( $prices['price'] );
    $max_price = end( $prices['price'] );
    // Return price if min is equal to max.
    if ( $min_price === $max_price || $product->is_on_sale() ) {
        return $price;
    }
    return sprintf( __( 'from: %s', 'your-text-domain' ), wc_price( $min_price ) . $product->get_price_suffix() );
}
add_filter( 'woocommerce_variable_price_html', 'cs_my_wc_custom_variable_price_html', 10, 2 );
/**
 * Custom variable sale price HTML.
 * Shows "Starting at" prefix with when min price is different from max price.
 *
 * @param stirng $price Product price HTML
 * @param WC_Product_Variable $product Product data.
 * @return string
 */
function cs_my_wc_custom_variable_sale_price_html( $price, $product ) {
    $prices = $product->get_variation_prices( true );
    $min_price = current( $prices['price'] );
    $min_regular_price = current( $prices['regular_price'] );
    $max_regular_price = end( $prices['regular_price'] );
    // Return price if min is equal to max.
    if ( $min_regular_price === $max_regular_price ) {
        return $price;
    }
    $price = $product->get_price_html_from_to( $min_regular_price, $min_price );
    return sprintf( __( 'Starting at %s', 'your-text-domain' ), $price . $product->get_price_suffix() );
}
add_filter( 'woocommerce_variable_sale_price_html', 'cs_my_wc_custom_variable_sale_price_html', 10, 2 );

function wc_custom_store_notice_updated( $text ) {
    return str_replace( 'replace', 'SITEWIDE SALE! Use discount code: LSWEB10 at checkout to receive 10% of your entire order! <a href="tel:1-720-600-2037" class="call-head">Need Help? Call us now! 720-600-2037</a>', $text );
}
add_filter( 'woocommerce_demo_store', 'wc_custom_store_notice_updated' );

add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {

            $title = '<span class="vcard">' . get_the_author() . '</span>' ;

        }

    return $title;

});

// Display Price For Variable Product With Same Variations Prices
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
    if ($value['price_html'] == '') {
        $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }
    return $value;
}, 10, 3);

//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );


/**
 * Add lightspeed_custom_sku, lightspeed_upc, lightspeed_ean, lightspeed_manufacturer, lightspeed_manufacturer_sku, and lightspeed_vendor to product search
 */
 
// hook into wp pre_get_posts
add_action('pre_get_posts', 'argoworks_woo_search_pre_get_posts');
 
/**
 * Add custom join and where statements to product search query
 * @param  mixed $q query object
 * @return void
 */
function argoworks_woo_search_pre_get_posts($q){
 
    if ( is_search() ) {
        add_filter( 'posts_join', 'argoworks_search_post_join' );
        add_filter( 'posts_where', 'argoworks_search_post_excerpt' );
    }
}
 
/**
 * Add Custom Join Code for wp_mostmeta table
 * @param  string $join
 * @return string
 */
function argoworks_search_post_join($join = ''){
 
    global $wp_the_query;
 
    // escape if not woocommerce searcg query
    if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) )
            return $join;
 
    $join .= "INNER JOIN wp_postmeta AS jcmt1 ON (wp_posts.ID = jcmt1.post_id) ";
    return $join;
}
 
/**
 * Add custom where statement to product search query
 * @param  string $where
 * @return string
 */
function argoworks_search_post_excerpt($where = ''){
 
    global $wp_the_query, $pagenow, $wpdb, $wp;
    // escape if not woocommerce search query
    if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) )
            return $where;
    $search_ids = array();
    $term = wc_clean($wp_the_query->query_vars['s']);
    $temp_where = "((pm.meta_key = 'lightspeed_custom_sku' AND CAST(pm.meta_value AS CHAR) LIKE '%%".$term."%%')
                OR (pm.meta_key = 'lightspeed_upc' AND CAST(pm.meta_value AS CHAR) LIKE '%%".$term."%%')
                OR (pm.meta_key = 'lightspeed_ean' AND CAST(pm.meta_value AS CHAR) LIKE '%%".$term."%%')
                OR (pm.meta_key = 'lightspeed_manufacturer' AND CAST(pm.meta_value AS CHAR) LIKE '%%".$term."%%')
                OR (pm.meta_key = 'lightspeed_manufacturer_sku' AND CAST(pm.meta_value AS CHAR) LIKE '%%".$term."%%')
                OR (pm.meta_key = 'lightspeed_vendor' AND CAST(pm.meta_value AS CHAR) LIKE '%%".$term."%%'))";
    $query = "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->postmeta} pm on p.ID = pm.post_id where p.post_parent <> 0 AND ".$temp_where." group by p.post_parent";
    $search_ids = $wpdb->get_col($query);
    $search_ids = array_filter(array_map('absint', $search_ids));
    $where = preg_replace("/post_title LIKE ('%[^%]+%')/", "post_title LIKE $1)
                OR (jcmt1.meta_key = 'lightspeed_custom_sku' AND CAST(jcmt1.meta_value AS CHAR) LIKE $1)
                OR (jcmt1.meta_key = 'lightspeed_upc' AND CAST(jcmt1.meta_value AS CHAR) LIKE $1)
                OR (jcmt1.meta_key = 'lightspeed_ean' AND CAST(jcmt1.meta_value AS CHAR) LIKE $1)
                OR (jcmt1.meta_key = 'lightspeed_manufacturer' AND CAST(jcmt1.meta_value AS CHAR) LIKE $1)
                OR (jcmt1.meta_key = 'lightspeed_manufacturer_sku' AND CAST(jcmt1.meta_value AS CHAR) LIKE $1)
                OR (jcmt1.meta_key = 'lightspeed_vendor' AND CAST(jcmt1.meta_value AS CHAR) LIKE $1 ", $where);
    if (sizeof($search_ids) > 0) {
        $where = str_replace(')))', ") OR ({$wpdb->posts}.ID IN (" . implode(',', $search_ids) . "))))", $where);
    }
    return $where;
}

?>