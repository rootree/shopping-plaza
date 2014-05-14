<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Регистрация клиента, для посмотра истории заказов
 */
class Reg_Controller extends Web_Controller
{

    public function index()
    {

        $this->template->title                = 'Регистрация';
        $this->template->content              = new View('reg/index');
        $this->template->content->input_error = false;
        $this->error                          = null;

        if ($_POST) {

            $dataUser['user_name'] = ($_POST['firms']['userName']);
            $dataUser['user_word'] = ($_POST['firms']['userPass']);
            $dataUser['user_mail'] = ($_POST['firms']['userMail']);

            if (!($dataUser['user_name'])) {
                $this->error .= 'Укажите ваше имя' . $this->NL();
            }
            if (!($dataUser['user_word'])) {
                $this->error .= 'Укажите пароль' . $this->NL();
            }
            if (!($dataUser['user_mail'])) {
                $this->error .= 'Укажите адрес электронной почты' . $this->NL();
            }

            if ($dataUser['user_mail'] && !valid::email($dataUser['user_mail'])) {
                $this->error .= 'Указан несуществующий адрес электронной почты' . $this->NL();
            }

            $table = "shop_users";
            $where = "user_mail = '" . $dataUser['user_mail'] . "'";
            $item  = $this->db->select('user_id')->from($table)->where($where)->get();
            if (isset($item[0])) {
                $this->error .= 'Клиент с указанным адресом электронной почты уже зарегестрирован в магазине' . $this->NL();
            }

            if (is_null($this->error)) {

                $dataUser['user_word'] = MD5($dataUser['user_word'] . WORD_SOLT_CLIENT);
                $dataUser['firm_id']   = $this->firmID;

                $status = $this->db->insert('shop_users', $dataUser);
                if (count($status)) {

                    $this->session->set("userId", $status->insert_id());
                    $this->session->set("userName", $dataUser['user_name']);
                    $this->session->set("userMail", $dataUser['user_mail']);


                    $con = new stdClass();

                    $con->userPass = $_POST['firms']['userPass'];
                    $con->mail     = $dataUser['user_mail'];
                    $con->user     = $dataUser['user_name'];


                    Mailer::addUser($con->mail, $con->user, $con);


                    url::redirect(url::site() . "dashboard/index?new");

                    exit();
                }
            }
        }
    }

} // End Welcome Controller