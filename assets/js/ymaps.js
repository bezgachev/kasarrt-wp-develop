$(function () {
    aadr = [];
    geo = [];
    twogis = [];
    type_contact = [];

    $('.contacts__info').find(".option-js").each(function () {
        aadr.push($(this).attr('addr'));
        geo.push($(this).attr('geo'));
        twogis.push($(this).attr('2gis'));
        type_contact.push($(this).text());
    });
    geo_first = $('.option-js.msw').attr('geo').split(',');
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map('map', {
            center: geo_first,
            searchControlProvider: 'yandex#search',
            zoom: 11,
            controls: []
        }, {
            //zoomControlSize: 'medium',
            zoomControlPosition: {
                right: 20,
                top: 160
            },
            suppressMapOpenBlock: true,
        });


        var pointer1 = geo[0].split(',');
        pointer2 = geo[1].split(',');
        pointer3 = geo[2].split(',');
        var pointer = [
            pointer1,
            pointer2,
            pointer3
        ];
        var modalContent = [
            [`<div class="map__modal"><span class="map__modal_title">${type_contact[0]}</span><span class="map__modal_subtitle">${aadr[0]}</span><a href="${twogis[0]}" target="_blank">Как добраться?</a></div></div>`],
            [`<div class="map__modal"><span class="map__modal_title">${type_contact[1]}</span><span class="map__modal_subtitle">${aadr[1]}</span><a href="${twogis[1]}" target="_blank">Как добраться?</a></div></div>`],
            [`<div class="map__modal"><span class="map__modal_title">${type_contact[2]}</span><span class="map__modal_subtitle">${aadr[2]}</span><a href="${twogis[2]}" target="_blank">Как добраться?</a></div></div>`]
        ];

        $("span.option-js").click(function () {
            myMap.panTo([$(this).attr('geo').split(',')], {
                flying: true
            });
        });

        var dataUrlDirectoryBlock = document.querySelector("#main-js");
        var dataUrlDirectory = dataUrlDirectoryBlock.getAttribute("data-dir");
        // Создадим пользовательский макет ползунка масштаба.
        ZoomLayout = ymaps.templateLayoutFactory.createClass("<div class='map-nav__wrapper'><div class='map-nav__block'>" + "<div id='zoom-in' title='Приблизить'><i class='map-nav__icon-plus'></i></div>" + "<div id='zoom-out' title='Отдалить'><i class='map-nav__icon-minus'></i></div>" + "</div></div>", {
            // Переопределяем методы макета, чтобы выполнять дополнительные действия
            // при построении и очистке макета.
            build: function () {
                // Вызываем родительский метод build.
                ZoomLayout.superclass.build.call(this);
                // Привязываем функции-обработчики к контексту и сохраняем ссылки
                // на них, чтобы потом отписаться от событий.
                this.zoomInCallback = ymaps.util.bind(this.zoomIn, this);
                this.zoomOutCallback = ymaps.util.bind(this.zoomOut, this);
                // Начинаем слушать клики на кнопках макета.
                $('#zoom-in').bind('click', this.zoomInCallback);
                $('#zoom-out').bind('click', this.zoomOutCallback);
            },
            clear: function () {
                // Снимаем обработчики кликов.
                $('#zoom-in').unbind('click', this.zoomInCallback);
                $('#zoom-out').unbind('click', this.zoomOutCallback);
                // Вызываем родительский метод clear.
                ZoomLayout.superclass.clear.call(this);
            },
            zoomIn: function () {
                var map = this.getData().control.getMap();
                map.setZoom(map.getZoom() + 1, {
                    checkZoomRange: true
                });
            },
            zoomOut: function () {
                var map = this.getData().control.getMap();
                map.setZoom(map.getZoom() - 1, {
                    checkZoomRange: true
                });
            }
        }),
            zoomControl = new ymaps.control.ZoomControl({
                options: {
                    layout: ZoomLayout
                }
            });


        // Создаём макет содержимого.
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass('<div class="map__title">$[properties.iconContent]</div>');
        for (i = 0; i < pointer.length; ++i) {
            balluns = new ymaps.Placemark(pointer[i], {
                //hintContent: 'Собственный значок метки с контентом',
                // balloonContent: 'А эта — новогодняя',
                iconContent: '',
                balloonContent: modalContent[i],
                //balloonContent: '<div class="map__modal"><span class="map__modal_title">Офис:</span><span class="map__modal_subtitle">г.Йошкар-Ола,б-р Победы, д.5</span></div>'
            }, {
                // Опции.
                // Необходимо указать данный тип макета.
                iconLayout: 'default#imageWithContent',
                // Своё изображение иконки метки.
                iconImageHref: '' + dataUrlDirectory + '/assets/icons/contacts-map.svg',
                // Размеры метки.
                iconImageSize: [45, 45],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-14, -14],
                // Смещение слоя с содержимым относительно слоя с картинкой.
                iconContentOffset: [60, 5],
                // Макет содержимого.
                iconContentLayout: MyIconContentLayout
            });

            myMap.controls.add(zoomControl);
            myMap.behaviors.disable('scrollZoom');
            myMap.behaviors.disable('multiTouch');
            myMap.geoObjects.add(balluns);
            myMap.geoObjects.events.add('click', function (e) {
                myMap.setZoom(16, {
                    duration: 1000
                });

                var targetObject = e.get('target');
                myMap.setCenter(targetObject.geometry.getCoordinates());

            });

        }
        myMap.events.add('click', function () {
            myMap.balloon.close();
        });
    }


});