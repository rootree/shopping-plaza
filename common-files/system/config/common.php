<?php defined('SYSPATH') OR die('No direct access allowed.');

defined('PAGE_LOGIN') or define('PAGE_LOGIN', 'login');
defined('PAGE_DASHBOARD') or define('PAGE_DASHBOARD', 'dashboard');
defined('PAGE_MAIN') or define('PAGE_MAIN', 'main');
defined('PAGE_REG') or define('PAGE_REG', 'reg');
defined('PAGE_API') or define('PAGE_API', 'reg');
defined('PAGE_TOUR') or define('PAGE_TOUR', 'tour');
defined('PAGE_HELP') or define('PAGE_HELP', 'help');
defined('PAGE_DESIGN') or define('PAGE_DESIGN', 'design');
defined('PAGE_EXAMPLES') or define('PAGE_EXAMPLES', 'examples');
defined('PAGE_PRICE') or define('PAGE_PRICE', 'price');

defined('PAGE_ARTICLE') or define('PAGE_ARTICLE', 'articles');

define('TYPE_ERROR', '1');
define('TYPE_INFO',  '0');
define('TYPE_HELP',  '2');


define('STATUS_WORK',  1);
define('STATUS_HIDE',  2);
define('STATUS_DELETED',  3);


$GLOBALS['ITEM_STATUS'] = array(
    STATUS_WORK => "На сайте",
    STATUS_HIDE => "Скрыт на сайте",
    STATUS_DELETED => "Удалён",
);

define('DATE_FORMAT', 'd.m.Y H:s');
define('DATE_FORMAT_LITE', 'd.m.Y');
define('DATE_FORMAT_DB', '%d.%m.%Y');

define('BASE_PATH', "http://".$_SERVER['SERVER_NAME']."/");
define('MAIL_ROBOT', "no-reply@mail.shopping-plaza.ru");
define('MAIL_ADMIN', "******@******.com");
define('MAIL_TITLE', "Shopping-Plaza.ru");
define('MAIL_SLOGAN', "Shopping-Plaza - это издатель Интернет-магазинов.");

define('WORD_SOLT', 'solt1');
define('WORD_SOLT_CLIENT', 'solt2');
define('WORD_SOLT_CONFIRM', 'solt3');

define('IMAGES_TYPE_COMMON', 'common');
define('IMAGES_TYPE_PRODUCT', 'product');
define('IMAGES_TYPE_LOGO', 'logo');
define('IMAGES_TYPE_WATERMARK', 'watermark');
define('IMAGES_TYPE_PRICE', 'prices');
define('IMAGES_TYPE_YANDEX', 'yandex');


switch ($GLOBALS['runningOn']){
    case 3: // DEV

        define('STORE_ON_DISC', '/var/www/static');
        define('STORE_ON_WWW', 'http://static.shopping-plaza.ru');


        define('DB_USER', 'user');
        define('DB_PASS', '******');
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'db');
        define('GOOGLE_MAP_KEY', '******');
        define('YANDEX_MAP_KEY', '******');

        define('SERVER_ROOT', '/var/shopping-plaza.ru');

        break;

    case 2: // DEV


        break;

    case 1: // Home

        define('SERVER_ROOT', 'D:\Source\magaz');
        define('STORE_ON_WWW', 'http://static.shopping-plaza.local');

        define('DB_USER', 'root');
        define('DB_PASS', '******');
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'db');

        define('GOOGLE_MAP_KEY', '******');
        define('YANDEX_MAP_KEY', '******');

        break;
}

define('IMAGES_STORE_ON_DISC', SERVER_ROOT . '\static\products');
define('IMAGES_STORE_IN_WWW', STORE_ON_WWW . '/products');

define('IMAGES_COMMON_ON_DISC', SERVER_ROOT . '\static\common');
define('IMAGES_COMMON_IN_WWW', STORE_ON_WWW . '/common');

