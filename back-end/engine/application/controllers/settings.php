<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Настройка интернет-магазина
 *
 * @package    Notify
 * @author     Ivan Chura
 */

class Settings_Controller extends Web_Controller
{

    const SUBPAGE_MAIN       = 'main';
    const SUBPAGE_FIRM       = 'firm';
    const SUBPAGE_ENABLED    = 'enabled';
    const SUBPAGE_SALES      = 'sales';
    const SUBPAGE_API        = 'api';
    const SUBPAGE_USERS      = 'users';
    const SUBPAGE_USERS_ADD  = 'usersadd';
    const SUBPAGE_FIELDS     = 'fields';
    const SUBPAGE_FIELDS_ADD = 'fieldsadd';

    const SUBPAGE_CATS         = 'cats';
    const SUBPAGE_CATS_ADD     = 'catsadd';
    const SUBPAGE_CATS_SUB     = 'catssub';
    const SUBPAGE_CATS_ADD_SUB = 'catsaddsub';

    const SUBPAGE_DELIVERY        = 'delivery';
    const SUBPAGE_DELIVERY_ADD    = 'deliveryadd';
    const SUBPAGE_DELIVERY_EDIT   = 'deliveryedit';
    const SUBPAGE_DELIVERY_DELETE = 'catsaddsub';

    const SUBPAGE_PAY        = 'pay';
    const SUBPAGE_PAY_ADD    = 'payadd';
    const SUBPAGE_PAY_EDIT   = 'payedit';
    const SUBPAGE_PAY_DELETE = 'paydelete';

    const SUBPAGE_TUTORIAL = 'tutorial';
    const SUBPAGE_ACCOUNT  = 'account';

    const SUBPAGE_CONTENT = 'content';

    public function __construct()
    {
        parent::__construct();
        $this->accessRules = array(

            'content'        => ACCESS_ADMIN,
            'enabled'        => ACCESS_ADMIN,
            'sales'          => ACCESS_ADMIN,
            'api'            => ACCESS_ADMIN,

            'pay'            => ACCESS_ADMIN,
            'payadd'         => ACCESS_ADMIN,
            'payedit'        => ACCESS_ADMIN,
            'paydelete'      => ACCESS_ADMIN,

            'delivery'       => ACCESS_ADMIN,
            'deliveryadd'    => ACCESS_ADMIN,
            'deliveryedit'   => ACCESS_ADMIN,
            'deliverydelete' => ACCESS_ADMIN,

            'index'          => ACCESS_ADMIN + ACCESS_VIEWER,
            'firm'           => ACCESS_ADMIN + ACCESS_VIEWER,
            'users'          => ACCESS_ADMIN,
            'usersadd'       => ACCESS_ADMIN,
            'useredit'       => ACCESS_ADMIN,
            'userdelete'     => ACCESS_ADMIN,

            'fields'         => ACCESS_ADMIN + ACCESS_VIEWER,
            'fieldsadd'      => ACCESS_ADMIN + ACCESS_VIEWER,
            'fieldsedit'     => ACCESS_ADMIN,
            'fieldsdelete'   => ACCESS_ADMIN,

            'cats'           => ACCESS_ADMIN,
            'catsadd'        => ACCESS_ADMIN,
            'catsedit'       => ACCESS_ADMIN,
            'catsdelete'     => ACCESS_ADMIN,

            'catssub'        => ACCESS_ADMIN,
            'subcatcopy'     => ACCESS_ADMIN,
            'catsaddsub'     => ACCESS_ADMIN,
            'catseditsub'    => ACCESS_ADMIN,
            'catsdeletesub'  => ACCESS_ADMIN,

            'tutorial'       => ACCESS_ADMIN,
            'account'        => ACCESS_ADMIN,

        );

        $this->selected_page = PAGE_SETTINGS;

        if (array_key_exists('up', $_REQUEST)) {
            $this->info = 'Информация об Интернет-магазине изменена.';
        }
        if (array_key_exists('upMainPage', $_REQUEST)) {
            $this->info = 'Главная страница Интернет-магазина изменена.';
        }
        if (array_key_exists('upFirm', $_REQUEST)) {
            $this->info = 'Информация о фирме изменена.';
        }

        // Админы --------------
        if (array_key_exists('userDeleted', $_REQUEST)) {
            $this->info = 'Администратор Интернет-магазина успешно удалён.';
        }
        if (array_key_exists('userDemo', $_REQUEST)) {
            $this->info = 'Главного управляющего демо-магазина нельзя удалить или изменть.';
        }
        if (array_key_exists('userUpdated', $_REQUEST)) {
            $this->info = 'Данные об администраторе Интернет-магазина успешно обновлены.';
        }
        if (array_key_exists('userUpdatedMail', $_REQUEST)) {
            $this->info = 'Данные об администраторе Интернет-магазина успешно обновлены. Внимание! На новый электронный адрес администратора магазина выслано письмо для подтверждения принадлежности нового адреса к администратору.';
        }
        if (array_key_exists('newUser', $_REQUEST)) {
            $this->info = 'Новый администратор успешно зарегестрирован. Ему отправлено письмо-приглащение о вступлении в ваш магазин. Чтобы он смог воспользоваться своим аккаунтом, ему стоит следовать инструкциям указаным в отправленном письме.';
        }

        if (array_key_exists('userDoNotDeleted', $_REQUEST)) {
            $this->error = 'Администатор не будет удалён, т.к. он единственный на весь Интернет-магазин. Зарегестрируйте нового администратора, затем вы сможете удалить текущего.';
        }

        /// payWay

        if (array_key_exists('updatedPayWay', $_REQUEST)) {
            $this->info = 'Способ оплаты успешно изменён.';
        }
        if (array_key_exists('newPayWay', $_REQUEST)) {
            $this->info = 'Новый способ оплаты успешно добавлен.';
        }
        if (array_key_exists('deletedPayWay', $_REQUEST)) {
            $this->info = 'Cпособ оплаты успешно удалён.';
        }

        if (array_key_exists('doNotDeletedPayWay', $_REQUEST)) {
            $this->error = 'Произошла ошибка при удалении способа оплаты.';
        }
        /// delivery

        if (array_key_exists('updatedDelivery', $_REQUEST)) {
            $this->info = 'Способ оплаты успешно изменён.';
        }
        if (array_key_exists('newDelivery', $_REQUEST)) {
            $this->info = 'Новый способ доставки успешно добавлен.';
        }
        if (array_key_exists('deletedDelivery', $_REQUEST)) {
            $this->info = 'Cпособ оплаты успешно удалён.';
        }

        if (array_key_exists('doNotDeletedPayWay', $_REQUEST)) {
            $this->error = 'Произошла ошибка при удалении способа оплаты.';
        }
        /// delivery

        if (array_key_exists('updatedCat', $_REQUEST)) {
            $this->info = 'Информация о категории успешно изменена.';
        }
        if (array_key_exists('newCat', $_REQUEST)) {
            $this->info = 'Новая категория успешно добавлена. В ней вы можете создать новые подкатегории (кнопка: <a class="openBtn" href="#">Открыть подкатегории</a> - напротив выбранной категории).';
        }
        if (array_key_exists('deletedCat', $_REQUEST)) {
            $this->info = 'Категория успешно удалёна.';
        }

        // ВУДУ
        if (array_key_exists('updatedСatssub', $_REQUEST)) {
            $this->info = 'Информация о подкатегории успешно изменена.';
        }
        if (array_key_exists('newСatssub', $_REQUEST)) {
            $this->info = 'Новая подкатегория успешно добавлена. Вы можете создать специфические характеристики для неё, что упростит наполнение сайта вашей продукцией (кнопка: <a class="addFieldBtn" href="#">Открыть подкатегории</a> - на против выбранной подкатегории).';
        }
        if (array_key_exists('deletedСatssub', $_REQUEST)) {
            $this->info = 'Категория успешно удалёна.';
        }
        if (array_key_exists('copiedСatssub', $_REQUEST)) {
            $this->info = 'Категория успешно скопирована.';
        }


        if (array_key_exists('updatedField', $_REQUEST)) {
            $this->info = 'Характеристика успешно изменена.';
        }
        if (array_key_exists('fieldNew', $_REQUEST)) {
            $this->info = 'Новая характеристика для подгруппы добавлена.';
        }
        if (array_key_exists('deletedField', $_REQUEST)) {
            $this->info = 'Характеристика успешно удалёна.';
        }
        if (array_key_exists('needDelivery', $_REQUEST)) {
            $this->info = 'Для добавления способа оплаты, сначала надо добавить хоть один способ доставки.';
        }


        if (array_key_exists('emptyCat', $_REQUEST)) {
            $this->info = 'Для добавления нового товара необходимо создать хотябы одну категорию, в которую он будет помещён.<br/><br/>
            Или, если у вас есть YML-файл, вы можете <a href="/products/yml/">импортировать</a> товары и услуги из него.
            ';
        }
        if (array_key_exists('addSubCatPlease', $_REQUEST)) {
            $this->info = 'Так как в выбранной вами категории товара, нет ни одной созданной подкатегории, вы перенаправленны на страницу добавления новой подкатегорий товаров.';
        }

        if (array_key_exists('enabled', $_REQUEST)) {
            $this->info = 'Магазин включён.';
        }
        if (array_key_exists('disabled', $_REQUEST)) {
            $this->info = 'Магазин выключён.';
        }

        if (array_key_exists('salesUP', $_REQUEST)) {
            $this->info = 'Режим работы магазина успешно изменён.';
        }

        require Kohana::find_file('vendor', 'SuperPath');


        $YMLprogress = 0;
        if ($this->firm && $this->firm->YMLenabled) {

            $YMLprogress = $this->db->select('YMLprogress')->from('firms')->
                where(array('id' => $this->firmID))->get();

            $YMLprogress = $YMLprogress[0];
            if ($YMLprogress->YMLprogress != 0 && $YMLprogress->YMLprogress != 100) {
                url::redirect(url::site() . "products/yml/");
                return;
            }
        }

    }


