<?
/*
Template Name: Услуги
Template Post Type: page
 */
?>

<? get_header();?>
<section class="bread-crumb container">
	<a href="index.html">Главная</a>
	<span>Услуги</span>
</section>
<section class="container">
	<div class="custom-project">
		<div class="custom-project__text">
			<h1>
				Мебельная продукция по индивидуальному
				проекту
			</h1>
			<h2>
				Запускаем «перестройку»
				<br>
				<span class="typed"></span>
			</h2>
			<p>
				#cпальни #гостиные #детские #прихожие #мебель для студентов #home #office
			</p>
			<div class="custom-project__img">
				<video muted="muted" autoplay loop>
					<source src="<? echo get_template_directory_uri(); ?>/assets/img/uslugi-cub.mp4" type="video/mp4">
				</video>
			</div>
		</div>
	</div>
</section>

<section class="services container">
	<div class="services__item"></div>
	<div class="services__item"></div>
	<div class="services__item"></div>
	<div class="services__item"></div>
	<div class="services__item"></div>
</section>
<section class="container decision">
	<h2>Подскажем, какое решение станет идеальным именно для вас!</h2>
	<div class="decision__wrapper">
		<div class="decision__item">
			<div class="decision__img">
				<img src="<? echo get_template_directory_uri(); ?>/assets/img/wardrobe.gif" alt="">
			</div>
			<p>Меняем стандартные формы готового решения: цвет, размер, фурнитуру по вашему желанию.</p>
		</div>
		<div class="decision__item">
			<div class="decision__img">
				<img src="<? echo get_template_directory_uri(); ?>/assets/img/table.jpg" alt="">
			</div>
			<p>Разработаем мебель по индивидуальным размерам. Проектируем, производим и устанавливаем.</p>
		</div>
	</div>
</section>

<section class="wave">
	<div class="wave__body gray">
		<div class="container panorama">
			<div class="panorama__text">
				<h2 class="panorama__text_title">Посмотрите 3D панораму,
					как мы обустроили квартиру</h2>
				<div class="panorama__text_descr">
					Расслабьтесь и представьте дом, в котором вы мечтаете жить. А теперь в любой удобной для вас
					форме расскажите нам.
					Дизайнер разработает для вас индивидуальный проект, который будет изготовлен на мебельной
					фабрике Мастер. Доверьте нам
					все сложные вопросы и наслаждайтесь приятным предвкушением от «преображения» вашей квартиры!
				</div>
				<ul class="panorama__text_list">
					<li>Профессиональные дизайнеры</li>
					<li>Быстрые сроки изготовления</li>
					<li>Фабричное качество</li>
					<li>Даем гарантию на мебель</li>
				</ul>
			</div>
			<div class="panorama__video">
				<iframe sandbox="allow-same-origin allow-forms allow-popups allow-scripts allow-pointer-lock"
					class="_3Xz9Z" title="Embedded Content" name="htmlComp-iframe" width="100%" height="100%"
					allow="fullscreen" data-src="" src="https://trilucha.ru/images/prj19/turHimki/index.html">
				</iframe>
			</div>
		</div>
	</div>
</section>
<? get_footer();?>