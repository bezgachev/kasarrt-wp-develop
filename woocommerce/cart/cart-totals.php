<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
	<?php do_action( 'woocommerce_before_cart_totals' ); ?>
	<div class="shopping-cart__total_container">


		<div class="cart_totals__text">
			<div class="cart_totals__text_title">Предварительная стоимость:</div>
				<?php
					$total_price = WC()->cart->get_cart_total();
					$notag_total_price = strip_tags($total_price);
					$total_price_space = number_format((int)$notag_total_price, 0, '', '&nbsp;');
				?>
				<div class="cart_totals__text_sum"><?php echo $total_price_space; ?></div>
			</div>
		</div>
		<a href="<?php echo wc_get_checkout_url() ; ?>" class="checkout-button wc-forward btn">оформить заказ</a>



		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>