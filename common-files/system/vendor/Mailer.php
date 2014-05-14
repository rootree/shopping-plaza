<?php


class Mailer{

    static public function orderToAdmin($order_id, $content, $deliveryInfo){

        if($GLOBALS['runningOn'] == '1') return;

        $session = new Session();
        $firm = $session->get("firm");

        // Отправка администратору сайта
        //
        $subject =  '[Shopping-Plaza] Заказ #'.$order_id;
        $subject =  '[' . $firm->title . '] Заказ #'.$order_id;

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, MAIL_TITLE);

        $messageTemplate = new View('mail/shopping-plaza');

        $body = new View('mail/order_SP');
        $body->content = $content;
        $body->deliveryInfo = $deliveryInfo;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();


        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($firm->mailo , $firm->title);
 
        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();
 
    }
    
    
    static public function orderToUser($toMail, $toUser, $order_id, $content){
if($GLOBALS['runningOn'] == '1') return;
        $session = new Session();
        $firm = $session->get("firm");
 
        // Отправка клиенту магазина
        //
        $subject =  'Заказ #'.$order_id;
 
        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, $firm->title);

        $replyTo =  new Swift_Address($firm->mailo, $firm->title);


        $messageTemplate = new View('mail/clients');

        $body = new View('mail/order_for_user');
        $body->content = $content;
        $body->firm = $firm;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();
 
        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($toMail , $toUser);
 
        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->setReplyTo($replyTo);
        $message->headers->set("Content-Type", "text/html");

        if($content->basePayWay == FIELD_TYPE_BANK_FIZ_LICO){

            // Надо приатачить квитанцию
  
            $forBank = new View('mail/for_bank');
            $forBank->content = $content;

            $message->attach(new Swift_Message_Part($message_body, "text/html"));
            $message->attach(new Swift_Message_Attachment(
                $forBank->render(), "Bill_For_Order_" . $order_id . ".html", "text/html")
            );

        }


        // Build the HTML message 
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();


 
        // Отправка администратору сайта
        //
        $subject =  '[Shopping-Plaza] Заказ #'.$order_id . ' (указана дополнительная информация)';
        $subject =  '[' . $firm->title . '] Заказ #'.$order_id. ' (указана дополнительная информация)';

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, MAIL_TITLE);

        $messageTemplate = new View('mail/shopping-plaza');

        $body = new View('mail/order_SP');
        $body->content = $content;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();


        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($firm->mailo , $firm->title);
 
        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();
 
    }

    static public function feedbackSP($toMail, $toUser, $content){
if($GLOBALS['runningOn'] == '1') return;
        $session = new Session();
        $firm = $session->get("firm");
  
        $subject =  '[' . $firm->title  . '] ' . $content->title ;

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, MAIL_TITLE);

        $messageTemplate = new View('mail/shopping-plaza');
 
        $body = new View('mail/feedback');
        $body->content = $content;
        $body->firm = $firm;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();


        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($firm->mailo , $firm->title);

        $message = new Swift_Message($subject, $message_body, "text/html");
 
        $replyTo =  new Swift_Address($content->mail, $content->user);
        $message->setReplyTo($replyTo);


        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();

        return $res;

    }


    static public function feedbackResponce($data, $isForComment = false){
  if($GLOBALS['runningOn'] == '1') return;
        $session = new Session();

        $firm = $session->get("firm");
        $user = $session->get("user");

        // Отправка клиенту магазина
        //
        $subject =  'RE: ' . $data['fb_title'] . ' ';

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, $firm->title);

        $replyTo =  new Swift_Address($firm->mailo, $firm->title);


        $messageTemplate = new View('mail/clients');

        $body = new View($isForComment ? 'mail/send_comment' : 'mail/send_feedback');

        $body->content = $data;
        $body->firm = $firm;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;
        $messageTemplate->user = $user;

        $message_body = $messageTemplate->render();

        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($data['fb_email'] , $data['fb_name']);

        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->setReplyTo($replyTo);
        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        ($swift->send($message, $recipients, $from));

        $swift->disconnect();
 
    }

     


    static public function orderSent($email, $name, $orderID){

        if($GLOBALS['runningOn'] == '1') return;
        
        $session = new Session();

        $firm = $session->get("firm");
        $user = $session->get("user");

        // Отправка клиенту магазина
        //
        $subject =  'Заказ №' . $orderID . ' отправлен';

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, $firm->title);

        $replyTo =  new Swift_Address($firm->mailo, $firm->title);


        $messageTemplate = new View('mail/clients');

        $body = new View('mail/order_sent');

        $body->content = array(
           'name' => $name,
           'orderID' => $orderID,
           'firmName' => $firm->title
        );
        $body->firm = $firm;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;
        $messageTemplate->user = $user;

        $message_body = $messageTemplate->render();

        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($email, $name);

        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->setReplyTo($replyTo);
        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        ($swift->send($message, $recipients, $from));

        $swift->disconnect();

    }

    static public function changeMail($toMail, $toUser, $subject, $content){
if($GLOBALS['runningOn'] == '1') return;
        $session = new Session();
        $firm = $session->get("firm");
        $user = $session->get("user");

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address($firm->mailo, $firm->title);

        $message = new View('mail/change_mail');
        
        $message->content = $content;
        $message->firm = $firm;
        $message->user = $user;
        
        $message_body = $message->render();

        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($toMail , $toUser);

        $message = new Swift_Message($subject, null, "text/html");

        $message->attach(new Swift_Message_Part($message_body));

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();

        return $res;

    }

    static public function addUser($toMail, $toUser, $content){
if($GLOBALS['runningOn'] == '1') return;
        $session = new Session();
        $firm = $session->get("firm");
        $user = $session->get("user");


        // Отправка клиенту магазина
        //
        $subject =  'Добро пожаловать в наш Интернет-магазине';

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, $firm->title);

        $replyTo =  new Swift_Address($firm->mailo, $firm->title);


        $messageTemplate = new View('mail/clients');

        $body = new View('mail/new_client');
        $body->content = $content;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();

        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($toMail , $toUser);

        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->setReplyTo($replyTo);
        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();

    }

    static public function regOnSP($toMail, $toUser, $hash, $domain, $title, $onwDomain = false){
if($GLOBALS['runningOn'] == '1') return;

        $firm = new stdClass();
        $user = new stdClass();

        $firm->domain = $domain;
        $firm->title = $title;

        $user->user_mail = $toMail;
        $user->user_name = $toUser;

        // Отправка администратору сайта
        //
        $subject =  'Завершение регистрации';

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, MAIL_TITLE);

        $messageTemplate = new View('mail/shopping-plaza');

        $body = new View('mail/SP_reg');

        $body->content = new stdClass();

        $body->content->user = $user;
        $body->content->hash = $hash;
        $body->content->firm = $firm;
        $body->content->onwDomain = $onwDomain;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();

        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($toMail , $toUser);

        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();

    }


    
    static public function addUserToSP($content){
if($GLOBALS['runningOn'] == '1') return;
        $session = new Session();
        $firm = $session->get("firm");
        $user = $session->get("user");
 
        // Отправка администратору сайта
        //
        $subject =  'Присоединение к Интернет-магазину '  . html::specialchars($firm->title);

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, MAIL_TITLE);

        $messageTemplate = new View('mail/shopping-plaza');

        $body = new View('mail/SP_add_admin');

        $body->content = new stdClass();

        $body->content->user = $content->userName;
        $body->content->mail = $content->userMail;
        $body->content->hash = $content->confirmed_code;
        $body->content->firm = $firm;
        $body->content->currentAdmin = $user;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();

        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($content->userMail, $content->userName);

        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();

    }



    static public function changeMailToSP($content){

        if($GLOBALS['runningOn'] == '1') return;

        $session = new Session();
        $firm = $session->get("firm");
        $user = $session->get("user");
//print_r($user); exit();
        // Отправка администратору сайта
        //
        $subject =  'Смена электронного адреса в Интернет-магазине '  . html::specialchars($firm->title);

        $swift = email::connect();

        // From, subject and HTML message
        $from =  new Swift_Address(MAIL_ROBOT, MAIL_TITLE);

        $messageTemplate = new View('mail/shopping-plaza');

        $body = new View('mail/SP_change_mail');

        $body->content = new stdClass();

        $body->content->himSelf = ($user->user_id == $content->userID);
        $body->content->user = $content->userName;
        $body->content->mail = $content->userMail;
        $body->content->hash = $content->confirmed_code;
        $body->content->firm = $firm;
        $body->content->currentAdmin = $user;

        $messageTemplate->content = $body;
        $messageTemplate->title = $subject;
        $messageTemplate->firm = $firm;

        $message_body = $messageTemplate->render();

        // Build recipient lists
        $recipients = new Swift_RecipientList;

        $recipients->addTo($content->userMail, $content->userName);

        $message = new Swift_Message($subject, $message_body, "text/html");

        $message->headers->set("Content-Type", "text/html");

        // Build the HTML message
        $res = ($swift->send($message, $recipients, $from));

        $swift->disconnect();

    }

}

?>