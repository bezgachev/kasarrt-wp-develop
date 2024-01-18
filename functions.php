<?
//Скрытие меню навигации панели управления при просмотре сайта
// add_filter('show_admin_bar', '__return_false');
// function remove_admin_bar() {
// 	if (!current_user_can('administrator') && !is_admin()) {
// 		show_admin_bar(false);
// 	}
// }

// Подключаем стили css в header
add_action( 'wp_enqueue_scripts', 'style_theme');
function style_theme() {	

	$swiper = get_stylesheet_directory() . '/assets/css/swiper.min.css';
	wp_enqueue_style( 'swiper', get_stylesheet_directory_uri().'/assets/css/swiper.min.css?leave=1', NULL, filemtime($swiper));

	$my = get_stylesheet_directory() . '/assets/css/style.min.css';
	wp_enqueue_style( 'style-min', get_stylesheet_directory_uri().'/assets/css/style.min.css?leave=1', NULL, filemtime($my));

	$woocommerce = get_stylesheet_directory() . '/assets/css/woocommerce.css';
	wp_enqueue_style( 'my-woocommerce', get_stylesheet_directory_uri().'/assets/css/woocommerce.css?leave=1', NULL, filemtime($woocommerce));

}

// Подключаем скрипты js footer
add_action( 'wp_enqueue_scripts', 'scripts_theme' );
function scripts_theme() {	
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', false, null, true );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), null, true);
	if ( is_page(68)) {
		wp_enqueue_script( 'typed', get_template_directory_uri() . '/assets/js/typed.min.js', array('jquery'), null, true);
	}
	wp_enqueue_script( 'maskedinput', get_template_directory_uri() . '/assets/js/maskedinput.js', array('jquery'), null, true);
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), null, true);
	if ( is_page(72)) {
		wp_enqueue_script('map-api', get_template_directory_uri() . '/assets/js/ymaps-api.js', array('jquery'), null, true);
		wp_enqueue_script('map', get_template_directory_uri() . '/assets/js/ymaps.js', array('jquery'), null, true);
	}	

	wp_enqueue_script('jquery-form');
	// Подключаем файл скрипта формы обратной связи и заказа звонка
	wp_enqueue_script('feedback', get_template_directory_uri() . '/assets/js/feedback.js', array('jquery'), null, true);
	// Задаем данные обьекта ajax
	wp_localize_script(
		'feedback',
		'feedback_object',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'feedback-nonce' ),
		)
	);

}

// Добавляем в DOM дереве в тег id.main-js атрибут data-dir путь сайта директории темы для использования в JS в дальнейшем
add_filter( 'script_loader_tag', 'dataUrlDirectory', 10, 2 );
function dataUrlDirectory( $tag, $handle ) {
    if ( 'main' !== $handle ) {
        return $tag;
    }
	$dataUrlDirectory = get_template_directory_uri();
    return str_replace( 'id', 'data-dir="'.$dataUrlDirectory.'"id', $tag );
}

// Регистрируем меню, виджеты, свои размеры для img
add_action( 'after_setup_theme', 'theme_register_nav_menu' );
function theme_register_nav_menu() {
	register_nav_menu( 'header-menu', 'Главное меню');
	// register_nav_menu( 'sibebar-menu', 'Боковое меню мобилка, планшет');
	// register_nav_menu( 'header-catalog', 'Каталог шапка, подвал сайта');
	register_nav_menu( 'catalog-main', 'Каталог');
	register_nav_menu( 'footer-help', 'Помощь, подвал сайта');
	// register_nav_menu( 'footer-clients', 'Покупателям, подвал сайта');
	// register_nav_menu( 'footer-help', 'Помощь, подвал сайта');
	

		add_theme_support(
		'custom-logo',
		array(
			'width'       => 500,
			'height'      => 104,
			'flex-width'  => true,
			'flex-height' => true,
		));
		// add_image_size( 'woo-thumbnail-product', 300, 400, true );
		add_image_size( 'woo-page-product', 700, 500, true );
		// add_image_size( 'woo-large-size-product', 1200, 1600, true );
		//add_image_size( 'woo-mini-catalog', 250, 250, true );

		add_theme_support( 'title-tag' );
}

class menu_header extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {

		if ($item->url && $item->url != '') {
			if ( $depth == 1) {
				$output .= '<div>';
			}
			else {
				$output .= '<div class="nav__link">';
			}
			
		}

		if ($item->url && $item->url != '') {
			$output .= '<a href="' . $item->url . '">'. $item->title .'</a>';
		}
		else {
			$output .= '<div class="nav__link nav-catalog"><span>'. $item->title .'</span>';
		}
	}

	function start_lvl(&$output, $depth=0, $args=null) {
		$output .= '<div class="nav__submenu">';	
	}
	function end_lvl(&$output, $depth=0, $args=null) {
		$output .= '</div>';
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		$output .= '</div>';
	}
}

// свой класс построения основного каталога на главной
class catalog_main extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		$thumbnail_id = get_term_meta($item->object_id, 'thumbnail_id', true);
        $thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail', true);
		if ($item->url && $item->url != '') {
			$output .= '
			<a class="catalog-product" href="' . $item->url . '">
				<div class="catalog-product__img">
					<img src="' .$thumbnail_url. '" alt="catalog-kasarrt">
				</div>
				<p>'. $item->title .'</p>';
		}
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		$output .= '</a>';
	}
}

// свой класс построения каталога футере
class menu_footer extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		if ($item->url && $item->url != '') {
			$output .= '<li><a href="' . $item->url . '">'. $item->title .'</a>';
		}
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		$output .= '</li>';
	}
}

//Когда активирован плагин WooCommerce подключаем стили WooCommerce + Поддержка для WooCommerce. ЭТО ОБЯЗАТЕЛЬНО
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	function mytheme_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
}

