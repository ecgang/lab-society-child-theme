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

add_filter('asp_custom_fonts', 'asp_null_css');
function asp_null_css($css_arr) {
    return array();
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
<!-- Global site tag (gtag.js) - AdWords: 847872588 --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-847872588"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-847872588'); </script>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Montserrat:300,400,700,300italic,400italic,700italic' ] }
};
(function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
    '://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})();
</script>

<?php 
}


add_action( 'init', 'storefront_custom_logo' );
function storefront_custom_logo() {
    remove_action( 'storefront_header', 'storefront_site_branding', 20 );
    add_action( 'storefront_header', 'storefront_display_custom_logo', 20 );
}


function storefront_display_custom_logo() {
    ?>
    <div class="site-branding">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
            <img class="custom-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/buy-lab-equipment-online-laboratory-supply-co.svg" alt="Lab Society - Buy Lab Equipment Online - Laboratory Supply Co." />
        </a>
    </div>
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
                    nextText: '',
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
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action( 'wp_footer', 'woocommerce_demo_store' );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );  
    remove_action( 'homepage', 'storefront_best_selling_products', 70 );
    remove_action( 'homepage', 'storefront_product_categories', 20 );
    remove_action( 'homepage', 'storefront_recent_products', 30 );
    remove_action( 'homepage', 'storefront_featured_products', 40 );
    remove_action( 'homepage', 'storefront_popular_products', 50 );
    remove_action( 'homepage', 'storefront_on_sale_products', 60 );
    add_action( 'storefront_before_header', 'woocommerce_demo_store' );
    add_action('storefront_before_header','page_load_script');
    add_action('woocommerce_single_variation','woocommerce_single_variation', 50);
    add_action( 'storefront_before_content', 'wc_print_notices' );
    add_action('storefront_after_footer', 'mobile_menu');
    add_action( 'woocommerce_after_add_to_cart_button', 'woocommerce_template_single_price', 10);  
    add_action( 'storefront_header', 'storefront_primary_navigation_wrapper',97);
    add_action( 'storefront_header', 'storefront_primary_navigation', 98);
    add_action( 'storefront_footer', 'custom_storefront_footer', 30);
    add_action( 'storefront_header', 'storefront_primary_navigation_wrapper_close',100);
    remove_theme_support( 'wc-product-gallery-zoom' ); 
    
    add_theme_support( 'woocommerce', array(
        'single_image_width'    => 1024,
        'thumbnail_image_width' => 500,
    ) );
}


add_action( 'woocommerce_after_single_product_summary', 'section_divider', 10 );

function section_divider(){
    global $product;
     if ( $product->get_upsells() && $product->product_type == 'composite' ) {
        echo '</div><div class="shadow-divider"></div>';
    }else if($product->get_upsells()){
        echo '<div class="shadow-divider"></div>';
    }
    
}

add_action( 'woocommerce_before_single_product_summary', 'composite_product_container_open', 10 );

function composite_product_container_open(){
    global $product;
     if ( $product->get_upsells() && $product->product_type == 'composite' ) {
        echo '<div class="product_container">';
    }   
    
}

add_filter('gettext', 'translate_like');
add_filter('ngettext', 'translate_like');
function translate_like($translated) {
$translated = str_ireplace('You may also like&hellip;', 'Related Products', $translated);
return $translated;
}

add_action('woocommerce_before_add_to_cart_button', 'add_show_options');

function add_show_options(){
    global $product;

    if($product -> is_type('composite')){
        echo '<div class="composite_options_container"><a href="#" class="options-button"><span>Show Options</span><span class="down-angle"></span></a>';
    }
 
}



add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 100 );
//add_action( 'woocommerce_before_add_to_cart_button', 'add_call_info', 100 );

function add_call_info(){
    echo '<a class="call-number" href="tel:7206002037" name="Call Lab Society (720) 600-2037"><strong>(720) 600-2037</strong></a>';
}

function page_load_script(){
    ?>
    <script>document.body.className += ' fade-out';</script>
    <?php
}

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
            //wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            //wp_dequeue_script( 'wc-cart' );
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