define('IMAGES_LOGO_ON_DISC', SERVER_ROOT . '\static\logotypes');
define('IMAGES_LOGO_IN_WWW', STORE_ON_WWW . '/logotypes');

define('IMAGES_WATERMARK_ON_DISC', SERVER_ROOT . '\static\watermark');
define('IMAGES_WATERMARK_IN_WWW', STORE_ON_WWW . '/watermark');

define('IMAGES_PRICE_ON_DISC', SERVER_ROOT . '\static\prices');
define('IMAGES_PRICE_IN_WWW', STORE_ON_WWW . '/prices');

define('IMAGES_YANDEX_ON_DISC', SERVER_ROOT . '\static\yandex');
define('IMAGES_YANDEX_IN_WWW', STORE_ON_WWW . '/yandex');

define('MAINPAGE_PRICE_NEW', '1');
define('MAINPAGE_PRICE_WEEK', '2');
define('MAINPAGE_PRICE_SPEC', '3');
define('MAINPAGE_PRICE_POPULAR', '4');
define('MAINPAGE_PRICE_BUY', '5');

define('SHOW_ON_SITE_NEWS', 1);
define('SHOW_ON_SITE_PARTNERS', 2);
define('SHOW_ON_SITE_VACANCY', 4);
define('SHOW_ON_SITE_PAGES', 8);

define('IMPORT_TYPE_EXCEL', '1');
define('IMPORT_TYPE_CSV', '2');

define('CONFIRM_NEW_FIRM', 1);
define('CONFIRM_NEW_USER', 2);
define('CONFIRM_NEW_MAIL', 3);
define('CONFIRM_MAIL', 4);
define('CONFIRM_DONE', 0);

define('SMS_ON_AMDIN_NEW_ORDER', 1);
define('SMS_ON_AMDIN_NEW_FEEDBACK', 2);
define('SMS_ON_AMDIN_NEW_CALLBACK', 4);
define('SMS_ON_NEW_ORDER', 8);
define('SMS_ON_ORDER_SEND', 16);
define('SMS_ON_SYSTEM_REG', 32);
define('SMS_ON_SYSTEM_RESPONSE', 64);
define('SMS_ON_AMDIN_COMMENT', 128);


define('COMMENT_ON_ITEMS', 1);
define('COMMENT_ON_NEWS', 2);
define('COMMENT_ON_ARTICLE', 4);

$GLOBALS['COMMENT_ON'] = array(
    COMMENT_ON_ITEMS => "Продукция",
    COMMENT_ON_NEWS => "Новость",
    COMMENT_ON_ARTICLE => "Страница",
);

define('COMMENT_STATUS_NEW', 1);
define('COMMENT_STATUS_CHACKED', 2);
define('COMMENT_STATUS_DELETED', 3);
define('COMMENT_STATUS_VIEWED', 4);
define('COMMENT_STATUS_ANSWER', 5);
define('COMMENT_STATUS_ANSWERED', 6);


$GLOBALS['COMMENT_STATUS'] = array(
    COMMENT_STATUS_NEW => "Новый",
    COMMENT_STATUS_DELETED => "Удалённый",
    COMMENT_STATUS_VIEWED => "Просмотренный",
    COMMENT_STATUS_CHACKED => "Обработан",
    COMMENT_STATUS_ANSWER => "Ответ на коментарий",
    COMMENT_STATUS_ANSWERED => "Есть ответ",
);


$GLOBALS['SMS_SETTINGS'] = array(
    SMS_ON_AMDIN_NEW_ORDER      => 'Поступил новый заказ',
    SMS_ON_AMDIN_NEW_FEEDBACK   => 'Сообщение от пользователя',
    SMS_ON_AMDIN_NEW_CALLBACK   => 'Оставлен номер для обратного звонка',
    SMS_ON_AMDIN_COMMENT        => 'Оставлен коментарии',
);

