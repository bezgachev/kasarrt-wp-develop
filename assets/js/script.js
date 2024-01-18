// Header mouse ---------------------
// var cursor = document.getElementById('cursor');
// document.addEventListener('mousemove', function (e) {
//     var x = e.clientX;
//     cursor.style.left = x + "px";
// });


document.addEventListener('DOMContentLoaded', () => {
    const navLine = document.querySelector('#cursor'),
        navItem = document.querySelectorAll('.nav__link');
    navItem.forEach(el => {
        el.addEventListener('mouseenter', (e) => {
            const widthEl = e.currentTarget.clientWidth, // ширина наведенного элимента
                widthCursor = 134, // ширина курсова волны
                distanceFromCurrentLink = e.currentTarget.offsetLeft; // расстояние от края до текущей ссылки
            const stepBack = distanceFromCurrentLink - ((widthCursor - widthEl) / 2);
            navLine.style.transform = `scaleY(1)`;
            navLine.style.left = `${stepBack}px`;
        });
        el.addEventListener('mouseleave', () => {
            navLine.style.transform = `scaleY(0)`;
        });
    });
});

'use strict';



// Menu hamburger ----------------------------------------------
function burger() {
    const burger = document.querySelector('.hamburger');
    const mobExit = document.querySelector('.nav__exit');
    const navCatalog = document.querySelector('.nav-catalog');
    const menu = document.querySelector('#mobile');
    const menuLinks = document.querySelectorAll('.nav__link');

    burger.addEventListener('click', function () {
        menu.classList.toggle('open');
        document.querySelector('body').classList.add('stop-scrolling');

    });

    navCatalog.addEventListener('click', function () {
        this.classList.toggle('open');
        document.querySelector('.nav__submenu').classList.toggle('open');
    });

    mobExit.addEventListener('click', function () {
        menu.classList.toggle('open');
        document.querySelector('body').classList.remove('stop-scrolling');
    });


    menuLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            if (!(event.target.closest('#mobile'))) {
                menu.classList.remove('open');
            }
        })
    });

    document.addEventListener('click', (event) => {
        if (!(event.target.closest('#mobile') || event.target.closest('.hamburger') || event.target.closest('.nav-catalog'))) {
            menu.classList.remove('open');
            document.querySelector('body').classList.remove('stop-scrolling');
        }
    });
}
burger();