// Регистрируем кастомайзер. Проивольные стандартные поля WP для основной информации на сайте. Находится это в Админка -> Внешний Вид -> Настроить -> Основная контактная информация
add_action( 'customize_register', 'mt_customize' );
function mt_customize( $wp_customize ) {

	$wp_customize->add_panel( 'contacts_office_panel', array(
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
		'title'          => 'Контакты',
	  ) );


	$wp_customize->add_section(
        'main_email',
        array(
            'title' => 'E-mail',
            'priority' => 1,
			'panel' => 'contacts_office_panel',
        )
    );

	$wp_customize->add_section(
        'production',
        array(
            'title' => get_option('production_text'),
            'priority' => 4,
			'panel' => 'contacts_office_panel',
        )
    );

	$wp_customize->add_section(
        'office_moscow',
        array(
			'title' => get_option('office_moscow_text'),
            'priority' => 2,
			'panel' => 'contacts_office_panel',
        )
    );

	$wp_customize->add_section(
        'office_kazan',
        array(
            'title' => get_option('office_kazan_text'),
            'priority' => 3,
			'panel' => 'contacts_office_panel',
        )
    );

	$wp_customize->add_setting(
		'office_moscow_text', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_moscow_text_control',
		array(
			'type' => 'text',
			'label' => 'Название',
			'section' => 'office_moscow',
			'settings' => 'office_moscow_text'
		)
	);

	$wp_customize->add_setting(
		'office_moscow_tel', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_moscow_tel_control',
		array(
			'type' => 'number',
			'label' => 'Телефон',
			'description' => "Без пробелов, скобок и тире, пример: 79104000504",
			'section' => 'office_moscow',
			'settings' => 'office_moscow_tel'
		)
	);

	
	$wp_customize->add_setting(
		'office_moscow_addr', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_moscow_addr_control',
		array(
			'type' => 'text',
			'label' => 'Адрес',
			'section' => 'office_moscow',
			'settings' => 'office_moscow_addr'
		)
	);


	$wp_customize->add_setting(
		'office_moscow_work_time', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_moscow_work_time_control',
		array(
			'type' => 'text',
			'label' => 'Время работы с ПН-ПТ',
			'section' => 'office_moscow',
			'description' => "Пример: 10.00-18.00",
			'settings' => 'office_moscow_work_time'
		)
	);

	$wp_customize->add_setting(
		'office_moscow_geo', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_moscow_geo_control',
		array(
			'type' => 'text',
			'label' => 'Геолокация',
			'section' => 'office_moscow',
			'description' => "Необходимо указать местоположение координат. Значения берутся в Яндекс.Картах. Пример: 55.855851, 37.470383",
			'settings' => 'office_moscow_geo'
		)
	);


	$wp_customize->add_setting(
		'office_moscow_2gis', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_moscow_2gis_control',
		array(
			'type' => 'text',
			'label' => 'Ссылка для маршрута в 2ГИС',
			'section' => 'office_moscow',
			'description' => "Необходимо указать местоположение ссылкой из сервиса 2ГИС",
			'settings' => 'office_moscow_2gis'
		)
	);

	$wp_customize->add_setting(
		'office_kazan_text', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_kazan_text_control',
		array(
			'type' => 'text',
			'label' => 'Название',
			'section' => 'office_kazan',
			'settings' => 'office_kazan_text'
		)
	);

	$wp_customize->add_setting(
		'office_kazan_tel', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_kazan_tel_control',
		array(
			'type' => 'number',
			'label' => 'Телефон',
			'description' => "Без пробелов, скобок и тире, пример: 79104000504",
			'section' => 'office_kazan',
			'settings' => 'office_kazan_tel'
		)
	);

	$wp_customize->add_setting(
		'office_kazan_addr', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_kazan_addr_control',
		array(
			'type' => 'text',
			'label' => 'Адрес',
			'section' => 'office_kazan',
			'settings' => 'office_kazan_addr'
		)
	);

	$wp_customize->add_setting(
		'office_kazan_work_time', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_kazan_work_time_control',
		array(
			'type' => 'text',
			'label' => 'Время работы с ПН-ПТ',
			'section' => 'office_kazan',
			'description' => "Пример: 10.00-18.00",
			'settings' => 'office_kazan_work_time'
		)
	);

	$wp_customize->add_setting(
		'office_kazan_geo', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_kazan_geo_control',
		array(
			'type' => 'text',
			'label' => 'Геолокация',
			'section' => 'office_kazan',
			'description' => "Необходимо указать местоположение координат. Значения берутся в Яндекс.Картах. Пример: 55.855851, 37.470383",
			'settings' => 'office_kazan_geo'
		)
	);

	$wp_customize->add_setting(
		'office_kazan_2gis', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_kazan_2gis_control',
		array(
			'type' => 'text',
			'label' => 'Ссылка для маршрута в 2ГИС',
			'section' => 'office_kazan',
			'description' => "Необходимо указать местоположение ссылкой из сервиса 2ГИС",
			'settings' => 'office_kazan_2gis'
		)
	);

	$wp_customize->add_setting(
		'office_email', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'office_email_control',
		array(
			'type' => 'email',
			'label' => 'E-mail',
			'description' => "E-mail для показа посетителям сайта",
			'section' => 'main_email',
			'settings' => 'office_email'
		)
	);

	$wp_customize->add_setting(
		'production_text', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'production_text_control',
		array(
			'type' => 'text',
			'label' => 'Название',
			'section' => 'production',
			'settings' => 'production_text'
		)
	);

	$wp_customize->add_setting(
		'production_tel', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'production_tel_control',
		array(
			'type' => 'number',
			'label' => 'Телефон',
			'description' => "Без пробелов, скобок и тире, пример: 79104000504",
			'section' => 'production',
			'settings' => 'production_tel'
		)
	);

	$wp_customize->add_setting(
		'production_addr', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'production_addr_control',
		array(
			'type' => 'text',
			'label' => 'Адрес производства',
			'section' => 'production',
			'settings' => 'production_addr'
		)
	);

	$wp_customize->add_setting(
		'production_time', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'production_time_control',
		array(
			'type' => 'text',
			'label' => 'Время работы с ПН-ПТ',
			'section' => 'production',
			'description' => "Пример: 10.00-18.00",
			'settings' => 'production_time'
		)
	);

	$wp_customize->add_setting(
		'production_geo', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'production_geo_control',
		array(
			'type' => 'text',
			'label' => 'Геолокация производства',
			'section' => 'production',
			'description' => "Необходимо указать местоположение координат. Значения берутся в Яндекс.Картах. Пример: 55.855851, 37.470383",
			'settings' => 'production_geo'
		)
	);

	$wp_customize->add_setting(
		'production_2gis', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		'production_2gis_control',
		array(
			'type' => 'text',
			'label' => 'Ссылка для маршрута в 2ГИС',
			'section' => 'production',
			'description' => "Необходимо указать местоположение ссылкой из сервиса 2ГИС",
			'settings' => 'production_2gis'
		)
	);

	$wp_customize->add_section(
		// ID
		'messeng_social',
		// Arguments array
		array(
			'title' => 'Соц.сети и мессенджеры',
			'priority'  => 2
		)
	);

	//whatsapp
	$wp_customize->add_setting(
		'messeng_social_whatsapp', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'messeng_social_whatsapp_control', array(
			'type' => 'number',
			'label' => "WhatsApp",
			'section' => 'messeng_social',
			'description' => "Пример: 79104000504",
			'settings' => 'messeng_social_whatsapp'
		)
	);
	$wp_customize->add_setting('show_messeng_social_whatsapp', array(
		'default'    => 'true',
		'capability' => 'edit_theme_options',
		'type' => 'option',
	));
	$wp_customize->add_control(
		'show_messeng_social_whatsapp_control', array(
			'type'      => 'checkbox',
			'section' => 'messeng_social',
			'label'     => __('Вкл./Выкл. Whatsapp'),
			'settings'  => 'show_messeng_social_whatsapp',		
		)
	);

	//Телеграм
	$wp_customize->add_setting(
		'messeng_social_telegram', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'messeng_social_telegram_control', array(
			'type' => 'text',
			'section' => 'messeng_social',
			'label' => "Telegram",
			'description' => "Укажите свой ник без @",
			'settings' => 'messeng_social_telegram'
		)
	);
	$wp_customize->add_setting('show_messeng_social_telegram', array(
		'default'    => 'true',
		'capability' => 'edit_theme_options',
		'type' => 'option',
	));
	$wp_customize->add_control(
		'show_messeng_social_telegram_control', array(
			'type'      => 'checkbox',
			'section' => 'messeng_social',
			'label'     => __('Вкл./Выкл. Telegram'),
			'settings'  => 'show_messeng_social_telegram',		
		)
	);

	//Инстаграм
	$wp_customize->add_setting(
		'messeng_social_instagram', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'messeng_social_instagram_control', array(
			'type' => 'text',
			'section' => 'messeng_social',
			'label' => 'Instagram',
			'description' => "Укажите свой ник без @",
			'settings' => 'messeng_social_instagram'
		)
	);
	$wp_customize->add_setting('show_messeng_social_instagram', array(
		'default'    => 'true',
		'capability' => 'edit_theme_options',
		'type' => 'option',
	));
	$wp_customize->add_control(
		'show_messeng_social_instagram_control', array(
			'type'      => 'checkbox',
			'section' => 'messeng_social',
			'label'     => __('Вкл./Выкл. Инстаграм'),
			'settings'  => 'show_messeng_social_instagram',		
		)
	);
	
	//Почта
	$wp_customize->add_section(
		// ID
		'mail_custom',
		// Arguments array
		array(
			'title' => 'Настройки Почты',
			'capability' => 'edit_theme_options',
			'priority'  => 4,
			'description' => "Здесь Вы можете настроить SMTP сервер-обработчик почты.<br><br>Внимание! Если нужно изменить Административный E-mail для WordPress (Настройки - Общие - Административный E-mail), то временно отключите SMTP-сервер.<br><br>При смене Административной почты, необходимо продублировать её также в настройках: WooCommerce - Настройки - Email'ы - Адрес отправителя.<br><br>Если вдруг почта не отправляется, сверьте свои настройки для исходящей почты: <a href='https://yandex.ru/support/mail/mail-clients/others.html' target='_blank'>Яндекс </a>, <a href='https://developers.google.com/gmail/imap/imap-smtp' target='_blank'>Google</a>, <a href='https://help.mail.ru/mail/mailer/popsmtp' target='_blank'>Mail.ru</a> или перезапустите SMTP-сервер, если настройки верны.",
		)
	);

	$wp_customize->add_setting('enabled_mail_smtp', array(
		'default'    => 'true',
		'capability' => 'edit_theme_options',
		'type' => 'option',
	));
	$wp_customize->add_control(
		'enabled_mail_smtp_control', array(
			'type'      => 'checkbox',
			'section' => 'mail_custom',
			'label'     => __('Запустить SMTP-сервер'),
			'settings'  => 'enabled_mail_smtp',		
		)
	);

	//email почты
	$wp_customize->add_setting(
		'mail_custom_SMTP_USER', array(
			'default' => '', 
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_USER_control', array(
			'type' => 'hidden',
			'section' => 'mail_custom',
			'label' => 'Сервер-обработчик: ' . get_option('admin_email'),
			'description' => "Для обработки писем используется Ваш Административный E-mail<br><br>",
			'settings' => 'mail_custom_SMTP_USER'
		)
	);

	$wp_customize->add_setting(
		'mail_custom_SMTP_PASS', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_PASS_control', array(
			'type' => 'text',
			'section' => 'mail_custom',
			'label' => 'Пароль приложения',
			'description' => "Пароль приложения сервера почты. Пароль генерируется в аккаунте Вашей почты в настройках безопасности. Обычный пароль для входа не подойдёт, не рекомендуется в целях безопасности",
			'settings' => 'mail_custom_SMTP_PASS'
		)
	);
	
	$wp_customize->add_setting(
		'mail_custom_SMTP_HOST', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_HOST_control', array(
			'type' => 'text',
			'section' => 'mail_custom',
			'label' => 'Хост почтового сервера',
			'description' => "Яндекс — smtp.yandex.ru, Google — smtp.gmail.com, Mail.ru — ssl://smtp.mail.ru. Скопируйте и вставьте значения, в соответствии с тем, какой сервис почты Вы используете.<br><br>Если письма не отправляются, добавьте приставку ssl://<br>Пример: ssl://smtp.yandex.ru",
			'settings' => 'mail_custom_SMTP_HOST'
		)
	);

	$wp_customize->add_setting(
		'mail_custom_SMTP_PORT', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_PORT_control', array(
			'type' => 'text',
			'section' => 'mail_custom',
			'label' => 'Порт почтового сервера',
			'description' => "Яндекс — 465, Google — 465, либо 587, Mail.ru — 465",
			'settings' => 'mail_custom_SMTP_PORT'
		)
	);

	$wp_customize->add_setting(
		'mail_custom_SMTP_SECURE', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_SECURE_control', array(
			'type' => 'select',
			'section' => 'mail_custom',
			'label' => 'Метод защиты соединения, передачи данных',
			'description' => "Яндекс — SSL, Google — TLS, Mail.ru — SSL или TLS",
			'settings' => 'mail_custom_SMTP_SECURE',
			'choices' => array(
				'SSL' => 'SSL',
				'TLS' => 'TLS',
			),
		)
	);
}


