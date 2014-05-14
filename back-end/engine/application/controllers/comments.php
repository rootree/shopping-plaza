<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Модерирование коментариев
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Comments_Controller extends Web_Controller {

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

        $this->selected_page   = PAGE_COMMENTS;
        $this->selected_subpage = null;
        
        if(array_key_exists('up', $_REQUEST)){
            $this->info = 'Комментарий успешно изменён.';
        }
        if(array_key_exists('answer', $_REQUEST)){
            $this->info = 'Ответ успешно сохранён.';
        }
    }

 
    public function index() {

        $this->template->content = new View('comments/index');

        $this->template->title = 'Комментарии пользователей';
        $this->selected_subpage = Comments_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };


        $this->typeaction = $this->uri->segment('typeaction');
        $this->id = $this->uri->segment('id');
        if(!empty($this->typeaction) && !empty($this->id)){
            $status = $this->db->update('comment_items',
                                        array(
                                             'status' => COMMENT_STATUS_DELETED 
                                        ),
                                        array('coment_id' => $this->id ));
            if(count($status)){
                $this->info = 'Комментарий удалён.';
            }

            if(array_key_exists('block', $_REQUEST)){
 
                $table = "comment_items";
                $where = "coment_id = " . $this->id . " and firm_id = " . $this->firmID;
                $comment = $this->db->select('*')->from($table)->where($where)->get();
                $comment = $comment[0];

                if(!empty($comment)){

                    $data['email'] = $comment->mail;
                    $data['ip'] = $comment->ip;
                    $data['agent'] = $comment->agent;
                    $data['date'] = date('Y-m-d H:i:s');
                    $data['moder_id'] = $this->moderId;
                    $data['firm_id'] = $this->firmID;

                    $this->db->insert('blocked_users', $data);
                    
                    $this->info .= ' Пользователь заблокирован.';
                }
            }
        } 
        
        $this->type = $this->uri->segment('type');
        if(empty($this->type)){
 
        }else{
 
            switch($this->type){
                case COMMENT_STATUS_NEW:
                    $this->template->title = 'Новые комментарии';
                    break;
                case COMMENT_STATUS_DELETED:
                    $this->template->title = 'Проигнорированные комментарии';
                    break;
                case COMMENT_STATUS_VIEWED:
                    $this->template->title = 'Просмотренные/одобренные комментарии';
                    break;  
              /*  case COMMENT_STATUS_CHACKED:
                    $this->template->title = 'Обработанные сообщения от пользователей магазина';
                    break;*/
                default:
                    $this->type = null;
            }
        }

   /*     if($this->type == FEEDBACK_STATUS_NEW && $this->firm->new_feedback > 0){
            $data = array(
                'new_feedback' => 0,
            );
            $this->db->update('firms', $data, 'id = '. $this->firmID);
        }
*/
        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'comment_items';
        $where = '1=1 and firm_id = ' . $this->firmID  . (!empty($this->type) ? " and status = " . $this->type : "");

        $addonWhere = array();


        if ($this->firm->comment_settings & COMMENT_ON_ITEMS) {
            $addonWhere[] = COMMENT_ON_ITEMS;
        }
        if ($this->firm->comment_settings & COMMENT_ON_NEWS) {
            $addonWhere[] = COMMENT_ON_NEWS;
        }
        if ($this->firm->comment_settings & COMMENT_ON_ARTICLE) {
            $addonWhere[] = COMMENT_ON_ARTICLE;
        }

        $where .= ' AND coment_type IN ('. implode(',',$addonWhere) . ')';

        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('createDate', 'DESC')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

            // Base_url will default to the current URI
           'base_url'    => 'comments/index/type/'.$this->type,

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

        $this->template->content = new View('comments/info');
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));


        $table = "comment_items";
        $where = "coment_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get(); 
        $this->template->content->item = $this->template->content->item[0];

        if(!empty($this->template->content->item)){

            $item_id = $this->template->content->item->item_id;

            switch ($this->template->content->item->coment_type) {
                case COMMENT_ON_ITEMS:

                    $table = "products";
                    $where = "product_id = " . $item_id . " and firm_id = " . $this->firmID;
                    $this->template->content->commentFor = $this->db->select('title')->from($table)->
                            where($where)->get();
                    $this->template->content->commentFor = $this->template->content->commentFor[0];
                    $this->template->content->commentFor = $this->template->content->commentFor->title;

                    $url = '/products/item/id/' . $item_id.'#comment'.$id;
                    break ;
                
                case COMMENT_ON_NEWS:

                    $table = "news";
                    $where = "news_id = " . $item_id . " and firm_id = " . $this->firmID;
                    $this->template->content->commentFor = $this->db->select('title')->from($table)->
                            where($where)->get();
                    $this->template->content->commentFor = $this->template->content->commentFor[0];
                    $this->template->content->commentFor = $this->template->content->commentFor->title;
                    $url = '/news/index/item/' . $item_id.'#comment'.$id;
                    break ;

                case COMMENT_ON_ARTICLE:

                    $table = "pages";
                    $where = "page_id = " . $item_id . " and firm_id = " . $this->firmID;
                    $this->template->content->commentFor = $this->db->select('title')->from($table)->
                            where($where)->get();
                    $this->template->content->commentFor = $this->template->content->commentFor[0];
                    $this->template->content->commentFor = $this->template->content->commentFor->title;
                        
                    $url = '/pages/index/id/' . $item_id.'#comment'.$id;
                    break ;
            }

            $this->template->title = "Просмотр комментария";

            if($this->template->content->item->status == COMMENT_STATUS_NEW){
                $this->template->content->item->status = COMMENT_STATUS_VIEWED;
                $status = $this->db->update('comment_items',
                    array(
                         'status' => COMMENT_STATUS_VIEWED 
                    ),
                    array('coment_id' => $id ));
                if(count($status)){
                    $this->info = 'Статус комментария изменён на «просмотренный».';
                }
            }

            $this->type = $this->template->content->item->status;

            if ($_POST){

                $data['coment_type'] = $this->template->content->item->coment_type;
                $data['content'] = trim($_POST['msg']);
                $data['name'] = trim($this->user->user_name) . ' (администратор магазина)';
                $data['mail'] = trim('system');
                $data['firm_id'] = $this->firmID;
                $data['item_id'] = $this->template->content->item->item_id;
                $data['status'] = COMMENT_STATUS_ANSWER;
                $data['createDate'] = date('Y-m-d H:i:s');
                $data['ip'] = $this->input->ip_address();

                $db = new Database;
                $db->insert('comment_items', $data);

                $this->db->update('comment_items',
                    array(
                         'status' => COMMENT_STATUS_ANSWERED
                    ),
                    array('coment_id' => $id ));

                $data = array();

                require Kohana::find_file('vendor', 'Mailer');
                
                $data['fb_title'] = $this->template->content->commentFor;
                $data['fb_email'] = $this->template->content->item->mail;
                $data['fb_name'] = $this->template->content->item->name;
                $data['fb_ansver'] = trim($_POST['msg']);
                $data['fb_questing'] = $this->template->content->item->content;
                $data['url'] = $this->firm->domain . $url;

                Mailer::feedbackResponce($data, true);

                url::redirect("/comments/info/id/$id?answer");
            }
 
        }else{
            Event::run('system.404');
        }
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

        $this->template->content = new View('comments/edit');
        $this->selected_subpage = null;

        $this->type = null;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){
 
            $data['content'] = ($_POST['comments']['content']);
            if(!($data['content']) || strlen($data['content']) == 4){
                $this->errorFields[] = "Содержание";
            }

            if(is_null($this->error) && !count($this->errorFields)){
 
                $id = intval($this->uri->segment('id'));

                $status = $this->db->update('comment_items', $data, array('coment_id' => $id, 'firm_id' => $this->firmID));

                if(count($status)){
                    url::redirect(url::site() . "/comments/info/id/$id/".'?up');
                    exit();
                }
            }else{
                if($this->error == null){
                    $this->error = $this->completeErrorFieldsMessage('Изменение комментария не произведено. Для изменения комментария необходимо запонить все поля. ');
                }
            }
        }

        $this->id = $id = intval($this->uri->segment('id'));
        $table = "comment_items";
        $where = "coment_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

        if(empty($this->template->content->item)){
            Event::run('system.404');
            exit;
        }

        $this->template->title = 'Редактирование комментария'; 
    }


    

} 