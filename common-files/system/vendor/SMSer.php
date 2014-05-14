<?php


class SMSer{

    static public function send($toNumber, $content, $senderName){

        require_once (SYSPATH . 'vendor/sms24x7.php');

        $email = "*******@******.com";
        $password = "******";

        $result = smsapi_push_msg_nologin($email, $password, $toNumber, $content, array("sender_name"=>format::do_latin($senderName)));
 var_dump($result);
        $code = (is_array($result)) ? $result[0] : 999;
 
        $db = new Database;

        $ss = (Input::instance()->post(Kohana::Config('session.name')) );
        $session = Session::instance(NULL, $ss);
        $firm = $session->get("firm");

        $data = array(
            'toNumber' => $toNumber,
            'content' => $content,
            'firm_id' => (!empty($firm->id)) ? $firm->id : 0,
            'code' => $code,
            'date' => date("Y.m.d H:i:s"),
        );

        $status = $db->insert('sms_history', $data);
        
    }

}

?>