function social_messeng() {
	$whatsapp = get_option('messeng_social_whatsapp');
	$whatsapp_cut = mb_substr($whatsapp, 1, 10, 'UTF8');
	$show_whatsapp = get_option('show_messeng_social_whatsapp');
	if ($show_whatsapp) { ?>
		<a href="whatsapp://send?phone=+7<? echo $whatsapp_cut; ?>" class="social whatsapp" target="_blank"></a>
	<? }
	$telegram = get_option('messeng_social_telegram');
		$show_telegram = get_option('show_messeng_social_telegram');
		if ($show_telegram) { ?>
			<a href="https://t.me/<? echo $telegram; ?>" class="social telegram" target="_blank"></a>
	<? }
	$instagram = get_option('messeng_social_instagram');
		$show_instagram = get_option('show_messeng_social_instagram');
		if ($show_instagram) { ?>
			<a href="https://www.instagram.com/<? echo $instagram; ?>" class="social instagram" target="_blank"></a>
	<? }

}

function kazan_tel() {
	$tel_kz = get_option('office_kazan_tel');
	$part1 = mb_substr($tel_kz, 1, 3, 'UTF8'); $part2 = mb_substr($tel_kz, 4, 3, 'UTF8'); $part3 = mb_substr($tel_kz, 7, 2, 'UTF8'); $part4 = mb_substr($tel_kz, 9, 2, 'UTF8');
	$part_all = '+7 (' . $part1 . ') ' . $part2 . '-' . $part3 . '-' . $part4;
	echo '<a href="tel:+' . $tel_kz .'">' . $part_all . '</a>';
}

function moscow_tel() {
	$tel_msw = get_option('office_moscow_tel');
	$part1 = mb_substr($tel_msw, 1, 3, 'UTF8'); $part2 = mb_substr($tel_msw, 4, 3, 'UTF8'); $part3 = mb_substr($tel_msw, 7, 2, 'UTF8'); $part4 = mb_substr($tel_msw, 9, 2, 'UTF8');
	$part_all = '+7 (' . $part1 . ') ' . $part2 . '-' . $part3 . '-' . $part4;
	echo '<a href="tel:+' . $tel_msw .'">' . $part_all . '</a>';
}

// --------------- НАЧАЛО ПОДКАТЕГОРИЙ ---------------


remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
remove_action( 'woocommerce_after_subcategory_title', 'woocommerce_after_subcategory_title');
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

// --------------- КОНЕЦ ПОДКАТЕГОРИЙ ---------------
// --------------- НАЧАЛО АРХИВА КАТАЛОГА ---------------

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_filter( 'woocommerce_default_catalog_orderby_options', 'woocust_catalog_orderby' ); // выводим сортировку свою, лишнее удаляем
add_filter('woocommerce_catalog_orderby', 'woocust_catalog_orderby'); // выводим сортировку свою, лишнее удаляем
function woocust_catalog_orderby($sortby) {
	unset($sortby['menu_order']); // удаляем
	unset($sortby['rating']);
	unset($sortby['date']);
	unset($sortby['popularity']);
	unset($sortby['price']);
	unset($sortby['price-desc']);

	$sortby['menu_order'] = 'По умолчанию';
	$sortby['price-desc'] = 'По убыванию цены';
	$sortby['price'] = 'По возрастанию цены';
	return $sortby;
}

add_action( 'woocommerce_before_main_content', 'woo_page_catalog_category', 25 );
function woo_page_catalog_category($args = array()) {
	$parentid = get_queried_object_id();
	$args = array('parent' => $parentid);
	$terms = get_terms('product_cat', $args);
	//если это категория/подкатегория
	if (is_search()) { ?>
	<section class="category container search-result">
		<div class="category__title">
			<h1>
				<? 
				$product_search = get_search_query();
				if (!empty($product_search)) {
					echo '«'. $product_search . '»';
				}
				?>
			</h1>
		</div>
		<div class="category__items">
			
	<?
	
	}
	else if (is_shop()) { ?>
		<section class="catalog catalog-page container">
			<h1>Каталог продукции</h1>


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

	<?
	}
	else if ( $terms ) {
		echo '<section class="catalog subcategory container"><h1>';
		echo woocommerce_page_title();
		echo '</h1><div class="catalog-products">';
			foreach ( $terms as $term ) {
				echo '<a href="'.esc_url(get_term_link($term)).'" class="catalog-product '.$term->slug.'">';
				echo '<div class="catalog-product__img">';	
					woocommerce_subcategory_thumbnail($term);
				echo '</div>';
				echo '<p>'.$term->name.'</p>';
				echo '</a>';
			}
		//echo '</div>';
	}
	//если страница товара
	else if (is_product()) {
		return;
	}
	//иначе выводим товары в архиве
	else { ?>
		<section class="category container">
			<div class="category__title">
				<h1><? woocommerce_page_title(); ?></h1>
				<? if ( apply_filters( 'woocommerce_catalog_ordering', true ) ) : ?>
					<? woocommerce_catalog_ordering(); ?>
				<? endif; ?>
			</div>
			<div class="category__items">
	<? }

}

add_action('woocommerce_before_shop_loop_item', 'product_card', 15);
function product_card() {
	global $product;
	?>
	<a href="<? echo get_the_permalink(); ?>" class="category__item">
		<div class="category__item_img">
			<? 
				$img_src = get_the_post_thumbnail_url( $post->ID, 'thumbnail', false ); //подключаем вывод превью изоображения товара
				echo '<img src="' . esc_url($img_src) . '">';
			?>
		</div>
		<? global $product; $product_article = $product->sku;
		if (!empty($product_article)) { ?>
			<div class="category__item_article">Артикул:&nbsp;<? echo $product_article; ?></div>
		<? }
		else {
			echo '<div class="category__item_article"></div>';
		} ?>
		
		<div class="category__item_title"><? echo get_the_title(); ?></div>
		<? $price = get_post_meta( get_the_ID(), '_regular_price', true); // основная цена товара
		$price_space = number_format((int)$price, 0, '', '&nbsp;');
		?>
		<div class="category__item_price"><span><? echo $price_space; ?></span>₽</div>
	</a>

<?
}

remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

add_action('woocommerce_after_shop_loop', 'product_card_after_close_div', 5);
function product_card_after_close_div() {
	// закрытие category__items и catalog-products
	echo '</div>';
}

add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

add_action('woocommerce_after_shop_loop', 'product_card_after', 15);
function product_card_after() {
	// закрытие catalog subcategory container и category container и category container search-result
	echo '</section>';
}


// --------------- КОНЕЦ АРХИВА КАТАЛОГА ---------------
// --------------- НАЧАЛО КАРТОЧКИ ТОВАРА ---------------


remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 ); // удаляем вывод инфо после добавления товара в корзину
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 ); //удаляем показ распродажа

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 ); // Удаление артикула и название категории
add_action( 'woocommerce_before_single_product_summary', 'shop_sku', 10 ); // добавляем кнопки вернуться назад и показываем артикул товара
function shop_sku() {
?>
	<? global $product; $product_article = $product->sku;
	if (!empty($product_article)) { ?>
		<span class="container product-article"><? echo $product_article; ?></span>
	<? } ?>
	<section class="product container">
		<div class="product__body">
<?
}

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 ); // удаляем стандартный вывод изоображений товара
add_action( 'woocommerce_before_single_product_summary', 'woo_product_images', 25 );
function woo_product_images() {
	global $product;
	$img_thumb = get_the_post_thumbnail( $post->ID, 'woo-page-product', $attributes );
	?>

	<div class="product__img">
		<?
		if (empty($img_thumb)) {
			$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image('woo-page-product'));
			echo $thumbnail;
		}
		else {
			echo $img_thumb;
		}
		?>
	</div>