// Cлайдер ---------------------
function functionSlider() {
    new Swiper('.last__slider', {
        navigation: {
            nextEl: '.last-next',
            prevEl: '.last-prev',
        },
        // Скорость
        // speed: 800,
        initialSlide: 1,
        	// Слежка за видимыми слайдами
		watchSlidesProgress: true,
		// Добавление класса видимым слайдам
		watchSlidesVisibility: true,

        // Отключение функционала если слайдов меньше чем нужно
        watchOverflow: true,
        centeredSlides: true,
        slidesPerView: 1.2,
        spaceBetween: 9,
        breakpoints: {
            400: {
                centeredSlides: true,
                slidesPerView: 1.5,
                spaceBetween: 20,
            },
            800: {
                centeredSlides: true,
                slidesPerView: 2,
            },
            // when window width is >= 1230px
            1200: {
                centeredSlides: false,
                // Количество слайдов для показа
                slidesPerView: 2,
                // Отступ между слайдами
                spaceBetween: 30,
                // Бесконечный слайдер
                loop: true,
                // Кол-во дублирующих слайдов
                loopedSlides: 3,
            },
        },

    });
    // блок на странице корзины Вы смотрели
    new Swiper('.viewed__slider', {
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            // Буллеты
            type: 'bullets',
            clickable: true,
        },
        // Скорость
        speed: 500,
        // Отключение функционала если слайдов меньше чем нужно
        watchOverflow: true,
        slidesPerView: 1.5,
        // Количество пролистываемых слайдов
        slidesPerGroup: 1,
        spaceBetween: 12,
        breakpoints: {
            425: {
                slidesPerView: 2.4,
                slidesPerGroup: 2,
            },
            725: {
                slidesPerView: 3,
                slidesPerGroup: 3,
                spaceBetween: 15,
            },
            // when window width is >= 1230px
            992: {
                centeredSlides: false,
                // Количество слайдов для показа
                slidesPerView: 4,
                slidesPerGroup: 4,
                // Отступ между слайдами
                spaceBetween: 32,
                // Скорость
                speed: 800,
            },
        },
    });

    new Swiper('.shop__slider', {
        // Скорость
        speed: 800,
        // Отключение функционала если слайдов меньше чем нужно
        watchOverflow: true,
        navigation: {
            nextEl: '.shop-next',
            prevEl: '.shop-prev'
        },

        // Cмена прозрачности
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        // Навигация
        // Буллеты, текущее положение, прогрессбар
        pagination: {
            el: '.swiper-pagination',
            // Буллеты
            type: 'bullets',
            clickable: true,
        },
    });

    new Swiper('.popup-cert__slider', {
        slidesPerView: 1,
        slidesPerGroup: 1,
        effect: 'fade',
        // Бесконечный слайдер
        loop: true,
        autoHeight: true,
        // Обновить свайпер
        // при изменении элементов слайдера
        observer: true,
        observeParents: true,
        observeSlideChildren: true,

        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev'
        },

        thumbs: {
            // Свайпер с мениатюрами
            // и его настройки
            swiper: {
                el: '.about-cert__slider',
                slidesPerView: 4.8,
                spaceBetween: 13,
                // Бесконечный слайдер
                loop: true,
                // Скорость
                speed: 6000,
                observer: true,
                observeParents: true,
                observeSlideChildren: true,

                // Автопрокрутка
                autoplay: {
                    enabled: true,
                    delay: 1,
                },
            }
        },

    });
}

if (document.querySelectorAll(".swiper-slide").length) {
    functionSlider();
}


// Footer Аккардион ---------------------
$(function () {
    var akkardionContentClass = '.akkardion__wrapper';
    akkardionText = '.akkardion__text';
    akkardionContent = $('' + akkardionContentClass + '');
    akkardionContentControl = '.start' + '' + akkardionContentClass + '';


    $(window).on('load resize', function () {
        if (document.documentElement.clientWidth < 690) {
            akkardionContent.addClass("start");
            akkardionContent.removeClass("active");
        } else {
            akkardionContent.removeClass("start");
            akkardionContent.removeClass("active");
            $('.akkardion__text').removeAttr('style');
        }
    });

    $('body').on("click", '' + akkardionContentControl + '', function () {
        //Если не текущий клик (ключевое задание по функции) имеет класс active
        if (!$(this).hasClass("active")) {
            akkardionContent.removeClass("active");
            akkardionContent.find(akkardionText).slideUp(200);
            $(this).addClass("active");
            $(this).find(akkardionText).slideDown(200);
        }
        //Иначе, если данный клик имеет класс active
        else {
            akkardionContent.removeClass("active");
            akkardionContent.find(akkardionText).slideUp(200);
        }
    });
});


