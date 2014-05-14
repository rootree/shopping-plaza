<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Блок вакансий
 */
class Vanancy_Controller extends Web_Controller
{

    // Do not allow to run in production

    const ALLOW_PRODUCTION = false;

    function index()
    {
        $table = 'vacancy';

        $this->template->content = new ViewMod('vanancy');

        $this->template->title = 'Вакансии';

        $query = $this->db->select('*')->from($table)->where("firm_id = " . $this->firmID)->
            orderby('date', 'desc')->get();

        $this->template->content->items = array();

        if (count($query)) {

            $this->template->content->items = $query;

        }
        $this->selected_page = 'vanancy';
    }

} // End Examples
