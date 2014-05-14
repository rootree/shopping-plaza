<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Авторизация в панель управлением магазина
 */
class Login_Controller extends Web_Controller {

    // public $template = 'public/template';

    public function __construct() {

        parent::__construct();
        $this->accessRules = array(
            'index' =>  ACCESS_GUEST,
            'logout' =>  ACCESS_GUEST
        );

    }

    public function index() {
 
        if($this->access != ACCESS_GUEST){
            url::redirect("dashboard/index");
            exit();
        }
        
        $this->selected_page = PAGE_LOGIN;
 

        if($_POST){

            $data['user_mail'] = trim($_POST['singin']['mail']);
            $data['user_word'] = md5(trim($_POST['singin']['word']) . WORD_SOLT);

            $SQLResult = $this->db->select('*')->from('moders')->
                    where($data)->get();

            if($SQLResult->count()){

                $moder = $SQLResult->current();

                $this->session->set("access", $moder->user_right);
                $this->session->set("moderId", $moder->user_id);
                $this->session->set("firmId", $moder->firm_id);

                $this->db->update('moders', array('last_login' => date('Y-m-d H:i:s')), array('user_id' => $moder->user_id));
            
                url::redirect("dashboard/index");

                return;

            }else{

                $this->error .= "Указаны ошибочные данные" . $this->NL();
            }

        }

        $this->template->content = new View('public/login');
        $this->template->title = 'Авторизация';

    }

    public function logout() {

        $this->session->set("access", ACCESS_GUEST);

        $this->session->set("access", null);
        $this->session->set("moderId", null);
        $this->session->set("firmId", null);

        $this->session->set("firm", null);
        $this->session->set("user", null);
       // $this->session->delete("lastRedirected" );
        $this->session->set("lastRedirected", 0);
        //$this->session->destroy();

        url::redirect("/login/");
        exit();

    }
    public function demo() {

        $this->session->set("access", ACCESS_ADMIN);
        $this->session->set("moderId", DEMO_SHOP_MODER);
        $this->session->set("firmId", DEMO_SHOP);

        url::redirect("dashboard/index");
        
        exit();

    }

} // End Welcome Controller