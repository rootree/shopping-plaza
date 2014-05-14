<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Регистрация в shopping-plaza
 */
class Reg_Controller extends Web_Controller {

    public $template = 'public/template';

    public function __construct() {
        
        parent::__construct();
 
        $this->accessRules = array(
            'index' => ACCESS_GUEST,
        );

    }
 
    public function index() {


        $this->template->content = new View('reg/index');
 
        $this->template->title = 'Создание Интернет-магазина';

        $this->selected_page = PAGE_REG;

        if(!$this->haveAccess()){
            return;
        };

        $plan = $this->uri->segment('plan');
        if(empty($plan)){
            url::redirect(url::site() . "prise" );
        }
        
        $this->template->content->plan = $plan;


        if ($_POST){

            $data['title'] = trim($_POST['firms']['title']);
            $data['showfirstpro'] = MAINPAGE_PRICE_NEW;
            $data['mail'] = trim($_POST['firms']['userMail']);

            $_POST['firms']['domain'] = $data['domain'] = strtolower(trim($_POST['firms']['domain']));

            if(empty($data['domain'])){
                $domain_own = $data['domain'] = trim($_POST['firms']['domain_own']);
                $domain_own = $data['domain'] = $domain_own. '.shopping-plaza.ru';
            }
             
            $dataUser['user_name'] = trim($_POST['firms']['userName']);
            $dataUser['user_word'] = trim($_POST['firms']['userPass']);
            $passwordConfirmation = trim($_POST['firms']['password_confirmation']);
            $dataUser['user_mail'] = trim($_POST['firms']['userMail']);

            if(!($data['title'])){
                $this->error .= '- Укажите пожалуйста название вашего будущего Интернет-магазина' . $this->NL();
            }
            if(!($data['domain'])){
                $this->error .= '- Домен для Интернет-магазина не выбран, сделайте это пожалуйста' . $this->NL();
            }else{

                if(!empty($domain_own)){

                    if(!is_valid_domain_name($domain_own)){
                        $this->error .=  '- Указанный собственный домен имеет не правильный формат. Пример правлильного заполнения: www.domain.ru' . $this->NL();
                    }

                }else{

                    if(!valid::alpha_dash($data['domain'])){
                        $this->error .= '- Указанный домен содержит недопустимые символы. Допустимыми символами считаються латинские буквы, цифры и тире' . $this->NL();
                    }else{

                        if(strlen($data['domain']) < 3){
                            $this->error .= '- Выбранный вами домен состоит меньше чем из 4-х символов, придумайте более длинное название для домена' . $this->NL();
                        }
 
                    }
                }
            }

            if(!($dataUser['user_name'])){
                $this->error .= '- Вы не указали как вас зовут' . $this->NL();
            }
            if(!($dataUser['user_word'])){
                $this->error .= '- Пароль не был указан' . $this->NL();
            }else{

                if(strlen($dataUser['user_word']) < 6){
                    $this->error .= '- Вы указали слишком простой пароль, придумайте пароль от шести символов' . $this->NL();
                }

            }
            if(!($dataUser['user_mail'])){
                $this->error .= '- Укажите ваш адрес электронной почты' . $this->NL();
            }
            if(!valid::email($dataUser['user_mail'])){
                $this->error .= '- Вы указали не существующий адрес электронной почты' . $this->NL();
            }

            if($passwordConfirmation != $dataUser['user_word']){
                $this->error .= '- Указанный пароль и его подтверждение не совпадают, убедитесь что вы правильно ввели пароль и подтвердите его в соответствующие поле' . $this->NL();
            }

            if(is_null($this->error)){
                $table = "firms";
                $where = "domain = '" . mysql_escape_string($data['domain']) . "'";
                $item = $this->db->select('id')->from($table)->where($where)->get();
                if(!empty($item[0])){
                    $this->error .= '- К сожалению, выбранный вами домен уже занят, укажите другой домен для вашего магазина' . $this->NL();
                }
            }

            if(is_null($this->error)){ 
                $table = "moders";
                $where = "user_mail = '" . mysql_escape_string($dataUser['user_mail']) . "'";
                $item = $this->db->select('user_id')->from($table)->where($where)->get();
                if(!empty($item[0])){
                    $this->error .= '- Указанный электронный адрес уже используеться у нас, для регистрации нового магазина укажите другой адрес электронной почты' . $this->NL();
                }
            }


            if(is_null($this->error)){

                if(empty($domain_own)){
                    $data['domain'] = $data['domain'].'.shopping-plaza.ru';
                }

                $data['domain'] = strtolower($data['domain']);
                $data['template'] = 'template1';


                $prices = new stdClass();
                $prices->enabled = 0;
                $prices->visible = 0;
                $prices->list = array();
                $prices->list['price1'] = '';
                $prices->list['price2'] = '';
                $prices->list['price3'] = '';
                $prices->list['price4'] = '';
                $prices->list['price5'] = '';

                $data['prices'] = json_encode($prices);
                $data['createDate'] = date('Y-m-d');

                $status = $this->db->insert('firms', $data);

                if(count($status)){

                    $hash = MD5($status->insert_id() . $dataUser['user_word'] . WORD_SOLT_CLIENT);

                    $dataUser['user_word'] = MD5($dataUser['user_word'] . WORD_SOLT);
                    $dataUser['user_right'] = ACCESS_ADMIN;
                    $dataUser['firm_id'] = $status->insert_id();
                    $dataUser['confirmed'] = CONFIRM_NEW_USER;
                    $dataUser['confirmed_code'] = $hash;

                    $status = $this->db->insert('moders', $dataUser);
                    if(count($status)){

                        $this->session->set("access", ACCESS_ADMIN);
                        $this->session->set("moderId", $status->insert_id());
                        $this->session->set("firmId", $dataUser['firm_id']);
 
                        require Kohana::find_file('vendor', 'SMSer'); 
                        SMSer::send('79057374040',
                            'В Shopping-Plaza новый пользователь, приятно.' ,
                            'Shopping');

                        require Kohana::find_file('vendor', 'Mailer');
                        Mailer::regOnSP($dataUser['user_mail'] , $dataUser['user_name'], $hash, $data['domain'], $data['title'], !empty($domain_own));
 
                        url::redirect(url::site() . "settings/tutorial?ownDomain" );
                        exit();
                    }

                }else{
                    $this->error .= 'Произошла критическая ошибка в работе. Немедленно сообщите администрации сайта о случивщемся.' . $this->NL();
                }
            }
        } 
    }
  
} // End Welcome Controller


function is_valid_domain_name($domain_name)
{
    $pieces = explode(".",$domain_name);
    foreach($pieces as $piece)
    {
        if (!preg_match('/^[a-z\d][a-z\d-]{0,62}$/i', $piece)
            || preg_match('/-$/', $piece) )
        {
            return false;
        }
    }
    return true;
}