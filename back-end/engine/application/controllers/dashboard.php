<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Главная страница панели управлением магазина
 */
class Dashboard_Controller extends Web_Controller {

    public function __construct() {

        parent::__construct();

        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'photo' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'info' => ACCESS_ADMIN + ACCESS_MODER
        );

    }

    public function index() {

        $confirmed = intval($this->uri->segment('confirmed'));

        if($confirmed){
            
            switch($confirmed){
                case CONFIRM_NEW_MAIL:
                    $this->info .= 'Вам успешно присвоен новый адрес электронный почты. Теперь для входа вы можете использовать именно его.' . $this->NL();
                    break;
                case CONFIRM_MAIL:
                    $this->info .= 'Указаный вами электронный адрес успешно активирован' . $this->NL();
                    break;
                case CONFIRM_NEW_FIRM:
                    $this->info .= 'Спасибо за доверие' . $this->NL();
                    break;
                case CONFIRM_NEW_USER:
                    $this->info .= 'Рады что с нами' . $this->NL();
                    break;
            }

            if(!empty($this->user->user_word)){
/*
                $data['confirmed_code'] = 0;
                $data['confirmed'] = CONFIRM_DONE;
                $this->db->update('moders', $data, array('user_id' => $this->moderId,'firm_id' => $this->firmID ));
               */
            } else {

                url::redirect(url::site() . "settings/useredit/id/" . $this->moderId . "?newPass" );
            /*    $this->error .=
                        'Сейчас вы подтвердили вашу пренадлежность а Ваш аккаунт не имеет пароля, настоятельно рекомендую его установить:

    <a href="' . url::site() . 'settings/useredit/id/' . $this->moderId . '">Настройки пользоватлея</a>' .$this->NL();
*/
                exit();
            }
        }

    

        $this->selected_page = PAGE_DASHBOARD;


        if(!$this->haveAccess()){
            return;
        };

        $this->session->set("search", null);

        $SQL = null;
        
        if ($_POST){
 
            $data['title'] = trim($_POST['search']['word']);
            $data['type'] = @($_POST['search']['type']);

            if(empty($data['title'])){
                $this->error = 'Поиск не произведён. Не указано что именно искать.';
            }

            $this->session->set("search", $data['title']);

            switch($data['type']){
                case SEARCH_TYPE_NEWS:
                    $this->template->content = new View('search/news');
                    $this->template->title = 'Результат поиска по новостям';
                    $SQL = "select * from news where (title like '%" . mysql_escape_string($data['title']). "%' OR annonce like '%" . mysql_escape_string($data['title']). "%' OR content like '%" . mysql_escape_string($data['title']). "%') AND firm_id = " . $this->firmID;
                    break;
                case SEARCH_TYPE_PRODUCTS:
                    $this->template->content = new View('search/products');
                    $this->template->title = 'Результат поиска в продукции';
                    $SQL = "select * from `products` where status in (".STATUS_WORK.',' . STATUS_HIDE .") AND (`arcitule` like '%" . mysql_escape_string($data['title']). "%' OR `title` like '%" . mysql_escape_string($data['title']). "%' OR `desc` like '%" . mysql_escape_string($data['title']). "%' OR `product_id` = " . intval($data['title']). ") AND firm_id = " . $this->firmID;
                    break;
                case SEARCH_TYPE_ORDER:
                    $this->template->content = new View('search/orders');
                    $this->template->title = 'Результат поиска по номеру заказа';
 
                    $SQL = "select `order`.*, pay_type.title as payment, delivery.title as devivery from `order`
                    left join pay_type on pay_type.pay_id = `order`.payment
                    left join delivery on delivery.del_id = `order`.devivery
                    where (`order`.id = " . intval($data['title']). " OR `order`.total = " . floatval($data['title']). " OR `order`.date = \"" . mysql_escape_string($data['title']). "\") AND `order`.firm_id = " . $this->firmID;
                    break;
                case SEARCH_TYPE_FEEDBACK:
                    $this->template->content = new View('search/feedback');
                    $this->template->title = 'Результат поиска по сообщениям от пользователей';
                    $SQL = "select * from feedback where (fb_questing like '%" . mysql_escape_string($data['title']). "%' OR fb_ansver like '%" . mysql_escape_string($data['title']). "%' OR fb_title like '%" . mysql_escape_string($data['title']). "%' OR fb_name like '%" . mysql_escape_string($data['title']). "%' OR fb_email like '%" . mysql_escape_string($data['title']). "%') AND firm_id = " . $this->firmID;
                    break;
                case SEARCH_TYPE_PARTNER:
                    $this->template->content = new View('search/partners');
                    $this->template->title = 'Результат поиска в партнёрах';
                    $SQL = "select * from partners where (annonce like '%" . mysql_escape_string($data['title']). "%' OR title like '%" . mysql_escape_string($data['title']). "%' ) AND firm_id = " . $this->firmID;
                    break;
                case SEARCH_TYPE_PAGES:
                    $this->template->content = new View('search/pages');
                    $this->template->title = 'Результат поиска на страницах сайта';
                    $SQL = "select * from pages where (content like '%" . mysql_escape_string($data['title']). "%' OR title like '%" . mysql_escape_string($data['title']). "%' ) AND firm_id = " . $this->firmID;
                    break;
                case SEARCH_TYPE_VACANCY:
                    $this->template->content = new View('search/vacancy');
                    $this->template->title = 'Результат поиска по вакансиям';
                    $SQL = "select * from vacancy where (responsibilities like '%" . mysql_escape_string($data['title']). "%' OR title like '%" . mysql_escape_string($data['title']). "%' OR requirements like '%" . mysql_escape_string($data['title']). "%' OR conditions like '%" . mysql_escape_string($data['title']). "%' ) AND firm_id = " . $this->firmID;
                    break;
                case SEARCH_TYPE_COMMENTS:
                    $this->template->content = new View('search/comment');
                    $this->template->title = 'Результат поиска по комментариям';
                    $SQL = "select * from comment_items where (content like '%" . mysql_escape_string($data['title']). "%') AND firm_id = " . $this->firmID;
                       
                    break;
                default:
                    $this->error = 'При поиске так же надо укзать где именно искать.';
            }

            if($SQL && empty($this->error)){

                $this->template->content->items = $this->db->query($SQL);

                if(!count($this->template->content->items)){
                    $this->info = "К сожалению по вашему запросу ничего не найдено.";
                }


                $this->template->content->search = $data['title'];
                $this->template->content->searchType = $data['type'];

            }
 
        }


        if(!$SQL || !empty($this->error)){

            $currentDate = "'".date('Y-m-d H:i:s', strtotime("-24 hour"))."'";

            $sortBy = 'desc';

            $this->template->content = new View('dashboard');
            $this->template->title = 'Новые заказы';

            $page_limit = ELEMENTS_ON_PAGE;

            $table = 'order';
            $where = '1=1 and order.firm_id = ' . $this->firmID . " and order.date > " . $currentDate;

            $this->template->content->items = $this->db->
                    select($table.'.*, pay_type.title as payment, delivery.title as devivery')->from($table)->
                    join("pay_type", 'pay_type.pay_id', 'order.payment', 'left')->
                    join("delivery", 'delivery.del_id', 'order.devivery', 'left')->
                    where($where)->limit($page_limit)->orderby('id', $sortBy)->get();
            
            $page_limit = ELEMENTS_ON_PAGE;

            $table = 'feedback';
            $where = '1=1 and firm_id = ' . $this->firmID . " and fb_date > " . $currentDate;

            $this->template->content->feedbacks = $this->db->select('*')->from($table)->
                    where($where)->limit($page_limit)->orderby('fb_date', $sortBy)->get();


            $table = 'comment_items';
            $where = '1=1 and firm_id = ' . $this->firmID . " and createDate > " . $currentDate;

            $this->template->content->comments = $this->db->select('*')->from($table)->
                    where($where)->limit($page_limit)->orderby('createDate', $sortBy)->get();


            $table = 'users_phone';
            $where = '1=1 and firm_id = ' . $this->firmID . " and date > " . $currentDate;
 
            $this->template->content->phones = $this->db->select('*')->from($table)->
                    where($where)->limit($page_limit)->orderby('date', $sortBy)->get();
            
        }

    }

} // End Welcome Controller