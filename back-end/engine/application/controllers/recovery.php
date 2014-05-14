<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Восстановление забытого пароля
 */
class Recovery_Controller extends Web_Controller {

    public $template = 'public/template';

    public function __construct() {
        
        parent::__construct();
 
        $this->accessRules = array(
            'index' => ACCESS_GUEST,
        );

    }
 
    public function index() {
        
        $this->template->content = new View('recovery/index');
 
        $this->template->title = 'Восстановление забытого пароля';

        $this->selected_page = PAGE_REG;

        if(!$this->haveAccess()){
            return;
        };
 
        if ($_POST){

            $data['title'] = ($_POST['firms']['title']);
            $data['domain'] = ($_POST['firms']['domain']);

            $dataUser['user_name'] = ($_POST['firms']['userName']);
            $dataUser['user_word'] = ($_POST['firms']['userPass']);
            $dataUser['user_mail'] = ($_POST['firms']['userMail']);

            if(!($data['title'])){
                $this->error .= 'Укажите новый уровень' . $this->NL();
            } 
            if(!($data['domain'])){
                $this->error .= 'Укажите опыт до получения нового уровня' . $this->NL();
            }

            if(!($dataUser['user_name'])){
                $this->error .= 'Укажите новый уровень' . $this->NL();
            } 
            if(!($dataUser['user_word'])){
                $this->error .= 'Укажите опыт до получения нового уровня' . $this->NL();
            }
            if(!($dataUser['user_mail'])){
                $this->error .= 'Укажите опыт до получения нового уровня' . $this->NL();
            }
            if(!valid::email($dataUser['user_mail'])){
                $this->error .= '!!!Укажите опыт до получения нового уровня' . $this->NL();
            }

 
            $table = "firms";
            $where = "domain = '" . $data['domain'] . "'";
            $item = $this->db->select('id')->from($table)->where($where)->get();
            if(isset($item[0])){
                $this->error .= '12121Укажите новый уровень' . $this->NL();
            }
            
            $table = "moders";
            $where = "user_mail = '" . $dataUser['user_mail'] . "'";
            $item = $this->db->select('user_id')->from($table)->where($where)->get();
            if(isset($item[0])){
                $this->error .= 'user_id  Укажите новый уровень' . $this->NL();
            }

 
            if(is_null($this->error)){

                $status = $this->db->insert('firms', $data);

                if(count($status)){ 

                    $dataUser['user_word'] = MD5($dataUser['user_word'] . WORD_SOLT);
                    $dataUser['user_right'] = ACCESS_ADMIN;
                    $dataUser['firm_id'] = $status->insert_id();

                    $status = $this->db->insert('moders', $dataUser);
                    if(count($status)){

                        $this->session->set("access", ACCESS_ADMIN);
                        $this->session->set("moderId", $status->insert_id());
                        $this->session->set("firmId", $dataUser['firm_id']);

                        url::redirect(url::site() . "welcome/index?new" );
                        exit();
                    }
                     
                }else{
                    $this->error .= 'Укажите опыт до получения нового уровня' . $this->NL();
                }  
            }
        } 
    }
  
} // End Welcome Controller