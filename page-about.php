<?
/*
Template Name: О компании
Template Post Type: page
*/

?>
<? get_header(); ?>

<section class="bread-crumb container">
	<a href="index.html">Главная</a>
	<span>О нас</span>
</section>
<section class="container about">
	<div class="about__wrapper">
		<div class="about__text">
			<h1>О компании</h1>
			<h2 class="about__text_subtitle"><? echo get_field('nasha_czel'); ?></h2>
			<p class="about__text_descr"><? echo get_field('opisanie_k_nashej_czeli'); ?></p>
		</div>
		<div class="about__img sticky">
			<? 
				$image = get_field('foto_komandy');
				$size = 'medium'; // (thumbnail, medium, large, full или ваш размер)
				if( $image ) {
					echo wp_get_attachment_image( $image, $size );
				}
			?>
		</div>

	</div>

</section>
<section class="container about-box">
	<div class="about-box__item">
		<h3>Дизайн</h3>
		<hr>
		<p><? echo get_field('dizajn'); ?></p>
	</div>
	<div class="about-box__item">
		<h3>Цены</h3>
		<hr>
		<p><? echo get_field('czeny'); ?></p>
	</div>

	<div class="about-box__item">
		<h3>Материалы</h3>
		<hr>
		<p><? echo get_field('materialy'); ?></p>
	</div>
	<div class="about-box__item">
		<h3>Партнеры</h3>
		<hr>
		<p><? echo get_field('partnery'); ?></p>
	</div>
	<div class="about-box__item">
		<h3>Мебель со вкусом</h3>
		<hr>
		<p><? echo get_field('mebel_so_vkusom'); ?></p>
	</div>
	<div class="about-box__item">
		<h3>Изменения — это просто</h3>
		<hr>
		<p><? echo get_field('izmeneniya_eto_prosto'); ?></p>
	</div>
	<div class="about-box__item">
		<h3>Объединяем все нужное</h3>
		<hr>
		<p><? echo get_field('obedinyaem_vse_nuzhnoe'); ?></p>
	</div>
</section>


<? $img_gallery = get_field('sertifikaty_gallery'); ?>
<? if ($img_gallery) : ?>
	<section class="wave about-cert">
	<div class="wave__body gray">
		<div class="container">
			<h2>Сертификаты</h2>
			<div class="about-cert__slider swiper">
				<div class="about-cert__slider_wrapper swiper-wrapper">

				<? foreach ($img_gallery as $img) : ?>
					<? if ($img) : ?>
						<? echo '<div class="about-cert__slider_slide swiper-slide"><img src="' . esc_url($img['sizes']['medium']) . '" alt="certificates"></div>'; ?>
					<? endif; ?>
				<? endforeach; ?>

				</div>
			</div>
		</div>
	</div>
	</section>

	<section class="modal-cert">
	<div class="popup-cert__btn">
		<div class="swiper-prev"></div>
		<div class="swiper-next"></div>
	</div>
	<div class="popup-cert__slider swiper">
		<div class="popup-cert__slider_wrapper swiper-wrapper">
			<? foreach ($img_gallery as $img) : ?>
				<? if ($img) : ?>
					<? echo '<div class="popup-cert__slider_slide swiper-slide"><img src="' . esc_url($img['sizes']['large']) . '" alt="certificates"></div>'; ?>
				<? endif; ?>
			<? endforeach; ?>
		</div>
	</div>
</section>







<? endif; ?>




<? get_footer(); ?>