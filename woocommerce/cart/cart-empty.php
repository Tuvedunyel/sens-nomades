<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
//do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) :
	$return = get_field( 'retour_aux_voyages' );
	?>
    <section class="empty-cart">
		<h3>Il semblerait que votre panier soit vide !</h3>
        <strong>N'hésitez à pas à aller visiter la page de nos voyages en cliquant sur le lien ci-dessous</strong>
        <a href="<?= esc_url( $return['url'] ); ?>" class="btn__return-voyages"><?= esc_html( $return['title'] ); ?></a>
    </section>
<?php endif; ?>
