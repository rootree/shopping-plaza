<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Обработка статей для интернет-магазина
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Pages_Controller extends Web_Controller {

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

        if(array_key_exists('up', $_REQUEST)){
            $this->info = 'Страница успешно изменёна.';
        }
        if(array_key_exists('droped', $_REQUEST)){
            $this->info = 'Страница успешно удалена.';
        }
        if(array_key_exists('new', $_REQUEST)){
            $this->info = 'Страница успешно добавлена.';
        }

        $this->selected_page   = PAGE_PAGES;
    }


    public function index() {

        $this->template->content = new View('pages/index');

        $this->template->title = 'Страницы';
        $this->selected_subpage = Pages_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'pages';
        $where = '1=1 and firm_id = ' . $this->firmID;

        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('sort', 'asc')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

              // Base_url will default to the current URI
              'base_url'    => 'pages/index',

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

        $this->template->content = new View('pages/add');

        $this->template->title = 'Добавление новой страницы';
        $this->selected_subpage = Pages_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $data['title'] = ($_POST['pages']['title']);
            $data['content'] = ($_POST['pages']['content']);

            $data['sort'] = @intval($_POST['pages']['sort']);

            $data['firm_id'] = $this->firmID;
            $data['date'] = date("Y.m.d H:i:s");

            if(!($data['title'])){
                $this->errorFields[] = "Заголовок";
            }

            if(!($data['content'])|| strlen($data['content']) == 4){ 
                $this->errorFields[] = "Содержимое";
            }

            if(is_null($this->error) && !count($this->errorFields)){

                $this->db->query('UPDATE pages SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);;

                $data['url_link'] = format::do_latin($data['title']);
                $status = $this->db->insert('pages', $data);

                if(count($status)){

                    $this->db->update('images', array(
                                                    "for_item" => $status->insert_id()),
                                      array(
                                           'for_item' => 0,
                                           'firm_id' => $this->firmID,
                                           'type' => $this->convertSelectedPageToCode($this->selected_page)
                                      ));
                    $this->info = 'Уровень добавлен.';
                    url::redirect(url::site() . "pages/info/id/" . $status->insert_id(). "?new");


                }
            }else{
                 $this->error = $this->completeErrorFieldsMessage('Страница не добавлена. Для добавления страницы необходимо запонить обязательные поля. ');
            }
        }

        $this->template->content->pages = $this->db->select('*')->from('pages')
                ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();
    }


    public function delete() {

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));

        $status = $this->db->delete('pages', array('page_id' => $id,'firm_id' => $this->firmID ));

        if(count($status)){ 
            url::redirect(url::site() . "pages/". "?droped");
            exit();
        }else{
            Event::run('system.404');
        }
    }

    public function edit() {

        $this->template->content = new View('pages/edit');
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $data['title'] = ($_POST['pages']['title']);
            $data['content'] = ($_POST['pages']['content']);
            $data['sort'] = @intval($_POST['pages']['sort']);

            if(!($data['title'])){
                $this->errorFields[] = "Заголовок";
            }
            if(!($data['content']) || strlen($data['content']) == 4){
                $this->errorFields[] = "Содержание";
            }

            if(is_null($this->error) && !count($this->errorFields)){

                $this->db->query('UPDATE pages SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);;

                $data['url_link'] = format::do_latin($data['title']);
                
                $id = intval($this->uri->segment('id'));

                $status = $this->db->update('pages', $data, array('page_id' => $id, 'firm_id' => $this->firmID));

                if(count($status)){
                    $this->info = 'Уровень отредактирован.';
                    url::redirect(url::site() . "pages/".'?up');
                    exit();
                } 
            }else{
                if($this->error == null){
                    $this->error = $this->completeErrorFieldsMessage('Изменение страницы не произведено. Для изменения страницы необходимо запонить все поля. ');
                }
            }
        }

        $this->id = $id = intval($this->uri->segment('id'));
        $table = "pages";
        $where = "page_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if(empty($this->template->content->item)){
            Event::run('system.404');
            exit;
        }
 
        $this->template->title = 'Редактирование страницы «' . $this->template->content->item->title . "»";

        $this->template->content->pages = $this->db->select('*')->from('pages')
                ->where('1=1 and firm_id = ' . $this->firmID)->orderby('sort', 'asc')->get();
    }


    public function info() {

        $this->template->content = new View('pages/info');
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));
        $table = "pages";
        $where = "page_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if(empty($this->template->content->item)){
            Event::run('system.404');
        }else{
            $this->template->title = $this->template->content->item->title;
        }
        
    }

} 