<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Блок статей
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Pages_Controller extends Web_Controller
{


    public function index()
    {

        $this->template->content = new ViewMod('pages/info');

        $title = ($this->uri->segment('title'));

        $id = intval($this->uri->segment('id'));

        if (empty($title) && empty($id)) {
            url::redirect(url::site());
        }

        if (empty($title)) {
            $where = "page_id = " . ($id) . " and firm_id = " . $this->firmID;
        } else {
            $where = "url_link = '" . mysql_escape_string($title) . "' and firm_id = " . $this->firmID;
        }

        $table = "pages";

        $this->template->content->item = $this->db->select('*')->from($table)->
            where($where)->get();

        if ((!$this->template->content->item->count())) {
            url::redirect(url::site());
        }

        $this->template->content->item = $this->template->content->item[0];

        if (!$this->template->content->item) {
            Event::run('system.404');
            exit();
        }

        $this->template->title = $this->template->content->item->title;

        $this->selected_page = $this->template->content->item->page_id;

        $this->commentsEnabled = ($this->firm->comment_settings & COMMENT_ON_ARTICLE);
        if ($this->commentsEnabled) {

            $where = 'coment_type = ' . COMMENT_ON_ARTICLE . ' and item_id = ' . $this->template->content->item->page_id .
                ' and  firm_id = ' . $this->firmID . ' and status in ( ' . COMMENT_STATUS_NEW . ',' . COMMENT_STATUS_VIEWED . ',' . COMMENT_STATUS_ANSWERED . ',' . COMMENT_STATUS_ANSWER . ')';

            $this->template->content->comments = $this->db->select('*')->from('comment_items')->
                where($where)->orderby('coment_id', 'asc')->get();

        }

    }

} 