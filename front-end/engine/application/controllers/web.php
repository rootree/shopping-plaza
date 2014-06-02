<?php defined('SYSPATH') OR die('No direct access allowed.');

set_time_limit(0);

#session_set_cookie_params(83000,"/","c-net-shopping.ru");
#session_set_cookie_params(1,"/","media.c-net-shopping.ru");

function formula($key)
{
    return $key->price;
}

function getKeyWords($words)
{
    return ',' . str_replace(' ', ',', $words);
}

/**
 * подготовительная обработка перед любой страницей
 */
abstract class Web_Controller extends Template_Controller
{

    var $groups = null;
    public $template = 'kohana/template';

    public function __construct()
    {
        Kohana::config('common.php');

        expires::set(600);

        Kohana::config_set('locale', 'ru_RU');

        $this->input = new Input();

        $this->session = new Session;

        if (count($this->session->get('items')) == 0) {
            $this->session->set('items', array());
        }

        if (($this->session->get('locale')) == null) {
            $this->session->set('locale', 'ru_RU');
        }

        $this->db = new Database;

        $this->selected_page = null;

        $this->firm  = $this->session->get("firm");
        $this->phone = $this->session->get('phone');

        if (array_key_exists('clear', $_REQUEST)) {
            $this->firm = null;
            ;
        }
        // cookie::set('userBlocked', '0');
        if (cookie::get('userBlocked')) {
            $this->session->set('userBlocked', '1');
        }

        $val            = $this->session->get('items');
        $this->totalSum = $this->session->get('totalSum');
        ;

        if (empty($this->totalSum)) {
            $this->totalSum = money::ru(0);
        }

        if (empty($val)) {
            $this->count_bin_items = 0;
        } else {
            $this->count_bin_items = count($val);
        }
        try {

            if (!empty($val)) {
                $archive_items = $this->db->select('*')->from('bz_items')->where('it_archive = 1')->in('it_id', array_keys($val))->get()->count();
                if ($archive_items) {
                    $this->session->set('items', array());
                    header('Location: /?catalog_updated');
                    exit(); //url::redirect('/?catalog_updated');
                }
                ;
            }
        } catch (Exception $e) {

        }

        if (!empty($this->firm->domain) && $this->firm->domain != $_SERVER['SERVER_NAME']) {
            $this->firm = null;
            ;
        }

        if (empty($this->firm)) {

            $wwwDomain = (substr($_SERVER['SERVER_NAME'], 0, 4) == 'www.')
                ? substr($_SERVER['SERVER_NAME'], 4)
                : $_SERVER['SERVER_NAME'];

            $table      = "firms";
            $where      = "domain = '" . $wwwDomain . "'"; // $_SERVER['HTTP_HOST']
            $this->firm = $this->db->select('*')->from($table)->
                where($where)->get();

            $this->firm = $this->firm[0];

            if (empty($this->firm)) {
                header('Location: http://www.shopping-plaza.ru/?free=' . $_SERVER['SERVER_NAME']);
                exit();
            }

            unset($this->firm->mainpage);

            $this->session->set("firm", $this->firm);
        }

        $this->template = 'kohana/' . $this->firm->template;

        require Kohana::find_file('vendor', 'SuperPath');
        require Kohana::find_file('vendor', 'SMSer');

        $priceFile = SuperPath::get($this->firm->id, false, IMAGES_TYPE_PRICE) . ".zip";
        if (file_exists($priceFile)) {
            $last_modified = filemtime($priceFile);
            define('FILE_PRISE', $priceFile);
            $this->datePriceUpdate = date(DATE_FORMAT_LITE, $last_modified);
            $this->priceLink       = SuperPath::get($this->firm->id, true, IMAGES_TYPE_PRICE) . ".zip";
        } else {
            $this->datePriceUpdate = null;
            $this->priceLink       = null;
            define('FILE_PRISE', $priceFile);
        }


        parent::__construct();

        if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get")) {
            date_default_timezone_set('Europe/Moscow');
        }

        $this->descriptionHTML = $this->firm->description;

        $this->firmID          = $this->firm->id;
        $config['site_domain'] = $this->firm->domain; // 'shop.webnizer.com/';

        define('SERVER_SITE', $this->firm->domain . '/');

        $table                  = 'cats';
        $this->groups           = $this->db->select('*')->from($table)->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->
            orderby('sort')->orderby('title')->get();
        $this->template->groups = $this->groups;

        $table = 'pages';
        $where = '1=1 and firm_id = ' . $this->firmID;

        $this->pages = $this->db->select('*')->from($table)->
            where($where)->orderby('sort', 'acs')->get();

        $this->userId      = intval($this->session->get("userId"));
        $this->userName    = $this->session->get("userName");
        $this->userMail    = $this->session->get("userMail");
        $this->userMailNew = $this->session->get("userMailNew");

        if (is_string($this->firm->prices)) {
            $this->firm->prices = json_decode($this->firm->prices);
        }

        require Kohana::find_file('vendor', 'Mailer');
    }

    public function _render()
    {
        header("Title: " . format::do_latin($this->template->title));
        parent::_render();
    }

    protected function NL()
    {
        return "<br/>" . PHP_EOL;
    }
}

?>