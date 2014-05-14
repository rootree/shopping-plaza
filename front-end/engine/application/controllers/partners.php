<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Блок партнеров магазина
 */
class Partners_Controller extends Web_Controller
{

    // Do not allow to run in production

    const ALLOW_PRODUCTION = false;

    function index()
    {
        $table = 'partners';

        $this->template->content = new ViewMod('partners');

        $this->template->title = 'Наши партнёры';

        $query = $this->db->select('*')->from($table)->where("firm_id = " . $this->firmID)->
            orderby('title', 'desc')->get();

        $this->template->content->items = array();

        if (count($query)) {

            $this->template->content->items = $query;

        }

        $this->selected_page = 'partners';
    }

} // End Examples
