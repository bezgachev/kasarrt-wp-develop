<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">-->
	<?wp_head();?>
</head>
<body>
	<header class="header">
		<div class="container header__menu">
			<a href="<? echo home_url(); ?>" class="header__logo">
				<img src="<? $custom_logo_url = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full'); echo $custom_logo_url[0];  ?>"
					alt="kasarrt-logo">
			</a>
			<? get_product_search_form(); ?>
			<div class="header__city">
				<div class="header__city_phone">
					<p>Казань:</p>
					<? kazan_tel(); ?>
				</div>
				<div class="header__city_phone">
					<p>Москва:</p>
					<? moscow_tel(); ?>
				</div>
			</div>
			<div class="header__social">
				<? social_messeng(); ?>
			</div>

			<a href="<? echo wc_get_cart_url(); ?>" class="header__basket">
				<span class="header__basket_img">
					<img src="<? echo get_template_directory_uri(); ?>/assets/icons/card.svg" alt="icon-cart">
				</span>
				<span class="header__basket_text">Корзина товаров</span>
			</a>
			<button class="hamburger"></button>
		</div>
		<hr>
		<nav class="header__nav nav container" id="mobile">
			<div class="mobile__form">
			<form role="search" method="get" class="woocommerce-product-search mobile-form" action="<? echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="woocommerce-product-search-field-<? echo isset( $index ) ? absint( $index ) : 0; ?>"><? esc_html_e( 'Search for:', 'woocommerce' ); ?></label>
				<input type="search" autocomplete="off" id="woocommerce-product-search-field-<? echo isset( $index ) ? absint( $index ) : 0; ?>" class="mobile-field" placeholder="<? echo esc_attr__( 'Search products&hellip;', 'woocommerce' ); ?>" value="<? echo get_search_query(); ?>" name="s" />
				<button type="submit" value="<? echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" class="mobile-submit"></button>
				<input type="hidden" name="post_type" value="product" />
			</form>
				<button class="nav__exit"></button>
			</div>

			<? wp_nav_menu(array(
				'theme_location'  => 'header-menu',
				'menu_id'      => false,
				'container'       => false, 
				'container_class' => false, 
				'menu_class'      => false,
				'items_wrap'      => '%3$s',
				'order' => 'ASC',      
				'walker' => new menu_header()   
			)); ?>

			<div id="cursor"></div>
			<div class="mobile__city">
				<div class="mobile__city_phone">
					<p>Казань:</p>
					<? kazan_tel(); ?>
				</div>
				<div class="mobile__city_phone">
					<p>Москва:</p>
					<? moscow_tel(); ?>
				</div>
			</div>
			<div class="mobile__social">
				<? social_messeng(); ?>
			</div>
		</nav>
	</header>
	<main>