<?
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ); // удаление title
add_action( 'woocommerce_single_product_summary', 'woo_product_title', 5 ); // своя верстка title
function woo_product_title() {
?>
	<div class="product__descr sticky">
	<h1><? global $product; echo $product->get_name(); ?></h1>
<?
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 ); // удаляем цены
add_action( 'woocommerce_single_product_summary', 'wooo_product_price', 10 ); //своя верстка показана цен
function wooo_product_price() {
	global $product;
	$price = get_post_meta( get_the_ID(), '_regular_price', true); // основная цена товара
	$price_space = number_format((int)$price, 0, '', '&nbsp;');
	$woody = $product->get_meta( '_checkbox_woody', true );
	$monochrome = $product->get_meta( '_checkbox_monochrome', true );
	$cloth = $product->get_meta( '_checkbox_cloth', true );
	$special = $product->get_meta( '_checkbox_special', true );
	
	?>
	<div class="product__descr_price"><? echo $price_space; ?>&nbsp;₽</div>
	<p>*Стоимость товара может отличаться от заявленной стоимости на сайте. Конечная стоимость зависит от размера и материала</p>

	
		<div class="product__descr_title">
			<h3>Цветовые решения:</h3>
			<span class="product__descr_solutions" id="colorSolutions"></span>
		</div>

		<? if ($woody == 'yes') { ?>
			<div class="product__descr_color solutions__woody">
				<p>Древесные:</p>
				<div class="solutions__woody">
					<label class="solution"><input type="radio" name="color" value="Бодега Тёмный" name-img="woody/bodega"></label>
					<label class="solution"><input type="radio" name="color" value="Дезира Тёмная" name-img="woody/desira"></label>
					<label class="solution"><input type="radio" name="color" value="Дуб Кельтик Светлый" name-img="woody/OakCeltic"></label>
					<label class="solution"><input type="radio" name="color" value="Дуб Сонома Светлый" name-img="woody/OakSonoma"></label>
					<label class="solution"><input type="radio" name="color" value="Ясень Анкор Тёмный" name-img="woody/AshAnchorDark"></label>
					<label class="solution"><input type="radio" name="color" value="Ясень Анкор" name-img="woody/AshAnchor"></label>
					<label class="solution"><input type="radio" name="color" value="Ясень Шимо Тёмный" name-img="woody/AshShimoDark"></label>
				</div>
			</div>
		<? } ?>
		<? if ($monochrome == 'yes') { ?>
		<div class="product__descr_color">
			<p>Однотонники:</p>
			<div class="solutions__monochrome">
				<label class="solution"><input type="radio" name="color" value="Белый" name-img="monophones/White"></label>
				<label class="solution"><input type="radio" name="color" value="Бирюза" name-img="monophones/Turquoise"></label>
				<label class="solution"><input type="radio" name="color" value="Жёлтый" name-img="monophones/Yellow"></label>
				<label class="solution"><input type="radio" name="color" value="Зеленый" name-img="monophones/Green"></label>
				<label class="solution"><input type="radio" name="color" value="Красный" name-img="monophones/Red"></label>
				<label class="solution"><input type="radio" name="color" value="Оранжевый" name-img="monophones/Orange"></label>
				<label class="solution"><input type="radio" name="color" value="Серый" name-img="monophones/Gray"></label>
			</div>
		</div>
		<? } ?>
		<? if ($cloth == 'yes') { ?>
		<div class="product__descr_color">
			<p>Ткань:</p>
			<div class="solutions__cloth">
				<label class="solution"><input type="radio" name="color" value="Белый" name-img="loth/White"></label>
				<label class="solution"><input type="radio" name="color" value="Бирюза" name-img="cloth/Turquoise"></label>
				<label class="solution"><input type="radio" name="color" value="Красный" name-img="cloth/Red"></label>
				<label class="solution"><input type="radio" name="color" value="Кремовый" name-img="cloth/Cream"></label>
				<label class="solution"><input type="radio" name="color" value="Оранжевый" name-img="cloth/Orange"></label>
				<label class="solution"><input type="radio" name="color" value="Салатовый" name-img="cloth/Green"></label>
				<label class="solution"><input type="radio" name="color" value="Серый" name-img="cloth/Gray"></label>
			</div>
		</div>
		<? } ?>
		<? if ($special == 'yes') { ?>
		<div class="product__descr_color">
			<p>Специальный окрас:</p>
			<div class="solutions__special">
				<label class="solution"><input type="radio" name="color" value="Специальный окрас" name-img="SpecialСolor"></label>
			</div>
		</div>
		<? } ?>

	<?
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action('woocommerce_single_product_summary', 'woo_product_add_to_cart', 20);
function woo_product_add_to_cart() {
	global $product;
	$price = get_post_meta( get_the_ID(), '_regular_price', true); // основная цена товара
	$price_space = number_format((int)$price, 0, '', '&nbsp;');
	?>
	<div class="product__descr_count">
		<div class="number">
			<button class="number-minus disabled"></button>
			<input class="number-text" type="number" name="quantity" value="1" data-max-count="999">
			<input type="hidden" name="product_id" value="<? echo get_the_id();?>">
			<button class="number-plus"></button>
		</div>
		
		<button data-title="<? echo get_the_title();?>" data-price="<? echo $price_space; ?>" class="btn add-to-cart-product-js">добавить в корзину</button>
	</div>
	<!-- закрываем product__descr sticky -->
	</div>
	<?
}

add_action( 'woocommerce_single_product_summary', 'woo_product_specif', 30 );
function woo_product_specif() { ?>
	<div class="product__specifications">
		<h3>Характеристики:</h3>
		<div class="specifications">
			<div class="specification">
				<div>Ширина</div>
				<div></div>
				<div><span><? global $product; echo $product->get_meta( '_number_field_width', true ); ?></span>&nbsp;мм</div>
			</div>
			<div class="specification">
				<div>Глубина</div>
				<div></div>
				<div><span><? echo $product->get_meta( '_number_field_depth', true ); ?></span>&nbsp;мм</div>
			</div>
			<div class="specification">
				<div>Высота</div>
				<div></div>
				<div><span><? echo $product->get_meta( '_number_field_height', true ); ?></span>&nbsp;мм</div>
			</div>
			<div class="specification specification-material">
				<div>Материал</div>
				<div></div>
				<div>
					<span><? echo $product->get_meta( '_text_field_material', true ); ?></span>
				</div>
			</div>
		</div>
<?
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ); //удаляем описание
add_action( 'woocommerce_single_product_summary', 'woo_product_excerpt', 40 );
function woo_product_excerpt() { ?>
	
	<? 
		$desc_content = get_the_content();
		if (!empty($desc_content)) {
			echo '<h3>Описание:</h3>';
			echo the_content();
		}
	?>
<!-- закрываем product__specifications -->
</div>

<!-- закрываем product__body -->
</div>

<!-- закрываем product container -->
</section>
<?
}

add_action( 'woocommerce_product_options_general_product_data', 'art_woo_add_custom_fields' );
function art_woo_add_custom_fields() {
	global $product, $post;
	echo '<div class="options_group">';// Группировка полей 
		woocommerce_wp_text_input( array(
			'id'                => '_number_field_width',
			'label'             => __( 'Ширина (мм)', 'woocommerce' ),
			'placeholder'       => 'Ширина',
			'description'       => __( 'Ширина товара в мм. Выводится в карточке товара в разделе Характеристики', 'woocommerce' ),
			'type'              => 'number',
			'desc_tip'          => 'true',
			'custom_attributes' => array( 'required' => 'required' ),
		));

		woocommerce_wp_text_input( array(
			'id'                => '_number_field_depth',
			'label'             => __( 'Глубина (мм)', 'woocommerce' ),
			'placeholder'       => 'Глубина',
			'description'       => __( 'Глубина товара в мм. Выводится в карточке товара в разделе Характеристики', 'woocommerce' ),
			'type'              => 'number',
			'desc_tip'          => 'true',
			'custom_attributes' => array( 'required' => 'required' ),
		));

		woocommerce_wp_text_input( array(
			'id'                => '_number_field_height',
			'label'             => __( 'Высота (мм)', 'woocommerce' ),
			'placeholder'       => 'Высота',
			'desc_tip'          => 'true',
			'description'       => __( 'Высота товара в мм. Выводится в карточке товара в разделе Характеристики', 'woocommerce' ),
			'type'              => 'number',
			'custom_attributes' => array( 'required' => 'required' ),
		));


		woocommerce_wp_text_input( array(
			'id'                => '_text_field_material',
			'label'             => __( 'Материал', 'woocommerce' ),
			'placeholder'       => 'Впишите Материалы',
			'desc_tip'          => 'true',
			'custom_attributes' => array( 'required' => 'required' ),
			'description'       => __( 'Материал выводится в карточке товара в разделе Характеристики', 'woocommerce' ),
		));
	echo '</div>';
	echo '<div class="options_group">'; // Группировка полей 
	echo '<h2>Цветовые решения:</h2>';

	woocommerce_wp_checkbox( array(
		'id'            => '_checkbox_woody',
		'wrapper_class' => 'show_if_simple',
		'label'         => 'Древесные',
		'description'   => 'Вкл./Выкл.',
	 ));
	 woocommerce_wp_checkbox( array(
		'id'            => '_checkbox_monochrome',
		'wrapper_class' => 'show_if_simple',
		'label'         => 'Однотонники',
		'description'   => 'Вкл./Выкл.',
	 ));
	 woocommerce_wp_checkbox( array(
		'id'            => '_checkbox_cloth',
		'wrapper_class' => 'show_if_simple',
		'label'         => 'Ткань',
		'description'   => 'Вкл./Выкл.',
	 ));
	 woocommerce_wp_checkbox( array(
		'id'            => '_checkbox_special',
		'wrapper_class' => 'show_if_simple',
		'label'         => 'Специальный окрас',
		'description'   => 'Вкл./Выкл.',
	 ));


	echo '</div>';
}


add_action( 'woocommerce_process_product_meta', 'art_woo_custom_fields_save', 10 );
function art_woo_custom_fields_save( $post_id ) {

	// Вызываем объект класса
	$product = wc_get_product( $post_id );

	// Сохранение текстового поля
	$text_field = isset( $_POST['_text_field_material'] ) ? sanitize_text_field( $_POST['_text_field_material'] ) : '';
	$product->update_meta_data( '_text_field_material', $text_field );

	// Сохранение цифрового поля
	$number_field = isset( $_POST['_number_field_width'] ) ? sanitize_text_field( $_POST['_number_field_width'] ) : '';
	$product->update_meta_data( '_number_field_width', $number_field );

	$number_field = isset( $_POST['_number_field_depth'] ) ? sanitize_text_field( $_POST['_number_field_depth'] ) : '';
	$product->update_meta_data( '_number_field_depth', $number_field );

	$number_field = isset( $_POST['_number_field_height'] ) ? sanitize_text_field( $_POST['_number_field_height'] ) : '';
	$product->update_meta_data( '_number_field_height', $number_field );

	// Сохранение чекбоксов
	$checkbox_field = isset( $_POST['_checkbox_woody'] ) ? 'yes' : 'no';
	$product->update_meta_data( '_checkbox_woody', $checkbox_field );

	$checkbox_field = isset( $_POST['_checkbox_monochrome'] ) ? 'yes' : 'no';
	$product->update_meta_data( '_checkbox_monochrome', $checkbox_field );

	$checkbox_field = isset( $_POST['_checkbox_cloth'] ) ? 'yes' : 'no';
	$product->update_meta_data( '_checkbox_cloth', $checkbox_field );

	$checkbox_field = isset( $_POST['_checkbox_special'] ) ? 'yes' : 'no';
	$product->update_meta_data( '_checkbox_special', $checkbox_field );

	// Сохраняем все значения
	$product->save();

}

add_action( 'woocommerce_add_cart_item_data', 'save_name_on_woo_field_color', 10, 2 );
function save_name_on_woo_field_color( $cart_item_data, $product_id ) {
	if( isset( $_POST['type_color'] ) ) {
        $cart_item_data[ 'type_color' ] = $_POST['type_color'];
    }
	if( isset( $_POST['color'] ) ) {
        $cart_item_data[ 'color' ] = $_POST['color'];
    }
	if( isset( $_POST['name_img'] ) ) {
        $cart_item_data[ 'name_img' ] = $_POST['name_img'];
    }
    return $cart_item_data;
}

add_filter( 'woocommerce_get_item_data', 'render_meta_on_cart_and_checkout', 10, 2 );
function render_meta_on_cart_and_checkout( $cart_data, $cart_item) {
    $custom_items = array();
    /* Woo 2.4.2 updates */
    if( !empty( $cart_data ) ) {
        $custom_items = $cart_data;
    }
    if( isset( $cart_item['type_color'] ) ) {
       $custom_items[] = array("name" => 'Тип материала', "value" => $cart_item['type_color'] );
    }
	if( isset( $cart_item['color'] ) ) {
		$custom_items[] = array("name" => 'Цвет', "value" => $cart_item['color'] );
	}
	if( isset( $cart_item['name_img'] ) ) {
		$custom_items[] = array("name" => 'img', "value" => $cart_item['name_img'] );
	}
    return $custom_items;
}

add_action( 'woocommerce_add_order_item_meta', 'woo_order_meta_handler', 10, 3 );
function woo_order_meta_handler( $item_id, $values, $cart_item_key ) {
    if( isset( $values['type_color'] ) ) {
        wc_add_order_item_meta( $item_id, "Тип материала", $values['type_color'] );
    }
	if( isset( $values['color'] ) ) {
        wc_add_order_item_meta( $item_id, "Цвет", $values['color'] );
    }
}

//Запретить добавлять товар в корзину после обновления страницы, если после добавления товара с карточки товара
add_action('add_to_cart_redirect', 'resolve_dupes_add_to_cart_redirect');
function resolve_dupes_add_to_cart_redirect($url = false) {
if(!empty($url)) { return $url; }
return get_bloginfo('wpurl').add_query_arg(array(), remove_query_arg('add-to-cart'));
}


add_action('wp_ajax_oneclick', 'oneclick');
add_action('wp_ajax_nopriv_oneclick', 'oneclick');
function oneclick() {
	$product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
	$color = $_POST['color'];
	$type_color = $_POST['type_color'];
	if ($variation_id) {
	  WC()->cart->add_to_cart( $product_id, $quantity, $variation_id);
	} else {
	  WC()->cart->add_to_cart( $product_id, $quantity, $color, $type_color);
	}
	$items = WC()->cart->get_cart();
	global $woocommerce;
	$woocommerce->cart->cart_contents_count; ?>
	<? 
	die();
}

//Динамически обновляем кол-во товаров и сумму корзины в header
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_reset_basket_header');
function woo_reset_basket_header($fragments){
    ob_start(); 
	$cart_count = WC()->cart->get_cart_contents_count();
	$card_total = WC()->cart->get_cart_total(); 
	$notag_card_total = strip_tags($card_total);
	$card_total_space = number_format((int)$notag_card_total, 0, '', '&nbsp;');
	$card_url = wc_get_cart_url();
	?>
		<?
		if (!empty($cart_count)){
			?>
			<a href="<? echo $card_url; ?>" class="header__basket">
				<span class="header__basket_img">
					<img src="<? echo get_template_directory_uri(); ?>/assets/icons/card.svg" alt="">
					<span class="header__basket_price"><? echo $cart_count; ?></span>
				</span>
				<span class="header__basket_text">Корзина
					<br>
					<span>от</span>
					<span class="header__basket_text-price"><? echo $card_total_space; ?>&nbsp;₽</span>
				</span>
			</a>
			<?
		}
		else { ?>
			<a href="<? echo $card_url; ?>" class="header__basket">
				<span class="header__basket_img">
					<img src="<? echo get_template_directory_uri(); ?>/assets/icons/card.svg" alt="icon-cart">
				</span>
				<span class="header__basket_text">Корзина товаров</span>
			</a>
		<? } ?>
    <?
        $fragments['.header__basket'] = ob_get_clean();
    return $fragments;
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 ); //удаляем атрибуты
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );// удаление rating
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 ); //удаляем похожие товары
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