// Menu select ---------------------------
$(function () {
    $('.select').each(function () {
        const _this = $(this),
            selectOption = _this.find('option'),
            selectOptionLength = selectOption.length,
            selectedOption = selectOption.filter(':selected'),
            duration = 300; // длительность анимации

        _this.hide();
        _this.wrap('<div class="select"></div>');
        $('<div>', {
            class: 'new-select',
            text: _this.children('option:disabled').text()
        }).insertAfter(_this);

        const selectHead = _this.next('.new-select');
        $('<div>', {
            class: 'new-select__list'
        }).insertAfter(selectHead);

        const selectList = selectHead.next('.new-select__list');
        for (let i = 1; i < selectOptionLength; i++) {
            $('<div>', {
                class: 'new-select__item',
                html: $('<span>', {
                    text: selectOption.eq(i).text(),
                })
            })
                .attr('data-value', selectOption.eq(i).val())
                .appendTo(selectList);
        }

        const selectItem = selectList.find('.new-select__item');
        selectList.slideUp(0);
        selectHead.on('click', function () {
            if (!$(this).hasClass('on')) {
                $(this).addClass('on');
                $('.new-select').addClass('on');
                selectList.slideDown(duration);

                selectItem.on('click', function () {
                    let chooseItem = $(this).data('value');

                    $('select').val(chooseItem).attr('selected', 'selected');
                    selectHead.text($(this).find('span').text());

                    selectList.slideUp(duration);
                    selectHead.removeClass('on');
                });

            } else {
                $(this).removeClass('on');
                selectList.slideUp(duration);
            }
        });

        $(document).mouseup(function (e) { // событие клика по веб-документу
            var div = $(".new-select__list"); // тут указываем ID элемента
            if (!div.is(e.target) // если клик был не по нашему блоку
                &&
                div.has(e.target).length === 0) { // и не по его дочерним элементам
                div.hide(); // скрываем его
                $('.new-select').removeClass('on');
            }
        });

    });
});



// Выбор цвета----------------------------------------------
function colorСhanges() {
    window.onclick = function onclickRadio() {
        var nameColor = document.getElementsByName('color');
        for (var i = 0; i < nameColor.length; i++) {
            if (nameColor[i].type === 'radio' && nameColor[i].checked) {
                rezultatRadio = nameColor[i].value;
            }
        }
        document.getElementById('colorSolutions').innerHTML = rezultatRadio;
    }
}

if (document.querySelectorAll(".product__descr_color").length) {
    colorСhanges();
}

// Переключение кнопок [-] 1 [+] -----------------------------------
// < !--скрипт для изменения кол - во товаров по нажатию на кнопки + /- на странице карточки товара -->
// Убавляем кол-во по клику
$(function () {
    $('.number .number-minus').click(function () {
        var $input = $(this).parent().find('.number-text');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
    });

    // Прибавляем кол-во по клику
    $('.number .number-plus').click(function () {
        var $input = $(this).parent().find('.number-text');
        var count = parseInt($input.val()) + 1;
        count = count > parseInt($input.data('max-count')) ? parseInt($input.data('max-count')) : count;
        $input.val(parseInt(count));
    });

    // Убираем все лишнее и невозможное при изменении поля
    $('.number .number-text').bind("change keyup input click", function () {
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
        if (this.value == "") {
            this.value = 1;

        }
        if (this.value > parseInt($(this).data('max-count'))) {
            this.value = parseInt($(this).data('max-count'));
        }
    });

    //Добавляем и убираем класс disabled
    $(function () {
        setInterval(function () {
            var count_num = $('.number .number-text').val();
            if (count_num == 1) {
                $('.number-minus').addClass('disabled');
            } else {
                $('.number-minus').removeClass('disabled');
            }
            if (count_num == 999) {
                $('.number-plus').addClass('disabled');
            } else {
                $('.number-plus').removeClass('disabled');
            }
        }, 800);
    });
});


// На экране до 992рх Если height блока product__descr > product__img (height)
// тогда product__specifications добовляем класс up иначе отбираем up
function changeHeightBlock() {
    $(window).on('load resize', function () {
        if (document.documentElement.clientWidth > 992) {
            var heightImg = $('.product__img').height();
            heightDescr = $('.product__descr').height();
            raiseBlockHeight = heightDescr - heightImg - 27;

            if (heightDescr > heightImg) {
                $('.product__specifications').css("transform", `translateY(-${raiseBlockHeight}px)`);
            } else {
                $('.product__specifications').removeAttr('style');
            }
        } else {
            $('.product__specifications').removeAttr('style');
        }
    });
};
if (document.querySelectorAll(".product__descr").length) {
    changeHeightBlock();
};

