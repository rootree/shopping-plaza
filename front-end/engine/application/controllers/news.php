<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Блок новостей
 */
class News_Controller extends Web_Controller
{

    // Do not allow to run in production

    const ALLOW_PRODUCTION = false;

    function index()
    {

        $table               = 'news';
        $this->selected_page = 'news';
        // In Kohana, all views are loaded and treated as objects.

        $news_item = $this->uri->segment('item');

        $list = true;

        if (!empty($news_item)) {

            $offset = $this->uri->segment('return_page');

            $query = $this->db->select('*')->from($table)->where('news_id = ' . $news_item)->get();

            if (count($query[0]) > 0) {
                $list = false;

                $this->template->content       = new View('news_item');
                $this->template->content->item = $query[0];

                $this->template->title = $this->template->content->item->title;
                $this->commentsEnabled = ($this->firm->comment_settings & COMMENT_ON_NEWS);

                if ($this->commentsEnabled) {

                    $where = 'coment_type = ' . COMMENT_ON_NEWS . ' and item_id = ' . $news_item .
                        ' and  firm_id = ' . $this->firmID . ' and status in ( ' . COMMENT_STATUS_NEW . ',' . COMMENT_STATUS_VIEWED . ',' . COMMENT_STATUS_ANSWERED . ',' . COMMENT_STATUS_ANSWER . ')';

                    $this->template->content->comments = $this->db->select('*')->from('comment_items')->
                        where($where)->orderby('coment_id', 'asc')->get();

                }
            }
        }

        if ($list) {

            $offset = $this->uri->segment('page');

            $this->template->content = new View('news');

            $this->template->title = 'Новости';

            $page_limit = 20;

            if ($offset < 1) {
                $offset = 1;
            }

            $query = $this->db->select('*')->from($table)->orderby('date', 'desc')
                ->where('firm_id = ' . $this->firmID)->limit($page_limit)->offset(($offset - 1) * $page_limit)->get();

            $this->template->content->items      = array();
            $this->template->content->pagination = '';

            if (count($query)) {

                foreach ($query as $item) {

                    $this->template->content->items[] = $item;

                }

                if (count($this->template->content->items) > 0) {
                    $this->template->content->result = true;
                }

                $base_url = 'news/index';

                $pagination = new Pagination(array(
                    // Base_url will default to the current URI
                    'base_url'       => $base_url,

                    // The URI segment (integer) in which the pagination number can be found
                    // The URI segment (string) that precedes the pagination number (aka "label")
                    'uri_segment'    => 'page',

                    // You could also use the query string for pagination instead of the URI segments
                    // Just set this to the $_GET key that contains the page number
                    // 'query_string'   => 'page',

                    // The total items to paginate through (probably need to use a database COUNT query here)
                    'total_items'    => $this->db->count_records($table),

                    // The amount of items you want to display per page
                    'items_per_page' => $page_limit,

                    // The pagination style: classic (default), digg, extended or punbb
                    // Easily add your own styles to views/pagination and point to the view name here
                    'style'          => 'digg',

                    // If there is only one page, completely hide all pagination elements
                    // Pagination->render() will return an empty string
                    'auto_hide'      => true,
                ));

                $this->template->content->pagination = $pagination->render('digg');
            }
        }

        $this->template->content->page = $offset;

    }


} // End Examples