function mobile_menu(){
    echo '<div class="mobile_menu_container">';
    
    echo dynamic_sidebar();
    echo '</div>';

}


function custom_storefront_footer() {
    ?>
    <div class="inner-container"><?php
        wp_nav_menu( array('menu' => 'Footer Menu') );
        ?>
        <div class="social">
            <a href="http://instagram.com/labsociety" target="_blank" class="fa fa-instagram" aria-hidden="true"></a>
            <a href="http://facebook.com/labsociety" target="_blank" class="fa fa-facebook" aria-hidden="true"></a>
        </div>
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
            ?><ul id="menu-home-anchors" class="menu"><li class="menu-item">Need Help? Call: <a class="call-number" href="tel:7206002037" onclick="_gaq.push(['_trackEvent','Phone Call Tracking','Click/Touch','Header']);" name='Call Lab Society (720) 600-2037'><strong>(720) 600-2037</strong></a></li>
                <li class="menu-item"><a href="/my-account" name='Log in'>Log in</a></li>
                <li class="menu-item"><a href="/shop" class="add_to_cart_button" name='Explore Lab Society'>Explore</a></li>
                <!--<li class="menu-item"><a href="javascript:$zopim.livechat.window.show();">Live Chat Now!</a></li>--></ul>
                <?php
            endif;
            ?>
            <div class="search-container">
                <?php storefront_product_search(); ?>
            </div>
            <?php/* wp_nav_menu( array( 'theme_location' => 'primary' ) ); */?>
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
        
        // get current page we are on. If not set we can assume we are on page 1.
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        // are we on page one?
        if(1 == $paged) :
            //true
            
            
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
    endif;
}

