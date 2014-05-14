<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Логин клиен, в свой личный кабинет, для просмотра истории заказов
 */
class Login_Controller extends Web_Controller
{

    public function index()
    {

        $this->error = null;

        if ($_POST) {

            $data['user_mail'] = trim($_POST['singin']['mail']);
            $data['user_word'] = md5(trim($_POST['singin']['word']) . WORD_SOLT_CLIENT);

            $SQLResult = $this->db->select('*')->from('shop_users')->
                where($data)->get();

            if ($SQLResult->count()) {

                $moder = $SQLResult->current();

                $this->session->set("userId", $moder->user_id);
                $this->session->set("userName", $moder->user_name);
                $this->session->set("userMail", $moder->user_mail);

                url::redirect("dashboard");

                return;

            } else {

                $this->error .= "Указаны ошибочные данные" . $this->NL();
            }

        }

        $this->template->content = new ViewMod('login');
        $this->template->title   = 'Авторизация';

    }

    public function out()
    {

        $this->session->set("userId", null);
        $this->session->set("userName", null);
        $this->session->set("userMail", null);

        url::redirect("");
        exit();

    }

} // End Welcome Controller