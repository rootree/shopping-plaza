<?php defined('SYSPATH') OR die('No direct access allowed.');

class Welcome_Controller extends Web_Controller {

    public function __construct() {
        
        parent::__construct();

        $this->template = new View('public/template');
 
    }
 
    public function index() {
 
        $this->template->content = new View('public/welcome_content');
        $this->template->title = null;

        $this->selected_page = PAGE_MAIN;
 
    }
  
} // End Welcome Controller