    public function content()
    {


        if (!$this->haveAccess()) {
            return;
        }
        ;

        $this->template->content = new View('settings/content');

        $this->template->title  = 'Настройки Интернет-магазина';
        $this->selected_subpage = Settings_Controller::SUBPAGE_CONTENT;


        if ($_POST) {

            $data['title'] = trim($_POST['firms']['title']);

            if (empty($this->firm->mail)) {
                $data['mail'] = trim($_POST['firms']['mailo']);
            }
            if (empty($this->firm->title_firm)) {
                $data['title_firm'] = trim($_POST['firms']['title']);
            }

            $data['mailo']       = trim($_POST['firms']['mailo']);
            $data['description'] = trim($_POST['firms']['description']);
            $data['meta']        = trim($_POST['firms']['meta']);
            $data['mail_inside'] = trim($_POST['firms']['mail_inside']);
            $data['meta_name']   = trim($_POST['firms']['meta_name']);
            $data['meta_text']   = trim($_POST['firms']['meta_text']);
            $data['main_phone']  = trim($_POST['firms']['main_phone']);

            $data['sms_title']  = trim($_POST['firms']['sms_title']);
            $data['sms_number'] = trim($_POST['firms']['sms_number']);

            $data['code_inside'] = trim($_POST['firms']['code_inside']);
            $data['template']    = @trim($_POST['firms']['template']);
            $show                = (empty($_POST['firms']['show']) ? array() : $_POST['firms']['show']);
            $smsSettings         = (empty($_POST['firms']['sms_settings']) ? array() : $_POST['firms']['sms_settings']);
            $commentSettings     = (empty($_POST['firms']['comment_settings']) ? array() : $_POST['firms']['comment_settings']);
            $pricesS             = (empty($_POST['firms']['price']) ? array() : $_POST['firms']['price']);
            $priceVisible        = (empty($_POST['firms']['priceVisible']) ? array() : $_POST['firms']['priceVisible']);

            if (empty($data['template'])) {
                unset($data['template']);
            }

            $data['show'] = 0;

            foreach ($show as $whatView) {
                $data['show'] += intval($whatView);
            }

            $data['sms_settings'] = 0;

            if ($this->firmID != DEMO_SHOP) {
                foreach ($smsSettings as $whatView) {
                    $data['sms_settings'] += intval($whatView);
                }
            } else {
                $this->info = 'В демо-магазине нельзя поменять настройки для уведомлений.';
            }

            $data['comment_settings'] = 0;
            foreach ($commentSettings as $whatView) {
                $data['comment_settings'] += intval($whatView);
            }

            if (!isset($data['title']) || !($data['title'])) {
                $this->errorFields[] = "Название сайта";
            }
            if (!isset($data['mailo']) || !($data['mailo'])) {
                $this->errorFields[] = "Обратная связь";
            } else {
                if (!valid::email($data['mailo'])) {
                    $this->errorFields[] = "Обратная связь";
                }
            }


            if (!empty($data['sms_title']) && (strlen($data['sms_title']) > 11 || !preg_match("/[a-z]/i", $data['sms_title']))) {
                $this->errorFields[] = "SMS отправитель";
            }
            if (!empty($data['sms_number']) && (strlen(intval($data['sms_number'])) != 11 || substr($data['sms_number'], 0, 1) != '7')) {
                $this->errorFields[] = "SMS оповещения для";
            }

            if ($data['sms_settings'] && (empty($data['sms_title']) || empty($data['sms_number']))) {
                $this->errorFields[] = "SMS отправитель";
                $this->errorFields[] = "SMS оповещения для";
            }

            if (!isset($data['description']) || !($data['description'])) {
                $this->errorFields[] = "Деятельность";
            }

            $prices          = new stdClass();
            $prices->enabled = 0;
            foreach ($pricesS as $whatView) {
                $prices->enabled += $whatView;
            }
            $prices->visible = 0;
            foreach ($priceVisible as $whatView) {
                $prices->visible += $whatView;
            }
            $prices->list           = array();
            $prices->list['price1'] = isset($_POST['firms']['priceTitle'][1]) ? $_POST['firms']['priceTitle'][1] : '';
            $prices->list['price2'] = isset($_POST['firms']['priceTitle'][2]) ? $_POST['firms']['priceTitle'][2] : '';
            $prices->list['price3'] = isset($_POST['firms']['priceTitle'][3]) ? $_POST['firms']['priceTitle'][3] : '';
            $prices->list['price4'] = isset($_POST['firms']['priceTitle'][4]) ? $_POST['firms']['priceTitle'][4] : '';
            $prices->list['price5'] = isset($_POST['firms']['priceTitle'][5]) ? $_POST['firms']['priceTitle'][5] : '';

            $data['prices'] = json_encode($prices);

            if (!empty($_FILES) && $_FILES['logo']['error'] != 4) {

                switch ($_FILES['logo']['error']) {
                    case 0:
                        // $this->error = "No Error"; // comment this out if you don't want a message to appear on success.
                        break;
                    case 1:
                        $this->error = "The file is bigger than this PHP installation allows";
                        break;
                    case 2:
                        $this->error = "The file is bigger than this form allows";
                        break;
                    case 3:
                        $this->error = "Only part of the file was uploaded";
                        break;
                    case 4:
                        $this->error = "No file was uploaded";
                        break;
                    case 6:
                        $this->error = "Missing a temporary folder";
                        break;
                    case 7:
                        $this->error = "Failed to write file to disk";
                        break;
                    case 8:
                        $this->error = "File upload stopped by extension";
                        break;
                }

                if (empty($this->error)) {

                    $tempFile = $_FILES['logo']['tmp_name'];

                    $size = getimagesize($tempFile);

                    if (!is_array($size)) {
                        $this->error = "Логотип не загружен так как загруженый файл не являеться изображением.";
                    }

                    if ($size[0] > 300 || $size[1] > 150) {
                        $this->error = "Размер загруженного логотипа слишвком высок. Ограничения по ширене 300px, по высоте 150px. Ваше изображение имеет размеры " . $size[0] . 'px на ' . $size[1] . 'px';
                    }

                    if (empty($this->error)) {

                        $imageId    = $this->firmID;
                        $targetFile = SuperPath::get($imageId, false, IMAGES_TYPE_LOGO);

                        $origFile = $targetFile . '.png';

                        move_uploaded_file($tempFile, $origFile);


                    }
                }
            }

            if (!empty($_FILES) && $_FILES['watermark']['error'] != 4) {

                switch ($_FILES['watermark']['error']) {
                    case 0:
                        // $this->error = "No Error"; // comment this out if you don't want a message to appear on success.
                        break;
                    case 1:
                        $this->error = "The file is bigger than this PHP installation allows";
                        break;
                    case 2:
                        $this->error = "The file is bigger than this form allows";
                        break;
                    case 3:
                        $this->error = "Only part of the file was uploaded";
                        break;
                    case 4:
                        $this->error = "No file was uploaded";
                        break;
                    case 6:
                        $this->error = "Missing a temporary folder";
                        break;
                    case 7:
                        $this->error = "Failed to write file to disk";
                        break;
                    case 8:
                        $this->error = "File upload stopped by extension";
                        break;
                }

                if (empty($this->error)) {

                    $tempFile = $_FILES['watermark']['tmp_name'];

                    $size = getimagesize($tempFile);

                    if (!is_array($size)) {
                        $this->error = "Водяной знак не загружен так как загруженый файл не являеться изображением.";
                    }

                    if (empty($this->error)) {

                        $imageId    = $this->firmID;
                        $targetFile = SuperPath::get($imageId, false, IMAGES_TYPE_WATERMARK);

                        $origFile = $targetFile . '.png';

                        move_uploaded_file($tempFile, $origFile);

                    }
                }
            }


            if (is_null($this->error) && !count($this->errorFields)) {
                $status = $this->db->update('firms', $data, array('id' => $this->firmID));

                if (count($status)) {
                    $this->session->set("firm", null);
                    url::redirect("/settings/content?up");
                }
            } else {
                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Настройки Интернет-магазина не произведены. ');
                }
            }

        }