$GLOBALS['CAT'] = array(
    "++" => null,
    1 => "Сады",
    "--" => null,
    3 => "Сады--",
    4 => "Сады***",
);

$GLOBALS['CITY'] = array(
    "Москва" => null,
    1 => "Москва",
    "Питер" => null,
    3 => "Питергофф",
    4 => "Питергофф***",
);

$GLOBALS['VACANCY_XP'] = array(
    1 => "от года",
    2 => "1-3 года",
    3 => "всю жизнь",
);

$GLOBALS['VACANCY_EMPL_TYPE'] = array(
    1 => "полная",
    2 => "частичная",
);



$GLOBALS['PAYMENT_TYPE'] = array(
    1 => "Начисными",
    2 => "Безналичными",
    4 => "Ещё какими-либо",
);

define('MECRIC_TYPE_SHT', 1);
define('MECRIC_TYPE_LITR', 2);
define('MECRIC_TYPE_KG', 3);

$GLOBALS['MECRIC_TYPE'] = array(
    0 => "-",
    MECRIC_TYPE_SHT => "шт.",
    MECRIC_TYPE_LITR => "литр.",
    MECRIC_TYPE_KG => "Кг.",
);


define('ORDER_STATUS_NEW', 1);
define('ORDER_STATUS_CANCEL', 2);
define('ORDER_STATUS_VIEWED', 3);
define('ORDER_STATUS_PROCEEDED', 5);
define('ORDER_STATUS_DELIVERED', 7);
define('ORDER_STATUS_PAYED', 8);

$GLOBALS['ORDER_STATUS'] = array(
    ORDER_STATUS_NEW => "Новый",
    ORDER_STATUS_CANCEL => "Отменённый",
    ORDER_STATUS_VIEWED => "Просмотренный",
    ORDER_STATUS_PROCEEDED => "Обработанный",
    ORDER_STATUS_DELIVERED => "Отправленный",
    ORDER_STATUS_PAYED => "Оплаченный",
);

define('RESPONSE_STATUS_NEW', 1);
define('RESPONSE_STATUS_CANCEL', 2);
define('RESPONSE_STATUS_VIEWED', 3);
define('RESPONSE_STATUS_PROCEEDED', 5);

define('RESPONSE_TYPE_QUESTION', 1);
define('RESPONSE_TYPE_PREDLO', 2);
define('RESPONSE_TYPE_ERROR', 3);
define('RESPONSE_TYPE_OTHER', 4);
define('RESPONSE_TYPE_SERVICE', 5);

define('TEMPLATE_1', "template1");
define('TEMPLATE_2', "template2");
define('TEMPLATE_3', "template3");

define('SEARCH_TYPE_NEWS', "news");
define('SEARCH_TYPE_PRODUCTS', "products");
define('SEARCH_TYPE_ORDER', "orders");
define('SEARCH_TYPE_FEEDBACK', "feedback");
define('SEARCH_TYPE_COMMENTS', "comments");
define('SEARCH_TYPE_PARTNER', "partner");
define('SEARCH_TYPE_PAGES', "pages");
define('SEARCH_TYPE_VACANCY', "vacancy");
// define('SEARCH_TYPE_PAGES', "pages");

$GLOBALS['RESPONSE_TYPE'] = array(
    RESPONSE_TYPE_QUESTION => "Вопрос по работе сервиса",
    RESPONSE_TYPE_PREDLO => "Предложение",
    RESPONSE_TYPE_ERROR => "Найдена ошибка",
    RESPONSE_TYPE_OTHER => "Другое",
);

define('FEEDBACK_STATUS_NEW', 1);
define('FEEDBACK_STATUS_CANCEL', 2);
define('FEEDBACK_STATUS_VIEWED', 3);
define('FEEDBACK_STATUS_PROCEEDED', 5);