// --------------- КОНЕЦ КАРТОЧКИ ТОВАРА ---------------

// --------------- НАЧАЛО СТРАНИЦЫ КОРЗИНЫ CART ---------------
remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 ); //удаление уведомлений в корзине при добавлении товара
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display'); //отключение вывода кросселов-товаров в корзине

//ВЫ СМОТРЕЛИ РАНЕЕ
add_action( 'template_redirect', 'woo_recently_viewed_product_cookie', 20 ); //создаем куки, записываем данные ID просмотренных товаров
function woo_recently_viewed_product_cookie() {
	// если находимся не на странице товара, ничего не делаем
	if ( ! is_product() ) {
		return;
	}
	if ( empty( $_COOKIE[ 'kasar_woo_recently_viewed_product' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'kasar_woo_recently_viewed_product' ] );
	}
	// добавляем в массив текущий товар
	if ( ! in_array( get_the_ID(), $viewed_products ) ) {
		$viewed_products[] = get_the_ID();
	}
	// нет смысла хранить там бесконечное количество товаров
	if ( sizeof( $viewed_products ) > 10 ) {
		array_shift( $viewed_products ); // выкидываем первый элемент
	}
 	// устанавливаем в куки
	wc_setcookie( 'kasar_woo_recently_viewed_product', join( '|', $viewed_products ), time() + (3600 * 24 * 3) );
}

