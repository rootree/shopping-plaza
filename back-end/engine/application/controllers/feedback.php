<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Обработка сообщений обратной связи со страницы магазина
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Feedback_Controller extends Web_Controller {

    const SUBPAGE_MAIN = 'main';
    const SUBPAGE_ADD = 'add';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,  
            'info' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'delete' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
        );

        $this->selected_page   = PAGE_FEEDBACK;

        if(array_key_exists('up', $_REQUEST)){
            $this->info = 'Ответ на сообщение зафиксирован.';
        }
    }

 
    public function index() {

        $this->template->content = new View('feedback/index');

        $this->template->title = 'Сообщения от пользователей';
        $this->selected_subpage = Feedback_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $this->typeaction = $this->uri->segment('typeaction');
        $this->order = $this->uri->segment('feedbackid');
        if(!empty($this->typeaction) && !empty($this->order)){
            $status = $this->db->update('feedback',
                                        array(
                                             'status' => $this->typeaction,
                                             'moder_id' => $this->moderId
                                        ),
                                        array('fb_id' => $this->order ));
            if(count($status)){
                $this->info = 'Статус сообщения изменён.';
            }
        }
 
        $this->type = $this->uri->segment('type');
        if(empty($this->type)){
 
        }else{
 
            switch($this->type){
                case FEEDBACK_STATUS_NEW:
                    $this->template->title = 'Новые сообщения от пользователей магазина';
                    break;
                case FEEDBACK_STATUS_CANCEL:
                    $this->template->title = 'Проигнорированные сообщения от пользователей магазина';
                    break;
                case FEEDBACK_STATUS_VIEWED:
                    $this->template->title = 'Просмотренные сообщения от пользователей магазина';
                    break;  
                case FEEDBACK_STATUS_PROCEEDED:
                    $this->template->title = 'Обработанные сообщения от пользователей магазина';
                    break;
                default:
                    $this->type = null;
            }
        }
/*
        if($this->type == FEEDBACK_STATUS_NEW && $this->firm->new_feedback > 0){ 
            $data = array(
                'new_feedback' => 0,
            );
            $this->db->update('firms', $data, 'id = '. $this->firmID);
        }
*/
        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'feedback';
        $where = '1=1 and firm_id = ' . $this->firmID  . (!empty($this->type) ? " and status = " . $this->type : "");

        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('fb_date', 'DESC')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

            // Base_url will default to the current URI
           'base_url'    => 'feedback/index',

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


    public function info() {

        $this->template->content = new View('feedback/info');
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));

        $table = "feedback";
        $where = "fb_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get(); 
        $this->template->content->item = $this->template->content->item[0];

        if(!empty($this->template->content->item)){


            if ($_POST){

                $data['fb_ansver'] = trim($_POST['feedback']['ansver']);
                $data['fb_ansver_date'] = date("Y.m.d H:i:s");;
                $data['status'] = FEEDBACK_STATUS_PROCEEDED;;
                $data['moder_id'] = $this->moderId;;

                if(empty($data['fb_ansver'])){
                    $this->errorFields[] = "Ответ";
                }

                if(is_null($this->error) && !count($this->errorFields)){

                    $status = $this->db->update('feedback', $data, array('fb_id' => $id, 'firm_id' => $this->firmID));
                    if(count($status)){

                        require Kohana::find_file('vendor', 'Mailer');

                        $data['fb_title'] = $this->template->content->item->fb_title;
                        $data['fb_name'] = $this->template->content->item->fb_name;
                        $data['fb_email'] = $this->template->content->item->fb_email;
                        $data['fb_questing'] = $this->template->content->item->fb_questing;

                        Mailer::feedbackResponce($data );

                        url::redirect("/feedback/info/id/$id?up");
                        exit();
                    }

                }else{
                    if($this->error == null){
                        $this->error = $this->completeErrorFieldsMessage('Для ответа на сообщение его необходимо сначала написать. ');
                    }
                }
            }



            $this->template->title = "Просмотр сообщений от пользователей вашего магазина";

            if($this->template->content->item->status == FEEDBACK_STATUS_NEW){
                $this->template->content->item->status = FEEDBACK_STATUS_VIEWED;
                $status = $this->db->update('feedback',
                    array(
                         'status' => FEEDBACK_STATUS_VIEWED,
                         'moder_id' => $this->moderId
                    ),
                    array('fb_id' => $id ));
                if(count($status)){
                    $this->info = 'Статус сообщения изменён на «просмотренный».';
                }
            }

            $this->type = $this->template->content->item->status;

            $where = "fb_id = " . $id ;
            $this->template->content->order_history = $this->db->select('*')->from("feedback_history")->
                     join("moders", 'moders.user_id', 'feedback_history.moder_id', 'left')->
                     where($where)->orderby('date', 'acs')->get();

        }else{
            Event::run('system.404');
        }
    }

} 