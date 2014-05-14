<?php defined('SYSPATH') OR die('No direct access allowed.');

class Terms_Controller extends Web_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->template = new View('public/template');
 
    }
 
    public function index() {
        
        $this->template->content = new View('public/terms');
        $this->template->title = 'Условия';

        $this->selected_page = PAGE_HELP;

    }
  
} // End Welcome Controller