$GLOBALS['FEEDBACK_STATUS'] = array(
    FEEDBACK_STATUS_NEW => "Новый",
    FEEDBACK_STATUS_CANCEL => "Проигнорирован",
    FEEDBACK_STATUS_VIEWED => "Просмотренный",
    FEEDBACK_STATUS_PROCEEDED => "Обработан",
);

define('CALLBACK_STATUS_NEW', 1);
define('CALLBACK_STATUS_CANCEL', 2);
define('CALLBACK_STATUS_PROCEEDED', 5);

$GLOBALS['CALLBACK_STATUS'] = array(
    CALLBACK_STATUS_NEW => "Новый",
    CALLBACK_STATUS_CANCEL => "Проигнорирован",
    CALLBACK_STATUS_PROCEEDED => "Обработан",
);

define('CLIENT_TYPE_FIZ', 1);
define('CLIENT_TYPE_IUR', 2);

$GLOBALS['CLIENT_TYPE'] = array(
    CLIENT_TYPE_FIZ => "Физическое лицо",
    CLIENT_TYPE_IUR => "Юридическое лицо",
);

define('FIELD_TYPE_NONE', 1);
define('FIELD_TYPE_BANK', 2);
define('FIELD_TYPE_BANK_FIZ_LICO', 3);

$GLOBALS['FIELD_TYPE'] = array(
    FIELD_TYPE_NONE => "Не требуються",
    FIELD_TYPE_BANK => "Банковские реквизиты для юридического лица",
    FIELD_TYPE_BANK_FIZ_LICO => "Банковские реквизиты для физического лица",
);


$GLOBALS['PAY_WAY_TYPE'] = array(
    FIELD_TYPE_BANK => array(
        "nameFirm" => getDeliveryType("Название компании", "trim", true),
        "inn" => getDeliveryType("ИНН", "trim", true),
        "kpp" => getDeliveryType("КПП", "trim", true),
        "okpo" => getDeliveryType("ОКПО", "trim", true),
        "address" => getDeliveryType("Юр.адрес", "trim", true),
        "account" => getDeliveryType("Расчётный счёт", "trim", true),
        "bank" => getDeliveryType("Банк", "trim", true),
        "cityBank" => getDeliveryType("Город банка", "trim", true),
        "korrAc" => getDeliveryType("Корр.счёт", "trim", true),
        "bik" => getDeliveryType("БИК", "trim", true),
        "comment" => getDeliveryType("Комментарии", "trim", false),
    ),
    FIELD_TYPE_BANK_FIZ_LICO => array(

    ),
    FIELD_TYPE_NONE => array(
    )
);

define('DELIVERY_TYPE_CURIER', 1);
define('DELIVERY_TYPE_CURIER_TO_METRO', 8);
define('DELIVERY_TYPE_HIMSELF', 2);
define('DELIVERY_TYPE_EMS', 4);
define('DELIVERY_TYPE_CURIER_TO_MCAD', 16);

$GLOBALS['DELIVERY'] = array(
    DELIVERY_TYPE_CURIER => "Курьер",
    DELIVERY_TYPE_CURIER_TO_METRO => "Курьер до метро",
    DELIVERY_TYPE_CURIER_TO_MCAD => "Курьер за МКАД",
    DELIVERY_TYPE_HIMSELF => "Самовывоз",
    DELIVERY_TYPE_EMS => "Почта",
);


