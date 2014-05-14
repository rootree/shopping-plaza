<?php defined('SYSPATH') OR die('No direct access allowed.');

class Price_Controller extends Web_Controller {

    public function __construct() {

        parent::__construct();
        $this->template = new View('public/template');
 
    }
 
    public function index() {

        if($this->access != ACCESS_GUEST){
            url::redirect("/settings/account");
            exit();
        }
        
        $this->template->content = new View('public/price');
        $this->template->title = 'Тарифные планы';

        $this->selected_page = PAGE_PRICE;
 
    }
  
} // End Welcome Controller