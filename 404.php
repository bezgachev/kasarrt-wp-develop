<?
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package weblitex
 */

get_header(); ?>
<div class="container">
<section class="posted search-result posted-404">
	<h1 class="posted__title">Страница не найдена</h1>
	<p class="posted__text">К сожалению, такая страница не существует. Вероятно, она была удалена, либо ее здесь никогда не было</p>
	<i class="fly" style="transform: translate(-9.49219px, -48.4868px);"></i>
	<a href="<? echo get_home_url(); ?>">
		<div class="btn">Перейти на главную</div>
	</a>
</section>
</div>
<? get_footer(); ?>