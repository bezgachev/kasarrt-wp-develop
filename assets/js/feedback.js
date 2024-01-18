$(function () {

    // $(document).on('click', '.header__callback_text, #btn-modal-call', function () {
    // 	$('#overlay, .modal-popup').css('display', "block");
    // });

    // $(document).on('click', '.modal-popup .close-button', function () {
    // 	$('#overlay, .modal-popup').removeAttr('style');
    // });

    var btnModalCall = $('.btn-modal-call');
    btnCloseModal = $('.form__btn-close');
    overlayModal = $('#overlay');
    popupModal = $('.modal');

    pageUrl = window.location.href;
    fScrollTop = $('html');



    btnModalCall.on("click", function () {
        $('body').css('overflow-y', 'scroll');
        overlayModal.css('overflow-y', 'initial');
        var scrolled = $(window).scrollTop();
        localStorage.setItem('kasarrtScrollTop', scrolled);
        fScrollTop.scrollTop(scrolled);
        fScrollTop.css("overflow", "hidden");
        overlayModal.addClass('modal-open');
        popupModal.addClass('modal-open');
    });

    btnCloseModal.on("click", function () {
        var scrolled = localStorage.getItem("kasarrtScrollTop");
        fScrollTop.removeAttr('style');
        fScrollTop.scrollTop(scrolled);
        overlayModal.removeClass('modal-open');
        popupModal.removeClass('modal-open');
        $('body').removeAttr('style');
        overlayModal.removeAttr('style');
        $('.modal-access').removeClass('modal-open');
        $('.modal, .modal-access').removeAttr('style');
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            btnCloseModal.click();
        }
    });

    overlayModal.on("click", function () {
        btnCloseModal.trigger('click');
        $('#feedback input, #feedback textarea').parent().removeClass('woocommerce-invalid woocommerce-invalid-required-field');

    });

    // $(document).on('click', '.btn-modal-call', function (e) {
    //     $('.modal, #overlay').addClass('modal-open');
    // });


    var form_feedback = $('#feedback');
    var form_feedback_btn = form_feedback.find('input[type="submit"]');
    // Сброс значений полей
    // $('#add_feedback input, #add_feedback textarea').on('blur', function () {
    //     $('#add_feedback input, #add_feedback textarea').removeClass('error');
    //     $('.error-name,.error-email,.error-comments,.message-success').remove();
    //     $('#submit-feedback').val('Отправить сообщение');
    // });
    function successDisplay() {
        console.log('успешно');
        $('#overlay, .modal-access .form__btn-close').removeAttr('style');
        $('.modal.modal-open').css('opacity', '0');
        $('.modal-access').addClass('modal-open');
        if ($('.modal-access').hasClass('popup-err')) {
            $('.modal-access').removeClass('popup-err');
        }
        setTimeout(function () {
            $('.modal-access.modal-open').css('opacity', '1');
            $('.modal.modal-open').removeClass('modal-open');
            $('.modal-access').addClass('modal-open');
            $('.modal-access').find('.form__title').text('Сообщение отправлено');
            $('.modal-access').find('.form__subtitle').text('Совсем скоро мы ответим Вам!');
            $('#feedback')[0].reset();
            $('#feedback input[type="submit"]').val('Отправить сообщение');
        }, 300);


    }

    function errorDisplay() {
        console.log('ошибка');
        $('.modal-access').find('.form__btn-close').css('display', 'none');
        $('.modal.modal-open').css('opacity', '0');
        $('.modal-access').addClass('popup-err modal-open');
        setTimeout(function () {
            $('#overlay').css('pointer-events', 'none');
            $('.modal-access.modal-open').css('opacity', '1');
            $('.modal-access').addClass('modal-open');
            $('.modal-access').find('.form__title').text('Что-то пошло не так');
            $('.modal-access').find('.form__subtitle').text('Не удалось отправить сообщение. Пожалуйста, повторите еще раз');
            $('#feedback input[type="submit"]').val('Отправить сообщение');
        }, 300);

        setTimeout(function () {
            $('.modal-access.modal-open').css('opacity', '0');
        }, 3000);

        setTimeout(function () {
            $('.modal.modal-open').css('opacity', '1');
            $('.modal-access').removeClass('modal-open');
            $('#overlay').removeAttr('style');
        }, 3400);




    }
    // Отправка значений полей

    $(document).on('click', 'input[name="popup-checkbox"]', function () {
        if ($(this).is(':checked')) {
            $(this).attr('value', '1');
            $('#feedback .form__btn').removeClass('disabled');
            $('#feedback .form__btn').prop('disabled', false);
        } else {
            $(this).attr('value', '');
            $('#feedback .form__btn').addClass('disabled');
            $('#feedback .form__btn').prop('disabled', true);

        }
    });

    $(document).on('input', '#feedback input, #feedback textarea', function (e) {
        $(this).parent().removeClass('woocommerce-invalid woocommerce-invalid-required-field');
    });


    var options = {
        url: feedback_object.url,
        data: {
            action: 'feedback_action',
            nonce: feedback_object.nonce
        },
        type: 'POST',
        dataType: 'json',
        beforeSubmit: function (xhr) {
            // При отправке формы меняем надпись на кнопке
            $('#feedback input[type="submit"]').val('Отправляем...');
        },
        success: function (request, xhr, status, error) {
            if (request.success === true) { } else {
                console.log('ПОЛЯ НЕ ЗАПОЛНЕНЫ');
                $.each(request.data, function (key) {
                    $('input[name="form-' + key + '"]').parent().addClass('woocommerce-invalid woocommerce-invalid-required-field');
                    $('textarea[name="form-' + key + '"]').parent().addClass('woocommerce-invalid woocommerce-invalid-required-field');
                });
                $('#feedback input[type="submit"]').val('Отправить сообщение');
            }
            if (request.message == 'OK') {
                successDisplay();
            }
            else if (request.message == 'ERROR') {
                errorDisplay();
            }
            // При успешной отправке сбрасываем значения полей
            //$('#add_feedback')[0].reset();
            //successDisplay();
            console.log(xhr);
        },
        error: function (request, status, error) {
            errorDisplay();
        }
    };
    // Отправка формы
    form_feedback.ajaxForm(options);



});