function woo_recently_viewed_product() {
	if( empty( $_COOKIE[ 'kasar_woo_recently_viewed_product' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'kasar_woo_recently_viewed_product' ] );
	}
	if ( empty( $viewed_products ) ) {
		return;
	}
	// надо ведь сначала отображать последние просмотренные
	$viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
	//$product_ids = join( ", ", $viewed_products);
	$args = [
		'post_type'      => 'product',
		'posts_per_page' => 10,
		'post__in' => $viewed_products
	];

	$query = new WP_Query( $args );

	// обрабатываем результат
	if ( $query->have_posts() ) :
	?>
	<section class="viewed container">
		<div class="viewed__title">
			<h3>Вы смотрели</h3>
			<nav class="viewed__navigation">
				<div class="swiper-prev"></div>
				<div class="swiper-next"></div>
			</nav>
		</div>
            <!-- Slider main container -->
            <div class="viewed__slider swiper">
                <!-- Additional required wrapper -->
                <div class="viewed__wrapper swiper-wrapper">
                    <!-- Slides -->
					<?
					while ( $query->have_posts() ) {
						$query->the_post(); ?>
						<div class="viewed__slide swiper-slide">
							<? product_card(); ?>
						</div>
					<? 
					} //endwhile ?>
				
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</section>
	<? wp_reset_postdata(); endif; 
}
//КОНЕЦ ВЫ СМОТРЕЛИ РАНЕЕ

// --------------- КОНЕЦ СТРАНИЦЫ КОРЗИНЫ CART ---------------

// --------------- НАЧАЛО ОФОРМЛЕНИЯ ЗАКАЗА ---------------

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10); 
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_filter( 'woocommerce_checkout_fields', 'wpbl_remove_some_fields', 9999 ); 
function wpbl_remove_some_fields( $array ) {
 
    //unset( $array['billing']['billing_first_name'] ); // Имя
    unset( $array['billing']['billing_last_name'] ); // Фамилия
    //unset( $array['billing']['billing_email'] ); // Email
    unset( $array['order']['order_comments'] ); // Примечание к заказу
 
    //unset( $array['billing']['billing_phone'] ); // Телефон
    //unset( $array['billing']['billing_company'] ); // Компания
    //unset( $array['billing']['billing_country'] ); // Страна
    unset( $array['billing']['billing_address_1'] ); // 1-ая строка адреса 
    unset( $array['billing']['billing_address_2'] ); // 2-ая строка адреса 
    //unset( $array['billing']['billing_city'] ); // Населённый пункт
    unset( $array['billing']['billing_state'] );

    unset( $array['billing']['billing_postcode'] ); // Почтовый индекс
	unset($array['shipping_city']);
	unset($array['shipping_first_name']);
	unset($array['shipping_last_name']);
	unset($array['shipping_company']);
	unset($array['shipping_address_1']);
	unset($array['shipping_address_2']);
	unset($array['shipping_postcode']);
	unset($array['shipping_country']);
	unset($array['shipping_state']);
    // Возвращаем обработанный массив
    return $array;
}

add_filter( 'woocommerce_checkout_fields', 'woo_custom_fields' );
function woo_custom_fields( $array ) {
    // Меняем приоритет
	$array['billing']['billing_first_name']['priority'] = 10;
	$array['billing']['billing_first_name']['label'] = 'ФИО';
	$array['billing']['billing_first_name']['custom_attributes'] = array("minlength" => "5", "maxlength" => "80" );

	$array['billing']['billing_phone']['priority'] = 20;
	$array['billing']['billing_phone']['label'] = 'Контактный телефон';
	$array['billing']['billing_phone']['custom_attributes'] = array("inputmode" => "decimal", "minlength" => "11", "maxlength" => "11" );

	$array['billing']['billing_email']['priority'] = 30;
	$array['billing']['billing_email']['label'] = 'Электронная почта';

	$array['billing']['billing_city']['priority'] = 40;
	$array['billing']['billing_city']['label'] = 'Населённый пункт / Город';

	$array['billing']['billing_company']['priority'] = 80;
	$array['billing']['billing_company']['label'] = 'Название компании / ИП';

	$array['billing']['billing_country']['class'][0] = 'd-hide';

    // Возвращаем обработанный массив
    return $array;
}

add_filter( 'woocommerce_form_field_text', 'woo_form_field_billing', 10, 4 );
add_filter( 'woocommerce_form_field_email', 'woo_form_field_billing', 10, 4 );
add_filter( 'woocommerce_form_field_tel', 'woo_form_field_billing', 10, 4 );
function woo_form_field_billing( $field, $key, $args, $value ){

    if ( $args['required'] ) {
        //$args['class'][] = '';
        $required = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr>';
    } else {
        $required = '';
    }

    $args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';

    $args['autocomplete'] = ( $args['autocomplete'] ) ? 'autocomplete="' . esc_attr( $args['autocomplete'] ) . '"' : '';

    if ( is_string( $args['label_class'] ) ) {
        $args['label_class'] = array( $args['label_class'] );
    }

    if ( is_null( $value ) ) {
        $value = $args['default'];
    }

    // Custom attribute handling
    $custom_attributes = array();

    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
        }
    }

    $field = '';
    $label_id = $args['id'];
    $field_container = '<p class="field %1$s" id="%2$s">%3$s</p>';


	$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="field__input text-field__input input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . $args['label'] .'' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . $args['autocomplete'] . ' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';


    if ( ! empty( $field ) ) {

        $field_html = '';

        if ( $args['label']) {
            $field_html .= ''. $field.'<label for="' . esc_attr( $label_id ) . '" class="field__label ' . esc_attr( implode( ' ', $args['label_class'] ) ) .'">' . $args['label'] . $required . '</label>';
        }
		
        $container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
        $container_id = esc_attr( $args['id'] ) . '_field';

        $after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';

        $field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
    }
    return $field;
}

add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');
function my_custom_checkout_field_process() {
	$client_name = $_POST['billing_first_name'];
	$client_tel = $_POST['billing_phone'];
	$clean_str_tel = mb_eregi_replace('[^0-9]', '', $client_tel);
	if (!$client_name || (preg_match('/[^абвгдеёжзийклмнопрстуфхцчшщъыьэюя\s]+/isu', $client_name))) {
		wc_add_notice( __( '<span class="error_name">error_name</span>' ), 'error' );
	}
	if (mb_strlen($clean_str_tel) < 11 ) {
		wc_add_notice( __( '<span class="error_tel">error_tel</span>' ), 'error' );
	}
}

//Создаем поля, которые нужны при выборе юридического лица:
add_action( 'woocommerce_assembling', 'my_custom_checkout_field_assembling' );
function my_custom_checkout_field_assembling( $checkout ) {
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
    woocommerce_form_field( 'shipping_checkbox', array(
		'required'      => true,
        'type'          => 'checkbox',
		'class' 		=> 'custom-checkbox',
        'label'   		=>	'Требуется сборка мебели',
		'description' 	=>	'Стоимость сборки уточняйте у нашего менеджера',
    ), get_user_meta( $user_id, 'shipping_checkbox', true ));

}


add_filter( 'woocommerce_form_field_checkbox', 'woo_form_field_assembling', 10, 4 );
function woo_form_field_assembling( $field, $key, $args, $value ){

    $field = '';
    $label_id = $args['id'];
    $field_container = '<div class="checkout__descr">%3$s</div>';
    $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="custom-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value=""></input>';

    if ( ! empty( $field ) ) {
        $field_html = '';
        if ( $args['label']) {
            $field_html .= ''.$field.'<label for="' . esc_attr( $label_id ) . '">
			<span class="checkout__descr_title">' . $args['label'] . '</span>
			<span class="checkout__descr_subtitle">' . $args['description'] . '</span>
			</label>';
        }
        $container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
        $container_id = esc_attr( $args['id'] ) . '_field';
        $after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';
        $field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
    }
    return $field;
}

//Функция сохранения полей. Причем данные поля сохраняем не как order meta, а как user meta.
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta',25 );
function my_custom_checkout_field_update_order_meta( $order_id ) {
	if ( ! empty( $_POST['shipping_checkbox'] ) ) { update_user_meta( $order_id, 'shipping_assembling', sanitize_text_field( $_POST['shipping_checkbox'] ) ); }
}

//Вывести реквизиты в адмике (в заказе):
add_action( 'woocommerce_admin_order_data_after_billing_address', 'organisation_checkout_field_echo_in_admin_order', 25 );
function organisation_checkout_field_echo_in_admin_order( $order) {
	$ship_check = get_user_meta( $order->get_id(), 'shipping_assembling', true );
	echo '<h3 style="font-size: 14px;">Cборка мебели требуется:</h3>';
	if ($ship_check == '1') {
		echo '<p style="color:#A4C756;font-size: 14px;margin-top:0px;font-weight:600;">Да</p>';
	}else {
		echo '<p style="color:#F26060;font-size: 14px;margin-top:0px;font-weight:600;">Нет</p>';
	}
}

add_action('admin_head', 'my_admin_head');
function my_admin_head() {
    ?>
    <style>
    .order_data_column_container > .order_data_column:nth-child(3) {
        display:none !important;
    }
    </style>
<?
}