// Переместить блок----------------------------------------------
$(function () {
    $(window).on('load resize', function () {
        if (document.documentElement.clientWidth < 991) {
            $('.product__descr h1').insertBefore('.product__body');
            $('.nav').removeClass('open');
        } else {
            $('h1').insertBefore('.product__descr_price');
        }
        if (document.documentElement.clientWidth < 846) {
            $('.panorama__text .panorama__text_title').insertAfter('.panorama__video');
        } else {
            $('.panorama__text_title').insertBefore('.panorama__text_descr');
        }
    });
});

// --------------------- Движение от мышки ---------------------
function flyBlock() {
    var bg = document.querySelector('.fly');
    window.addEventListener('mousemove', function (e) {
        var x = e.clientX / window.innerWidth;
        var y = e.clientY / window.innerHeight;
        bg.style.transform = 'translate(-' + x * 50 + 'px, -' + y * 50 + 'px)';
    });

    var bg = document.querySelector('.fly');
}

if (document.querySelectorAll(".fly").length) {
    flyBlock();
}

// меняем поиск --------------------------
$(function () {
    if ($('.category__items').find('.container').hasClass('no-products')) {
        $('.category').addClass('posted');
    } else {
        $('.category').removeClass('posted');
    }
});

$(function () {
    if ($('.typed').length) {
        $(".typed").typed({
            strings: ["вашей квартиры.", "вашей комнаты.", "вашего офиса.", "вашей дачи.", "вашего коттеджа."],
            // Optionally use an HTML element to grab strings from (must wrap each string in a <p>)
            stringsElement: null,
            // typing speed
            typeSpeed: 30,
            // time before typing starts
            startDelay: 1200,
            // backspacing speed
            backSpeed: 20,
            // time before backspacing
            backDelay: 500,
            // loop
            loop: true,
            // false = infinite
            //loopCount: 10,
            // show cursor
            showCursor: false,
            // character for cursor
            cursorChar: "|",
            // attribute to type (null == text)
            attr: null,
            // either html or text
            contentType: 'html',
            // call when done callback function
            callback: function () { },
            // starting callback function before each string
            preStringTyped: function () { },
            //callback for every typed string
            onStringTyped: function () { },
            // callback for reset
            resetCallback: function () { }
        });
    }

});

