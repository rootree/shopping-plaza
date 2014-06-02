<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Управление партнерами, для магазина
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Partners_Controller extends Web_Controller
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

        $this->selected_page = PAGE_PARTNERS;

        if (array_key_exists('up', $_REQUEST)) {
            $this->info = 'Партнёр успешно изменён.';
        }
        if (array_key_exists('droped', $_REQUEST)) {
            $this->info = 'Партнёр успешно удален.';
        }
        if (array_key_exists('new', $_REQUEST)) {
            $this->info = 'Партнёр успешно добавлен.';
        }
    }


    public function index()
    {

        $this->template->content = new View('partners/index');

        $this->template->title  = 'Партнёры';
        $this->selected_subpage = Partners_Controller::SUBPAGE_MAIN;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'partners';
        $where = '1=1 and firm_id = ' . $this->firmID;

        $offset = $page_limit * ($offset - 1);

        if (!isset($offset) || $offset <= 0) {
            $offset = 0;
        }

        $this->template->content->items = $this->db->select('*')->from($table)->
            where($where)->offset($offset)->limit($page_limit)->orderby('partner_id', 'acs')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(

            // Base_url will default to the current URI
            'base_url'       => 'partners/index',

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

        $this->template->content = new View('partners/add');

        $this->template->title  = 'Добавление нового партнёра';
        $this->selected_subpage = Partners_Controller::SUBPAGE_ADD;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        if ($_POST) {

            $data['title']   = ($_POST['partners']['title']);
            $data['annonce'] = ($_POST['partners']['annonce']);

            $data['tel']     = ($_POST['partners']['tel']);
            $data['address'] = ($_POST['partners']['address']);
            $data['fax']     = ($_POST['partners']['fax']);
            $data['mail']    = ($_POST['partners']['mail']);
            $data['www']     = ($_POST['partners']['www']);

            $data['firm_id'] = $this->firmID;

            if (empty($data['title'])) {
                $this->errorFields[] = "Название";
            }
            if (empty($data['annonce']) || strlen($data['annonce']) == 4) {
                $this->errorFields[] = "Описание";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $status = $this->db->insert('partners', $data);

                if (count($status)) {
                    $this->info = 'Уровень добавлен.';
                    url::redirect(url::site() . "partners/info/id/" . $status->insert_id() . "?new");
                    exit();
                }
            } else {
                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Информация о парнёре не добавлена. ');
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

        $status = $this->db->delete('partners', array('partner_id' => $id, 'firm_id' => $this->firmID));

        if (count($status)) {
            url::redirect(url::site() . "partners/?droped");
            exit();
        } else {
            Event::run('system.404');
        }
    }

    public function edit()
    {

        $this->template->content = new View('partners/edit');
        $this->selected_subpage  = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id = intval($this->uri->segment('id'));

        if ($_POST) {

            $data['title']   = ($_POST['partners']['title']);
            $data['annonce'] = ($_POST['partners']['annonce']);
            $data['tel']     = ($_POST['partners']['tel']);
            $data['address'] = ($_POST['partners']['address']);
            $data['fax']     = ($_POST['partners']['fax']);
            $data['mail']    = ($_POST['partners']['mail']);
            $data['www']     = ($_POST['partners']['www']);

            if (empty($data['title'])) {
                $this->errorFields[] = "Название";
            }
            if (empty($data['annonce']) || strlen($data['annonce']) == 4) {
                $this->errorFields[] = "Описание";
            }

            if (is_null($this->error) && !count($this->errorFields)) {

                $status = $this->db->update('partners', $data, array('partner_id' => $id, 'firm_id' => $this->firmID));

                if (count($status)) {
                    url::redirect(url::site() . "partners/?up");
                    exit();
                }
            } else {
                if ($this->error == null) {
                    $this->error = $this->completeErrorFieldsMessage('Информация о парнёре не изменена. ');
                }
            }
        }

        $table                         = "partners";
        $where                         = "partner_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if (!empty($this->template->content->item)) {
            $this->template->title = "Изменение партнёра «" . html::specialchars($this->template->content->item->title) . '»';
        } else {
            Event::run('system.404');
        }
    }


    public function info()
    {

        $this->template->content = new View('partners/info');
        $this->selected_subpage  = null;

        if (!$this->haveAccess()) {
            return;
        }
        ;

        $id                            = intval($this->uri->segment('id'));
        $table                         = "partners";
        $where                         = "partner_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
            where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if (!empty($this->template->content->item)) {
            $this->template->title = "Парнёр «" . html::specialchars($this->template->content->item->title) . '»';
        } else {
            Event::run('system.404');
        }
    }

} 