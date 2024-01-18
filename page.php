<? get_header(); ?>
<section class="first-screen">
    <div class="first-screen__content">
        <div class="container">
            <div class="first-screen__items">
                <p class="first-screen__text">Мебельная фабрика</p>
                <h1 class="first-screen__title">Мебель для дома, бизнеса и&nbsp;государственных учреждений</h1>
                <ul class="first-screen__descr">
                    <li>Производство полного цикла</li>
                    <li>Доставка и сборка</li>
                    <li>Разработка дизайн-проектов</li>
                    <li>Бесплатный выезд на замер</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="first-screen__img"><img src="<? echo get_template_directory_uri(); ?>/assets/img/bg-main.png" alt="Мебель для дома, бизнеса и государственных учреждений"></div>
</section>
<section class="catalog container" id="catalog_url">
    <h2>Каталог продукции</h2>

    <? wp_nav_menu(array(
        'theme_location'  => 'catalog-main',
        'menu_id'      => false,
        'container'       => false, 
        'container_class' => false, 
        'menu_class'      => false,
        'items_wrap'      => '<div class="catalog-products">%3$s</div>',
        'order' => 'ASC',      
        'walker' => new catalog_main()   
    )); ?> 

</section>
<section class="wave trigger">
    <div class="wave__body">
        <div class="container">
            <h2>наши преимущества</h2>
            <div class="trigger__body">
                <div class="trigger__item">
                    <h3>Собственное производство</h3>
                    <p>Современное оборудование европейских производителей</p>

                </div>
                <div class="trigger__item">
                    <h3>Скидки
                        от объёма</h3>
                    <p>Выгодные цены
                        для постоянных клиентов</p>
                </div>
                <div class="trigger__item">
                    <h3>Комплексные
                        решения</h3>
                    <p>Мебель для бизнеса, дома
                        и учреждений</p>
                </div>
                <div class="trigger__item">
                    <h3>Заводская
                        гарантия</h3>
                    <p>Даём гарантию
                        на всю продукцию</p>
                </div>
                <div class="trigger__item">
                    <h3>Быстрое
                        изготовление</h3>
                    <p>Максимально быстрые
                        сроки изготовления</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="last">
    <h2>Последние работы</h2>
    <div class="last__wrapper">
        <div class="last-prev"><span class="swiper-prev"></span></div>
        <div class="last-next"><span class="swiper-next"></span></div>

        <div class="last__slider swiper">
            <div class="last__slider_wrapper swiper-wrapper">

                <? $img_gallery = get_field('poslednie_raboty_gallery'); ?>
                <? if ($img_gallery) : ?>
                    <? foreach ($img_gallery as $img) : ?>
                        <? if ($img) : ?>
                            <? echo '<div class="last__slider_img swiper-slide"><img src="' . esc_url($img['sizes']['medium']) . '" alt="last-job"></div>'; ?>
                        <? endif; ?>
                    <? endforeach; ?>
                <? endif; ?>

            </div>
        </div>
    </div>
</section>
<section class="shop container">
    <div class="shop__content_descr">
        <h2>Интернет-магазин
            мебели KASAR
        </h2>
        <p>Команда интернет-магазина KASAR поможет Вам подобрать самый подходящий вариант и воплотить в
            жизнь
            Ваши мечты об
            интерьере. Создавайте обстановку вместе с нами, которая будет делать будни ярче!</p>
        <p>Мы открыли собственное производство и сотрудничаем с лидерами отрасли, чтобы создавать стильную
            мебель, которая
            прослужит долго. Главным принципом KASAR является индивидуальный подход к каждому клиенту.</p>
    </div>

    <div class="shop__gallery sticky">
        <? $img_gallery = get_field('proizvodstvo_gallery'); ?>
            <? if($img_gallery) { ?>
                <div class="shop__slider swiper">
                    <div class="shop__nav">
                        <div class="swiper-prev shop-prev"></div>
                        <div class="swiper-next shop-next"></div>
                    </div>
                    <div class="shop__slider_wrapper swiper-wrapper">
                      
                            <? foreach ($img_gallery as $img) : ?>
                                <? if ($img) : ?>
                                    <? echo '<div class="shop__slider_img swiper-slide"><img src="' . esc_url($img['sizes']['medium']) . '" alt="proizvodstvo"></div>'; ?>
                                <? endif; ?>
                            <? endforeach; ?>
                        
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            <? } ?>
    </div>

    <div class="shop__content_consultation">
        <h3>Бесплатная консультация специалиста </h3>
        <p>Вы можете абсолютно бесплатно заказать выезд специалиста в удобное для Вас время для консультации
            и замера помещения.</p>
        <p>Он проинформирует по интересующим вопросам и&nbsp;предложит подходящие варианты мебели, от
            недорогих
            моделей до премиум-класса, исходя из&nbsp;бюджета и Ваших пожеланий.</p>
        <button class="btn btn-modal-call">Написать письмо</button>
    </div>
</section>
<section class="wave client">
    <div class="wave__body gray">
        <div class="container">
            <h2>Наши клиенты</h2>
            <div class="client__body">
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-sber.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-vert.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-tat.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-tattel.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-mosoba.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-dev.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-ener.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-akk.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/taif.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-mosk.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-ross.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-yad.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-one.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-vtb.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-elec.svg" alt="">
                </div>
                <div class="client__item">
                    <img src="<? echo get_template_directory_uri(); ?>/assets/icons/client/logo-olimp.svg" alt="">
                </div>
            </div>
        </div>
    </div>
</section>



















<? get_footer(); ?>



