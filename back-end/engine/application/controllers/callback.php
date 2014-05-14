<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Список заявок на обратный звонок
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Callback_Controller extends Web_Controller {

    const SUBPAGE_MAIN = 'main';
    const SUBPAGE_ADD = 'add';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER, 
        );

        $this->selected_page   = PAGE_CALLBACK;

        if(array_key_exists('up', $_REQUEST)){
            $this->info = 'Ответ на сообщение зафиксирован.';
        }
    }

 
    public function index() {
        
        $this->template->content = new View('callback/index');

        $this->template->title = 'Запросы на обратный звонок';
        $this->selected_subpage = Feedback_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $this->typeaction = $this->uri->segment('typeaction');
        $this->callbackid = $this->uri->segment('callbackid');

         if(!empty($this->typeaction) && !empty($this->callbackid) &&
            array_key_exists($this->typeaction, $GLOBALS['CALLBACK_STATUS'])){
            $status = $this->db->update('users_phone',
                                        array(
                                             'status' => $this->typeaction
                                             //'moder_id' => $this->moderId
                                        ),
                                        array('id' => $this->callbackid ));
            if(count($status)){
                $this->info = 'Статус запроса изменён.';
            }
        }
 
        $this->type = $this->uri->segment('type');
        if(empty($this->type)){
 
        }else{
 
            switch($this->type){
                case CALLBACK_STATUS_NEW:
                    $this->template->title = 'Новые запросы от пользователей магазина';
                    break;
                case CALLBACK_STATUS_CANCEL:
                    $this->template->title = 'Проигнорированные запросы от пользователей магазина';
                    break;  
                case CALLBACK_STATUS_PROCEEDED:
                    $this->template->title = 'Обработанные запросы от пользователей магазина';
                    break;
                default:
                    $this->type = null;
            }
        }
 
        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'users_phone';
        $where = '1=1 and firm_id = ' . $this->firmID  . (!empty($this->type) ? " and status = " . $this->type : "");

        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('date', 'DESC')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

            // Base_url will default to the current URI
           'base_url'    => 'callback/index',

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
            'auto_hide'      => TRUE,
        ));
 
        $this->template->content->pagination = $pagination->render('digg');
        $this->template->content->count_records = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;
    }
 
} 