function category_description_footer(){
    global $wp_query, $product;
    $cat = $wp_query->get_queried_object();
    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
    $image = wp_get_attachment_url( $thumbnail_id );
    if (is_product_category()):
        // get current page we are on. If not set we can assume we are on page 1.
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        // are we on page one?
        if(1 == $paged) :
            //true
         
            if ( $image ) { ?>
            <div class="col left category-banner">
                <?php
                echo '<img src="' . $image . '" alt="' . $cat->name . '" width="100%" />';
                ?>
                <div class="shadow-hide"></div>
            </div>
            <?php  }
            if(get_term_meta( get_queried_object_id(), '_cmb2_cat_subfooter_title', true )):    
                ?> 
                <section class="content-section category-footer">
                    
                    <div class="col right">
                        <h2>
                            <?php
                            
                            $cat_subtitle = get_term_meta( get_queried_object_id(), '_cmb2_cat_subfooter_title', true );
                            echo $cat_subtitle;
                            ?>
                            
                        </h2>
                        <?php echo '<div class="term-description">' . apply_filters( 'the_content', term_description()) . '</div>';?>

                    </div>
                </section>

                <?php
            endif;
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
            elseif (is_single()):
                if(!empty(get_post_meta( get_the_ID(), '_cmb2_new_title', true ))):
                    $new_title = get_post_meta( get_the_ID(), '_cmb2_new_title', true );
                         echo $new_title;
                    else:
                    the_title();
                endif;
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

    $cmb_title = new_cmb2_box( array(
        'id'            => 'new_title_metabox',
        'title'         => __( 'Replace Title Fields', 'title_metabox' ),
        'object_types'  => array( 'product'), // Post type
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
        'type'       => 'wysiwyg',
        'show_on_cb' => 'cmb2_hide_if_no_cats', 
         // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    $cmb_title->add_field( array(
        'name'       => __( 'Title Replace', 'title_metabox' ),
        'desc'       => __( '(optional)', 'title_metabox' ),
        'id'         => $prefix . 'new_title',
        'type'       => 'text',
         // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    $cmb_title->add_field( array(
        'name'       => __( 'Subtitle', 'title_metabox' ),
        'desc'       => __( '(optional)', 'title_metabox' ),
        'id'         => $prefix . 'new_subtitle',
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
    $cmb->add_field( array(
        'name'       => __( 'Product Information Header Replace', 'cmb2' ),
        'desc'       => __( '(optional)', 'cmb2' ),
        'id'         => $prefix . 'product_infomation_header',
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

add_action('woocommerce_single_product_summary','product_description',30);
function product_description(){
  global $product;
  if(is_product() && !$product -> is_type('composite')):
    ?>
    <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_product_infomation_header', true ))): ?>
        <span class="display_blank"></span>
        <h2>
            <?php
            $specs = get_post_meta( get_the_ID(), '_cmb2_product_infomation_header', true );
            echo $specs;
            ?>
        </h2>
    <?php else: ?>
        <span class="display_blank"></span>
        <h3>Product Information</h3>

    <?php endif; ?>
    <div class="description">
        <?php echo the_content(); ?>

    </div>
    <?php 
    $_text_field = get_post_meta( get_the_ID(),'lightspeed_custom_sku');
    if(!empty( $_text_field)){
           // echo 'SKU: ' . get_post_meta( get_the_ID(),'lightspeed_custom_sku', true);
    }
    
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
                    <dt><div class="border-separate"></div><a target="_blank" class="download-link" href="<?php echo $pdf_download_link; ?>">Download the Data Sheet</a></dt>
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
        
        <div class="accordion-container composite">
           
            <dl class="accordion store-accordion">
                <?php if( !empty(get_post_meta( get_the_ID(), '_cmb2_product_infomation_header', true ))): ?>
                    <h2>
                        <?php
                        $specs = get_post_meta( get_the_ID(), '_cmb2_product_infomation_header', true );
                        echo $specs;
                        ?>
                    </h2>
                <?php else: ?>
                    <h3>Product Information</h3>
                <?php endif; ?>
                <div class="description">
                    <?php echo the_content(); ?>
                </div>
                
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
                <dt><div class="border-separate"></div><a target="_blank" class="download-link" href="<?php echo $pdf_download_link; ?>">Download the Data Sheet</a></dt>
            <?php endif; ?>
            <dt><div class="border-separate"></div><span class="open"></span><small class="right"><span class="down-angle"></span></small><h4>Customer Reviews</h4></dt>
            <dd>
                <div class="section">
                    <?php
                    comments_template();
                    ?>
                </div>
            </dd>
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
    return str_replace( 'replace', 'Please note: We are moving warehouses today and tomorrow, please expect orders placed between today and Monday, January 28th to be shipped out on the 29th.', $text );
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


add_action('woocommerce_after_order_notes', 'wps_add_select_checkout_field');
function wps_add_select_checkout_field( $checkout ) {
    woocommerce_form_field( 'salesperson', array(
        'type'          => 'select',
        'class'         => array( 'wps-drop' ),
        'label'         => __( 'Did someone help you today?' ),
        'options'       => array(
            ''     => _('Select Sales Person', 'wps'),
            'Adam'     => __( 'Adam', 'wps' ),
            'Mark'   => __( 'Mark', 'wps' ),
            'Mike' => __( 'Mike', 'wps' ),
            'Paul'   => __( 'Paul', 'wps' ),
            'Peter'   => __( 'Peter', 'wps' )
        )
    ),
    $checkout->get_value( 'salesperson' ));
}


add_action('woocommerce_checkout_update_order_meta', 'wps_select_checkout_field_update_order_meta');
function wps_select_checkout_field_update_order_meta( $order_id ) {
 if ($_POST['salesperson']) update_post_meta( $order_id, 'salesperson', esc_attr($_POST['salesperson']));
}


add_action( 'woocommerce_admin_order_data_after_billing_address', 'wps_select_checkout_field_display_admin_order_meta', 10, 1 );
function wps_select_checkout_field_display_admin_order_meta($order){
    $salesperson = get_post_meta( $order->id, 'salesperson');
    if(!empty($salesperson)):
        echo '<p><strong>'.__('Salesperson').':</strong> ' . get_post_meta( $order->id, 'salesperson', true ) . '</p>';
    endif;
}


add_filter( 'manage_edit-shop_order_columns', 'wc_new_order_column' );
function wc_new_order_column( $columns ) {
    $columns['salesperson'] = 'Salesperson';
    return $columns;
}


add_action( 'manage_shop_order_posts_custom_column', 'salesperson_column_content', 10, 2 );
function salesperson_column_content( $column, $post_id ) {    
    if ( 'salesperson' === $column ) {
        $salesperson = get_post_meta( $post_id, 'salesperson', true );
        echo $salesperson;
    }
}

add_filter( 'manage_edit-shop_order_sortable_columns', 'my_wc_column_sort' );
function my_wc_column_sort( $columns ) {
    $custom = array(
        'salesperson'    => '_salesperson'
    );
    return wp_parse_args( $custom, $columns );
}

add_action( 'pre_get_posts', 'manage_wp_posts_be_qe_pre_get_posts', 1 );
function manage_wp_posts_be_qe_pre_get_posts( $query ) {

   /**
    * We only want our code to run in the main WP query
    * AND if an orderby query variable is designated.
    */
   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

      switch( $orderby ) {

       case 'salesperson':

            // set our query's meta_key, which is used for custom fields
       $query->set( 'meta_key', '_salesperson' );

       $query->set( 'orderby', 'meta_value' );

       break;

   }

}

}

/**
 * Only copy the <?php if needed
 * 
 * Hide coupon field at checkout until coupon link clicked
 * Tutorial: http://www.sellwithwp.com/move-the-woocommerce-coupon-field/
**/

/**
 * Show a coupon link above the order details.
**/
function cw_show_coupon() {
    global $woocommerce;

    if ($woocommerce->cart->needs_payment()) {
        echo '<p style="padding-bottom: 5px;"> Have a coupon? <a href="#" id="show-coupon-form">Click here to enter your coupon code</a>.</p><div id="coupon-anchor"></div>';
    }
}
add_action('woocommerce_checkout_order_review', 'cw_show_coupon');


function cw_scripts() {
    wp_enqueue_script('jquery-ui-dialog');
}
add_action('wp_enqueue_scripts', 'cw_scripts');

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');
add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form' );

function cw_show_coupon_js() {
    wc_enqueue_js('$("a.showcoupon").parent().hide();');
    wc_enqueue_js('dialog = $("form.checkout_coupon").dialog({
     autoOpen: false,
     width: 500,
     open: function(event, ui) {
        $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
    },
    minHeight: 0,
    modal: false,
    appendTo: "#coupon-anchor",
    position: { my: "left", at: "left", of: "#coupon-anchor"},
    draggable: false,
    resizable: false,
    dialogClass: "coupon-special",
    buttons: {}});');
    wc_enqueue_js('$("#show-coupon-form").click( function() {
     if (dialog.dialog("isOpen")) {
         $(".checkout_coupon").hide();
         dialog.dialog( "close" );
     } else {
         $(".checkout_coupon").show();
         dialog.dialog( "open" );
     }
     return false;});');
}
add_action('woocommerce_before_checkout_form', 'cw_show_coupon_js');



add_action('woocommerce_before_checkout_form','returning_customer_prompt');

function returning_customer_prompt(){
    echo '<p style="padding-bottom: 5px;"> Returning Customer? <a href="#" class="showlogin">Click here to login</a></p>';
}

add_filter( 'woocommerce_apply_base_tax_for_local_pickup', '__return_false' );



add_action( 'woocommerce_single_product_summary', 'ec_child_modify_wc_variation_desc_position' );
function ec_child_modify_wc_variation_desc_position() {
    ?>
    <script>
        (function($) {
            $(document).on( 'found_variation', function() {
                var desc = $( '.woocommerce-variation.single_variation' ).find( '.woocommerce-variation-description' ).html();
                var $entry_summary = $( '.accordion-container' ), $wc_var_desc = $entry_summary.find( '.woocommerce-variation-description' );

                if ( $wc_var_desc.length == 0 ) {
                    $entry_summary.prepend( "<a id='variation_description' name='variation_description' href='#'></a><div class='woocommerce-variation-description' ></div>" );
                }
                $entry_summary.find( '.woocommerce-variation-description' ).html( desc );
            });
        })( jQuery );

    </script>
    <style>form.variations_form .woocommerce-variation-description { display: none; }</style>
    <?php
}

add_action( 'woocommerce_single_product_summary', 'single_product_variable_customization', 3, 0 );
function single_product_variable_customization() {
    global $product;

    // Only for variable products on single product pages
    if ( $product->is_type('variable') && is_product() ) {

    ##  ==>  ==>  Here goes your php code (if needed)  ==>  ==>  ##

    // Passing a variable to javascript
        $string1 = "The selected Variation ID is: ";
        $string2 = "Please select all Variations ";
        ?>
    <script>
        jQuery(document).ready(function($) {           
            function updateData () {
                var missing = false;
                var divs = []
                // Iterate over all the items
                $('#ivpa-content').first().children('.ivpa_attribute.ivpa_text').each(function() {
                    var $element = $(this)
                    var title = ($element.find('.ivpa_title').text() || '').trim()
                    var value = ($element.find('.ivpa_term.ivpa_clicked').text() || '').trim()

                    if (!value) {
                        missing = true;
                        value = 'Select Option'
                    }
                    // Create the new Div to add, with their attributes
                    var $title = $('<span>', {"class": 'selection_title', text:title});
                    var $value = $('<span>', {"class": 'selection_value', text:value});
                    var $newDiv = $('<div>', {"class": 'current_selection'});
                    $newDiv.append($title, $value);
                    divs.push($newDiv);
                });
                var $wrapper = $('.variant_selection');
                $wrapper.empty();
                
                    $wrapper.append(divs);
                
            }
            updateData();
   
            $('.ivpa_term.ivpa_active').click(function () {
                if ($(".woocommerce-variation-add-to-cart").hasClass("woocommerce-variation-add-to-cart-disabled")) {
                    $(this).closest(".single_variation").addClass("price-disabled");
                }
                setTimeout(updateData, 100);
            })
        });
    </script>
<?php
}
}


add_action('woocommerce_single_variation', 'add_empty_div',100);

function add_empty_div(){
    echo "<div class='variant_selection_container'><span class='down-angle'></span><div class='variant_selection'></div></div>";
}


add_filter('woocommerce_review_order_before_payment', 'add_payment_note');

function add_payment_note(){
    echo '<p>Note: If you are having difficulty checking out, high value carts may need to be verified with your bank to complete your purchase."</p>';
}

add_filter('storefront_footer', 'add_div_conatiner', 0);
add_filter('storefront_footer', 'add_price_match_info', 40);
function add_div_conatiner(){
    echo '<div class="flex-left">';
}

function add_price_match_info(){
    echo '</div><div class="flex-right"><a class="price-match" href="/price-match"><img src="https://labsociety.com/wp-content/uploads/vectors/laboratory-supply-co-lab-equipment.svg" alt="Lab Equipment &amp; Laboratory Supply Co. - Fractional Distillation" width="100" /></a></div>';
}


function ld_wc_filter_billing_fields( $address_fields ) {
    $address_fields['billing_email']['priority'] = 8;
 
    $address_fields['billing_phone']['required'] = false;
    $address_fields['billing_phone']['priority'] = 98;
    return $address_fields;
}
add_filter( 'woocommerce_billing_fields', 'ld_wc_filter_billing_fields', 10, 1 );


add_action( 'woocommerce_product_options_general_product_data', 'custom_general_product_data_custom_fields' );
/**
 * Add `Not Ready to Sell` field in the Product data's General tab.
 */
function custom_general_product_data_custom_fields() {
    // Checkbox.
    woocommerce_wp_checkbox(
        array(
            'id'            => '_not_ready_to_sell',
            'label'         => __( 'Call To Order', 'woocommerce' ),
            'description'   => __( '', 'woocommerce' )
            )
    );
}

add_action( 'woocommerce_process_product_meta', 'custom_save_general_proddata_custom_fields' );
/**
 * Save the data values from the custom fields.
 * @param  int $post_id ID of the current product.
 */
function custom_save_general_proddata_custom_fields( $post_id ) {
    // Checkbox.
    $woocommerce_checkbox = isset( $_POST['_not_ready_to_sell'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_not_ready_to_sell', $woocommerce_checkbox );
}

add_filter( 'woocommerce_is_purchasable', 'custom_woocommerce_set_purchasable' );
/**
 * Mark "Not ready to sell" products as not purchasable.
 */
function custom_woocommerce_set_purchasable() {
    $not_ready_to_sell = get_post_meta( get_the_ID(), '_not_ready_to_sell', true );

    return ( 'yes' === $not_ready_to_sell ? false : true );
}


add_filter( 'woocommerce_product_add_to_cart_text', 'custom_product_add_to_cart_text', 10, 3);
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_product_add_to_cart_text', 10, 3);


/**
 * Change "Read More" button text for non-purchasable products.
 */
function custom_product_add_to_cart_text() {
    global $product;
    $not_ready_to_sell = get_post_meta( get_the_ID(), '_not_ready_to_sell', true );
    $availability = $product->get_availability();
    $product_type = $product->product_type;
    $stock_status = $availability['class'];
    if ( 'yes' === $not_ready_to_sell ) {
        return __( 'Call to Order', 'woocommerce' );
    } 
    else if ($product_type == 'variable' && $stock_status == 'in-stock' ){
        return __( 'Select Options', 'woocommerce' );
    }

    else if ($product_type == 'variable' && $stock_status == 'out-of-stock') {
        return __( 'Sold Out', 'woocommerce' );
    }

    else if ( $product_type == 'simple' && $stock_status == 'out-of-stock') {
        return __( 'Sold Out', 'woocommerce' );
    }

    else if ( $product_type == 'composite') {
        return __( 'Select Options', 'woocommerce' );
    }
    
    else {
        return __( 'Add to cart', 'woocommerce' );
    }
}

add_action( 'woocommerce_single_product_summary', 'custom_woocommerce_call_to_order_text', 10, 3 );
/**
 * Add calling instructions for non-purchasable products.
 */
function custom_woocommerce_call_to_order_text() {
    $not_ready_to_sell = get_post_meta( get_the_ID(), '_not_ready_to_sell', true );

    if ( 'yes' === $not_ready_to_sell ) {
        echo '<div class="call_to_order_button_container"><a href="tel:7206002037" class="call_to_order_button add_to_cart_button button">Call to order: (720) 600-2037 </a></div>';
    }

}


add_filter( 'woocommerce_product_add_to_cart_text', 'customizing_add_to_cart_button_text', 10, 2 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'customizing_add_to_cart_button_text', 10, 2 );
function customizing_add_to_cart_button_text( $button_text, $product ) {
    global $product;
    $sold_out = __( "Sold Out", "woocommerce" );

    $availability = $product->get_availability();
    $stock_status = $availability['class'];

    // Only for variable products on single product pages
    if ( $product->is_type('variable') && is_product() && $stock_status == 'out-of-stock') {
                
               $button_text = $sold_out;
            }

    elseif ( $product->is_type('variable') && is_product() && $stock_status == 'in-stock') {
        
       $button_text = 'Add to cart';
    }

   


    return $button_text;
}

add_filter( 'body_class', 'call_to_order_body_class' );

function call_to_order_body_class($classes){
   $not_ready_to_sell = get_post_meta( get_the_ID(), '_not_ready_to_sell', true );
    if ( 'yes' === $not_ready_to_sell ) {
        $classes[] = 'call-to-order';
    }
    return $classes;
}

function my_post_image_html( $html, $post_id, $post_image_id ) {
if(is_single() && !is_product()) {
    return '';
} else
    return $html;
}
add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );

add_filter( 'woocommerce_register_post_type_product', 'wpse_modify_product_post_type' );

function wpse_modify_product_post_type( $args ) {
     $args['supports'][] = 'revisions';

     return $args;
}

add_filter( 'woocommerce_product_subcategories_args', 'remove_uncategorized_category' );
function remove_uncategorized_category( $args ) {
  $uncategorized = get_option( 'default_product_cat' );
  $args['exclude'] = $uncategorized;
  return $args;
}

?>