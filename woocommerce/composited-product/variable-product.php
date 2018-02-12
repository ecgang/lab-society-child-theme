<?php
/**
 * Composited Variable Product template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/composited-product/variable-product.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version  3.4.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;



?><div class="details component_data" data-price="0" data-regular_price="0" data-product_type="variable" data-product_variations="<?php echo esc_attr( json_encode( $product_variations ) ); ?>" data-custom="<?php echo esc_attr( json_encode( $custom_data ) ); ?>"><?php

	/**
	 * woocommerce_composited_product_details hook.
	 *
	 * @since 3.2.0
	 *
	 * @hooked wc_cp_composited_product_excerpt - 10
	 */
	do_action( 'woocommerce_composited_product_details', $product, $component_id, $composite_product );

	?><table class="variations" cellspacing="0">
			<?php $attribute_keys = array_keys( $attributes ); ?>
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<?php 
					$i = substr($attribute_name, -1);
						$attribute_name_num = '_cmb2_attribute_'.$i;

						$custom_name = get_post_meta( $product->id,$attribute_name_num,true);

					?>
					<tr>
						<td class="label">
							<label for="<?php echo sanitize_title( $attribute_name ); ?>">
								<?php 
								    
									if ($custom_name != '') {
									    echo $custom_name;
									}
									else{
										echo wc_attribute_label( $attribute_name );
										
									}
								?>
								
							</label>
						</td>
						</td>
					<td class="value"><?php

						$selected = isset( $_REQUEST[ 'wccp_attribute_' . sanitize_title( $attribute_name ) ][ $component_id ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'wccp_attribute_' . sanitize_title( $attribute_name ) ][ $component_id ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );

						wc_dropdown_variation_attribute_options( array(
							'options'   => $options,
							'attribute' => $attribute_name,
							'name'      => 'wccp_attribute_' . sanitize_title( $attribute_name ) . '[' . $component_id . ']',
							'product'   => $product,
							'selected'  => $selected,
						) );

						echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce-composite-products' ) . '</a>' : '';

					?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table><?php

	/**
	 * woocommerce_composited_product_add_to_cart hook.
	 *
	 * Useful for outputting content normally hooked to 'woocommerce_before_add_to_cart_button'.
	 */
	do_action( 'woocommerce_composited_product_add_to_cart', $product, $component_id, $composite_product );

	?><div class="single_variation_wrap component_wrap"><?php

		/**
		 * woocommerce_composited_single_variation hook. Used to output the cart button and placeholder for variation data.
		 *
		 * @since 3.4.0
		 *
		 * @hooked wc_cp_composited_single_variation - 10
		 */
		do_action( 'woocommerce_composited_single_variation', $product, $component_id, $composite_product );

	?></div>
</div>
