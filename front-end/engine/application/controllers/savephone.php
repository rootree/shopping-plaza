<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Сохранение телефона клиента, для обратного звонка
 */
class Savephone_Controller extends Web_Controller
{

    // Do not allow to run in production

    const ALLOW_PRODUCTION = false;

    function index()
    {

        $phone = trim($this->uri->segment('phone'));

        if ($phone) {

            $data = array();

            $data['phone']   = $phone;
            $data['firm_id'] = $this->firmID;
            $data['date']    = date("Y-m-d H:i:s");
            $data['status']  = CALLBACK_STATUS_NEW;

            $this->db->insert('users_phone', $data);

            $this->session->set('phone', $phone);

            if ($this->firm->sms_settings & SMS_ON_AMDIN_NEW_CALLBACK) {
                SMSer::send($this->firm->sms_number,
                    'Оставлен номер для обратного звонка ' . substr($phone, 0, 20),
                    $this->firm->sms_title);
            }
        }

        echo('{responce:1}');
        exit();

    }

} //
