<?php defined('SYSPATH') OR die('No direct access allowed.');

class Examples_Controller extends Web_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->template = new View('public/template');
 
    }
 
    public function index() {
        
        $this->template->content = new View('public/examples');
        $this->template->title = 'Успешные примеры';

        $this->selected_page = PAGE_EXAMPLES;

 

    }
  
} // End Welcome Controller