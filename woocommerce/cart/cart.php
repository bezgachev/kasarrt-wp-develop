<?
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>
<h1 class="shopping-title container">Корзина</h1>
<section class="shopping-cart container">
	<div class="shopping-cart__wrapper">
		<form class="woocommerce-cart-form" action="<? echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<? do_action( 'woocommerce_before_cart_table' ); ?>
			<? do_action( 'woocommerce_before_cart_contents' ); ?>
			<div class="showcase showcase__name">
				<!-- Фото -->
				<div>Товар</div>
				<!-- Oписание -->
				<div></div>
				<!-- Количество -->
				<div>Количество</div>
				<!-- Итого -->
				<div>Итого</div>
			</div>

					

			<?
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<div class="woocommerce-cart-form__contents showcase <? echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<?
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s" class="showcase__img">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>

						<div class="showcase__details details" data-title="<? esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<div class="details__title">
								<?
								if ( ! $product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
								} else {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								} ?>
							</div>

							<? 
							$product_article = $_product->sku;


							?>
							<div class="details__article">&nbsp;<? echo $product_article; ?></div>
							<div class="details__descr">
                                <div class="details__descr_color">Цвет:</div>
                                <div class="details__descr_img"><img src="<? echo get_template_directory_uri(); ?>/assets/img/color/<? echo $cart_item['name_img']; ?>.png" alt="img-material"></div>
                                <div class="details__descr_subtitle"><? echo $cart_item['color']; ?></div>
                            </div>
								<? do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>

						</div>


 

						<div class="showcase__count">
							<div class="showcase__count_quantity">
								<?
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
							</div>

							<? $quantity_product = $cart_item['quantity'];
								if ($quantity_product > 1) {
									echo '<div class="showcase__count_price">';
									$item_quantity = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									$item_quantity_text = strip_tags($item_quantity);
									$item_quantity_space = number_format((int)$item_quantity_text, 0, '', ' ');
									echo 'от&nbsp;<span>'. $item_quantity_space .'</span>&nbsp;₽&nbsp;/&nbsp;шт.';
									echo '</div>';
								}
							?>
							


						</div>

						<div class="showcase__sum">
							<?
								$item_subtotal = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								$item_subtotal_text = strip_tags($item_subtotal);
								$item_subtota_space = number_format((int)$item_subtotal_text, 0, '', ' ');
								echo $item_subtota_space; ?>
						</div>


						<div class="product-remove">
						<?
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_html__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								),
								$cart_item_key
							);
							?>
						</div>


					</div>
					<?
				}
			}
			?>

					<? do_action( 'woocommerce_cart_contents' ); ?>

					<div class="actions d-hide">
						<? /* if ( wc_coupons_enabled() ) { ?>
							<div class="coupon">
								<label for="coupon_code"><? esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<? esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<? esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><? esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
								<? do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
						<? } */?>

						<button type="submit" class="button" name="update_cart" value="<? esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><? esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
						<? do_action( 'woocommerce_cart_actions' ); ?>
						<? wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
					</div>

					<? do_action( 'woocommerce_after_cart_contents' ); ?>
				
			
			<? do_action( 'woocommerce_after_cart_table' ); ?>
		</form>
		<hr>

		<?
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
		?>
		<? do_action( 'woocommerce_before_cart_collaterals' ); ?>




	</div>
</section>
<? woo_recently_viewed_product(); ?>
<? do_action( 'woocommerce_after_cart' ); ?>