$(function () {
    // ---------------------- НАЧАЛО ПЕРЕМЕННЫЕ ----------------------
    var notices_for_user = $('.notices_for_user_wrapper');
    const msg_basket_success = 'Товар добавлен в корзину';
    const msg_basket_error = 'Не удалось добавить товар в корзину';
    const msg_basket_update = 'Корзина была обновлена';

    // ---------------------- КОНЕЦ ПЕРЕМЕННЫЕ ----------------------

    var text_sorting = $('#select').find('option[selected=selected]').text();
    val_sorting = $('#select').find('option[selected=selected]').val();
    $('.select-orderby-js').parent('').find('.select-input span[data-for="' + val_sorting + '"]').addClass('selected');
    $('.select-orderby-js').text(text_sorting);
    $(document).on('click', '.select-orderby-js', function () {
        $(this).parent().find('.select-input').toggleClass('show');
        $(this).toggleClass('active');

    });

    $(document).on('click', '.select-input span', function () {
        if ($(this).parent().parent().attr('class') == 'category__sorting') {
            if (!$(this).hasClass('selected')) {
                attr = $(this).attr('data-for');
                text = $(this).text();
                $('.select-orderby-js').text(text);
                $(this).parent().find('span').removeClass('selected');
                $(this).addClass('selected');
                $('#select option').removeAttr('selected');
                $('#select option[value="' + attr + '"]').prop('selected', true);
                $('#select option[value="' + attr + '"]').attr('selected', 'selected');
                $('#select').trigger('change');
            }
        }
    });

    $(document).mouseup(function (e) {
        var div = $(".select-orderby-js");
        if (!div.is(e.target) &&
            div.has(e.target).length === 0) {
            $('.select-input').removeClass('show');
            $('.select-orderby-js').removeClass('active');

        }
    });

    $(document).on('click', '.solution input', function (e) {
        th = $(this).val();
        $('input[name="colour"').val(th);

    });

    if ($('.add-to-cart-product-js').length) {
        setInterval(function () {
            card_count = $('.header__basket_price').text();
            card_amount = $('.header__basket_text-price').text();
            notices_for_user.find('.notices_for_user_count span').html(card_count);
            notices_for_user.find('.notices_for_user_result span').html(card_amount);
        }, 100);
    }
    $(document).on('click', '.add-to-cart-product-js', function (e) {
        e.preventDefault();
        name_img = $('input[name=color]:checked').attr('name-img');
        type_colors = $('input[name=color]:checked').parents().eq(2).find('p').text();
        type_color = type_colors.slice(0, -1);
        input_quantity = $('.number-text');
        product_title = $(this).data('title');
        product_price = $(this).data('price');
        product_id = $(this).parent().find('input[name=product_id]').val();
        product_quantity = $(this).parent().find('input[name=quantity]').val();
        variations = $('input[name=color]:checked').val();
        ajax_url = "/wp-admin/admin-ajax.php";
        $.ajax({
            type: 'POST',
            url: ajax_url,
            data: 'action=oneclick&product_id=' + product_id + '&quantity=' + product_quantity + '&type_color=' + type_color + '&color=' + variations + '&name_img=' + name_img + '',
            success: function () {
                console.log(type_color);
                console.log(name_img);

                $(document.body).trigger('wc_fragment_refresh');
                notices_for_user.find('h4').html(msg_basket_success);
                notices_for_user.find('.notices_for_user_text').html(product_title);
                notices_for_user.find('.notices_for_user_price').html(product_quantity + ' х <span>' + product_price + '</span>&nbsp;₽');
                notices_for_user.addClass('show');
                setTimeout(function () {
                    notices_for_user.removeClass('show');
                    input_quantity.val('1');
                }, 5000);
            },
            error: function () {
                notices_for_user.find('h4').html(msg_basket_error);
                notices_for_user.addClass('show');
                setTimeout(function () {
                    notices_for_user.removeClass('show');
                }, 5000);
            }
        });
    });

    //Закрыть уведомление пользователю по клику на блок уведомления
    $(document).on('click', '.notices_for_user_wrapper', function () {
        notices_for_user.removeClass('show');
    })

    //Указываем первому цвету checked и click
    $('.product__descr.sticky input[name="color"]').each(function (i) {
        if (i == 0) {
            $(this).prop('checked', true);
            $(this).trigger('click');
        }
    });

    //При изменении ввода своего числа кол-во товаров в input обновляем корзину (срабатывает, когда убрали фокус с input)
    $(document).on('change', '.quantity, input[class="quantity-input"]', function () {
        setTimeout(function () {
            $('.actions button[name="update_cart"]').removeAttr("disabled").trigger("click");
        }, 200);
    });

    //При обновлении checkout работаем с checked доставки/оплаты (технические скрытые)
    $('#shipping_checkbox').attr('value', '');
    $(document).on('updated_checkout', function () {
        ship_check = $('input[type=checkbox][name="shipping_checkbox"]');
        ship_check.change(function () {
            if ($('#shipping_checkbox').is(':checked')) {
                $('#shipping_checkbox').attr('value', '1');
            } else {
                $('#shipping_checkbox').attr('value', '');
            }
        });
    });

    //Разрешено вводить только русс.буквы в ФИО
    $(document).on('input', '#billing_first_name, #feedback input[name="form-name"]', function () {
        this.value = this.value.replace(/[^а-яё\s]/gi, '');
    });

    //Маска e-mail
    $(document).on('input', '#billing_email', function () {
        this.value = this.value.replace(/[^a-z@\-_.0-9\s]/gi, '');
    });

    //Каждое слово в ФИО с заглавной буквой
    $('input#billing_first_name, #feedback input[name="form-name"]').keyup(function (evt) {
        var txt = $(this).val();
        $(this).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
            return $1.toUpperCase();
        }));
    });

    $('#billing_phone, #feedback input[name="form-tel"]').mask("+7 (999) 999-99-99", {
        autoclear: false
    });

    $(document).on('click', '#billing_phone', function () {
        $('#billing_phone').on("blur", function () {
            var minlength = $(this).attr('minlength');
            var maxlength = $(this).attr('maxlength');
            var phone_val = $(this).val();
            var clean_str_phone = phone_val.replace(/[^0-9]/g, '');
            if (clean_str_phone.length >= maxlength && clean_str_phone.length <= minlength) {
                $('#billing_phone_field').removeClass('woocommerce-invalid woocommerce-invalid-required-field');
            } else {
                $('#billing_phone_field').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            }
        });
    });

    $(document).on('click', '#feedback ibput[type="submit"]', function () {
        $('#form-tel').on("blur", function () {
            var minlength = $(this).attr('minlength');
            var maxlength = $(this).attr('maxlength');
            var phone_val = $(this).val();
            var clean_str_phone = phone_val.replace(/[^0-9]/g, '');
            if (clean_str_phone.length >= maxlength && clean_str_phone.length <= minlength) {
                $('#form-tel').parent('.field').removeClass('woocommerce-invalid woocommerce-invalid-required-field');
            } else {
                $('#form-tel').parent('.field').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            }
        });
    });

    $(document).on('click', '#place_order', function (e) {
        setInterval(function () {
            if ($('.woocommerce-error li span').hasClass('error_name')) {
                $('#billing_first_name_field').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            }
            if ($('.woocommerce-error li span').hasClass('error_tel')) {
                $('#billing_phone_field').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            }
        }, 1000);

    });

    $(document).on('change', '.quantity, input[class="quantity-input"]', function () {
        setTimeout(function () {
            $('.actions button[name="update_cart"]').removeAttr("disabled").trigger("click");
        }, 0);
    });

    $(document).on('input', '#billing_first_name', function (e) {
        $('.woocommerce-error li .error_name').remove();
    });
    $(document).on('input', '#billing_phone', function (e) {
        $('.woocommerce-error li .error_tel').remove();
    });

    $(document).on('click', '.option-js-active', function () {
        $(this).parent().find('.options-js').toggleClass('show');
        $(this).addClass('show');
    });

    $(document).on('click', '.option-js', function () {
        var th = $(this);
        // Замена адреса по клику селекта
        addr = th.attr('addr');
        addrhref = th.attr('2gis');
        mode = th.attr('mode');
        tel = th.attr('tel');
        telhref = th.attr('telhref');
        wrapperDescr = $('.contacts__info');
        optionActive = th.text();
        option = $(this).parents('.select-js').find('.option-js-active').text();
        $('.option-js-active').removeClass('show');
        if (optionActive !== option) {
            $(this).parents('.select-js').find('.option-js-active').text(optionActive);
            wrapperDescr.find('#addr').html(addr);
            wrapperDescr.find('#addr').attr('href', addrhref);
            wrapperDescr.find('#mode').html(mode);
            wrapperDescr.find('#tel').html(tel);
            wrapperDescr.find('#tel').attr('href', 'tel:+' + telhref + '');
        }
        if (th.hasClass('kz')) {
            $('.contacts__info_production').removeClass('d-hide');
        } else {
            $('.contacts__info_production').addClass('d-hide');

        }
    });

    $(document).mouseup(function (e) { // событие клика по веб-документу
        var div = $(".option-js-active, .about-cert__slider_slide"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            &&
            div.has(e.target).length === 0) { // и не по его дочерним элементам
            $('.options-js').removeClass('show');
            $('.option-js-active').removeClass('show');
        }
    });

    $(document).on('click', '.about-cert__slider_slide', function () {
        $('.modal-cert, #overlay').addClass('modal-open');
    });
    $(document).on('click', '#overlay', function () {
        if ($('.modal-cert').hasClass('modal-open')) {
            $('.modal-cert, #overlay').removeClass('modal-open');
        }
    });

});