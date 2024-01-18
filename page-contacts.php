<?
/*
Template Name: Контакты
Template Post Type: page
*/
?>

<? get_header(); ?>

<section class="bread-crumb container">
	<a href="index.html">Главная</a>
	<span>Контакты</span>
</section>

<section class="contacts container">
	<h1>Контактная информация</h1>
	<div class="contacts__wrapper">
		<div class="contacts__info">
			<div class="select-js">
				<div class="option-js-active">Офис, г.Москва</div>
				<div class="options-js">
					<?
					
					$tel_msw = get_option('office_moscow_tel');
					$part_msw1 = mb_substr($tel_msw, 1, 3, 'UTF8');
					$part_msw2 = mb_substr($tel_msw, 4, 3, 'UTF8');
					$part_msw3 = mb_substr($tel_msw, 7, 2, 'UTF8');
					$part_msw4 = mb_substr($tel_msw, 9, 2, 'UTF8');
					$part_all_msw = '+7 (' . $part_msw1 . ') ' . $part_msw2 . '-' . $part_msw3 . '-' . $part_msw4;

					$tel_kz = get_option('office_kazan_tel');
					$part_kz1 = mb_substr($tel_kz, 1, 3, 'UTF8');
					$part_kz2 = mb_substr($tel_kz, 4, 3, 'UTF8');
					$part_kz3 = mb_substr($tel_kz, 7, 2, 'UTF8');
					$part_kz4 = mb_substr($tel_kz, 9, 2, 'UTF8');
					$part_all_kz = '+7 (' . $part_kz1 . ') ' . $part_kz2 . '-' . $part_kz3 . '-' . $part_kz4;

					$tel_prod = get_option('production_tel');
					$part_prod1 = mb_substr($tel_prod, 1, 3, 'UTF8');
					$part_prod2 = mb_substr($tel_prod, 4, 3, 'UTF8');
					$part_prod3 = mb_substr($tel_prod, 7, 2, 'UTF8');
					$part_prod4 = mb_substr($tel_prod, 9, 2, 'UTF8');
					$part_all_prod = '+7 (' . $part_prod1 . ') ' . $part_prod2 . '-' . $part_prod3 . '-' . $part_prod4;

					?>
					<span class="option-js msw"
						tel="<? echo $part_all_msw; ?>"
						telhref="<? echo $tel_msw; ?>"
						mode="<? echo get_option('office_moscow_work_time'); ?>"
						addr="<? echo get_option('office_moscow_addr'); ?>"
						geo="<? echo get_option('office_moscow_geo'); ?>"
						2gis="<? echo get_option('office_moscow_2gis'); ?>">
						<? echo get_option('office_moscow_text'); ?></span>

					<span class="option-js kz"
						tel="<? echo $part_all_kz; ?>"
						telhref="<? echo $tel_kz; ?>"
						mode="<? echo get_option('office_kazan_work_time'); ?>"
						addr="<? echo get_option('office_kazan_addr'); ?>"
						geo="<? echo get_option('office_kazan_geo'); ?>"
						2gis="<? echo get_option('office_kazan_2gis'); ?>">
						<? echo get_option('office_kazan_text'); ?></span>

					<span class="option-js prod"
						tel="<? echo $part_all_prod; ?>"
						telhref="<? echo $tel_prod; ?>"
						mode="<? echo get_option('production_time'); ?>"
						addr="<? echo get_option('production_addr'); ?>"
						geo="<? echo get_option('production_geo'); ?>"
						2gis="<? echo get_option('production_2gis'); ?>">
						<? echo get_option('production_text'); ?></span>
				</div>

			</div>
			<div class="contacts__info_tel">
				<a href="tel:+<? echo $tel_msw; ?>" id="tel"><? echo $part_all_msw; ?></a>
			</div>

			<div class="contacts__info_mail">
				<? $email = get_option('office_email'); ?>
				<a href="mailto:<? echo $email; ?>"><? echo $email; ?></a>
			</div>
			<span class="contacts__info_mode">Пн-Пт:&nbsp;<span id="mode"><? echo get_option('office_moscow_work_time'); ?></span>
			</span>
			<div class="contacts__info_map">
				<a href="<? echo get_option('office_moscow_2gis'); ?>" target="_blank" id="addr"><? echo get_option('office_moscow_addr'); ?></a>
			</div>
			
			<!-- <div class="contacts__info_production d-hide">
				<a href="<? echo get_option('production_2gis'); ?>" target="_blank" geo="<? echo get_option('production_geo'); ?>"><? echo get_option('production_addr'); ?></a>
			</div> -->
			<div class="contacts__info_social">
				<button class="btn btn-modal-call">Написать письмо</button>
				<div class="footer__social">
					<? social_messeng(); ?>
				</div>
			</div>

		</div>
		<div class="contacts__map">
			<div id="map"></div>
		</div>
	</div>
</section>

<? get_footer(); ?>