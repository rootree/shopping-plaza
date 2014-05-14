<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Обратная связь клиента с администрацией магазина
 *
 * @package    Core
 * @author     Ivan Chura
 * @copyright  (c) 2010-2013 Ivan Chura
 * @license    http://shopping-plaza.ru/license.html
 */

class Feedback_Controller extends Web_Controller
{

    // Do not allow to run in production
    const ALLOW_PRODUCTION = false;


    public function __construct()
    {

        parent::__construct();
        //require Kohana::find_file('vendor', 'Mailer');

    }

    /**
     * Displays a list of available examples
     */
    function index()
    {
        // In Kohana, all views are loaded and treated as objects.
        $this->template->content = new ViewMod('feedback');
        $this->selected_page     = 'feedback';
        ;
        $this->template->content->input_error = false;

        if (array_key_exists('sended', $_REQUEST)) {
            $this->template->content->sended = true;
        } else {
            $this->template->content->sended = false;
        }

        // You can assign anything variable to a view by using standard OOP
        // methods. In my welcome view, the $title variable will be assigned
        // the value I give it here.
        $this->template->title = Kohana::lang('feedback.main_title');
        ;

        // An array of links to display. Assiging variables to views is completely
        // asyncronous. Variables can be set in any order, and can be any type
        // of data, including objects.

        if ($_POST) {

            $data['fb_title']    = trim($_POST['title']);
            $data['fb_questing'] = trim($_POST['msg']);
            $data['fb_name']     = trim($_POST['name']);
            $data['fb_email']    = trim($_POST['mail']);
            $data['fb_date']     = date('Y-m-d H:i:s');
            $data['fb_ip']       = $this->input->ip_address();
            $data['status']      = 1;
            $data['firm_id']     = $this->firmID;

            if (!(valid::email($data['fb_email']) && !empty($data['fb_questing']) &&
                !empty($data['fb_name']) && !empty($data['fb_title']))
            ) {
                $this->template->content->input_error = true;
                return;
                ;
            }

            $db = new Database;

            $status = $db->insert('feedback', $data);

            // count how many rows were inserted
            $rows = count($status);

            if ($rows > 0) {

                cookie::set('name', $data['fb_name']);
                cookie::set('mail', $data['fb_email']);

                $this->db->query("update firms set new_feedback = new_feedback + 1 where id = " . $this->firmID);

                $con = new stdClass();

                $con->questing = $data['fb_questing'];
                $con->mail     = $data['fb_email'];
                $con->user     = $data['fb_name'];
                $con->title    = $data['fb_title'];

                if ($this->firm->sms_settings & SMS_ON_AMDIN_NEW_FEEDBACK) {
                    SMSer::send($this->firm->sms_number,
                        'Пришло новое сообщение от пользователя',
                        $this->firm->sms_title);
                }

                Mailer::feedbackSP($data['fb_email'], $data['fb_name'], $con);

                header('Location: /feedback/?sended#feedBackForm');
            }
        }
    }

}

?>