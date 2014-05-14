<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Настройки клиента (пароль, почта)
 */
class Settings_Controller extends Web_Controller
{

    public function index()
    {

        $this->template->content              = new View('settings');
        $this->template->title                = 'Настройки';
        $this->template->content->input_error = false;
        $this->error                          = null;

        if (array_key_exists('repeat', $_GET) && $this->userMailNew) {
            $forUpdate['confirmed_code'] = 'aaa';
            $forUpdate['confirmed']      = 3;
        }

        if ($_POST) {

            $forUpdate = array();

            if (array_key_exists('pass', $_GET)) {

                $dataUser['old']    = ($_POST['firms']['old']);
                $dataUser['pass']   = ($_POST['firms']['pass']);
                $dataUser['repass'] = ($_POST['firms']['repass']);

                if (!($dataUser['old']) || !($dataUser['pass']) || !($dataUser['repass'])) {
                    $this->error .= 'Заполните все поля' . $this->NL();
                }

                if (empty($this->error) && $dataUser['pass'] != $dataUser['repass']) {
                    $this->error .= 'Пароль и подтверждение не совпадают' . $this->NL();
                }

                if (empty($this->error)) {

                    $table = "shop_users";
                    $where = "user_word = '" . MD5($dataUser['old'] . WORD_SOLT_CLIENT) . "'";
                    $item  = $this->db->select('user_id')->from($table)->where($where)->get();
                    if (!isset($item[0])) {
                        $this->error .= 'Старый пароль некорректен' . $this->NL();
                    }
                }

                $forUpdate['user_word'] = MD5($dataUser['pass'] . WORD_SOLT_CLIENT);
            }

            if (array_key_exists('mail', $_GET)) {
                $dataUser['user_mail'] = ($_POST['firms']['userMail']);

                if (!($dataUser['user_mail'])) {
                    $this->error .= 'Заполните поле электронной почты' . $this->NL();
                }

                if (empty($this->error) && $dataUser['user_mail'] == $this->userMail) {
                    $this->error .= 'Новый адрес и текущий совпадают' . $this->NL();
                }

                if (empty($this->error) && !valid::email($dataUser['user_mail'])) {
                    $this->error .= 'Указан несуществующий адрес' . $this->NL();
                }

                if (empty($this->error)) {

                    $table = "shop_users";
                    $where = "user_mail = '" . $dataUser['user_mail'] . "'";
                    $item  = $this->db->select('user_id')->from($table)->where($where)->get();
                    if (isset($item[0])) {
                        $this->error .= 'Указанный адрес принадлежит другому пользователю' . $this->NL();
                    }
                }

                $forUpdate['user_mail_new']  = $dataUser['user_mail'];
                $forUpdate['confirmed_code'] = 'aaa';
                $forUpdate['confirmed']      = 3;


            }

            if (array_key_exists('name', $_GET)) {

                $dataUser['user_name'] = ($_POST['firms']['userName']);

                if (!($dataUser['user_name'])) {
                    $this->error .= 'Укажите как вы хотети быть представлены в магазине' . $this->NL();
                }

                if (empty($this->error) && $dataUser['user_name'] == $this->userName) {
                    $this->error .= 'Новое имя и текущее совпадают' . $this->NL();
                }

                $forUpdate['user_name'] = $dataUser['user_name'];

            }

            if (is_null($this->error)) {

                $status = $this->db->update('shop_users', $forUpdate, array('user_id' => $this->userId, 'firm_id' => $this->firmID));

                if (count($status)) {

                    if (array_key_exists('name', $_GET)) {
                        $this->session->set("userName", $dataUser['user_name']);
                    }

                    if (array_key_exists('mail', $_GET)) {
                        $this->userMailNew = $forUpdate['user_mail_new'];
                        $this->session->set("userMailNew", $this->userMailNew);
                    }

                    if (array_key_exists('mail', $_GET)) {
                        url::redirect(url::site() . "settings/?updatedMail");
                    } else {
                        url::redirect(url::site() . "settings/?updated");
                    }

                    exit();
                }
            }
        }
    }

} // End Welcome Controller