        $table                         = "firms";
        $where                         = "id = " . $this->firmID;
        $this->template->content->firm = $this->db->select('*')->from($table)->
            where($where)->get();

        $this->template->content->firm  = $this->template->content->firm[0];
        $this->template->content->cats  = $GLOBALS['CAT'];
        $this->template->content->citys = $GLOBALS['CITY'];

        $this->template->content->firm->prices = json_decode($this->template->content->firm->prices);


    }

    public function firm()
    {

        $this->template->content = new View('settings/firm');

        $this->template->title  = 'Информации о фирме';
        $this->selected_subpage = Settings_Controller::SUBPAGE_FIRM;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $data['title_firm'] = ($_POST['firms']['title']);
            $data['descFirm']   = ($_POST['firms']['descFirm']);
            $data['city']       = ($_POST['firms']['city']);
            //     $data['cat'] = ($_POST['firms']['cat']);

            $data['skype']    = ($_POST['firms']['skype']);
            $data['mail']     = ($_POST['firms']['mail']);
            $data['icq']      = ($_POST['firms']['icq']);
            $data['address']  = ($_POST['firms']['address']);
            $data['fax']      = ($_POST['firms']['fax']);
            $data['tele']     = ($_POST['firms']['tele']);
            $data['worktime'] = ($_POST['firms']['worktime']);
            $data['urik']     = ($_POST['firms']['urik']);

            if (!($data['title_firm']) || strlen($data['title_firm']) == 4) {
                $this->errorFields[] = "Название организации";
            }
            if (!($data['mail']) || strlen($data['mail']) == 4) {
                $this->errorFields[] = "Электронный адрес";
            }
            if (!($data['address']) || strlen($data['address']) == 4) {
                $this->errorFields[] = "Адрес";
            }
            if (!($data['tele']) || strlen($data['tele']) == 4) {
                $this->errorFields[] = "Телефон";
            }
            if (!($data['worktime']) || strlen($data['worktime']) == 4) {
                $this->errorFields[] = "Время работы";
            }
            if (!($data['urik']) || strlen($data['urik']) == 4) {
                $data['urik'] = '';
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $status = $this->db->update('firms', $data, array('id' => $this->firmID));

                if (count($status)) {
                    $this->info = 'Информация обновлена';
                    $this->session->set("firm", null);
                    url::redirect("/settings/firm?upFirm");
                    exit();
                }

            } else {
                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Настройки сайта не произведены. Для изменения настроек необходимо запонить все поля. ');
                }
            }

        }

        $table                         = "firms";
        $where                         = "id = " . $this->firmID;
        $this->template->content->firm = $this->db->select('*')->from($table)->
            where($where)->get();

        $this->template->content->firm  = $this->template->content->firm[0];
        $this->template->content->cats  = $GLOBALS['CAT'];
        $this->template->content->citys = $GLOBALS['CITY'];

    }


    public function index()
    {

        $this->template->content = new View('settings/index');

        $this->template->title  = 'Настройки главной страницы';
        $this->selected_subpage = Settings_Controller::SUBPAGE_MAIN;

        if (!$this->haveAccess()) {
            return;
        }
        ;


        if ($_POST) {

            $dataUser['mainpage']     = trim($_POST['firm']['mainpage']);
            $dataUser['showfirstpro'] = trim($_POST['firm']['showfirstpro']);
            $dataUser['shownews']     = (isset($_POST['firm']['shownews']) ? 1 : 0);
            $dataUser['welcomepage']  = (isset($_POST['firm']['welcomepage']) ? 1 : 0);
            $dataUser['showcatalog']  = (isset($_POST['firm']['showcatalog']) ? 1 : 0);

            if (is_null($this->error) && !count($this->errorFields)) {

                $status = $this->db->update("firms", $dataUser, array("id" => $this->firmID));
                ;

                if (count($status)) {
                    $this->session->set("firm", null);
                    url::redirect(url::site() . "settings?upMainPage");
                    exit();
                }
            } else {
                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Настройки сайта не произведены. Для изменения настроек необходимо запонить все поля. ');
                }
            }


        }

        $table                         = "firms";
        $where                         = "id = " . $this->firmID;
        $this->template->content->firm = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->firm = $this->template->content->firm[0];
    }


    public function users()
    {

        $this->template->content = new View('settings/users');

        $this->template->title  = 'Администаторы Интернет-магазина';
        $this->selected_subpage = Settings_Controller::SUBPAGE_USERS;

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'moders';
        $where = 'firm_id = ' . $this->firmID . ' and user_status != ' . MODER_DELETED;

        if (!isset($offset) || $offset == 0) {
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
            where($where)->offset($offset)->limit($page_limit)->orderby('user_name', 'asc')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'       => 'settings/users',

            // The URI segment (integer) in which the pagination number can be found
            // The URI segment (string) that precedes the pagination number (aka "label")
            'uri_segment'    => 'page',

            // You could also use the query string for pagination instead of the URI segments
            // Just set this to the $_GET key that contains the page number
            // 'query_string'   => 'page',

            // The total items to paginate through (probably need to use a database COUNT query here)
            'total_items'    => $count_records,

            // The amount of items you want to display per page
            'items_per_page' => $page_limit,

            // The pagination style: classic (default), digg, extended or punbb
            // Easily add your own styles to views/pagination and point to the view name here
            'style'          => 'digg',

            // If there is only one page, completely hide all pagination elements
            // Pagination->render() will return an empty string
            'auto_hide'      => true,
        ));


        $this->template->content->pagination         = $pagination->render('digg');
        $this->template->content->count_records      = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;

    }

    public function userdelete()
    {

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));


        if ($this->firmID == DEMO_SHOP) {
            //$this->info = 'Отключить демо-магазинь нельзя.';
            url::redirect(url::site() . "settings/users?userDemo");
            return;
        }

        $count_records = $this->db->from('moders')->
            where(array('firm_id' => $this->firmID, 'confirmed' => CONFIRM_DONE, 'user_status' => MODER_DELETED))
            ->count_records();

        if ($count_records <= 1) {
            url::redirect(url::site() . "settings/users?userDoNotDeleted");
            exit();
        }

        // $status = $this->db->delete('moders', array('user_id' => $id, 'firm_id' => $this->firmID ));

        $status = $this->db->update('moders', array('user_status' => MODER_DELETED), array('user_id' => $id, 'firm_id' => $this->firmID));


        if (count($status)) {

            if ($id == $this->moderId) {

                $this->session->set("access", null);
                $this->session->set("moderId", null);
                $this->session->set("firmId", null);

                $this->session->set("firm", null);
                $this->session->set("user", null);

                url::redirect("/login/");

            } else {
                url::redirect(url::site() . "settings/users?userDeleted");
            }

            exit();
        } else {
            Event::run('system.404');
        }
    }


    public function useredit()
    {

        $this->template->content = new View('settings/useredit');

        $this->template->title  = 'Изменение информации об администраторе';
        $this->selected_subpage = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        $this->editUserSelf = false;
        if ($id == $this->moderId) {
            $this->editUserSelf = true;
        }

        $table                         = "moders";
        $where                         = "user_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->user = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->user = $this->template->content->user[0];

        $this->template->content->emptyPass = false;

        if ($this->template->content->user) {


            if ($this->firmID == DEMO_SHOP) {
                //$this->info = 'Отключить демо-магазинь нельзя.';
                url::redirect(url::site() . "settings/users?userDemo");
                return;
            }

            if ($_POST) {

                $data['user_mail'] = trim($_POST['user']['user_mail']);
                $data['user_name'] = trim($_POST['user']['user_name']);

                if ($this->editUserSelf &&

                    ((!empty($this->template->content->user->user_word) && (!empty($_POST['user']['user_word'])))

                        ||

                        (empty($this->template->content->user->user_word)))

                ) {

                    $data['user_word'] = @($_POST['user']['user_word']);
                    $user_word_re      = @($_POST['user']['user_word_re']);
                    $user_word_current = @($_POST['user']['user_word_current']);

                    if (

                        ((empty($data['user_word']) || empty($user_word_re) || empty($user_word_current))
                        && !empty($this->template->content->user->user_word))

                        ||

                        ((empty($data['user_word']) || empty($user_word_re))
                        && empty($this->template->content->user->user_word))
                    ) {

                        if (empty($data['user_word'])) {
                            $this->errorFields[] = "Новый пароль";
                        }
                        if (empty($user_word_re)) {
                            $this->errorFields[] = "Повторите новый пароль";
                        }
                        if (empty($user_word_current) && !empty($this->template->content->user->user_word)) {
                            $this->errorFields[] = "Текущий пароль";
                        }

                    }

                    if ($data['user_word'] != $user_word_re) {
                        $this->error = "Новый пароль не соответствует его подтвержению.";
                    }

                    if (strlen($data['user_word']) < 6) {
                        $this->error = 'Вы указали слишком простой пароль, придумайте пароль от шести символов' . $this->NL();
                    }

                    if (is_null($this->error) && !count($this->errorFields) && !empty($this->template->content->user->user_word)) {

                        $count_records = $this->db->from('moders')->
                            where(array('firm_id' => $this->firmID, 'user_id' => $id, 'user_word' => MD5($user_word_current . WORD_SOLT)))->count_records();
                        if ($count_records != 1) {
                            $this->error = "Указаный текущий пароль не соответствует действительности.";
                        }

                    }

                    $data['user_word'] = MD5($data['user_word'] . WORD_SOLT);
                }


                if (empty($data['user_name'])) {
                    $this->errorFields[] = "Имя администратора";
                }
                if (empty($data['user_mail']) || !valid::email($data['user_mail'])) {
                    $this->errorFields[] = "Электронный адрес";
                }

                /*		$show = (empty($_POST['firms']['access']) ? array() : $_POST['firms']['access']);
                        $data['user_right'] = 0;
                        foreach($show as $whatView){
                            $data['user_right'] += $whatView;
                        }
                        if(!$data['user_right']){
                            $this->errorFields[] = "Возможности администратора";
                        }
                */
                $dataUser['user_right'] = ACCESS_ADMIN;

                if (is_null($this->error) && !count($this->errorFields)) {

                    if (empty($this->template->content->user->user_word)) {
                        $data['confirmed']      = CONFIRM_DONE; // TODO
                        $data['confirmed_code'] = 0;
                    }

                    if ($this->template->content->user->user_mail != $data['user_mail']) {

                        $data['user_mail_new'] = $data['user_mail'];
                        unset($data['user_mail']);
                        $data['confirmed']      = CONFIRM_NEW_MAIL; // TODO
                        $data['confirmed_code'] = MD5(rand(5, 88888) . $data['user_mail_new'] . WORD_SOLT_CONFIRM);

                    }

                    $status = $this->db->update('moders', $data, array('user_id' => $id, 'firm_id' => $this->firmID));

                    if (count($status)) {

                        if ($id == $this->moderId) {
                            $this->session->set("user", null);
                        }

                        if (isset($data['user_mail_new'])) {

                            $content                 = new stdClass();
                            $content->confirmed_code = $data['confirmed_code'];
                            $content->userName       = $data['user_name'];
                            $content->userMail       = $data['user_mail_new'];
                            $content->userID         = $id;

                            require Kohana::find_file('vendor', 'Mailer');
                            Mailer::changeMailToSP($content);

                            url::redirect(url::site() . "settings/users?userUpdatedMail");

                        } else {

                            if ($id == $this->moderId) {
                                $this->session->set("user", null);
                            }

                            url::redirect(url::site() . "settings/users?userUpdated");
                        }

                        exit();

                    } else {
                        // $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                    }
                } else {

                    if (count($this->errorFields)) {
                        if ($this->editUserSelf) {
                            $this->error = $this->completeErrorFieldsMessage('Информация о вашем аккаунте не изменена. ');
                        } else {
                            $this->error = $this->completeErrorFieldsMessage('Информация об администраторе не изменена. ');
                        }
                    }

                }
            } else {

                if (empty($this->template->content->user->user_word) && $this->editUserSelf) {
                    $this->info .= 'Поздравляем! Вы стали администратором Интернет-магазина «' .
                        html::specialchars($this->firm->title) . '». <br/>Для входа в панель управления магазином вам понадобиться указать ваш электронный адрес и пароль. <br/><br/>На данный момент пароль для вашего аккаунта не установлен, настоятельно рекомендуем установить его сейчас.' . $this->NL(); // TODO

                }

            }

            if (empty($this->template->content->user->user_word) && $this->editUserSelf) {
                $this->template->content->emptyPass = true;
            }

        } else {
            Event::run('system.404');
        }

    }


    public function usersadd()
    {

        $this->template->content = new View('settings/usersadd');

        $this->template->title  = 'Регистрация администратора';
        $this->selected_subpage = Settings_Controller::SUBPAGE_USERS_ADD;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $dataUser['user_name']   = @trim($_POST['firms']['userName']);
            $dataUser['user_mail']   = @trim($_POST['firms']['userMail']);
            $dataUser['user_status'] = MODER_ACTIVE;

            if (!($dataUser['user_name'])) {
                $this->errorFields[] = "Имя администратора";
            }

            if (!($dataUser['user_mail']) || !valid::email($dataUser['user_mail'])) {
                $this->errorFields[] = "Электронный адрес";
            }

            /*     $show = (empty($_POST['firms']['access']) ? array() : $_POST['firms']['access']);
                  $dataUser['user_right'] = 0;
                  foreach($show as $whatView){
                      $dataUser['user_right'] += $whatView;
                  }
                  */
            $dataUser['user_right'] = ACCESS_ADMIN;

            if (!$dataUser['user_right']) {
                $this->errorFields[] = "Возможности администратора";
            }


            $table = "moders";
            /// $where = "user_mail = '" . $dataUser['user_mail'] . "'";
            $item = $this->db->select('user_id')->from($table)->
                where(array('user_status' => MODER_ACTIVE, 'user_mail' => $dataUser['user_mail'], 'firm_id' => $this->firmID))->get(); // TODO может сделать с учотом подстверждённых аккаутов

            if (isset($item[0])) {
                $this->error = 'Администратор с указаным адресом электронной почты уже зарегестрирован в вашем магазине.' . $this->NL();
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                // $dataUser['user_word'] = MD5($dataUser['user_word'] . WORD_SOLT);
                // $dataUser['user_right'] = ACCESS_MODER;
                $dataUser['firm_id'] = $this->firmID;

                $dataUser['confirmed']      = CONFIRM_NEW_USER;
                $dataUser['confirmed_code'] = MD5(rand(5, 888888) . $dataUser['user_mail'] . WORD_SOLT_CONFIRM);

                $status = $this->db->insert('moders', $dataUser);
                if (count($status)) {

                    $content                 = new stdClass();
                    $content->confirmed_code = $dataUser['confirmed_code'];
                    $content->userName       = $dataUser['user_name'];
                    $content->userMail       = $dataUser['user_mail'];

                    require Kohana::find_file('vendor', 'Mailer');
                    Mailer::addUserToSP($content);

                    /*                 Mailer::addUser( // TODO
                                         $this->template->content->user->user_mail ,
                                         $this->template->content->user->user_name,
                                         $subject = "Привет новый пользователь",
                                         $content); */

                    url::redirect(url::site() . "settings/users?newUser");
                    exit();

                } else {
                    $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }
            } else {
                if (count($this->errorFields)) {
                    $this->error = $this->completeErrorFieldsMessage('Новый администратор не зарегестрирован. ');
                }
            }
        }
    }


    public function fields()
    {

        $catsubid = intval($this->uri->segment('catsubid'));

        $this->template->content = new View('settings/fields');

        $this->selected_subpage = Settings_Controller::SUBPAGE_CATS_SUB;

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'fields';
        $where = 'firm_id = ' . $this->firmID . " and catsub_id = " . $catsubid;

        if (!isset($offset) || $offset == 0) {
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
            where($where)->offset($offset)->limit($page_limit)->orderby('sort', 'asc')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'       => 'settings/fields/catsubid/' . $catsubid,

            // The URI segment (integer) in which the pagination number can be found
            // The URI segment (string) that precedes the pagination number (aka "label")
            'uri_segment'    => 'page',

            // You could also use the query string for pagination instead of the URI segments
            // Just set this to the $_GET key that contains the page number
            // 'query_string'   => 'page',

            // The total items to paginate through (probably need to use a database COUNT query here)
            'total_items'    => $count_records,

            // The amount of items you want to display per page
            'items_per_page' => $page_limit,

            // The pagination style: classic (default), digg, extended or punbb
            // Easily add your own styles to views/pagination and point to the view name here
            'style'          => 'digg',

            // If there is only one page, completely hide all pagination elements
            // Pagination->render() will return an empty string
            'auto_hide'      => true,
        ));


        $this->template->content->pagination         = $pagination->render('digg');
        $this->template->content->count_records      = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;
        $this->template->content->catsubid           = $catsubid;

        $table   = "catssub";
        $where   = "catsub_id = " . $catsubid . " and firm_id = " . $this->firmID;
        $catssub = $this->db->select('*')->from($table)->
            where($where)->get();
        $catssub = $catssub[0];

        $this->template->title           = "Характеристики товаров подкатегории «" . $catssub->title . '»';
        $this->template->content->catsub = $catssub;

    }


    public function fieldsadd()
    {

        $catsubid = intval($this->uri->segment('catsubid'));

        $this->template->content = new View('settings/fieldsadd');
        $this->selected_subpage  = Settings_Controller::SUBPAGE_CATS_SUB;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $proceed = @intval($_POST['fieldsadd']['proceed']);

            $dataUser['title']     = @trim($_POST['fieldsadd']['title']);
            $dataUser['sort']      = @intval($_POST['fieldsadd']['sort']);
            $dataUser['excel']     = (isset($_POST['fieldsadd']['excel']) ? 1 : 0);
            $dataUser['firm_id']   = $this->firmID;
            $dataUser['catsub_id'] = $catsubid;

            if (empty($dataUser['title'])) {
                $this->errorFields[] = "Название";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE fields SET sort = sort + 1 WHERE catsub_id = ' . $catsubid . " and firm_id = " .
                    $this->firmID . " and sort >=  " . $dataUser['sort']);
                ;

                $status = $this->db->insert('fields', $dataUser);

                if (count($status)) {
                    if ($proceed) {
                        url::redirect(url::site() . "/settings/fieldsadd/catsubid/" . $catsubid . "?fieldNew");
                    } else {
                        url::redirect(url::site() . "settings/fields/catsubid/" . $catsubid . "?fieldNew");
                    }
                    exit();
                } else {
                    $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Новая характеристика товара не добавлена. ');
                }
            }
        }

        $this->template->content->cats = $this->db->select('*')->from('fields')
            ->where("catsub_id = " . $catsubid . ' and 1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();

        $this->template->content->catsubid = $catsubid;
        $table                             = "catssub";
        $where                             = "catsub_id = " . $catsubid . " and firm_id = " . $this->firmID;
        $catssub                           = $this->db->select('*')->from($table)->
            where($where)->get();
        $catssub                           = $catssub[0];

        if ($catssub) {
            $this->template->title = "Добавление характеристики товара для подкатегории «" . $catssub->title . '»';
            ;
            $this->template->content->catsub = $catssub;
        } else {
            Event::run('system.404');
        }


    }


    public function fieldsdelete()
    { // TODO  и что сделать с заведёнными полями

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $catsubid = intval($this->uri->segment('catsubid'));

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('fields', array('catsub_id' => $catsubid, 'field_id' => $id, 'firm_id' => $this->firmID));

        if (count($status)) {
            url::redirect(url::site() . "settings/fields/catsubid/" . $catsubid . "?deletedField");
            exit();
        } else {
            Event::run('system.404');
            return;
        }
    }


    public function fieldsedit()
    {

        $catsubid = intval($this->uri->segment('catsubid'));

        $this->template->content = new View('settings/fieldsedit');

        $this->selected_subpage = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        if ($_POST) {

            $data['title']     = @trim($_POST['fieldsedit']['title']);
            $data['sort']      = @intval($_POST['fieldsedit']['sort']);
            $data['excel']     = (isset($_POST['fieldsedit']['excel']) ? 1 : 0);
            $data['catsub_id'] = $catsubid;

            if (empty($data['title'])) {
                $this->errorFields[] = "Название";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE fields SET sort = sort + 1 WHERE catsub_id = ' . $catsubid . " and firm_id = " . $this->firmID . " and sort >=  " . $data['sort']);
                ;

                if (is_null($this->error)) {

                    $status = $this->db->update('fields', $data, array('catsub_id' => $catsubid, 'field_id' => $id, 'firm_id' => $this->firmID));

                    if (count($status)) {
                        url::redirect(url::site() . "settings/fields/catsubid/" . $catsubid . "?updatedField");
                        exit();
                    }
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Изменение характеристики не произведено. ');
                }
            }
        }

        $this->template->content->cats = $this->db->select('*')->from('fields')
            ->where("catsub_id = " . $catsubid . ' and 1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();

        $this->template->content->catsubid = $catsubid;

        $table   = "catssub";
        $where   = "catsub_id = " . $catsubid . " and firm_id = " . $this->firmID;
        $catssub = $this->db->select('*')->from($table)->
            where($where)->get();
        $catssub = $catssub[0];

        if ($catssub) {

            $this->template->title = "Изменение характеристики подкатегории «" . $catssub->title . "»";
            ;
            $this->template->content->catsub = $catssub;

            $table                         = "fields";
            $where                         = "field_id = " . $id . " and firm_id = " . $this->firmID;
            $this->template->content->user = $this->db->select('*')->from($table)->
                where($where)->get();
            $this->template->content->user = $this->template->content->user[0];

        } else {
            Event::run('system.404');
        }
    }


    public function cats()
    {

        if ($this->firm->YMLenabled) {
            $this->info = 'Внимение! Данные обновляються из <a href="/products/yml/">YML-файла</a>.';
        }

        $this->template->content = new View('settings/cats');

        $this->template->title  = 'Категории';
        $this->selected_subpage = Settings_Controller::SUBPAGE_CATS;

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'cats';
        $where = 'firm_id = ' . $this->firmID . ' and `status` in (' . STATUS_HIDE . ',' . STATUS_WORK . ')';

        $id = @intval($_REQUEST['id']);

        if (array_key_exists('pleaseHide', $_REQUEST) && $id) {

            $status = $this->db->update('cats',
                array('status' => STATUS_HIDE),
                array('cat_id' => $id, 'firm_id' => $this->firmID));


            if (count($status)) {
                $this->info = 'Позиция убрана с сайта.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }

        if (array_key_exists('pleaseShow', $_REQUEST) && $id) {

            $status = $this->db->update('cats',
                array('status' => STATUS_WORK),
                array('cat_id' => $id, 'firm_id' => $this->firmID));


            if (count($status)) {
                $this->info = 'Позиция появилась на сайте.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }


        if (!isset($offset) || $offset == 0) {
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
            where($where)->offset($offset)->limit($page_limit)->orderby('sort', 'asc')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'       => 'settings/cats',

            // The URI segment (integer) in which the pagination number can be found
            // The URI segment (string) that precedes the pagination number (aka "label")
            'uri_segment'    => 'page',

            // You could also use the query string for pagination instead of the URI segments
            // Just set this to the $_GET key that contains the page number
            // 'query_string'   => 'page',

            // The total items to paginate through (probably need to use a database COUNT query here)
            'total_items'    => $count_records,

            // The amount of items you want to display per page
            'items_per_page' => $page_limit,

            // The pagination style: classic (default), digg, extended or punbb
            // Easily add your own styles to views/pagination and point to the view name here
            'style'          => 'digg',

            // If there is only one page, completely hide all pagination elements
            // Pagination->render() will return an empty string
            'auto_hide'      => true,
        ));

        $this->template->content->pagination         = $pagination->render('digg');
        $this->template->content->count_records      = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;

    }

    public function catsdelete()
    { //////// TODO чтото тут дофига всего

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('cats', array('cat_id' => $id, 'firm_id' => $this->firmID));

        if (count($status)) {
            url::redirect(url::site() . "settings/cats?deletedCat");
            exit();
        }
    }

    public function catsedit()
    {

        $this->template->content = new View('settings/catsedit');

        $this->template->title  = 'Редактирование категории';
        $this->selected_subpage = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $this->id = $id = intval($this->uri->segment('id'));
        if ($_POST) {

            $data['title']   = @trim($_POST['cats']['title']);
            $data['desc']    = @trim($_POST['cats']['desc']);
            $data['sort']    = @intval($_POST['cats']['sort']);
            $data['firm_id'] = $this->firmID;

            if (empty($data['title'])) {
                $this->errorFields[] = "Название";
            }
            if (!($data['sort'])) {
                $this->errorFields[] = "Позиция перед";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE cats SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);
                ;

                $data['url_link'] = format::do_latin($data['title']);
                $status           = $this->db->update('cats', $data, array('cat_id' => $id, 'firm_id' => $this->firmID));

                if (count($status)) {
                    url::redirect(url::site() . "settings/cats/?updatedCat");
                    exit();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Информация о категории не изменена. ');
                }

            }
        }


        $table                         = "cats";
        $where                         = "cat_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->user = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->user = $this->template->content->user[0];
        if ($this->template->content->user) {
            $this->template->content->cats = $this->db->select('*')->from('cats')
                ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();
        } else {
            Event::run('system.404');
        }


    }


    public function catsadd()
    {

        $this->template->content = new View('settings/catsadd');

        $this->template->title  = 'Добавление категории';
        $this->selected_subpage = Settings_Controller::SUBPAGE_CATS_ADD;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $dataUser['title']   = @trim($_POST['cats']['title']);
            $dataUser['desc']    = @trim($_POST['cats']['desc']);
            $dataUser['sort']    = @intval($_POST['cats']['sort']);
            $dataUser['firm_id'] = $this->firmID;
            $dataUser['status']  = STATUS_WORK;

            if (empty($dataUser['title'])) {
                $this->errorFields[] = "Название";
            } else {

                if (strlen($dataUser['title']) > 55) {
                    $this->errorFields[] = "Название - содержит больще 55 символов";
                }

            }

            if (!($dataUser['sort'])) {
                $this->errorFields[] = "Позиция перед";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE cats SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $dataUser['sort']);
                ;

                $dataUser['url_link'] = format::do_latin($dataUser['title']);

                $status = $this->db->insert('cats', $dataUser);
                if (count($status)) {

                    url::redirect(url::site() . "settings/cats?newCat");
                    exit();

                } else {
                    $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Категория не добавлена. ');
                }

            }

        }

        $this->template->content->cats = $this->db->select('*')->from('cats')
            ->where('1=1 and firm_id = ' . $this->firmID . ' and `status` in (' . STATUS_HIDE . ',' . STATUS_WORK . ')')->orderby('sort', 'asc')->get();
    }


    public function catssub()
    {

        if ($this->firm->YMLenabled) {
            $this->info = 'Внимение! Данные обновляються из <a href="/products/yml/">YML-файла</a>.';
        }

        $this->template->content = new View('settings/catssub');

        $this->template->title  = 'Все созданные подкатегории';
        $this->selected_subpage = Settings_Controller::SUBPAGE_CATS_SUB;

        $offset = $this->uri->segment('page');

        $id = @intval($_REQUEST['id']);

        if (array_key_exists('pleaseHide', $_REQUEST) && $id) {

            $status = $this->db->update('catssub',
                array('status' => STATUS_HIDE),
                array('catsub_id' => $id, 'firm_id' => $this->firmID));

            if (count($status)) {
                $this->info = 'Позиция убрана с сайта.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }

        if (array_key_exists('pleaseShow', $_REQUEST) && $id) {

            $status = $this->db->update('catssub',
                array('status' => STATUS_WORK),
                array('catsub_id' => $id, 'firm_id' => $this->firmID));


            if (count($status)) {
                $this->info = 'Позиция появилась на сайте.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }


        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'catssub';
        $where = 'catssub.firm_id = ' . $this->firmID;

        $id              = intval($this->uri->segment('id'));
        $this->mainGroup = 0;
        $pageAddOn       = '';
        if ($id) {

            $this->mainGroup = $id;

            /*    $tableCat = "cats";
                $whereCat = "cat_id = " . $id . " and firm_id = " . $this->firmID;
                $this->template->content->openedCat = $this->db->select('*')->from($tableCat)->
                        where($whereCat)->get();
                $this->template->content->openedCat = $this->template->content->openedCat[0];
                if(!$this->template->content->openedCat){
                    Event::run('system.404');
                }*/

            // $this->template->title = 'Подкатегории для «' . html::specialchars($this->template->content->openedCat->title) . '»';

            $where .= ' and catssub.cat_id = ' . $id;
            $pageAddOn = '/id/' . $id;
        }

        if (!isset($offset) || $offset == 0) {
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $where .= ' and catssub.status in (' . STATUS_WORK . ',' . STATUS_HIDE . ') ';

        $this->template->content->items = $this->db->select('*, catssub.title as title, cats.title as cat_title, catssub.status as status')->from($table)
            ->join('cats', 'cats.cat_id',
            'catssub.cat_id', ' AND 1=1', 'LEFT')->
            where($where)->offset($offset)->limit($page_limit)->orderby(array('cats.sort' => 'asc', 'catssub.sort' => 'asc'))->get();

        if (empty($this->template->content->items[0])) {
            url::redirect(url::site() . "settings/catsaddsub/catid/$id?addSubCatPlease");
            exit();
        }

        if ($id) {
            $this->template->title = 'Подкатегории для «' . html::specialchars($this->template->content->items[0]->cat_title) . '»';
        }

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'       => 'settings/catssub' . $pageAddOn,

            // The URI segment (integer) in which the pagination number can be found
            // The URI segment (string) that precedes the pagination number (aka "label")
            'uri_segment'    => 'page',

            // You could also use the query string for pagination instead of the URI segments
            // Just set this to the $_GET key that contains the page number
            // 'query_string'   => 'page',

            // The total items to paginate through (probably need to use a database COUNT query here)
            'total_items'    => $count_records,

            // The amount of items you want to display per page
            'items_per_page' => $page_limit,

            // The pagination style: classic (default), digg, extended or punbb
            // Easily add your own styles to views/pagination and point to the view name here
            'style'          => 'digg',

            // If there is only one page, completely hide all pagination elements
            // Pagination->render() will return an empty string
            'auto_hide'      => true,
        ));


        $this->template->content->pagination         = $pagination->render('digg');
        $this->template->content->count_records      = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;

    }


    public function catsdeletesub()
    { // TODO что с товаром делать

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('catssub', array('catsub_id' => $id, 'firm_id' => $this->firmID));

        if (count($status)) {
            url::redirect(url::site() . "settings/catssub?deletedСatssub");
            exit();
        } else {
            Event::run('system.404');
        }
    }


    public function catseditsub()
    {

        $this->template->content = new View('settings/catseditsub');

        $this->template->title  = 'Редактирование подкатегории товаров';
        $this->selected_subpage = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $this->id = $id = intval($this->uri->segment('id'));
        if ($_POST) {

            $data['title']   = @trim($_POST['catssub']['title']);
            $data['cat_id']  = @intval($_POST['catssub']['cat_id']);
            $data['desc']    = @trim($_POST['catssub']['desc']);
            $data['sort']    = @intval($_POST['catssub']['sort']);
            $data['firm_id'] = $this->firmID;

            if (empty($data['title'])) {
                $this->errorFields[] = "Название";
            }
            if (!($data['cat_id'])) {
                $this->errorFields[] = "Основная категория";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE catssub SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);
                ;

                $data['url_link'] = format::do_latin($data['title']);
                $status           = $this->db->update('catssub', $data, array('catsub_id' => $id, 'firm_id' => $this->firmID));

                if (count($status)) {
                    url::redirect(url::site() . "settings/catssub?updatedСatssub");
                    exit();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Добавление нового способа оплаты не произведено. ');
                }

            }

        }

        $table                         = "catssub";
        $where                         = "catsub_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->user = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->user = $this->template->content->user[0];

        if ($this->template->content->user) {

            $this->template->content->cats = $this->db->select('*')->from('cats')
                ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();

            if (!$this->template->content->cats->count()) {
                $this->error .= 'В вашем Интернет-магазине не создана не одна основная категория. Перед добавлением подкатегорий, создайте основные категории. ' . $this->NL();
                $this->catsadd();
                return;
            }

            $catid = intval($this->uri->segment('catid'));
            if (empty($catid)) {
                $catid = $this->template->content->user->cat_id;
            }
            $this->template->content->catid = $catid;

            $this->template->content->catssub = $this->db->select('*')->from('catssub')
                ->where('1=1 and firm_id = ' . $this->firmID . ' and cat_id = ' . $catid)->orderby('sort', 'asc')->get();

        } else {
            Event::run('system.404');
        }

    }

    public function subcatcopy()
    {

        $this->template->content = new View('settings/subcatcopy');

        $this->template->title  = 'Копирование подкатегории';
        $this->selected_subpage = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id                               = intval($this->uri->segment('catsubid'));
        $this->template->content->copyCat = $id;

        if ($_POST) {

            $data['title']   = @trim($_POST['catssub']['title']);
            $data['cat_id']  = @intval($_POST['catssub']['cat_id']);
            $data['sort']    = @intval($_POST['catssub']['sort']);
            $data['status']  = STATUS_WORK;
            $data['firm_id'] = $this->firmID;

            if (empty($data['title'])) {
                $this->errorFields[] = "Название копии";
            }
            if (!($data['cat_id'])) {
                $this->errorFields[] = "Скопировать в";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                /*   $dataUser['title'] = @trim($_POST['fieldsadd']['title']);
                   $dataUser['sort'] = @intval($_POST['fieldsadd']['sort']);
                   $dataUser['excel'] = (isset($_POST['fieldsadd']['excel']) ? 1 : 0);
                   $dataUser['firm_id'] = $this->firmID;*/

                $data['url_link'] = format::do_latin($data['title']);

                $this->db->query('UPDATE catssub SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);
                ;
                $status = $this->db->insert('catssub', $data);

                if (count($status)) {

                    $table = 'fields';
                    $where = 'firm_id = ' . $this->firmID . " and catsub_id = " . $id;

                    $copyFields = $this->db->select('*')->from($table)->where($where)->get();

                    foreach ($copyFields as $item) {

                        $field = array();

                        $field['title']     = $item->title;
                        $field['sort']      = $item->sort;
                        $field['excel']     = $item->excel;
                        $field['firm_id']   = $item->firm_id;
                        $field['catsub_id'] = $status->insert_id();

                        $this->db->insert('fields', $field);

                    }

                    url::redirect(url::site() . "/settings/fields/catsubid/" . $status->insert_id() . "?copiedСatssub");
                    exit();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Копирование подкатегории не произведено. ');
                }

            }
        }

        $table                         = "catssub";
        $where                         = "catsub_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->user = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->user = $this->template->content->user[0];

        if ($this->template->content->user) {

            $this->template->content->cats = $this->db->select('*')->from('cats')
                ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();

            if (!$this->template->content->cats->count()) {
                $this->error .= 'В вашем Интернет-магазине не создана не одна основная категория. Перед добавлением подкатегорий, создайте основные категории. ' . $this->NL();
                $this->catsadd();
                return;
            }

            $catid = intval($this->uri->segment('catid'));
            if (empty($catid)) {
                $catid = $this->template->content->user->cat_id;
            }

            $this->template->content->catid   = $catid;
            $this->template->content->catssub = $this->db->select('*')->from('catssub')
                ->where('1=1 and firm_id = ' . $this->firmID . ' and cat_id = ' . $catid)->orderby('sort', 'asc')->get();

        } else {
            Event::run('system.404');
        }

    }


    public function catsaddsub()
    {

        $this->template->content = new View('settings/catsaddsub');

        $this->template->title  = 'Добавление новой подкатегории ';
        $this->selected_subpage = Settings_Controller::SUBPAGE_CATS_ADD_SUB;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $dataUser['title']   = @trim($_POST['catssub']['title']);
            $dataUser['desc']    = @trim($_POST['catssub']['desc']);
            $dataUser['cat_id']  = @intval($_POST['catssub']['cat_id']);
            $dataUser['sort']    = @intval($_POST['catssub']['sort']);
            $dataUser['firm_id'] = $this->firmID;
            $dataUser['status']  = STATUS_WORK;

            if (!($dataUser['cat_id'])) {
                $this->errorFields[] = "Основная категория";
            }
            if (empty($dataUser['title'])) {
                $this->errorFields[] = "Название";
            }


            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE catssub SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $dataUser['sort']);
                ;

                $dataUser['url_link'] = format::do_latin($dataUser['title']);

                $status = $this->db->insert('catssub', $dataUser);
                if (count($status)) {

                    // url::redirect(url::site() . "settings/catssub/new/yes" );
                    url::redirect(url::site() . "settings/catssub/id/" . $dataUser['cat_id'] . "?newСatssub");
                    exit();

                } else {
                    $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Добавление новой подкатегории не произведено. ');
                }

            }

        }

        $this->template->content->cats = $this->db->select('*')->from('cats')
            ->where('1=1 and firm_id = ' . $this->firmID . ' and `status` in (' . STATUS_HIDE . ',' . STATUS_WORK . ')')->orderby('sort', 'asc')->get();

        if (!$this->template->content->cats->count()) {
            $this->error .= 'Вы перенаправлены на страницу добавления основных категорий, так как подкатегорию можно добавить тогда, когда есть хотя бы одна основная категория товаров.' . $this->NL();
            $this->catsadd();
            return;
        }

        $this->id                       = $catid = intval($this->uri->segment('catid'));
        $this->template->content->catid = $catid;

        if ($catid) {
            $this->template->content->catssub = $this->db->select('*')->from('catssub')
                ->where('1=1 and firm_id = ' . $this->firmID . ' and cat_id = ' . $catid .
                ' and `status` in (' . STATUS_HIDE . ',' . STATUS_WORK . ')')->orderby('sort', 'asc')->get();
        }

    }


    public function delivery()
    {

        $this->template->content = new View('settings/delivery');

        $this->template->title  = 'Способы доставки';
        $this->selected_subpage = Settings_Controller::SUBPAGE_DELIVERY;


        $id = @intval($_REQUEST['id']);

        if (array_key_exists('pleaseHide', $_REQUEST) && $id) {

            $status = $this->db->update('delivery',
                array('status' => STATUS_HIDE),
                array('del_id' => $id, 'firm_id' => $this->firmID));

            if (count($status)) {
                $this->info = 'Позиция убрана с сайта.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }

        if (array_key_exists('pleaseShow', $_REQUEST) && $id) {

            $status = $this->db->update('delivery',
                array('status' => STATUS_WORK),
                array('del_id' => $id, 'firm_id' => $this->firmID));


            if (count($status)) {
                $this->info = 'Позиция появилась на сайте.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }


        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'delivery';
        $where = 'firm_id = ' . $this->firmID;

        if (!isset($offset) || $offset == 0) {
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
            where($where)->offset($offset)->limit($page_limit)->orderby('sort', 'asc')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'       => 'settings/delivery',

            // The URI segment (integer) in which the pagination number can be found
            // The URI segment (string) that precedes the pagination number (aka "label")
            'uri_segment'    => 'page',

            // You could also use the query string for pagination instead of the URI segments
            // Just set this to the $_GET key that contains the page number
            // 'query_string'   => 'page',

            // The total items to paginate through (probably need to use a database COUNT query here)
            'total_items'    => $count_records,

            // The amount of items you want to display per page
            'items_per_page' => $page_limit,

            // The pagination style: classic (default), digg, extended or punbb
            // Easily add your own styles to views/pagination and point to the view name here
            'style'          => 'digg',

            // If there is only one page, completely hide all pagination elements
            // Pagination->render() will return an empty string
            'auto_hide'      => true,
        ));


        $this->template->content->pagination         = $pagination->render('digg');
        $this->template->content->count_records      = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;


    }


    public function deliverydelete()
    {

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('delivery', array('del_id' => $id, 'firm_id' => $this->firmID));

        if (count($status)) {
            url::redirect(url::site() . "settings/delivery/deletedDelivery");
            exit();
        } else {
            Event::run('system.404');
        }
    }


    public function deliveryedit()
    {

        $this->template->content = new View('settings/deliveryedit');

        $this->template->title  = 'Редактирование способа доставки';
        $this->selected_subpage = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));
        if ($_POST) {

            $data['title']      = @trim($_POST['delivery']['title']);
            $data['sort']       = @intval($_POST['delivery']['sort']);
            $data['type']       = @intval($_POST['delivery']['type']);
            $data['conditions'] = @trim($_POST['delivery']['conditions']);
            $data['cost']       = strlen($_POST['delivery']['cost']) == 0 ? null : floatval($_POST['delivery']['cost']);

            $data['firm_id'] = $this->firmID;

            if (empty($data['title'])) {
                $this->errorFields[] = "Название";
            }
            if (!($data['type'])) {
                $this->errorFields[] = "Шаблон доставки";
            }


            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE delivery SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);
                ;

                if (is_null($this->error)) {

                    $status = $this->db->update('delivery', $data, array('del_id' => $id, 'firm_id' => $this->firmID));

                    if (count($status)) {
                        url::redirect(url::site() . "settings/delivery?updatedDelivery");
                        exit();
                    }
                }
            } else {
                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Настройки сайта не произведены. Для изменения настроек необходимо запонить все поля. ');
                }
            }
        }


        $table                         = "delivery";
        $where                         = "del_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->user = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->user = $this->template->content->user[0];

        if ($this->template->content->user) {

            $this->template->content->delivery = $this->db->select('*')->from('delivery')
                ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();

        } else {
            Event::run('system.404');
        }

    }


    public function deliveryadd()
    {

        $this->template->content = new View('settings/deliveryadd');

        $this->template->title  = 'Добавление способа доставки';
        $this->selected_subpage = Settings_Controller::SUBPAGE_DELIVERY_ADD;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $dataUser['title']      = @trim($_POST['delivery']['title']);
            $dataUser['sort']       = @intval($_POST['delivery']['sort']);
            $dataUser['type']       = @intval($_POST['delivery']['type']);
            $dataUser['conditions'] = @trim($_POST['delivery']['conditions']);
            $dataUser['cost']       = empty($_POST['delivery']['cost']) ? null : floatval($_POST['delivery']['cost']);
            $dataUser['firm_id']    = $this->firmID;
            $dataUser['status']     = STATUS_WORK;

            if (empty($dataUser['title'])) {
                $this->errorFields[] = "Название";
            }
            if (!($dataUser['type'])) {
                $this->errorFields[] = "Шаблон доставки";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE delivery SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $dataUser['sort']);
                ;


                $status = $this->db->insert('delivery', $dataUser);
                if (count($status)) {

                    url::redirect(url::site() . "settings/delivery?newDelivery");
                    exit();

                } else {
                    $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Добавление нового способа доставки не произведено. ');
                }

            }

        }

        $this->template->content->delivery = $this->db->select('*')->from('delivery')
            ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();
    }


    public function pay()
    {

        $this->template->content = new View('settings/pay');

        $this->template->title  = 'Способы оплаты';
        $this->selected_subpage = Settings_Controller::SUBPAGE_PAY;


        $id = @intval($_REQUEST['id']);

        if (array_key_exists('pleaseHide', $_REQUEST) && $id) {

            $status = $this->db->update('pay_type',
                array('status' => STATUS_HIDE),
                array('pay_id' => $id, 'firm_id' => $this->firmID));

            if (count($status)) {
                $this->info = 'Позиция убрана с сайта.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }

        if (array_key_exists('pleaseShow', $_REQUEST) && $id) {

            $status = $this->db->update('pay_type',
                array('status' => STATUS_WORK),
                array('pay_id' => $id, 'firm_id' => $this->firmID));


            if (count($status)) {
                $this->info = 'Позиция появилась на сайте.';
            } else {
                $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
            }
        }


        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'pay_type';
        $where = 'pay_type.firm_id = ' . $this->firmID;

        if (!isset($offset) || $offset == 0) {
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*, pay_type.title as title, delivery.title as dev_title, pay_type.status as status')->from($table)->
            join('delivery', 'pay_type.delivery', 'delivery.del_id', ' AND 1=1')->
            where($where)->offset($offset)->limit($page_limit)->orderby('delivery.title', 'asc')->orderby('pay_type.sort', 'asc')->get();


        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'       => 'settings/pay',

            // The URI segment (integer) in which the pagination number can be found
            // The URI segment (string) that precedes the pagination number (aka "label")
            'uri_segment'    => 'page',

            // You could also use the query string for pagination instead of the URI segments
            // Just set this to the $_GET key that contains the page number
            // 'query_string'   => 'page',

            // The total items to paginate through (probably need to use a database COUNT query here)
            'total_items'    => $count_records,

            // The amount of items you want to display per page
            'items_per_page' => $page_limit,

            // The pagination style: classic (default), digg, extended or punbb
            // Easily add your own styles to views/pagination and point to the view name here
            'style'          => 'digg',

            // If there is only one page, completely hide all pagination elements
            // Pagination->render() will return an empty string
            'auto_hide'      => true,
        ));


        $this->template->content->pagination         = $pagination->render('digg');
        $this->template->content->count_records      = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;

    }


    public function paydelete()
    {

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('pay_type', array('pay_id' => $id, 'firm_id' => $this->firmID));

        if (count($status)) {
            url::redirect(url::site() . "settings/pay?deletedPayWay");
        } else {
            Event::run('system.404');
        }
    }


    public function payedit()
    {

        $this->template->content = new View('settings/payedit');

        $this->template->title  = 'Редактирование способа оплаты';
        $this->selected_subpage = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        if ($_POST) {

            $data['title']       = @trim($_POST['pay']['title']);
            $data['sort']        = @intval($_POST['pay']['sort']);
            $data['client_type'] = @intval($_POST['pay']['type']);
            $data['conditions']  = @trim($_POST['pay']['conditions']);
            $data['field_type']  = @intval($_POST['pay']['field_type']);
            $data['delivery']    = @intval($_POST['pay']['delivery']);

            if (empty($data['title'])) {
                $this->errorFields[] = "Название";
            }
            if (!($data['client_type'])) {
                $this->errorFields[] = "Тип клиента";
            }
            if (!($data['field_type'])) {
                $this->errorFields[] = "Требуемые поля";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE pay_type SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);
                ;

                if (is_null($this->error)) {

                    $status = $this->db->update('pay_type', $data, array('pay_id' => $id, 'firm_id' => $this->firmID));

                    url::redirect(url::site() . "settings/pay?updatedPayWay");
                    exit();

                }
            } else {
                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Настройки сайта не произведены. Для изменения настроек необходимо запонить все поля. ');
                }
            }
        }

        $table                         = "pay_type";
        $where                         = "pay_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->user = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->user = $this->template->content->user[0];

        if ($this->template->content->user) {

            $this->template->title = 'Редактирование способа оплаты «' . html::specialchars($this->template->content->user->title) . '»';

            $this->template->content->otherPayWay = $this->db->select('*')->from('pay_type')
                ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();

            $table                             = 'delivery';
            $where                             = 'firm_id = ' . $this->firmID;
            $this->template->content->delivery = $this->db->select('*')->from($table)->
                where($where)->orderby('sort', 'asc')->get();


        } else {
            Event::run('system.404');
        }

    }


    public function payadd()
    {

        $this->template->content = new View('settings/payadd');

        $this->template->title  = 'Добавление способа оплаты';
        $this->selected_subpage = Settings_Controller::SUBPAGE_PAY_ADD;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $dataUser['title']       = @trim($_POST['pay']['title']);
            $dataUser['sort']        = @intval($_POST['pay']['sort']);
            $dataUser['client_type'] = @intval($_POST['pay']['type']);
            $dataUser['conditions']  = @trim($_POST['pay']['conditions']);
            $dataUser['field_type']  = @intval($_POST['pay']['field_type']);
            $dataUser['delivery']    = @intval($_POST['pay']['delivery']);
            $dataUser['firm_id']     = $this->firmID;
            $dataUser['status']      = STATUS_WORK;

            if (empty($dataUser['title'])) {
                $this->errorFields[] = "Название";
            }
            if (!($dataUser['client_type'])) {
                $this->errorFields[] = "Тип клиента";
            }
            if (!($dataUser['field_type'])) {
                $this->errorFields[] = "Требуемые поля";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $this->db->query('UPDATE pay_type SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $dataUser['sort']);
                ;

                $status = $this->db->insert('pay_type', $dataUser);
                if (count($status)) {
                    url::redirect(url::site() . "settings/pay?newPayWay");
                    exit();
                } else {
                    $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Добавление нового способа оплаты не произведено. ');
                }

            }
        }

        $table                             = 'delivery';
        $where                             = 'firm_id = ' . $this->firmID;
        $this->template->content->delivery = $this->db->select('*')->from($table)->
            where($where)->orderby('sort', 'asc')->get();

        if (!count($this->template->content->delivery)) {
            url::redirect(url::site() . "/settings/deliveryadd?needDelivery");
            exit();
        }


        $this->template->content->payway = $this->db->select('*')->from('pay_type')
            ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();


    }


    public function tutorial()
    {

        $this->template->content = new View('settings/tutorial');

        $this->template->title  = 'Первые шаги';
        $this->selected_subpage = Settings_Controller::SUBPAGE_TUTORIAL;

        if (!$this->haveAccess()) {
            return;
        }
        ;

    }

    public function api()
    {

        $this->template->content = new View('settings/api');

        $this->template->title  = 'API';
        $this->selected_subpage = Settings_Controller::SUBPAGE_API;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if (empty($this->firm->api_key) || !isset($this->firm->api_key)) {

            $this->firm->api_key = md5($this->firmID . 'siske' . $this->firmID . rand(9999, 9999999));
            $this->firm->api_key = substr($this->firm->api_key, 0, 5) . substr($this->firm->api_key, -5);

            $this->db->update('firms', array('api_key' => $this->firm->api_key), array('id' => $this->firmID));

        }

    }


    public function account()
    {

        $this->template->content = new View('settings/account');

        $this->template->title  = 'Статистика ресурсов Интерен-магазина';
        $this->selected_subpage = Settings_Controller::SUBPAGE_ACCOUNT;

        if (!$this->haveAccess()) {
            return;
        }
        ;

    }


    //  'sales' => ACCESS_ADMIN,

    public function enabled()
    {

        $this->template->content = new View('settings/enabled');

        $this->template->title  = 'Включить/выключить магазин';
        $this->selected_subpage = Settings_Controller::SUBPAGE_ENABLED;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            if ($this->firmID == DEMO_SHOP) {
                $this->info = 'Отключить демо-магазинь нельзя.';
                return;
            }
            $enabled = (isset($_POST['firms']['enabled']) ? 1 : 0);

            $status = $this->db->update('firms', array('enabled' => $enabled), array('id' => $this->firmID));

            //  print_r($status); exit();
            if (count($status)) {

                $this->session->set("firm", null);

                if ($enabled == 1) {
                    url::redirect(url::site() . "settings/enabled?enabled");
                } else {
                    url::redirect(url::site() . "settings/enabled?disabled");
                }
                exit();
            } else {
                $this->error .= 'Выключатель не был изменён.' . $this->NL();
            }
        }
    }


    public function sales()
    {

        $this->template->content = new View('settings/sales');

        $this->template->title  = 'Режим продаж магазина';
        $this->selected_subpage = Settings_Controller::SUBPAGE_SALES;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $enabled = ($_POST['sales']);

            $status = $this->db->update('firms', array('sales' => $enabled), array('id' => $this->firmID));

            if (count($status)) {

                $this->session->set("firm", null);
                url::redirect(url::site() . "settings/sales?salesUP");

                exit();
            } else {
                $this->error .= 'Изменения не были произведены.' . $this->NL();
            }
        }
    }
}