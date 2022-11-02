<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button" id="cart-perso">

	<?php $template = get_field( 'template_produit' );
	if ( $template !== 'Gift Card' ) :
		?>
        <p class="participant">Nombre de participant.e.s :</p>
	<?php endif; ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>
	<?php if ( $template !== 'Gift Card' ) : ?>
        <div class="quantity-container">
            <div class="minus" id="minus">-</div>
			<?php woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
					// WPCS: CSRF ok, input var ok.
				)
			); ?>
            <div class="plus" id="plus">+</div>
        </div>
	<?php endif; ?>
    <p class="options" id="options">En options :</p>
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	<?php do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	if ( $template !== 'Gift Card' ) :
		do_action( 'woocommerce_after_single_product_summary' );
	endif;
	?>
	<?php if ( $template !== 'Gift Card' ) { ?>
        <button type="submit" class="single_add_to_cart_button button alt">Je valide mon voyage</button>
	<?php } else { ?>
        <button type="submit" class="single_add_to_cart_button button alt" id="gift__btn">Ajouter au panier</button>
	<?php } ?>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

    <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>"/>
    <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>"/>
    <input type="hidden" name="variation_id" class="variation_id" value="0"/>
</div>