<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Коментирование
 *
 * @package    Core
 * @author     Ivan Chura
 * @copyright  (c) 2010-2013 Ivan Chura
 * @license    http://shopping-plaza.ru/license.html
 */

class Comment_Controller extends Web_Controller
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

        if ($_POST) {

            $table   = "blocked_users";
            $where   = "email = '" . mysql_escape_string($_POST['mail']) . "' OR (agent = '" . Kohana::user_agent() . '" and ip = "' . $this->input->ip_address() . "')";
            $comment = $this->db->select('id')->from($table)->where($where)->get();
            $comment = $comment[0];

            if (!empty($comment)) {

                cookie::set('userBlocked', '1');

                switch ($_POST['type']) {
                    case COMMENT_ON_ITEMS:
                        header('Location: /products/item/id/' . $_POST['id'] . "/?errorOnComment#commentForm");
                        exit();
                    case COMMENT_ON_NEWS:
                        header('Location: /news/index/item/' . $_POST['id'] . "/return_page/1/?errorOnComment#commentForm");
                        exit();
                    case COMMENT_ON_ARTICLE:
                        header('Location: /pages/index/id/' . $_POST['id'] . "/?errorOnComment#commentForm");
                        exit();
                }
            }

            $data['coment_type'] = trim($_POST['type']);
            $data['content']     = trim($_POST['msg']);
            $data['name']        = trim($_POST['name']);
            $data['mail']        = trim($_POST['mail']);
            $data['firm_id']     = $this->firmID;
            $data['item_id']     = trim($_POST['id']);
            $data['status']      = COMMENT_STATUS_NEW;
            $data['createDate']  = date('Y-m-d H:i:s');
            $data['agent']       = Kohana::user_agent();
            ;
            $data['ip'] = $this->input->ip_address();


            if (isset($data['name'])) cookie::set('name', $data['name']);
            if (isset($data['mail'])) cookie::set('mail', $data['mail']);


            if ($data['coment_type'] == 0 || $data['item_id'] == 0 || empty($data['content']) || empty($data['name'])
                || (empty($data['mail']) || (!valid::email($data['mail']) && $data['mail'] != 'system@shopping-plaza.ru'))
            ) {
                switch ($data['coment_type']) {
                    case COMMENT_ON_ITEMS:
                        header('Location: /products/item/id/' . $data['item_id'] . "/?errorOnComment#commentForm");
                        exit();
                    case COMMENT_ON_NEWS:
                        header('Location: /news/index/item/' . $data['item_id'] . "/return_page/1/?errorOnComment#commentForm");
                        exit();
                    case COMMENT_ON_ARTICLE:
                        header('Location: /pages/index/id/' . $data['item_id'] . "/?errorOnComment#commentForm");
                        exit();
                }
            }

            $db = new Database;

            $status = $db->insert('comment_items', $data);

            if ($this->firm->sms_settings & SMS_ON_AMDIN_COMMENT && $data['mail'] != 'system@shopping-plaza.ru') {
                SMSer::send($this->firm->sms_number,
                    'Поступил новый комментарий',
                    $this->firm->sms_title);
            }

            switch ($data['coment_type']) {
                case COMMENT_ON_ITEMS:
                    header('Location: /products/item/id/' . $data['item_id'] . "/#comment" . $status->insert_id());
                    exit();
                case COMMENT_ON_NEWS:
                    header('Location: /news/index/item/' . $data['item_id'] . "/return_page/1/#comment" . $status->insert_id());
                    exit();
                case COMMENT_ON_ARTICLE:
                    header('Location: /pages/index/id/' . $data['item_id'] . "/#comment" . $status->insert_id());
                    exit();
            }
        }

        header('Location: /');
    }

}

?>