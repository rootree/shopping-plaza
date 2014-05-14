<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Управление новостями магазина
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class News_Controller extends Web_Controller {

    const SUBPAGE_MAIN = 'main';
    const SUBPAGE_ADD = 'add';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER, 
            'add' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'info' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'delete' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
        );

        $this->selected_page   = PAGE_NEWS;


        if(array_key_exists('up', $_REQUEST)){
            $this->info = 'Новость успешна отредактирована.';
        }
        if(array_key_exists('droped', $_REQUEST)){
            $this->info = 'Новость успешна удалена.';
        }
        if(array_key_exists('new', $_REQUEST)){
            $this->info = 'Новость успешна добавлена.';
        }

    }

 
    public function index() {
 
        $this->template->content = new View('news/index');

        $this->template->title = 'Список новостей';
        $this->selected_subpage = News_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'news';
        $where = '1=1 and firm_id = ' . $this->firmID;

        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('date', 'desc')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

            // Base_url will default to the current URI
            'base_url'    => 'news/index',

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


    public function add() {

        $this->template->content = new View('news/add');

        $this->template->title = 'Добавление новости';
        $this->selected_subpage = News_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };
  
        if ($_POST){

            $data['title'] = trim($_POST['news']['title']);
            $data['annonce'] = trim($_POST['news']['annonce']);
            $data['content'] = trim($_POST['news']['content']);
 
            $data['firm_id'] = $this->firmID;
            $data['date'] = date("Y.m.d H:i:s");
 
            if(!($data['title'])){
                $this->errorFields[] = "Заголовок";
            }

            if(!($data['annonce'])){
                $this->errorFields[] = "Анонс";
            }

            if(!($data['content']) || strlen($data['content']) == 4){
                $this->errorFields[] = "Содержание";
            }
  
            if(is_null($this->error) && !count($this->errorFields)){

                $status = $this->db->insert('news', $data);

                if(count($status)){ 
                    url::redirect(url::site() . "news/info/id/" . $status->insert_id() . '?new');
                    exit();
                }else{
                    $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }
            }else{
                $this->error = $this->completeErrorFieldsMessage('Новость не изменена. Для изменения новости необходимо запонить все поля. ');
            }
        }
    }


    public function delete() {

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('news', array('news_id' => $id,'firm_id' => $this->firmID ));

        if(count($status)){
            url::redirect(url::site() . "news/?droped");
            exit();
        }else{
            Event::run('system.404');
        }
    }

    public function edit() {

        $this->template->content = new View('news/edit');
        $this->template->title = 'Редактирование новости';
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };
 
        if ($_POST){

            $data['title'] = trim($_POST['news']['title']);
            $data['content'] = trim($_POST['news']['content']);
            $data['annonce'] = trim($_POST['news']['annonce']);

            if(!($data['title'])){
                $this->errorFields[] = "Заголовок";
            }
            if(!($data['annonce'])){
                $this->errorFields[] = "Анонс";
            }
            if(!($data['content']) || strlen($data['content']) == 4){
                $this->errorFields[] = "Содержание"; 
            }

            if(is_null($this->error) && !count($this->errorFields)){
 
                $id = intval($this->uri->segment('id'));

                $status = $this->db->update('news', $data, array('news_id' => $id, 'firm_id' => $this->firmID));
 
                if(count($status)){
                    url::redirect(url::site() . "/news/info/id/".$id."?up");
                    exit();
                }else{
                    $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }
            }else{
                 $this->error = $this->completeErrorFieldsMessage('Новость не изменена. Для изменения новости необходимо запонить все поля. ');
            }
        }

        $id = intval($this->uri->segment('id'));
        $table = "news";
        $where = "news_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if($this->template->content->item){

            $this->id = $id;
        }else{
            Event::run('system.404');
        }

    }
 

    public function info() {

        $this->template->content = new View('news/info');
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));
        $table = "news";
        $where = "news_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if($this->template->content->item){
            $this->template->title = $this->template->content->item->title;
        }else{
            Event::run('system.404'); 
        }

    }

} 