add_shortcode( 'call_form', 'call_form' );
function call_form() {

	ob_start();
	?>
	<!-- ---------------Popap-------------------- -->
	<div class="modal">
		<h3>Обратная связь</h3>
		<div class="form__subtitle">Напишите нам, мы обязательно ответим!</div>
		<form class="form" method="POST" id="feedback">
			<p class="field">
				<input class="field__input" type="text" class="text-field__input" name="form-name"
					id="form-name" placeholder="Ваше имя" autocomplete="given-name" value="">
				<label class="field__label" for="form-name">Ваше имя
					<abbr class="required" title="обязательно">*</abbr>
				</label>
			</p>
			<p class="field">
				<input class="field__input" type="email" name="form-email" id="form-email"
					placeholder="Электронная почта" autocomplete="email username" value="">
				<label class="field__label" for="form-email" class="">Электронная почта
					<abbr class="required" title="обязательно">*</abbr>
				</label>
			</p>
			<p class="field">
				<input class="field__input" type="tel" name="form-tel" id="form-tel"
					placeholder="Контактный телефон" autocomplete="tel" value="" inputmode="decimal" minlength="11" maxlength="11">
				<label class="field__label" for="form-tel" class="">Контактный телефон
					<abbr class="required" title="обязательно">*</abbr>
				</label>
			</p>
			<p class="field">
				<textarea class="field__input" name="form-message" id="form-message" placeholder="Текст сообщения"></textarea>
				<label class="field__label" for="form-message" class="">Текст сообщения
					<abbr class="required" title="обязательно">*</abbr>
				</label>
			</p>
			<input class="form__btn btn disabled" type="submit" value="Отправить сообщение" disabled>
			<p class="field checkbox">
				<input type="checkbox" name="popup-checkbox" id="popup-checkbox">
				<label for="popup-checkbox">Я согласен(-а) на обработку своих
					<a target="_blank" href="<? echo home_url(); ?>">персональных данных</a>
				</label>
			</p>
			
		</form>
		<button class="form__btn-close"></button>
	</div>
	<!-- ---------------Popap-------------------- -->
	<div id="overlay"></div>
	<div class="modal-access">
		<h3 class="form__title"></h3>
		<p class="form__subtitle"></p>
		<button class="form__btn-close"></button>
	</div>
	<?

	return ob_get_clean();
}
add_action( 'wp_ajax_feedback_action', 'ajax_action_callback' );
add_action( 'wp_ajax_nopriv_feedback_action', 'ajax_action_callback' );

function ajax_action_callback() {
	$clean_str_tel = mb_eregi_replace('[^0-9]', '', $_POST['form-tel']);
	// Массив ошибок
	$err_message = array();

	if ( ! wp_verify_nonce( $_POST['nonce'], 'feedback-nonce' ) ) {
		wp_die();
	}

	if ($_POST['popup-checkbox'] !== '1') {
		wp_die();
	}

	if ( empty( $_POST['form-name'] ) || ! isset( $_POST['form-name'] ) ) {
		$err_message['name'] = '';
	} else {
		$name = sanitize_text_field( $_POST['form-name'] );
	}

	if ( empty( $_POST['form-tel'] ) || ! isset( $_POST['form-tel'] ) ) {
		$err_message['tel'] = '';
	} elseif (mb_strlen($clean_str_tel) !== 11 ) {
		$err_message['tel'] = '';
	} else {
		$name = sanitize_text_field( $_POST['form-tel'] );
	}


	if ( empty( $_POST['form-email'] ) || ! isset( $_POST['form-email'] ) ) {
		$err_message['email'] = '';
	} elseif ( ! preg_match( '/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', $_POST['form-email'] ) ) {
		$err_message['email'] = '';
	} else {
		$email = sanitize_email( $_POST['form-email'] );
	}

	if ( empty( $_POST['form-message'] ) || ! isset( $_POST['form-message'] ) ) {
		$err_message['message'] = '';
	} else {
		$comments = sanitize_textarea_field( $_POST['form-message'] );
	}


	if ( $err_message ) {
		wp_send_json_error( $err_message );
	} else {

		// Указываем адресата

		$email_to = get_option( 'admin_email' );
		$art_subject = 'Сообщение с сайта Касар';
		// Если адресат не указан, то берем данные из настроек сайта
		// if ( ! $email_to ) {
		// 	$email_to = get_option( 'admin_email' );
		// }

		$name = $_POST['form-name'];
		$email= $_POST['form-email'];
		$tel = $_POST['form-tel'];
		$comments = $_POST['form-message'];
		$website_addr = get_site_url();
		$company_name = get_bloginfo('name');
		$message = '
			Поступила новая заявка <a href="' . $website_addr . '">с сайта</a> ' . $company_name . '.<br><br>
			<table>
				<tr style="background-color: #f8f8f8;">
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><b>Имя:</b></td>
					<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $name . '</td>
				</tr>
				<tr style="background-color: #f8f8f8;">
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><b>Телефон:</b></td>
					<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $tel . '</td>
				</tr>
				<tr style="background-color: #f8f8f8;">
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><b>E-mail:</b></td>
					<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $email . '</td>
				</tr>
				<tr style="background-color: #f8f8f8;">
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><b>Сообщение:</b></td>
					<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $comments . '</td>
				</tr>
			</table>
		';

		$body = $message;
		$headers = 'From: ' . $name . ' <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email_to;

		// Отправляем письмо
		$sent_message = wp_mail($email_to, $art_subject, $body, $headers );
  
		if ($sent_message ) {
			echo json_encode(array('message'=>__('OK')));
		} else {
			echo json_encode(array('message'=>__('ERROR')));
		}
	}

	die();

}

$enabled_mail_smtp = get_option('enabled_mail_smtp');
if ($enabled_mail_smtp) {
	add_action( 'phpmailer_init', 'my_phpmailer_example' );
	function my_phpmailer_example( $phpmailer ) {
		$phpmailer->isSMTP();     
		$phpmailer->Host = get_option('mail_custom_SMTP_HOST');
		$phpmailer->SMTPAuth = true; // Force it to use Username and Password to authenticate
		$phpmailer->Port = get_option('mail_custom_SMTP_PORT');
		$phpmailer->Username = get_option('admin_email');
		$phpmailer->Password = get_option('mail_custom_SMTP_PASS');
		$phpmailer->SMTPSecure = get_option('mail_custom_SMTP_SECURE');
	}

}

add_filter( 'wp_mail_content_type', 'true_content_type' );
 
function true_content_type( $content_type ) {
	return 'text/html';
}
// --------------- КОНЕЦ ОФОРМЛЕНИЯ ЗАКАЗА ---------------

// ------------------------- НАЧАЛО ДОПОЛНИТЕЛЬНЫЕ НУЖНЫЕ ИЗМЕНЕНИЯ, КОТОРЫЕ ДОЛЖНЫ НАХОДИТЬСЯ В КОНЦЕ ФАЙЛА -------------------------

//отключение абсолютно все стили WooCommerce (не удаляет в админке стили woo)
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


//Удаляем уведомление об обновлении WordPress для всех кроме админа
add_action( 'admin_head', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
		remove_action( 'admin_notices', 'maintenance_nag', 10 );
	}
} );

//Отключаем Gutenberg
add_filter('use_block_editor_for_post_type', '__return_false', 100);
add_action('admin_init', function() {
    remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
    add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']); 
});
function gut_style_disable() { wp_dequeue_style('wp-block-library'); }
add_action('wp_enqueue_scripts', 'gut_style_disable', 100);

add_action( 'init', 'true_remove_woo_image_sizes', 999 ); // отключение ненужных размеров img WP (это все нужно в конце func.php!)
function true_remove_woo_image_sizes() {
	remove_image_size( 'woocommerce_single' );
	remove_image_size( 'shop_single' );
	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );
	remove_image_size( 'woocommerce_thumbnail' );
	remove_image_size( 'shop_catalog' );
 	remove_image_size( 'woocommerce_gallery_thumbnail' );
	remove_image_size( 'shop_thumbnail' );
	//remove_image_size( 'large' );
	//remove_image_size( 'thumbnail' );
	//remove_image_size( 'medium' );
	remove_image_size( 'medium_large' );
}

add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' ); // удаляем все неиспользуемые размеры img WP (это все нужно в конце func.php!)
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		//'thumbnail',
		//'medium',
		'medium_large',
		//'large',
		'1536x1536',
		'2048x2048',
	] );
}

//удаляем мета-тег версии движка с DOM дерева
add_filter('the_generator', 'remove_wpversion');
function remove_wpversion() {
	return '';
}


