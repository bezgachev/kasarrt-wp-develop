<?
/*
Template Name: Альбомы
Template Post Type: page
*/
?>

<? get_header(); ?>
<section class="bread-crumb container">
	<a href="index.html">Главная</a>
	<span>Альбомы</span>
</section>

<section class="album ">
	<div class="container"><h1>Онлайн каталог</h1></div>
	
	<div class="album-catalog">
	<? the_content(); ?>
	</div>
</section>
<? get_footer(); ?>