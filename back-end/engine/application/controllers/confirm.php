<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Подтверждение регистрации на shopping-plaza
 */
class Confirm_Controller extends Web_Controller {

    public $template = 'public/template';

    public function __construct() {
        
        parent::__construct();
 
        $this->template = new View('public/template');

    }
 
    public function index() {


        $this->template->content = new View('public/confirm');
 
        $this->template->title = 'Активация аккаунта';

        $this->selected_page = PAGE_REG;
 
        $this->template->content->code = $this->uri->segment('code');

        if ($_POST){

            $code = trim($_POST['code']);


            if(empty($code)){
                $this->error .= 'Код активации пуст, если вы хотите активировать свой аккаунт, укажите полученный в письме код активации.' . $this->NL();
            }
 

            if(is_null($this->error)){
                $table = "moders";
                $where = "confirmed_code = '" . mysql_escape_string($code) . "'";
                $item = $this->db->select('*')->from($table)->where($where)->get();
                if(empty($item[0])){

                    $this->error .= 'К сожалению, указанный вами код активации не найден.' . $this->NL();
                    
                }else{
                    $user = $item[0];
                    
                    if($user->confirmed == CONFIRM_DONE){
                        
                        $this->error .= 'Указанный код активации уже был использован, ваш аккаунт уже активирован.' . $this->NL();

                    }else{

                        $forChange = array('confirmed' => CONFIRM_DONE);

                        if($user->confirmed == CONFIRM_NEW_MAIL){
                            $forChange['user_mail'] = $user->user_mail_new;
                            $forChange['user_mail_new'] = '';
                        }

                        $status = $this->db->update('moders', $forChange, array('confirmed_code' => $code));
                        if(count($status)){

                            $this->session->set("firm", null);
                            $this->session->set("user", null);

                            $this->session->set("access", $user->user_right);
                            $this->session->set("moderId", $user->user_id);
                            $this->session->set("firmId", $user->firm_id);

                            url::redirect(url::site() . "dashboard/index/confirmed/" . CONFIRM_MAIL );
                            exit();
                            
                        } 
                    }
                }
            }
        } 
    }
  
} // End Welcome Controller

 