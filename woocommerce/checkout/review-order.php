<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>
<!-- <div class="checkout__items sticky">
	<div class="checkout__items_title">
		<h3>Ваш заказ</h3>
		<p>23</p>
	</div>

	<div class="checkout__item request">
		<div class="request__img">
			<img width="300" height="400"
				src="https://test.sandrahometextile.ru/wp-content/uploads/2022/05/mav03491-scaled.jpg"
				class="attachment-woo-thumbnail-product size-woo-thumbnail-product" alt=""
				loading="lazy">
		</div>
		<div class="request__descr">
			<div>
				<div class="request__descr_title">Стол офисный С 1.06, компактный с выдвижной полкой
				</div>
				<div class="request__descr_product">
					<div class="product__color">
						<img src="img/color/woody/bodega.png" alt="">
					</div>
					<div class="product__count">19</div>
				</div>
			</div>
			<div class="request__descr_sum">106 500</div>
		</div>
	</div>



	<div class="checkout__item payment">
		<div class="payment__total">
			<div class="payment__total_title">Итого:</div>
			<div class="payment__total_sum">178 800</div>
		</div>
		<a href="https://test.sandrahometextile.ru/checkout/" class="checkout-button wc-forward btn">оформить заказ</a>
		<p class="payment__text">Нажимая кнопку “Подтвердить заказ”, Вы соглашаетесь с обработкой <a href="">персональных данных</a></p>
	</div>
</div> -->

<div class="checkout__items sticky">
	<div class="checkout__items_title">
		<h3>Ваш заказ</h3>
		<?php 
			$cart_count = WC()->cart->get_cart_contents_count();
		?>
		<p><?php echo $cart_count;
			if ($cart_count == 1) { echo '&nbsp;товар';}
			if ($cart_count >= 2 && $cart_count <= 4) { echo '&nbsp;товара';}
			if ($cart_count >= 5) { echo '&nbsp;товаров';}
		?></p>
	</div>

	<?php
	

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key ); ?>


		<?php

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>
		
		<div class="checkout__item request">
			<div class="request__img">
				<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_image(), $cart_item, $cart_item_key ) ); ?>
			</div>
			<div class="request__descr">
				<div>
					<div class="request__descr_title">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
					</div>
					<div class="request__descr_product">
						<div class="product__color">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/color/<?php echo $cart_item['name_img']; ?>.png" alt="img-material">
						</div>
						<div class="product__count">
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', '' . sprintf( '%s', $cart_item['quantity'] ) . '', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
				</div>
				<div class="request__descr_sum"> 
					<?php 
						$item_subtotals = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						$notag_item_subtotal = strip_tags($item_subtotals);
						$item_subtotal = number_format((int)$notag_item_subtotal, 0, '', ' ');
						echo $item_subtotal;
					?>
				</div>
			</div>
		</div>
			<?php
		}
	}

	
	?>
	<div class="checkout__item payment">

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<?php 
			$wc_cart_totals = WC()->cart->get_cart_total();
			$pay_price = preg_replace('/<(.|\n)*?>/', '', $wc_cart_totals);
			$pay_price_space = number_format((int)$pay_price, 0, '', ' '); 
		?>
		<div class="payment__total">
			<div class="payment__total_title">Итого:</div>
			<div class="payment__total_sum"><?php echo $pay_price_space; ?></div>
		</div>
		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="checkout-button wc-forward btn" name="woocommerce_checkout_place_order" id="place_order" value="Подтвердить заказ" data-value="Подтвердить заказ">Подтвердить заказ</button>' ); ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
		<?php echo '<p class="payment__text">Нажимая кнопку “Подтвердить заказ”, Вы соглашаетесь с обработкой <a href="">персональных данных</a></p>'; ?>
	</div>
	
	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</div>
<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>
