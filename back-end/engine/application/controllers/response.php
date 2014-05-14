<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Обратная связь для администратора интернет-магазина
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Response_Controller extends Web_Controller {

    const SUBPAGE_MAIN = 'main';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER, 
        );

        $this->selected_page   = PAGE_RESPONSE;
		
        if(array_key_exists('send', $_REQUEST)){
            $this->info = 'Ваше сообщение успешно отправлено администрации сервиса. Спосибо за проявленный интерес к нашей работе.';
        }
    }

 
    public function index() {

        $this->template->content = new View('response/index');

        $this->template->title = 'Обратная связь';
        $this->selected_subpage = Response_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $data['annonce'] = @trim($_POST['response']['annonce']);
            $data['typer'] = @intval($_POST['response']['typer']);

            $data['firm_id'] = $this->firmID;
            $data['moderId'] = $this->moderId;
            $data['date'] = date("Y.m.d H:i:s");
            $data['status'] = date("Y.m.d H:i:s"); // TODO

            if(!($data['typer'])){
                $this->errorFields[] = "Тема";
            }
            if(empty($data['annonce'])){
                $this->errorFields[] = "Текст сообщение";
            }
 
            if(is_null($this->error) && !count($this->errorFields)){

                $status = $this->db->insert('responce', $data);

                if(count($status)){

                    require Kohana::find_file('vendor', 'SMSer');
                    SMSer::send('79057374040',
                        'В Shopping-Plaza новый вопрос от пользователей.' ,
                        'Shopping');

                    // Отправка администратору Shopping-Plaza
                    //
                    $subject =  'Shopping-Plaza с обратной связью №' . $data['typer'];

                    $swift = email::connect();

                    // From, subject and HTML message
                    $from =  new Swift_Address(MAIL_ROBOT, MAIL_TITLE);

                    $messageTemplate = new View('mail/shopping-plaza');

                    $body = new View('mail/respons_to_sp');

                    $body->content = $data['annonce'];

                    $messageTemplate->content = $body;
                    $messageTemplate->title = $subject;
                    $messageTemplate->firm = $this->firm;

                    $message_body = $messageTemplate->render();


                    // Build recipient lists
                    $recipients = new Swift_RecipientList;

                    $recipients->addTo(MAIL_ADMIN , 'Властитель мира');

                    $message = new Swift_Message($subject, $message_body, "text/html");

                    $message->headers->set("Content-Type", "text/html");

                    // Build the HTML message
                    $swift->send($message, $recipients, $from);

                    $swift->disconnect();

					url::redirect(url::site() . "response?send" );
                    
                }else{
					$this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
				}
				
			}else{
                
                if($this->error == null){
                    $this->error = $this->completeErrorFieldsMessage('Сообщение не отправлено. ');
                } 
			}
        }
    }
 
} 