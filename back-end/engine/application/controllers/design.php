<?php defined('SYSPATH') OR die('No direct access allowed.');

class Design_Controller extends Web_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->template = new View('public/template');
 
    }
 
    public function index() {
        
        $this->template->content = new View('public/design');
        $this->template->title = 'Уникальный дизайн';

        $this->selected_page = PAGE_DESIGN;

    }
  
} // End Welcome Controller