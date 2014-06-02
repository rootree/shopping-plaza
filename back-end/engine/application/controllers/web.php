<?php defined('SYSPATH') OR die('No direct access allowed.');

set_time_limit(0);

abstract class Web_Controller extends Template_Controller
{

    public $template = 'authorize/template';
    public $error = null;

    const ALLOW_PRODUCTION = false;

    protected $accessRules;

    public function __construct()
    {

        Kohana::config('common.php');

        if ($_SERVER['HTTP_USER_AGENT'] == 'Shockwave Flash') {

            $ss            = (Input::instance()->post(Kohana::Config('session.name')));
            $this->session = Session::instance(null, $ss);

        } else {
            $this->session = new Session(); // TODO
        }

        // expires::set(600);

        Kohana::config_set('locale', 'ru_RU');

        $this->input = new Input();
        $this->id    = 0;

        /**
         * Database
         */
        $this->db = new Database();

        if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get")) {
            date_default_timezone_set('Europe/Moscow');
        }

        $this->selected_page    = null;
        $this->selected_subpage = null;
        $this->error            = null;
        $this->errorFields      = array();
        $this->info             = null;

        $this->moderId = 0;
        $this->firmID  = 0;

        $this->firm = null;
        $this->user = null;

        if ($this->session->get("access") && $this->session->get("access") != ACCESS_GUEST) {

            $this->access = $this->session->get("access");

            $this->moderId = $this->session->get("moderId");
            $this->firmID  = $this->session->get("firmId");

            $this->firm = $this->session->get("firm");
            $this->user = $this->session->get("user");

            $this->planType = 1;

            if (empty($this->firm)) {

                $table = 'firms';
                $where = 'id = ' . $this->firmID;

                $this->firm = $this->db->select('*')->from($table)->
                    where($where)->get();
                $this->firm = $this->firm[0];

                $this->session->set("firm", $this->firm);

            }

            if (empty($this->user)) {

                $table = 'moders';
                $where = 'user_id = ' . $this->moderId;

                $this->user = $this->db->select('*')->from($table)->
                    where($where)->get();
                $this->user = $this->user[0];

                $this->session->set("user", $this->user);

            }

            if (is_string($this->firm->prices)) {
                $this->firm->prices = json_decode($this->firm->prices);
            }

            if (!isset($this->firm->YMLenabled)) {
                url::redirect(url::site() . "login");
                exit();
            }


            $lastPage       = cookie::get('lastPage');
            $lastRedirected = ($this->session->get("lastRedirected"));

            if (strpos($_SERVER['PATH_INFO'], 'login') === false && !array_key_exists('redirected', $_REQUEST)) {
                cookie::set('lastPage', $_SERVER['PATH_INFO']); // TODO
                $this->session->set("lastRedirected", 1);
            }

            if (!empty($lastPage) && !$lastRedirected && !array_key_exists('redirected', $_REQUEST)) {
                $this->session->set("lastRedirected", 1);
                url::redirect(url::site() . substr($lastPage, 1) . "?redirected");
                exit();
            }

        } else {

            $this->template = 'public/template';
            $this->access   = ACCESS_GUEST;

        }

        parent::__construct();

    }

    protected function NL()
    {
        return "<br/>" . PHP_EOL;
    }

    protected function exec($command)
    {
        if ($GLOBALS['runningOn'] == 3) {
            pclose(popen($command, 'r'));
            ;
        } else {
            exec('' . $command);
        }
    }

    protected function haveAccess()
    {
        $srcController = debug_backtrace();
        $srcController = $srcController[1]['function'];
        if (!($this->accessRules[$srcController] & $this->access)) {
            // нет прав
            $this->template->content = new View('public/login');
            $this->template->title   = "Ошибка доступа";
            $this->error             = 'Ваших прав не достаточно для просмотра запрашиваемой страницы' . $this->NL();
            return false;
        } else {
            return true;
        }
    }

    protected function haveAccessByStatus($status)
    {
        if (!($GLOBALS['ACCESS_BY_STATUS'][$status] & $this->access)) {
            return false;
        } else {
            return true;
        }
    }

    protected function convertSelectedPageToCode($page)
    {
        switch ($page) {
            case PAGE_LOGIN:
                return 1;
            case PAGE_DASHBOARD:
                return 2;
            case PAGE_REG:
                return 3;
            case PAGE_SETTINGS:
                return 4;

            case PAGE_ITEMS:
                return 5;
            case PAGE_USERS:
                return 6;
            case PAGE_CLIENTS:
                return 7;
            case PAGE_ORDERS:
                return 8;
            case PAGE_FEEDBACK:
                return 9;
            case PAGE_VACANCY:
                return 10;
            case PAGE_NEWS:
                return 11;
            case PAGE_PARTNERS:
                return 12;
            case PAGE_PAGES:
                return 13;
            default:
                return 0;
        }
    }

    protected function completeErrorFieldsMessage($msg)
    {

        if (count($this->errorFields) == 1) {
            return $msg . 'Обратите внимание на поле «' . $this->errorFields[0] . '»';
        } else {
            $msg .= 'Обратите внимание на поля: <div class="errorDescFields"><ul> ';
            foreach ($this->errorFields as $error) {
                $msg .= '<li>' . $error . '</li>';
            }
            $msg .= '</ul></div>';
        }

        return $msg;
    }

    protected function updatePrices()
    {
        $this->db->update('firms', array('updatePrices' => 1), 'id = ' . $this->firmID);
    }


}

function xo($msg)
{
    print_r($msg);
}

?>