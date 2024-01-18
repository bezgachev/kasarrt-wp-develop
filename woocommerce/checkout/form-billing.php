<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="checkout__item">
	<h3>Детали заказа</h3>
	<?php /*if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php esc_html_e( 'Billing details', 'woocommerce' ); ?></h3>

	<?php endif; */?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		// foreach ( $fields as $key => $field ) {
		// 	woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		// }
		woocommerce_form_field(
			"billing_first_name",
			$checkout->checkout_fields['billing']['billing_first_name'], 
			$checkout->get_value( 'billing_first_name' )
		);
		woocommerce_form_field(
			"billing_phone",
			$checkout->checkout_fields['billing']['billing_phone'], 
			$checkout->get_value( 'billing_phone' )
		);
		woocommerce_form_field(
			"billing_email",
			$checkout->checkout_fields['billing']['billing_email'], 
			$checkout->get_value( 'billing_email' )
		);
		woocommerce_form_field(
			"billing_country",
			$checkout->checkout_fields['billing']['billing_country'], 
			$checkout->get_value( 'billing_country' )
		);
		woocommerce_form_field(
			"billing_city",
			$checkout->checkout_fields['billing']['billing_city'], 
			$checkout->get_value( 'billing_city' )
		);
		woocommerce_form_field(
			"billing_company",
			$checkout->checkout_fields['billing']['billing_company'], 
			$checkout->get_value( 'billing_company' )
		);
		?>


	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
