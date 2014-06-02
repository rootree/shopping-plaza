<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Администрирование вакансий в интернет-магазине
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Vacancy_Controller extends Web_Controller
{

    const SUBPAGE_MAIN = 'main';
    const SUBPAGE_ADD  = 'add';

    public function __construct()
    {
        parent::__construct();
        $this->accessRules = array(
            'index'  => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'edit'   => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add'    => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'info'   => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'delete' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
        );

        $this->selected_page = PAGE_VACANCY;

        if (array_key_exists('vacancyAdded', $_REQUEST)) {
            $this->info = 'Новая вакансия успешно создана.';
        }
        if (array_key_exists('vacancyDeleted', $_REQUEST)) {
            $this->info = 'Вакансия успешно удалена.';
        }
        if (array_key_exists('vacancyUp', $_REQUEST)) {
            $this->info = 'Вакансия успешно изменена.';
        }
    }


    public function index()
    {

        $this->template->content = new View('vacancy/index');

        $this->template->title  = 'Вакансии';
        $this->selected_subpage = Vacancy_Controller::SUBPAGE_MAIN;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'vacancy';
        $where = '1=1 and firm_id = ' . $this->firmID;

        $offset = $page_limit * ($offset - 1);

        if (!isset($offset) || $offset <= 0) {
            $offset = 0;
        }

        $this->template->content->items = $this->db->select('*')->from($table)->
            where($where)->offset($offset)->limit($page_limit)->orderby('date', 'acs')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(

            // Base_url will default to the current URI
            'base_url'       => 'vacancy/index',

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


    public function add()
    {

        $this->template->content = new View('vacancy/add');

        $this->template->title  = 'Добавление новой вакансии';
        $this->selected_subpage = Vacancy_Controller::SUBPAGE_ADD;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $data['title']            = @trim($_POST['vacancy']['title']);
            $data['responsibilities'] = @trim($_POST['vacancy']['responsibilities']);
            $data['requirements']     = @trim($_POST['vacancy']['requirements']);
            $data['conditions']       = @trim($_POST['vacancy']['conditions']);

            $data['tel']  = @trim($_POST['vacancy']['tel']);
            $data['mail'] = @trim($_POST['vacancy']['mail']);

            $data['wage_level']          = @trim($_POST['vacancy']['wage_level']);
            $data['employment_type']     = @intval($_POST['vacancy']['employment_type']);
            $data['experience_required'] = @intval($_POST['vacancy']['experience_required']);

            $data['firm_id'] = $this->firmID;
            $data['date']    = date("Y.m.d H:i:s");

            $data['tel']  = @trim($_POST['vacancy']['tel']);
            $data['mail'] = @trim($_POST['vacancy']['mail']);

            if (!isset($data['title']) || !($data['title'])) {
                $this->errorFields[] = "Должность";
            }

            if (!isset($data['responsibilities']) || !($data['responsibilities']) || strlen($data['responsibilities']) == 4) {
                $this->errorFields[] = "Обязанности";
            }
            if (!isset($data['requirements']) || !($data['requirements']) || strlen($data['requirements']) == 4) {
                $this->errorFields[] = "Требования";
            }
            if (!isset($data['conditions']) || !($data['conditions']) || strlen($data['conditions']) == 4) {
                $this->errorFields[] = "Условия";
            }


            if (!($data['employment_type'])) {
                $this->errorFields[] = "Тип занятости";
            }
            if (!($data['experience_required'])) {
                $this->errorFields[] = "Требуемый опыт работы";
            }


            if (is_null($this->error) && !count($this->errorFields)) {

                $status = $this->db->insert('vacancy', $data);

                if (count($status)) {

                    $this->info = 'Уровень добавлен.';
                    url::redirect(url::site() . "vacancy/info/id/" . $status->insert_id() . "?vacancyAdded");
                    exit();

                } else {
                    $this->error .= 'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Добавление новой вакансии не произведено. ');
                }

            }
        }
    }


    public function delete()
    {

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('vacancy', array('vacancy_id' => $id, 'firm_id' => $this->firmID));

        if (count($status)) {
            url::redirect(url::site() . "vacancy?vacancyDeleted");
            exit();
        }
    }

    public function edit()
    {

        $this->template->content = new View('vacancy/edit');
        $this->template->title   = 'Изменение вакансии ';
        $this->selected_subpage  = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        //    $this->getLevelInfo();

        if ($_POST) {

            $data['title']            = @trim($_POST['vacancy']['title']);
            $data['responsibilities'] = @trim($_POST['vacancy']['responsibilities']);
            $data['requirements']     = @trim($_POST['vacancy']['requirements']);
            $data['conditions']       = @trim($_POST['vacancy']['conditions']);

            $data['tel']  = @trim($_POST['vacancy']['tel']);
            $data['mail'] = @trim($_POST['vacancy']['mail']);

            $data['wage_level']          = @intval($_POST['vacancy']['wage_level']);
            $data['employment_type']     = @intval($_POST['vacancy']['employment_type']);
            $data['experience_required'] = @intval($_POST['vacancy']['experience_required']);

            $data['date'] = date("Y.m.d H:i:s");


            if (!isset($data['title']) || !($data['title'])) {
                $this->errorFields[] = "Должность";
            }

            if (!isset($data['responsibilities']) || !($data['responsibilities']) || strlen($data['responsibilities']) == 4) {
                $this->errorFields[] = "Обязанности";
            }
            if (!isset($data['requirements']) || !($data['requirements']) || strlen($data['requirements']) == 4) {
                $this->errorFields[] = "Требования";
            }
            if (!isset($data['conditions']) || !($data['conditions']) || strlen($data['conditions']) == 4) {
                $this->errorFields[] = "Условия";
            }

            if (!($data['employment_type'])) {
                $this->errorFields[] = "Тип занятости";
            }
            if (!($data['experience_required'])) {
                $this->errorFields[] = "Требуемый опыт работы";
            }


            if (is_null($this->error) && !count($this->errorFields)) {

                $id     = intval($this->uri->segment('id'));
                $status = $this->db->update('vacancy', $data, array('vacancy_id' => $id, 'firm_id' => $this->firmID));

                if (count($status)) {
                    url::redirect(url::site() . "/vacancy/info/id/" . $id . "?vacancyUp");
                    exit();
                }

            } else {

                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Изменение вакансии не произведено. ');
                }

            }
        }

        $id                            = intval($this->uri->segment('id'));
        $table                         = "vacancy";
        $where                         = "vacancy_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if ($this->template->content->item) {
            // $this->template->title = $this->template->content->item->title;
        } else {
            Event::run('system.404');
        }

    }


    public function info()
    {

        $this->template->content = new View('vacancy/info');
        $this->selected_subpage  = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id                            = intval($this->uri->segment('id'));
        $table                         = "vacancy";
        $where                         = "vacancy_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if ($this->template->content->item) {
            $this->template->title = $this->template->content->item->title;
        } else {
            Event::run('system.404');
        }

    }

} 