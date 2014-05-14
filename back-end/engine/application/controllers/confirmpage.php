<?php defined('SYSPATH') OR die('No direct access allowed.');

class Confirmpage_Controller extends Web_Controller {

    public $template = 'public/template';

    public function __construct() {
        
        parent::__construct();
 
        $this->accessRules = array(
            'index' => ACCESS_GUEST,
        );

    }
 
    public function index() {
        
        $this->template->content = new View('confirmpage/index');
 
        $this->template->title = 'Подтверждение электронного адреса';

        $this->template->content->confirmed = 0;

        $this->selected_page = null;

        if(!$this->haveAccess()){
            return;
        };

        $confirmCode = @$_REQUEST['confirm_code'];
        $firmID = @$_REQUEST['firmID'];

        if ($_POST){ 
            if(empty($confirmCode)){
                $this->error .= 'Нужно указать код' . $this->NL();
            }
    /*        if(empty($firmID)){
                $this->error .= 'Нужно указать номер фирмы' . $this->NL();
            }*/
        }

        if(!empty($confirmCode)){

            
            $table = "moders";
            $where = "confirmed_code = '" . mysql_escape_string($confirmCode) . "' and firm_id = " . $firmID.
                     " and confirmed_code != '0'" ;
          /*  $where = array(
                'confirmed_code' => $confirmCode,
                'firm_id' => $firmID 
            );*/
            $user = $this->db->select('*')->from($table)->
                    where($where)->get();

            if(isset($user[0])){
                $user = $user[0];
 
                $this->session->set("access", $user->user_right);
                $this->session->set("moderId", $user->user_id);
                $this->session->set("firmId", $user->firm_id);

                url::redirect("dashboard/index/confirmed/" . $user->confirmed);

            }else{
                $this->error .= 'Ничего подобного не найдено' . $this->NL();
            }
        }
    }
  
} // End Welcome Controller