$GLOBALS['DELIVERY_FIELDS'] = array(
    DELIVERY_TYPE_CURIER => array(
        "name" => getDeliveryType("Имя", "trim", true),
        "mail" => getDeliveryType("Электронный адрес", "trim", true),
        "phone" => getDeliveryType("Телефон", "trim", true),
        "metro" => getDeliveryType("Метро", "trim", false),
        "street" => getDeliveryType("Улица", "trim", true),
        "house" => getDeliveryType("Дом", "trim", true),
        "houseAddOn" => getDeliveryType("Строение/корпус", "trim", false),
        "podiezd" => getDeliveryType("Подъезд", "trim", false),
        "floor" => getDeliveryType("Этаж", "trim", false),
        "apr" => getDeliveryType("Квартира/Офис", "trim", true),
        "domoph" => getDeliveryType("Домофон", "trim", false),
        "comment" => getDeliveryType("Комментарии", "trim", false),
    ),
    DELIVERY_TYPE_CURIER_TO_MCAD => array(
        "name" => getDeliveryType("Имя", "trim", true),
        "mail" => getDeliveryType("Электронный адрес", "trim", true),
        "phone" => getDeliveryType("Телефон", "trim", true),
        "metro" => getDeliveryType("Город/Поселение", "trim", false),
        "distance" => getDeliveryType("Расстояние от МКАД (км)", "trim", false),
        "street" => getDeliveryType("Улица", "trim", true),
        "house" => getDeliveryType("Дом", "trim", true),
        "houseAddOn" => getDeliveryType("Строение/корпус", "trim", false),
        "podiezd" => getDeliveryType("Подъезд", "trim", false),
        "floor" => getDeliveryType("Этаж", "trim", false),
        "apr" => getDeliveryType("Квартира/Офис", "trim", true),
        "domoph" => getDeliveryType("Домофон", "trim", false),
        "comment" => getDeliveryType("Комментарии", "trim", false),
    ),
    DELIVERY_TYPE_CURIER_TO_METRO => array(
        "name" => getDeliveryType("Имя", "trim", true),
        "mail" => getDeliveryType("Электронный адрес", "trim", true),
        "phone" => getDeliveryType("Телефон", "trim", true),
        "metro" => getDeliveryType("Метро", "trim", true),
        "street" => getDeliveryType("Улица", "trim", false),
        "comment" => getDeliveryType("Комментарии", "trim", false)
    ),
    DELIVERY_TYPE_HIMSELF => array(
        "name" => getDeliveryType("Имя", "trim", true),
        "mail" => getDeliveryType("Электронный адрес", "trim", true),
        "phone" => getDeliveryType("Телефон", "trim", true),
    ),
    DELIVERY_TYPE_EMS =>  array(
        "soname" => getDeliveryType("Фамилия", "trim", true),
        "name" => getDeliveryType("Имя", "trim", true),
        "thirdName" => getDeliveryType("Отчество", "trim", true),
        "mail" => getDeliveryType("Электронный адрес", "trim", true),
        "phone" => getDeliveryType("Телефон", "trim", true),
        "index" => getDeliveryType("Индекс", "intval", true),
        "region" => getDeliveryType("Регион", "trim", true),
        "city" => getDeliveryType("Город", "trim", true),
        "street" => getDeliveryType("Улица", "trim", true),
        "house" => getDeliveryType("Дом", "trim", true),
        "houseAddOn" => getDeliveryType("Строение/корпус", "trim", false),
        "podiezd" => getDeliveryType("Подъезд", "trim", false),
        "floor" => getDeliveryType("Этаж", "trim", false),
        "apr" => getDeliveryType("Квартира", "trim", true),
        "domoph" => getDeliveryType("Домофон", "trim", false),
        "comment" => getDeliveryType("Комментарии", "trim", false),
    ),
);

function getDeliveryType($name, $type, $must ){
    $fe = new stdClass();
    $fe->name = $name;
    $fe->type = $type;
    $fe->must = $must;
    return $fe;
}

define('PLAN_FREE', 1);
define('PLAN_BASE', 2);
define('PLAN_STAND', 3);
define('PLAN_MAX', 4);
define('PLAN_ELITE', 5);

function getPriceByPlan($plan){
    switch($plan){
        case PLAN_FREE: return 0;
        case PLAN_BASE: return 120;
        case PLAN_STAND: return 300;
        case PLAN_MAX: return 1500;
        case PLAN_ELITE: return 3200;
    };
    return 0;
}