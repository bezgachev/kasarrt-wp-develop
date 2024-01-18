<?
/**
* The template for displaying the footer
*
* Contains the closing of the #content div and all content after.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package weblitex
*/

?>

</main>
<? if ( is_product() ) { ?>
	<div class="notices_for_user_wrapper">
		<h4>Товар добавлен в корзину</h4>
		<div class="notices_for_user_text"></div>
		<div class="notices_for_user_price"></div>
		<hr>
		<div class="notices_for_user_count">В корзине <span></span> товаров</div>
		<div class="notices_for_user_result">Предварительная стоимость корзины <span></span></div>
	</div>
<? } ?>

<footer class="footer">
	<div class="container footer__body">
		<div class="footer__descr">
			<div class="footer__logo">
				<img src="<? $custom_logo_url = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full'); echo $custom_logo_url[0];?>" alt="kasarrt-logo">
			</div>
			<div class="footer__city">
				<div class="footer__city_phone">
					<p>Казань:</p>
					<? kazan_tel();?>
				</div>
				<div class="footer__city_phone">
					<p>Москва:</p>
					<? moscow_tel();?>
				</div>
			</div>
			<div class="footer__descr_letter-from"><button class="btn-modal-call">Написать письмо</button></div>
		</div>
		<div class="footer__catalog akkardion">
			<div class="akkardion__wrapper">
				<h3 class="akkardion__title">
					Каталог товаров
				</h3>

				<? wp_nav_menu(array(
					'theme_location' => 'catalog-main',
					'menu_id' => false,
					'container' => false,
					'container_class' => false,
					'menu_class' => false,
					'items_wrap' => '<ul class="akkardion__text footer__catalog_link">%3$s</ul>',
					'order' => 'ASC',
					'walker' => new menu_footer(),
				));?>

			</div>
		</div>
		<div class="footer__catalog akkardion">
			<div class="akkardion__wrapper">
				<h3 class="akkardion__title">
					Помощь
				</h3>

				<? wp_nav_menu(array(
					'theme_location' => 'footer-help',
					'menu_id' => false,
					'container' => false,
					'container_class' => false,
					'menu_class' => false,
					'items_wrap' => '<ul class="akkardion__text">%3$s</ul>',
					'order' => 'ASC',
					'walker' => new menu_footer(),
				));?>

			</div>
			<div class="footer__social">
				<? social_messeng();?>
			</div>
		</div>
		<div class="footer__social-mob">
			<? social_messeng();?>
		</div>
	</div>
	</div>
	<hr>
	<div class="container footer__info">
		<div class="footer__info_offer">
			<p>© 2016 –
				<? echo date('Y'); ?>, ООО “Касар”
			</p>
			<a href="" target="_blank">Политика конфиденциальности</a>
			<p>Информация на сайте не является публичной офертой</p>
		</div>
		<div class="footer__info_img">
			<img src="<? echo get_template_directory_uri(); ?>/assets/img/supplier-portal.png" alt="">
		</div>
		<div class="footer__info_weblitex">
			<a class="weblitex" target="_blank"
				href="https://weblitex.ru/?utm_source=clients&utm_medium=referal&utm_campaign=kasarrt.ru">
				<span>Разработка сайтов «Лайтекс»</span>
			</a>
		</div>
	</div>
</footer>
<? echo do_shortcode('[call_form]');?>
<? wp_footer(); ?>

</body>
</html>