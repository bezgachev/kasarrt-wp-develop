<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>


<?php
if ( $order ) :

	do_action( 'woocommerce_before_thankyou', $order->get_id() );
	?>

		<section class="bread-crumb container">
			<a href="index.html">Главная</a>
			<span>Оформление заказа</span>
		</section>
		<section class="posted">
			<h1 class="posted__title">Ваш Заказ оформлен, спасибо!</h1>
			<h2 class="posted__number">Номер заказа: <?php echo $order->get_order_number(); ?></h2>
			<p class="posted__text">Мы перезвоним Вам в ближайшее время для уточнения деталей заказа и способа оплаты</p>
			<i class="fly"></i>
		</section>


<?php endif; ?>