<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Небольшое вступление как пользоваться админкой
 */
class Tour_Controller extends Web_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->template = new View('public/template');
 
    }
 
    public function index() {
        
        $this->template->content = new View('public/tour');
        $this->template->title = 'Тур по сервису';

        $this->selected_page = PAGE_TOUR;

 

    }
  
} // End Welcome Controller