// //удаляем версию движка WP в конце файлов css/js
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
function remove_cssjs_ver( $src ) {
    if( strpos($src,'?ver='))
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// //удаление ненужных текстов в DOM дереве(type для css)
add_filter('style_loader_tag', 'clean_style_tag');
function clean_style_tag($src) {
    return str_replace("type='text/css'", '', $src);
}

// //удаление ненужных текстов в DOM дереве(type для js)
add_filter('script_loader_tag', 'clean_script_tag');
function clean_script_tag($src) {
    return str_replace("type='text/javascript'", '', $src);
}


// Удалить ссылки на RSS ленты
function fb_disable_feed(){wp_redirect(get_option('siteurl'));}
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
add_action( 'do_feed', 'fb_disable_feed', 1 );
add_action( 'do_feed_rdf', 'fb_disable_feed', 1 );
add_action( 'do_feed_rss', 'fb_disable_feed', 1 );
add_action( 'do_feed_rss2', 'fb_disable_feed', 1 );
add_action( 'do_feed_atom', 'fb_disable_feed', 1 );


// Отключаем Emoji
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

//Отменяем srcset
add_filter('wp_calculate_image_srcset_meta', '__return_null' );
add_filter('wp_calculate_image_sizes', '__return_false', 99 );
remove_filter('the_content', 'wp_make_content_images_responsive' );

//Отключение XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

//Отключение dns-prefetch
remove_action( 'wp_head', 'wp_resource_hints', 2 );

//Отключение rel shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

add_filter( 'product_type_options', function( $options ) {
	// remove "Virtual" checkbox
	if( isset( $options[ 'virtual' ] ) ) {
		unset( $options[ 'virtual' ] );
	}
	// remove "Downloadable" checkbox
	if( isset( $options[ 'downloadable' ] ) ) {
		unset( $options[ 'downloadable' ] );
	}
	return $options;
});

add_filter( 'manage_edit-product_columns', 'change_columns_filter',10, 1 );
function change_columns_filter( $columns ) {
	unset($columns['thumb']);
	unset($columns['name'] );
	unset($columns['sku'] );
	unset($columns['is_in_stock']);
	unset($columns['price']);
	unset($columns['product_cat'] );
	unset($columns['product_tag']);
	unset($columns['featured']);
	unset($columns['product_type']);
	unset($columns['date']);
	$columns['name'] = 'Имя товара';
	$columns['thumb'] = 'Превью';
	$columns['product_cat'] = 'Категория';
	$columns['price'] = 'Цена';
	$columns['sku'] = 'Артикул';
	return $columns;
}

add_filter( 'product_type_selector', 'misha_remove_grouped_and_external' );
 
function misha_remove_grouped_and_external( $product_types ){
	unset( $product_types['grouped'] );
	unset( $product_types['external'] );
	unset( $product_types['variable'] );
	return $product_types;
}

//Отключение виртуальный, скачиваемый товары
add_filter( 'woocommerce_products_admin_list_table_filters', function( $filters ) {
	if( isset( $filters[ 'product_type' ] ) ) {
		$filters[ 'product_type' ] = 'misha_product_type_callback';
	}
	return $filters;
});

//Отключение виртуальный, скачиваемый товары в админке фильтрации
function misha_product_type_callback(){
	$current_product_type = isset( $_REQUEST['product_type'] ) ? wc_clean( wp_unslash( $_REQUEST['product_type'] ) ) : false;
	$output               = '<select name="product_type" id="dropdown_product_type"><option value="">Фильтровать по типу товара</option>';
	foreach ( wc_get_product_types() as $value => $label ) {
		$output .= '<option value="' . esc_attr( $value ) . '" ';
		$output .= selected( $value, $current_product_type, false );
		$output .= '>' . esc_html( $label ) . '</option>';
	}
	$output .= '</select>';
	echo $output;
}

//Что-то отключает лишнее в Gutenberg, но хрен знай что именно
add_action('wp_footer','wooexperts_remove_block_data',0);
add_action('admin_enqueue_scripts','wooexperts_remove_block_data',0);
function wooexperts_remove_block_data(){ 
    remove_filter('wp_print_footer_scripts',array('Automattic\WooCommerce\Blocks\Assets','print_script_block_data'),1);
    remove_filter('admin_print_footer_scripts',array('Automattic\WooCommerce\Blocks\Assets','print_script_block_data'),1);
}

//Footer в админке
add_filter('admin_footer_text', 'remove_footer_admin');
function remove_footer_admin () {
	echo 'Разработка Интернет-магазинов <a href="https://weblitex.ru" target="_blank">ООО "Лайтекс"</a> | E-mail: <a href="mailto:info@weblitex.ru">info@weblitex.ru</a> | Сайт разработан на основе WordPress.</p>
	<style>
	#dropdown_product_type {display:none !important;}
	select[name="stock_status"]{display:none !important;}
	.options_group .form-field._sale_price_field{display:none !important;}
	.postbox-header .hndle.ui-sortable-handle .type_box.hidden {display:none !important;}
	.postbox-header .hndle.ui-sortable-handle .product-type{display:none !important;}
	#postdivrich #wp-content-media-buttons{display:none !important;}
	#woocommerce-fields.inline-edit-col .dimension_fields, #woocommerce-fields.inline-edit-col .inline-edit-group, #woocommerce-fields.inline-edit-col .stock_status_field, .inline-edit-tags-wrap, .inline-edit-group.wp-clearfix, #woocommerce-fields.inline-edit-col .text:nth-child(3) {display:none !important;}
	</style>
	<script type="text/javascript">
	var elementToHideList = document.getElementsByClassName("text wc_input_price sale_price");
	for (var i = elementToHideList.length; i--;) {
    elementToHideList[i].parentNode.parentNode.style.display = "none"; }

	var description;
	description = document.querySelectorAll("tr.shipping > td.name > div.view > table.display_meta > tbody > tr:nth-child(1) > th");
	for (var i = 0; i < description.length; i++) {
		description[i].innerHTML = "Описание:";
	}

	var dataClient;
	dataClient = document.querySelectorAll("#order_data > div.order_data_column_container > div.order_data_column > h3:nth-child(1)");
	for (var i = 0; i < dataClient.length; i++) {
		dataClient[i].innerHTML = "Данные клиента:";
	}
</script>
	';
}
//Скрываем пункты меню в админке
add_action('admin_menu', 'remove_admin_menu');
function remove_admin_menu()
{
  remove_menu_page('edit.php'); // Записи
  remove_menu_page('edit-comments.php'); // Комментарии
  remove_menu_page('marketing'); // Комментарии
}

//Скрываем пункты меню Advanced Custom Fields
add_filter('acf/settings/show_admin', '__return_false');

add_filter( 'woocommerce_product_data_tabs', 'truemisha_new_tab' );
 
function truemisha_new_tab( $tabs ){
	unset( $tabs[ 'shipping' ] ); // Доставка
	unset( $tabs[ 'advanced' ] ); // Дополнительно
	unset( $tabs[ 'linked_product' ] );
	unset( $tabs[ 'attribute' ] );

	// $tabs['general']['priority'] = 1;
	// $tabs['general']['label'] = 'Цены';
	
	// $tabs['attribute']['priority'] = 2;
	// $tabs['attribute']['label'] = 'Характеристики';

	// $tabs['linked_product']['priority'] = 3;
	// $tabs['linked_product']['label'] = 'Предложить доп. товары';

	// $tabs['inventory']['priority'] = 4;
	// $tabs['inventory']['label'] = 'Артикул';

	return $tabs;
}

//Скрытые пункта меню маркетинг в woo
add_filter( 'woocommerce_admin_features', function( $features ) {
    return array_values(
        array_filter( $features, function($feature) {
            return $feature !== 'marketing';
        } ) 
    );
});

//Скрытие меток в товары woo
add_action('admin_menu', 'remove_submenus');
function remove_submenus() {
	global $submenu;
	unset($submenu['edit.php?post_type=product'][16]); //скрытие меток woo
	unset($submenu['edit.php?post_type=product'][17]); //атрибуты меток woo
	unset($submenu['edit.php?post_type=product'][18]); //отзывы меток woo

}

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
 
function my_custom_dashboard_widgets() {
global $wp_meta_boxes;

wp_add_dashboard_widget('custom_help_widget', 'Поддержка Вашего сайта', 'custom_dashboard_help');
}

function custom_dashboard_help() {
echo '<p>Добро пожаловать в админ-панель управления Вашим Интернет-магазином.<br>Сайт разработан студией <a href="https://weblitex.ru" target="_blank">ООО "Лайтекс"</a>. Нужна помощь, доработка функционала?<br> Свяжитесь с нами <a href="mailto:info@weblitex.ru">info@weblitex.ru</a></p>';
}

// function remove_submenus() {
// 	global $submenu;
// 	echo '<pre>';
// 	var_dump($submenu);
// 	echo '</pre>';
//   }
//   add_action('admin_menu', 'remove_submenus');


//Добавление слово от в цену итого в письме клиентам
add_filter( 'woocommerce_get_order_item_totals', 'custom_order_total_message_html', 10, 3 );
function custom_order_total_message_html( $total_rows, $order, $tax_display ) {
    if( in_array( $order->get_shipping_country(), array('RU') ) && isset($total_rows['order_total']) && ! is_wc_endpoint_url() ) {
		$gran_total = $total_rows['order_total'];
		unset( $total_rows['order_total'] );
		$total_rows['order_total']['label'] = __( 'Total:', 'woocommerce' );
		$total_rows['order_total']['value'] = 'от '.$order->get_formatted_order_total();
    }
    return $total_rows;
}