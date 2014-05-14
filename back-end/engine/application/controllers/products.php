<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Управление продукцией для магазина
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Products_Controller extends Web_Controller {

    const SUBPAGE_MAIN = 'main';
    const SUBPAGE_ADD = 'add';
    const SUBPAGE_IMPORT = 'import';
    const SUBPAGE_IMPORT_YML = 'yml';
    const SUBPAGE_YANDEX = 'yandex';
    const SUBPAGE_JUNKYARD = 'junkyard';
    const SUBPAGE_EXCEL = 'excel';

    public function __construct() {

        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'info' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'delete' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'printer' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'satellite' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'productcopy' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'recommend' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'import' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'junkyard' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'excel' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'ajax' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'yandex' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'yml' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
        );

        $this->selected_page = PAGE_ITEMS;

        $this->productView = cookie::get('productView') ? cookie::get('productView') : PRODUCTS_VIEW_LIST;
        $this->yandexView = cookie::get('yandexView') ? cookie::get('yandexView') : PRODUCTS_VIEW_LIST;

        if(array_key_exists('changeViewMode', $_REQUEST)){

            $this->productView = ($this->productView == PRODUCTS_VIEW_LIST) ? PRODUCTS_VIEW_IMG : PRODUCTS_VIEW_LIST;
            cookie::set('productView', $this->productView); 
            url::redirect($_SERVER['HTTP_REFERER']);

        }

        if(array_key_exists('yandex', $_REQUEST)){

            $this->yandexView = ($this->yandexView == PRODUCTS_VIEW_LIST) ? PRODUCTS_VIEW_IMG : PRODUCTS_VIEW_LIST;
            cookie::set('yandexView', $this->yandexView);
            url::redirect('/products');

        }

        if(array_key_exists('up', $_REQUEST)){
            $this->info = 'Продукт успешно изменён.';
        }
        if(array_key_exists('droped', $_REQUEST)){
            $this->info = 'Продукт успешно удален.';
        }
        if(array_key_exists('new', $_REQUEST)){
            $this->info = 'Продукт успешно добавлен.';
        }
        if(array_key_exists('newSatellite', $_REQUEST)){
            $this->info = 'Сопутствующий товар успешно добавлен.';
        }
        if(array_key_exists('satelliteDroped', $_REQUEST)){
            $this->info = 'Связь с сопутствующем товаром успешна удалена.';
        }

        if(array_key_exists('newRecommend', $_REQUEST)){
            $this->info = 'Рекомендованный товар успешно добавлен.';
        }
        if(array_key_exists('recommendDroped', $_REQUEST)){
            $this->info = 'Связь с рекомендованным товаром успешна удалена.';
        }
        if(array_key_exists('YMLdisabled', $_REQUEST)){
            $this->info = 'Обновление из YML-файла отключено.';
        }
        if(array_key_exists('imported', $_REQUEST)){
            $this->info = 'Импорт из файла успешно произведён.';
        }
        if(array_key_exists('YMLupdated', $_REQUEST)){
            $this->info = 'Обновление из YML-файла завершено.';
        }

        if(array_key_exists('copied', $_REQUEST)){
            $this->info = 'Произведена копия продукта. Сейчас вы можете отредактировать её.<br/><br/>На данный момент, эта позиция закрыта на сайте. Отредактируйте её, если нужно, и сделайте видимой на сайте.';
        }
        if(array_key_exists('priceUpdated', $_REQUEST)){

            require Kohana::find_file('vendor', 'SuperPath');
            
            $zipFile = SuperPath::get($this->firmID, false, IMAGES_TYPE_PRICE). ".zip"  ;
            if(file_exists($zipFile)){
                $priceSize =  text::bytes(filesize($zipFile));
            }else{
                $priceSize = '0 байт';
            }

            $this->info = 'Обновление прайса произведено. Размер прайса составляет: ' . $priceSize . '. <a target="_blank" href="http://'. $this->firm->domain .'/bin/priselist">Скачать</a>';
        }

        require Kohana::find_file('vendor', 'SuperPath');

    }


    public function index() {

        if(!$this->haveAccess()){
            return;
        };

        if(array_key_exists('updatePrice', $_REQUEST)){

            $idProduct = intval($_REQUEST['idProduct']);

            $priceType = @trim($_REQUEST['type']);
            $data[(!empty($priceType) ? $priceType : 'price')] = floatval($_REQUEST['price']);
            if(empty($priceType)) $data['counter'] = intval($_REQUEST['counter']);
 
            $this->db->update('products', $data, array('product_id' => $idProduct, 'firm_id' => $this->firmID));

			// TODO
			// Находим все копии, и в них тоже ставим кол-во

			$idMainProduct = $idProduct;
			$table = "products";
			$where = "product_id = " . $idProduct . " and firm_id = " . $this->firmID;

			$items = $this->db->select('source, searchingId')->from($table)->where($where)->get();
	        foreach($items as $itemsc){

                $item = $itemsc;
            }
 
			if(empty($priceType)) $data = array(
				'counter' => floatval($_REQUEST['counter'])
				);
 
			if($item->source == 1){


                $idMainProduct = $item->searchingId;
                
                // Обновляем все копии
			    $this->db->update('products', $data, array('searchingId' => $idMainProduct, 'firm_id' => $this->firmID));

				// Обвновляем оригинальный товар

				$this->db->update('products', $data, array('product_id' => $idMainProduct, 'firm_id' => $this->firmID));
			}else{
                // Обновляем все копии
			    $this->db->update('products', $data, array('searchingId' => $idMainProduct, 'firm_id' => $this->firmID));
            }
			 
            exit();
        }
        $addonURL = '';
        $this->template->content = new View('products/index');

        $this->template->title = 'Вся продукция';
        $this->selected_subpage = Products_Controller::SUBPAGE_MAIN;


        $YMLprogress = 0;
        if($this->firm->YMLenabled){

            $YMLprogress = $this->db->select('YMLprogress')->from('firms')->
                    where( array('id' => $this->firmID))->get();

            $YMLprogress = $YMLprogress[0];
            if($YMLprogress->YMLprogress != 0 && $YMLprogress->YMLprogress != 100){
                url::redirect(url::site() . "products/yml/");return;
            }
        }

        if($this->firm->YMLenabled){
            $this->info = 'Внимение! Данные обновляються из <a href="/products/yml/">YML-файла</a>.';
        }

        $this->forMenu();

        if(!$this->cats->count()){

            url::redirect(url::site() . "settings/catsadd?emptyCat");return; 

        }

        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'products';
        $where = '1=1 and '.$table.'.firm_id = ' . $this->firmID . ' and '.$table.'.status in (' . implode(',', array(STATUS_HIDE, STATUS_WORK)) . ')';

        if(!empty($this->catid)){
            $where .= " and cat_id = " . $this->catid;
            $addonURL .= '/catid/' . $this->catid;
        }
        if(!empty($this->catssubid)){
            $where .= " and catsub_id = " . $this->catssubid;
            $addonURL .= '/catssubid/' . $this->catssubid;
        }

        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }
 
        if($this->productView == PRODUCTS_VIEW_LIST){

            $this->template->content->items = $this->db->select('*')->from($table)->
                    where($where)->offset($offset)->limit($page_limit)->orderby('title', 'acs')->get();

        }else{
            
            $this->template->content->items = $this->db->select($table.'.*, product_imgs.id as img, searchingImg.id as imgSearch')->from($table)->
                    join('product_imgs', array('product_imgs.product_id' => $table.'.product_id',
                                             'product_imgs.favorite' => 1), null, 'left')->

                    join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table.'.searchingId',
                                         'searchingImg.favorite' => 1), null, 'left')->
                    
                    where($where)->offset($offset)->limit($page_limit)->orderby('title', 'acs')->get(); 
        }
  
        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

              // Base_url will default to the current URI
              'base_url'    => 'products/index' . $addonURL,

              // The URI segment (integer) in which the pagination number can be found
              // The URI segment (string) that precedes the pagination number (aka "label")
              'uri_segment'    => 'page',

              // You could also use the query string for pagination instead of the URI segments
              // Just set this to the $_GET key that contains the page number
              // 'query_string'   => 'page',

              // The total items to paginate through (probably need to use a database COUNT query here)
              'total_items'    => $count_records,

              // The amount of items you want to display per page
              'items_per_page' => $page_limit,

              // The pagination style: classic (default), digg, extended or punbb
              // Easily add your own styles to views/pagination and point to the view name here
              'style'          => 'digg',

              // If there is only one page, completely hide all pagination elements
              // Pagination->render() will return an empty string
              'auto_hide'      => TRUE,
         ));


        $this->template->content->pagination = $pagination->render('digg');
        $this->template->content->count_records = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;

    }


    public function junkyard() {

        $this->template->content = new View('products/index');

        $this->template->title = 'Продукция без категорий';
        $this->selected_subpage = Products_Controller::SUBPAGE_JUNKYARD;

        if(!$this->haveAccess()){
            return;
        };

        $this->forMenu();
  
        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;

        $table = 'products';
        
        $where = '1=1 and products.firm_id = ' . $this->firmID . ' and products.status in (' . implode(',', array(STATUS_HIDE, STATUS_WORK)) . ')';
        $where .= " and (products.cat_id = 0 OR products.catsub_id = 0)" ;


        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }



        if($this->productView == PRODUCTS_VIEW_LIST){

            $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('title', 'acs')->get();

        }else{

            $this->template->content->items = $this->db->select($table.'.*, product_imgs.id as img, searchingImg.id as imgSearch')->from($table)->
                join('product_imgs', array('product_imgs.product_id' => $table.'.product_id',
                'product_imgs.favorite' => 1), null, 'left')->

                join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table.'.searchingId',
                'searchingImg.favorite' => 1), null, 'left')->

                where($where)->offset($offset)->limit($page_limit)->orderby('title', 'acs')->get();
        }



    //    $this->template->content->items = $this->db->select('*')->from($table)->
    //            where($where)->offset($offset)->limit($page_limit)->orderby('title', 'acs')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

              // Base_url will default to the current URI
              'base_url'    => 'products/index',

              // The URI segment (integer) in which the pagination number can be found
              // The URI segment (string) that precedes the pagination number (aka "label")
              'uri_segment'    => 'page',

              // You could also use the query string for pagination instead of the URI segments
              // Just set this to the $_GET key that contains the page number
              // 'query_string'   => 'page',

              // The total items to paginate through (probably need to use a database COUNT query here)
              'total_items'    => $count_records,

              // The amount of items you want to display per page
              'items_per_page' => $page_limit,

              // The pagination style: classic (default), digg, extended or punbb
              // Easily add your own styles to views/pagination and point to the view name here
              'style'          => 'digg',

              // If there is only one page, completely hide all pagination elements
              // Pagination->render() will return an empty string
              'auto_hide'      => TRUE,
         ));


        $this->template->content->pagination = $pagination->render('digg');
        $this->template->content->count_records = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;

    }

    private function forMenu() {

        $this->cats = $this->db->select('*')->from('cats')
                ->where('1=1 and firm_id = ' . $this->firmID .' and `status` in (' . STATUS_HIDE . ','.STATUS_WORK .')')->orderby('sort', 'asc')->get();

        $this->catid = intval($this->uri->segment('catid'));
        $this->catssubid = intval($this->uri->segment('catssubid'));

        if($this->catid){
            $this->catssub = $this->db->select('*')->from('catssub')
                    ->where('1=1 and firm_id = ' . $this->firmID . ' and cat_id = ' . $this->catid .
                            ' and `status` in (' . STATUS_HIDE . ','.STATUS_WORK .')')->orderby('sort', 'asc')->get();
        }

        if($this->cats && count($this->cats)){
            foreach ($this->cats as $item) {
                if($this->catid == $item->cat_id) {
                    $this->template->title =  $item->title;
                }
            }
        }

        if(isset($this->catssub) && count($this->catssub)){
            foreach ($this->catssub as $item) {
                if($this->catssubid == $item->catsub_id) {
                    $this->template->title .= ' / ' . $item->title;
                }
            }
        }


    }

    public function add() {

        $this->template->content = new View('products/add');

        $this->selected_subpage = Products_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $dataUser['title'] = @trim($_POST['product']['title']);
            $dataUser['cat_id'] = @intval($_POST['product']['cat_id']);
            $dataUser['catsub_id'] = @intval($_POST['product']['catsub_id']);
            $dataUser['arcitule'] = @trim($_POST['product']['arcitule']);
            $dataUser['price'] = @floatval($_POST['product']['price']);

            if(isset($_POST['product']['price1'])){
                $dataUser['price1'] = @floatval($_POST['product']['price1']);
            }
            if(isset($_POST['product']['price2'])){
                $dataUser['price2'] = @floatval($_POST['product']['price2']);
            }
            if(isset($_POST['product']['price3'])){
                $dataUser['price3'] = @floatval($_POST['product']['price3']);
            }
            if(isset($_POST['product']['price4'])){
                $dataUser['price4'] = @floatval($_POST['product']['price4']);
            }
            if(isset($_POST['product']['price5'])){
                $dataUser['price5'] = @floatval($_POST['product']['price5']);
            }

            $dataUser['desc'] = @trim($_POST['product']['desc']);
            $dataUser['desc_mini'] = @trim($_POST['product']['desc_mini']);

            $dataUser['discount'] = @intval($_POST['product']['discount']);
            $dataUser['weight'] = @intval($_POST['product']['weight']);

            $dataUser['new'] = (isset($_POST['product']['new']) ? 1 : 0);
            $dataUser['week'] = (isset($_POST['product']['week']) ? 1 : 0);
            $dataUser['unic'] = (isset($_POST['product']['unic']) ? 1 : 0);
            
            $dataUser['moder_id'] = $this->moderId;
            $dataUser['status'] = STATUS_WORK;

            $fields = @($_POST['product']['fields']);
            unset($_POST['product']['fields']);

            $dataUser['firm_id'] = $this->firmID;

            if( $dataUser['cat_id'] <= 0){
                $this->errorFields[] = "Основная категория";
            }
            if(!($dataUser['title'])){
                $this->errorFields[] = "Название";
            }
            if( $dataUser['price'] <= 0){
                $this->errorFields[] = "Цена";
            }
            
            if(!($dataUser['arcitule'])){
                $dataUser['arcitule'] = 'SP-'.sprintf("%03s", $this->firmID).'-'.sprintf("%05s", rand(0,99999));    
            }

            $dataUser['searchingId']    = @intval($_POST['product']['searchingId']);
            $dataUser['source']         = @intval($_POST['product']['source']);
            $dataUser['replace']        = @trim($_POST['product']['replace']);
            $dataUser['replace_to']     = @trim($_POST['product']['replace_to']);

            if($dataUser['source'] == 1){

                if(!$dataUser['searchingId']){
                    $this->errorFields[] = "Взять из";
                }

                if(!empty($dataUser['replace_to']) && empty($dataUser['replace'])){
                    $this->errorFields[] = "Заменить";
                    $this->errorFields[] = "На";
                } 
            }

            if(is_null($this->error) && !count($this->errorFields)){

                $dataUser['url_link'] = format::do_latin($dataUser['title']);
                try{
                    $status = $this->db->insert('products', $dataUser);
                    if(count($status)){

                        if(count($fields)){
                            foreach($fields as $field_id => $field_value){

                                $content = array(
                                    "product_id" => $status->insert_id(),
                                    "field_id" => $field_id,
                                    "field_value" => $field_value,
                                );
                                $this->db->insert('product_fields', $content);
                            }
                        }

                        url::redirect(url::site() . "products/info/catid/" . $dataUser['cat_id'] .
                                      "/catssubid/" . $dataUser['catsub_id'] . "/id/" . $status->insert_id() . "/?new");

                        exit();

                    }else{
                        $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                    }
                }catch(Exception $e){ 
                        $this->error .=  'Произошла ошибка. Скорей всего вы указали артикул товара, который уже есть.' . $this->NL();
                }
                
            }else{
                 $this->error = $this->completeErrorFieldsMessage('Товар не добавлен. Для добавления товара необходимо запонить обязательные поля. ');
            }
        }

        $this->forMenu();
        $this->template->title = 'Добавление товара';
        
        if($this->catssubid){
            $table = "fields";
            $where = "catsub_id = " . $this->catssubid . " and firm_id = " . $this->firmID;
            $this->fields = $this->db->select('*')->from($table)->
                    where($where)->orderby('sort', 'asc')->get();
        }
    }

    public function yml() {

        $this->template->content = new View('products/yml/index');

        $this->selected_subpage = Products_Controller::SUBPAGE_IMPORT_YML;

        if(!$this->haveAccess()){
            return;
        };

        $YMLprogress = 0;
        if($this->firm->YMLenabled){

            $YMLprogress = $this->db->select('YMLprogress')->from('firms')->
                where( array('id' => $this->firmID))->get();

            $YMLprogress = $YMLprogress[0];
            $YMLprogress = $YMLprogress->YMLprogress;

            if($YMLprogress != 100){
                $this->selected_page = PAGE_RESPONSE;
            }else{
                $this->forMenu();
                $YMLprogress = 0;
            }

        }else{
            $this->forMenu();
        }


        $this->YMLprogress = $YMLprogress;

        if ($_POST){

            $yml = @trim($_POST['yml']);
            $YMLenabled = @intval($_POST['YMLenabled']);

            if(  !valid::url($yml)){
                $this->errorFields[] = "Файл в формате YML";
            }
            if(is_null($this->error) && !count($this->errorFields)){

                if($YMLenabled){
                    
                    // Даты для отчёта

                    ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
                    ini_set("max_execution_time", 0);
                    ini_set("memory_limit", "10000M");

                    try{
                        $rss =  simplexml_load_file($yml);
                    }catch(Exception $e ){
                        $rss = false;
                        $this->error = 'Невозможно загрузить указанный YML-фаил';
                    }
                    if($rss === false){

                        $this->error = $this->completeErrorFieldsMessage('Внимание! Вы указали YML-файл который содержит ошибки. Мы не можем обработать его.
                        Исправте ошибки в файле, укажите другой адрес YML-файла или <a href="/response">напишите</a> нам за помощью.');

                        $this->resulert = false;

                    }else{

                        $this->countCats = count($rss->shop->categories->category);
                        $this->countItems = count($rss->shop->offers->offer);

                        $this->resulert = true;

                        $this->db->update('firms', array('YML' => $yml, 'YMLenabled' => $YMLenabled), array('id' => $this->firmID));
                        $this->session->set("firm", NULL);

                    }

                }else{
                    $this->db->update('firms', array('YML' => $yml, 'YMLenabled' => $YMLenabled), array('id' => $this->firmID));
                    $this->session->set("firm", NULL);

                    if($this->firm->YMLenabled){
                        url::redirect(url::site() . "/products/yml/?YMLdisabled");
                        exit();
                    }
                }


            }else
            {

                $this->error = $this->completeErrorFieldsMessage('Импорт не начался. ');
            }
        }


        $this->template->title = 'Импорт товаров из YML (формат Яндекс.Маркета)';
    }


    public function ymlstart() {


        $this->db->update('firms', array('YMLenabled' => 1, 'YMLprogress' => 1), array('id' => $this->firmID));

        if($GLOBALS['runningOn'] == 3){
            $cmd_command = ('php ' . escapeshellarg(SERVER_ROOT . '/common-files/cron/YMLupdate.php').' -f ' . $this->firmID);
        }else{
            $cmd_command = ('php ' . escapeshellarg(SERVER_ROOT . '\common-files\cron\YMLupdate.php').' -f ' . $this->firmID);
        }

        $this->exec($cmd_command);

        die(1);
    }

    public function ymlupdate() {
 
        $YMLprogress = $this->db->select('YMLprogress')->from('firms')->
                    where( array('id' => $this->firmID))->get();

        $YMLprogress = $YMLprogress[0];
        if($YMLprogress){
            $YMLprogress = intval($YMLprogress->YMLprogress);
        }else{
            $YMLprogress = 0;
        }

        die(''.$YMLprogress.'');
    }

    public function yandex() {

        $this->template->content = new View('products/yandex');

        $this->selected_subpage = Products_Controller::SUBPAGE_YANDEX;

        if(!$this->haveAccess()){
            return;
        };


        $this->forMenu();
        $this->template->title = 'YML-формат (Яндекс.Маркет)';

    }

    public function import() {

        $this->template->content = new View('products/import');

        $this->selected_subpage = Products_Controller::SUBPAGE_IMPORT;

        if(!$this->haveAccess()){
            return;
        };

        if ($_FILES){
 
            if(file_exists($_FILES['import_file']['tmp_name'])){

                require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Reader/OLERead');
                require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Reader/Spreadsheet_Excel_Reader');
  
                if ($_FILES['import_file']['type'] != 'application/vnd.ms-excel' && 'text/comma-separated-values' != $_FILES['import_file']['type']) {
                    $this->error .=  'Пожалуйста выберите файл соответствующего типа.' . $this->NL();
                }

                $this->updated = 0;
                $this->inserted = 0;
                $this->errorCount = 0;

                $handle = @fopen($_FILES['import_file']['tmp_name'], "r");

                if (is_null($this->error) && $handle) {

                    $excel = new Spreadsheet_Excel_Reader();

                    $excel->setUTFEncoder('iconv');
                    $excel->setOutputEncoding('UTF-8');

                    $excel->read($_FILES['import_file']['tmp_name']);

                    try {

                        foreach($excel->sheets as $k=>$data){

                            if(isset($data['cells']) && is_array($data['cells'])){
 
                                foreach($data['cells'] as $fields){

                                    foreach ($fields as $key => $item ){

                                        $fields[$key] = trim($fields[$key]);
                                        $fields[$key] = str_replace("\n", "", $fields[$key]);
                                        if(isset($item{0}) && $item{0} == '"'){
                                            $fields[$key] = substr($fields[$key], 1);
                                        }

                                        if(substr($fields[$key], -1) == '"'){
                                            $fields[$key] = substr($fields[$key], 0, -1);
                                        } 
                                    }

                                    switch ($this->firmID){

                                        case 1:
                                        case 21:

                                            if(!isset($fields[2]) || intval($fields[6]) == 0){
                                                continue;
                                            }

                                            $dataImport = array();
                                            $dataImport['price'] = floatval(trim($fields[9]));
                                            $dataImport['counter'] = intval($fields[6]);
                                            $dataImport['viewed'] = ($fields[3]);
                                            $dataImport['moder_id'] = $this->moderId;

                                            preg_match("/(\d+)/", $fields[2], $match);

                                            if(!count($match)){
                                                continue;
                                            }

                                            $arcitule = $match[1]; 
                                            if($arcitule == 0){
                                                continue;
                                            }

                                            $arcitule = ceil(($arcitule * 3 + 100) * 2 - 50); 
                                            $arcitule = ''. trim($arcitule) . '';

                                            try {

                                                //$status = $this->db->update('products', $dataImport, array('arcitule' => $arcitule, 'firm_id' => $this->firmID));
                                                $status = $this->db->query(" UPDATE `products` SET viewed = viewed + 1, `price` = " . $dataImport['price']. ",
                                                `counter` = " . $dataImport['counter'] .", `moder_id` = '" . $this->moderId. "'
                                                 WHERE `arcitule` = '" . $arcitule . "' AND `firm_id` = '" . $this->firmID . "'");
                                                if(count($status)){
                                                    $this->updated ++;
                                                }else{

                                                    throw new Exception('Something went wrong!');
                                                }

                                            } catch (Exception $e) {

                                                $dataUser['title'] = ($fields[3]);
                                                $dataUser['cat_id'] = 0;
                                                $dataUser['catsub_id'] = 0;
                                                $dataUser['arcitule'] = $arcitule;
                                                $dataUser['counter'] = intval($fields[6]);
                                                $dataUser['price'] = floatval(trim($fields[9]));
                                                $dataUser['desc'] = '';
                                                $dataUser['desc_mini'] = '';

                                                $dataUser['discount'] = 0;
                                                $dataUser['weight'] = 0;

                                                $dataUser['new'] = 0;
                                                $dataUser['week'] = 0;
                                                $dataUser['unic'] = 0;

                                                $dataUser['firm_id'] = $this->firmID;
                                                $dataUser['moder_id'] = $this->moderId;
                                                $dataUser['status'] = STATUS_HIDE;


                                                try {
                                                    $statusUE = $this->db->insert('products', $dataUser);
                                                    if(count($statusUE)){
                                                        $this->inserted ++;
                                                    }else{
                                                        $this->errorCount ++;
                                                    }
                                                } catch (Exception $e) {
                                                    $this->errorCount ++;
                                                    print_r($e); exit();
                                                }


                                            }
    
                                            break;

                                        default:
                                     
                                            $dataImport = array();
                                            $dataImport['price'] = floatval(trim($fields[3]));
                                            $dataImport['counter'] = intval($fields[2]);
                                            $dataImport['moder_id'] = $this->moderId;

                                            try {

                                                $status = $this->db->update('products', $dataImport, array('arcitule' => trim($fields[1]), 'firm_id' => $this->firmID));
                                                if(count($status)){
                                                    $this->updated ++;
                                                }else{
                                                    throw new Exception('Something went wrong!');
                                                }

                                            } catch (Exception $e) {

                                                $dataUser['title'] = 'Товар с артикулом ' . $fields[1];
                                                $dataUser['cat_id'] = 0;
                                                $dataUser['catsub_id'] = 0;
                                                $dataUser['arcitule'] = $fields[1];
                                                $dataUser['counter'] = intval($fields[2]);
                                                $dataUser['price'] = floatval($fields[3]);
                                                $dataUser['desc'] = '';
                                                $dataUser['desc_mini'] = '';

                                                $dataUser['discount'] = 0;
                                                $dataUser['weight'] = 0;

                                                $dataUser['new'] = 0;
                                                $dataUser['week'] = 0;
                                                $dataUser['unic'] = 0;

                                                $dataUser['firm_id'] = $this->firmID;
                                                $dataUser['moder_id'] = $this->moderId;
                                                $dataUser['status'] = STATUS_HIDE;

                                                $statusUE = $this->db->insert('products', $dataUser);
                                                if(count($statusUE)){
                                                    $this->inserted ++;
                                                }else{
                                                    $this->errorCount ++;
                                                }

                                            }

                                    }
                                }
                            }
                        }
 
                        fclose($handle);
 
                        url::redirect(url::site() . "/products/junkyard/?imported&ins=" . $this->inserted . "&upd=" . $this->updated . "&err=" . $this->errorCount);
                        exit();
                        
                    } catch (Exception $e) {
 
                        $this->error .=  'Произошла ошибка неизвестного типа. ' .$e->getMessage() . $this->NL();

                    }

                }

            }
 
        }

        $this->forMenu();
        $this->template->title = 'Обновление количества и цены товаров из файла по артикулу';
 
    }


    public function delete() {

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));
        $this->catid = intval($this->uri->segment('catid'));
        $this->catssubid = intval($this->uri->segment('catssubid'));
 
        $status = $this->db->update('products', array('status' => STATUS_DELETED), array('product_id' => $id,'firm_id' => $this->firmID ));
 
        if(count($status)){

            if($this->catid == 0 && $this->catssubid == 0){
                url::redirect(url::site() . "/products/junkyard/?droped"); 
            }else{
                url::redirect(url::site() . "products/index/catid/" . $this->catid .
                    "/catssubid/" . $this->catssubid . "/?droped");
            }

            exit();
        }else{
            Event::run('system.404');
        }
    }



    private function uploader($id) {
 
        if ($id && !empty($_FILES)) {

            $this->firmID = (Input::instance()->post('firmID') );
            
            switch ($_FILES['Filedata']['error']){
                case 0:
                    $msg = "No Error"; // comment this out if you don't want a message to appear on success.
                    break;
                case 1:
                    $msg = "The file is bigger than this PHP installation allows";
                    break;
                case 2:
                    $msg = "The file is bigger than this form allows";
                    break;
                case 3:
                    $msg = "Only part of the file was uploaded";
                    break;
                case 4:
                    $msg = "No file was uploaded";
                    break;
                case 6:
                    $msg = "Missing a temporary folder";
                    break;
                case 7:
                    $msg = "Failed to write file to disk";
                    break;
                case 8:
                    $msg = "File upload stopped by extension";
                    break;
                default:
                    // $msg = "unknown error ".$_FILES['Filedata']['error'];
                    break;
            }

            If ($_FILES['Filedata']['error'] && $msg){
                echo "Error: ".$_FILES['Filedata']['error']." Error Info: ".$msg;
                exit();
            }

            $tempFile = $_FILES['Filedata']['tmp_name'];

            $size = getimagesize($tempFile);

            if(!is_array($size)){
                echo "Error: Указанное изображение не подходит. Выберите другое изображение."  ;
                exit();;
            }

            $hash = hash_file('md5', $tempFile);

            $content = array(
                "product_id" => $id,
                "img_size" => filesize($tempFile),
                "img_hash" => $hash,
                'firm_id' => $this->firmID
            );


                $table = "product_imgs";
                $where = "product_id = " . $id . " and favorite = 1 and firm_id = " . $this->firmID;

                $item = $this->db->select('*')->from($table)->
                        where($where)->get();

                if(!isset($item[0])){
                    $content['favorite'] = 1;
                }


            $status = $this->db->insert('product_imgs', $content);
            if(count($status)){

                $imageId = $status->insert_id();
                $ext = "." . substr (strrchr ($_FILES['Filedata']['name'], "."), 1);  //".gif";
                $targetFile = SuperPath::get($imageId)  ;

                $origFile = $targetFile. "orig". $ext;

                move_uploaded_file($tempFile, $origFile) ;

                $cmd_command = 'convert ' . escapeshellarg($origFile) . ' -quality 85 -compress JPEG ' .
                               escapeshellarg($targetFile . ".jpg");
                $this->exec($cmd_command);
 
                $hiegth = 120;
                $width = $size[0] * $hiegth / $size[1];

                $cmd_command = 'convert ' . escapeshellarg($targetFile. ".jpg") . ' ' .
                               " -geometry " . $width . "x" . $hiegth . " +repage " .
                               escapeshellarg($targetFile . "m.jpg");
                $this->exec($cmd_command);



                $hiegth = 300;
                $width = $size[0] * $hiegth / $size[1];

                $cmd_command = 'convert ' . escapeshellarg($targetFile. ".jpg") . ' ' .
                               " -geometry " . $width . "x" . $hiegth . " +repage " .
                               escapeshellarg($targetFile . "b.jpg");
                $this->exec($cmd_command);

                $fileWaterMark = SuperPath::get($this->firmID, false, IMAGES_TYPE_WATERMARK).'.png';
  
                if(file_exists($fileWaterMark)) {
                    $cmd_command = 'composite -gravity Center -dissolve 25 ' . escapeshellarg($fileWaterMark) .
                                   ' ' . escapeshellarg($targetFile. ".jpg")  . ' ' . escapeshellarg($targetFile . ".jpg") . ' ';
                    $this->exec($cmd_command);
                }

                echo "1" ;





            }else{
                echo "Ошибка в БД."  ;
            }
        } 
    }

    public function info() {

        $id = (intval($this->uri->segment('id')))
                    ? intval($this->uri->segment('id')) 
                    : intval($this->uri->segment('itemid'));


        $this->firmID = (isset($this->firmID) && $this->firmID > 0) ? $this->firmID : intval($_REQUEST['firmID']);
        $table = "products";
        $where = "product_id = " . $id . " and firm_id = " . $this->firmID;

        $item = $this->db->select('*')->from($table)->
                where($where)->get();
 
        if (!empty($_FILES)) {
 
            if(!$item){
                echo "Error: Item #$id not Find" ;
            }else{
                $item = $item[0];
                if(empty($item)){ 
                    echo "Error: Item not found #$id ";
                    exit();
                }

                if($item->source == 1 && $item->searchingId){
                    $id = $item->searchingId;
                }
                $this->uploader($id);
            }
            exit();
        }

        if(!$this->haveAccess()){
            return;
        };


        if($this->firm->YMLenabled){
            $this->info = 'Внимение! Данные обновляються из <a href="/products/yml/">YML-файла</a>. <br/><br/>
            Для данного товара можно добавить расширенное описание и дополнительные изображение, <br/>но если при следующем обновлении из YML-файл
            данного товара не будет,<br/> вместе с ним исчезнут и проделанные изменения.';
        }

        
        $this->template->content = new View('products/info');
        $this->selected_subpage = null;

        $this->template->content->item = $item;

        if($this->template->content->item){

            $this->id = $id;
            $this->template->content->item = $this->template->content->item[0];
     
            $this->forMenu();

            $this->template->title = $this->template->content->item->title .
                                     (!empty($this->template->content->item->desc_mini) ? ' (' . ($this->template->content->item->desc_mini)  . ')' : '');

            
            if(array_key_exists('pleaseHide', $_REQUEST)){
                
                $status = $this->db->update('products',
                    array('status' => STATUS_HIDE),
                    array('product_id' => $id,'firm_id' => $this->firmID ));


                if(count($status)){
                    $this->info = 'Позиция убрана с сайта.';
                    $this->template->content->item->status = STATUS_HIDE;
                }else{
                    $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
                }
            }

            if(array_key_exists('pleaseShow', $_REQUEST)){

                $status = $this->db->update('products',
                    array('status' => STATUS_WORK),
                    array('product_id' => $id,'firm_id' => $this->firmID ));


                if(count($status)){
                    $this->info = 'Позиция появилась на сайте.';
                    $this->template->content->item->status = STATUS_WORK;
                }else{
                    $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
                }
            }

            $table = "product_cost";
            $where = "product_id = " . $id   ;
            $this->costs = $this->db->select('*')->from($table)
                    ->join('moders', 'moders.user_id',
                           'product_cost.moder_id' )
                    ->where($where)->orderby('product_cost.date', 'DESC')->get();
 
            if($this->template->content->item->source == 1 && $this->template->content->item->searchingId){
                $id = $this->template->content->item->searchingId;

                $table = "products";
                $where = "product_id = " . $id . " and firm_id = " . $this->firmID;
                $relative = $this->db->select('*')->from($table)->
                        where($where)->get();
                $relative = $relative[0];

                if(!empty($this->template->content->item->replace)){
                    $relative->desc = str_replace(
                        $this->template->content->item->replace,
                        $this->template->content->item->replace_to,
                        $relative->desc
                    );
                }

                $this->template->content->item->desc = $relative->desc;
                $this->template->content->relative = $relative;

            }
 
            $deleteimage = intval($this->uri->segment('deleteimage'));
            if($deleteimage && empty($_FILES)){

                $status = $this->db->delete('product_imgs', array(
                    'product_id' => $id,
                    'id' => $deleteimage,
                    'firm_id' => $this->firmID )
                );

                if(count($status)){
                    $this->info = 'Изображение удалено.';
                }else{
                    $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
                }
            }

            $favoriteimage = intval($this->uri->segment('favoriteimage'));
            if($favoriteimage && empty($_FILES)){

                $status = $this->db->update('product_imgs', array('favorite' => 0), array(
                                                                 'product_id' => $id,
                                                                 'firm_id' => $this->firmID )
                );

                $status = $this->db->update('product_imgs', array('favorite' => 1), array(
                                                                 'product_id' => $id,
                                                                 'id' => $favoriteimage,
                                                                 'firm_id' => $this->firmID )
                );

                if(count($status)){
                    $this->info = 'Основное изображение установлено.';
                }else{
                    $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку.' . $this->NL();
                }
            }

            $table = "product_fields";
            $where = "product_id = " . $id   ;
            $this->fields = $this->db->select('*')->from($table)
                    ->join('fields', 'fields.field_id',
                           'product_fields.field_id' )
                    ->where($where)->orderby('fields.sort', 'asc')->get();

            $table = "product_imgs";
            $where = "product_id = " . $id   ;
            $this->imgs = $this->db->select('*')->from($table)
                    ->where($where)->orderby('product_imgs.id', 'asc')->get();

 
        } else{
            Event::run('system.404');
        }
    }
 
    public function printer() {

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));
 

        $this->template = new View('authorize/print');
        $this->template->content = new View('products/printer');
        $this->selected_subpage = null;

        $table = "products";
        $where = "product_id = " . $id . " and firm_id = " . $this->firmID;

        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();

        if($this->template->content->item){

            $this->id = $id;
            $this->template->content->item = $this->template->content->item[0];

            $this->forMenu();
            
            $this->template->title = $this->template->content->item->title .
                                     (!empty($this->template->content->item->desc_mini) ? ' (' . ($this->template->content->item->desc_mini)  . ')' : '');
 
            $table = "product_fields";
            $where = "product_id = " . $id   ;
            $this->fields = $this->db->select('*')->from($table)
                    ->join('fields', 'fields.field_id',
                           'product_fields.field_id')
                    ->where($where)->orderby('fields.sort', 'asc')->get();

            $table = "product_imgs";
            $where = "product_id = " . $id   ;
            $this->imgs = $this->db->select('*')->from($table)
                    ->where($where)->orderby('product_imgs.id', 'asc')->get();
 
        } else{
            Event::run('system.404');
        }
    }


    public function edit() {

        if($this->firm->YMLenabled){
            $this->info = 'Внимение! Данные обновляються из <a href="/products/yml/">YML-файла</a>. <br/><br/>
            Для данного товара можно добавить расширенное описание и дополнительные изображение, <br/>но если при следующем обновлении из YML-файл
            данного товара не будет,<br/> вместе с ним исчезнут и проделанные изменения.';
        }

        $this->template->content = new View('products/edit');
        $this->selected_subpage = null;

        $this->prevCountOfFields = 0;

        if(!$this->haveAccess()){
            return;
        };

        $this->catssubid = intval($this->uri->segment('catssubid'));
        $this->catSubIdInEdit = intval($this->uri->segment('catSubIdInEdit'));
        $this->catid = intval($this->uri->segment('catid'));

        if ($_POST){

            $data['title'] = @trim($_POST['product']['title']);
            $data['cat_id'] = @intval($_POST['product']['cat_id']);
            $data['catsub_id'] = @intval($_POST['product']['catsub_id']);
            $data['arcitule'] = @trim($_POST['product']['arcitule']);
            $data['price'] = @intval($_POST['product']['price']);
            $data['desc'] = @trim($_POST['product']['desc']);
            $data['desc_mini'] = @trim($_POST['product']['desc_mini']);

            if(isset($_POST['product']['price1'])){
                $data['price1'] = @floatval($_POST['product']['price1']);
            }
            if(isset($_POST['product']['price2'])){
                $data['price2'] = @floatval($_POST['product']['price2']);
            }
            if(isset($_POST['product']['price3'])){
                $data['price3'] = @floatval($_POST['product']['price3']);
            }
            if(isset($_POST['product']['price4'])){
                $data['price4'] = @floatval($_POST['product']['price4']);
            }
            if(isset($_POST['product']['price5'])){
                $data['price5'] = @floatval($_POST['product']['price5']);
            }

            $data['discount'] = @intval($_POST['product']['discount']);
            $data['weight'] = @intval($_POST['product']['weight']);

            $data['new'] = (isset($_POST['product']['new']) ? 1 : 0);
            $data['week'] = (isset($_POST['product']['week']) ? 1 : 0);
            $data['unic'] = (isset($_POST['product']['unic']) ? 1 : 0);

            $data['moder_id'] = $this->moderId;

            $fields = (isset($_POST['product']['fields']) ? $_POST['product']['fields'] : array());
            unset($_POST['product']['fields']);

            if(!($data['title'])){
                $this->errorFields[] = "Заголовок";
            }
            if( $data['price'] <= 0){
                $this->errorFields[] = "Цена";
            }
            if( $data['cat_id'] <= 0){
                $this->errorFields[] = "Основная категория";
            }

            $data['searchingId'] = @intval($_POST['product']['searchingId']);
            $data['source'] = @intval($_POST['product']['source']);
            $data['replace'] = @trim($_POST['product']['replace']);
            $data['replace_to'] = @trim($_POST['product']['replace_to']);

            if($data['source'] == 1){

                if(!$data['searchingId']){
                    $this->errorFields[] = "Взять из";
                }

                if(!empty($data['replace_to']) && empty($data['replace'])){
                    $this->errorFields[] = "Заменить";
                    $this->errorFields[] = "На";
                }

            }

            if(is_null($this->error) && !count($this->errorFields)){

                $id = intval($this->uri->segment('id'));

                $data['url_link'] = format::do_latin($data['title']);

                $status = $this->db->update('products', $data, array('product_id' => $id, 'firm_id' => $this->firmID));

                if(count($status) || 1){

                    if($this->catSubIdInEdit != $this->catssubid && $this->catSubIdInEdit != 0){
                        $this->db->delete('product_fields', array("product_id" => $id));
                    }

                    foreach($fields as $field_id => $field_value){


                        if(empty($field_value)){
                            continue;
                        }

                        if($this->catSubIdInEdit != $this->catssubid && $this->catSubIdInEdit != 0){

                            $content = array(
                                "field_value" => trim($field_value),
                                "field_id" => $field_id,
                                "product_id" => $id,
                            );

                            $this->db->insert('product_fields', $content);

                        }else{
 
                            $sql = "INSERT INTO product_fields (field_value, field_id, product_id )
                            VALUES ('" . mysql_escape_string(trim($field_value)) . "', " . intval($field_id) . ", $id) ON DUPLICATE KEY UPDATE field_value='" . mysql_escape_string(trim($field_value)) . "'";

                            $this->db->query($sql);

                        } 
                    }

                    url::redirect(url::site() . "products/info/catid/" . $data['cat_id'] .
                                  "/catssubid/" . $data['catsub_id'] . "/id/" . $id .'/?up');

                    exit();

                }else{
                    $this->error .=  'Произошла системная ошибка. Обратитесь в техническую поддержку' . $this->NL();
                }

            }else{
                $this->error = $this->completeErrorFieldsMessage('Продукт не изменен. Для изменения продукта необходимо запонить обязательные поля. ');
            }
        }

        $id = intval($this->uri->segment('id'));

        $table = "products";
        $where = "product_id = " . $id . " and firm_id = " . $this->firmID;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();

        if($this->template->content->item){
 
            $this->template->content->item = $this->template->content->item[0];

            $this->forMenu(); 
            $this->template->title = 'Редактирование «' . ($this->template->content->item->title) .
                (!empty($this->template->content->item->desc_mini) ? ' (' . ($this->template->content->item->desc_mini)  . ')' : ''). '»';

            $this->catidinedit = intval($this->uri->segment('catidinedit'));
            if($this->catidinedit){
                $this->catssubForEdit = $this->db->select('*')->from('catssub')
                        ->where('1=1 and firm_id = ' . $this->firmID . ' and cat_id = ' . $this->catidinedit . ' and status = ' . STATUS_WORK )->orderby('sort', 'asc')->get();

                if(!$this->catid){//
                    $this->catid = $this->catidinedit;
                }
            }else{
                $this->catssubForEdit = @$this->catssub;
                $this->catidinedit = @$this->catid;
            }

            if($this->catSubIdInEdit){

                if(!$this->catssubid){
                    $this->catssubid = $this->catSubIdInEdit;
                }

                // $this->catSubIdInEdit = intval($this->uri->segment('catSubIdInEdit'));
            }else{
                if($this->template->content->item->cat_id == $this->catidinedit){
                    $this->catSubIdInEdit = $this->catssubid;
                }
            }

            if($this->catSubIdInEdit){

                $table = "fields";
                $where = "fields.catsub_id = " . $this->catSubIdInEdit . " and fields.firm_id = " . $this->firmID  ;
                $this->fields = $this->db->select('*, fields.field_id as field_id')->from($table)
                        ->join('product_fields',
                               array(
                                    'fields.field_id' => 'product_fields.field_id',
                                    'product_id' => $id,
                               ), 'product_fields.field_id AND product_id = ' . $id, "LEFT")
                        ->where($where)->orderby('fields.sort', 'asc')->get();

            }
 
            if($this->catssubid != $this->catSubIdInEdit ){
 

                $table = "fields";
                $where = "fields.catsub_id = " . $this->catssubid . " and fields.firm_id = " . $this->firmID  ;

                $this->prevCountOfFields = $this->db->from($table)->
                    where($where)->count_records();
 
                $table = "fields";
                $where = "fields.catsub_id = " . $this->catssubid . " and fields.firm_id = " . $this->firmID  ;
                $this->oldFields = $this->db->select('*, fields.field_id as field_id')->from($table)
                        ->join('product_fields',
                               array(
                                    'fields.field_id' => 'product_fields.field_id',
                                    'product_id' => $id,
                               ), 'product_fields.field_id AND product_id = ' . $id, "LEFT")
                        ->where($where)->orderby('fields.sort', 'asc')->get();


            }

            if($this->template->content->item->source == 1 && $this->template->content->item->searchingId){

                $table = "products";
                $where = "product_id = " . $this->template->content->item->searchingId . " and firm_id = " . $this->firmID;
                $this->template->content->relative = $this->db->select('*')->from($table)->
                        where($where)->get();
                $this->template->content->relative = $this->template->content->relative[0];
            }
 
        }else{
            Event::run('system.404');
        }

    }






    public function satellite() {

        $id = intval($this->uri->segment('id'));

        if (!empty($_FILES)) {
            $this->uploader($id);
            exit();
        }

        if(!$this->haveAccess()){
            return;
        };



        $this->template->content = new View('products/satellite');
        $this->selected_subpage = null;

        $table = "products";
        $where = "product_id = " . $id . " and firm_id = " . $this->firmID;

        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();

        if($this->template->content->item){

            $this->id = $id;
            $this->template->content->item = $this->template->content->item[0];

            $this->forMenu();

            $this->template->title = 'Сопутствующие товары для «' . ($this->template->content->item->title) . '»';

            if($this->template->content->item->source == 1 && $this->template->content->item->searchingId){
                $id = $this->template->content->item->searchingId;
                $this->template->content->item->product_id = $this->template->content->item->searchingId;
            }

            $addsatellite = intval($this->uri->segment('addsatellite'));

            if($addsatellite > 0){

                $table = "products";
                $where = "product_id = " . $addsatellite . " and firm_id = " . $this->firmID;

                $check = $this->db->select('product_id')->from($table)->
                        where($where)->get();

                if(empty($check)){
                    $this->error = "Выбранный вами сопутствующий товар не найден.";
                }else{

                    $data = array(
                        'satellite_product' => $addsatellite,
                        'product' => $this->id,
                        'firm_id' => $this->firmID 
                    );
                    
                    $status = $this->db->insert('satellites', $data);

                    if(count($status)){

                        url::redirect(url::site() . "products/satellite/catid/" . $this->template->content->item->cat_id .
                              "/catssubid/" . $this->template->content->item->catsub_id . "/id/" . $id .'?newSatellite');
                         
                        exit();
                    }
                }
            }

 
            $deleteSatellite = intval($this->uri->segment('deletesatellite'));

            if($deleteSatellite > 0){

                $status = $this->db->delete('satellites', array(
                              'satellite_product' => $deleteSatellite,
                              'product' => $this->id,
                              'firm_id' => $this->firmID )
                );

                if(count($status)){

                    url::redirect(url::site() . "products/satellite/catid/" . $this->template->content->item->cat_id .
                              "/catssubid/" . $this->template->content->item->catsub_id . "/id/" . $id .'?satelliteDroped'); 
                    exit();
                }else{
                    Event::run('system.404');
                }

            }
 
            $table = "satellites";
            $where = "satellites.product = " . $id  . " and satellites.firm_id = " . $this->firmID ;
            $this->satellites = $this->db->select('*')->from($table)
                    ->join('products', 'products.product_id',
                           'satellites.satellite_product')
                    ->where($where)->orderby('products.title', 'asc')->get();


            if ($_POST){

                $satellite = @trim($_POST['product']['satellite']);

                if(empty($satellite)){
                    $this->error = "К сожалению, по вашему запросу ничего не найдено так как не указанно что именно искать.";
                }

                $this->template->title = 'Результат поиска сопутствующих товаров для «' . ($this->template->content->item->title) . '» по запросу «' . $satellite . '»';
                $SQL = "select * from `products` where (`title` like '%" . mysql_escape_string($satellite).
                       "%' OR `desc` like '%" . mysql_escape_string($satellite). 
                       "%' OR product_id = " . intval($satellite). ") AND firm_id = " . $this->firmID .
                       ' order by title limit 20';
 
                $this->template->content->satelliteResult = $this->db->query($SQL);
 
                if(!count($this->template->content->satelliteResult)){
                    $this->info = "К сожалению, по вашему запросу ничего не найдено.";
                } 
            }

        } else{
            Event::run('system.404');
        }
    }




    public function recommend() {

        $id = intval($this->uri->segment('id'));

        if (!empty($_FILES)) {
            $this->uploader($id);
            exit();
        }

        if(!$this->haveAccess()){
            return;
        };

        $this->template->content = new View('products/recommend');
        $this->selected_subpage = null;

        $table = "products";
        $where = "product_id = " . $id . " and firm_id = " . $this->firmID;

        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();

        if($this->template->content->item){

            $this->id = $id;
            $this->template->content->item = $this->template->content->item[0];

            $this->forMenu();

            $this->template->title = 'Рекомендованные товары для «' . ($this->template->content->item->title) . '»';


            if($this->template->content->item->source == 1 && $this->template->content->item->searchingId){
                $id = $this->template->content->item->searchingId;
                $this->template->content->item->product_id = $this->template->content->item->searchingId;
            }

            $addsatellite = intval($this->uri->segment('addrecommend'));

            if($addsatellite > 0){

                $table = "products";
                $where = "product_id = " . $addsatellite . " and firm_id = " . $this->firmID;

                $check = $this->db->select('product_id')->from($table)->
                        where($where)->get();

                if(empty($check)){
                    $this->error = "Выбранный вами рекомендованный товар не найден.";
                }else{

                    $data = array(
                        'recommend_product' => $addsatellite,
                        'product' => $this->id,
                        'firm_id' => $this->firmID
                    );

                    $status = $this->db->insert('recommends', $data);

                    if(count($status)){

                        url::redirect(url::site() . "products/recommend/catid/" . $this->template->content->item->cat_id .
                              "/catssubid/" . $this->template->content->item->catsub_id . "/id/" . $id .'?newRecommend');

                        exit();
                    }
                }
            }


            $deleteSatellite = intval($this->uri->segment('deleterecommend'));

            if($deleteSatellite > 0){

                $status = $this->db->delete('recommends', array(
                              'recommend_product' => $deleteSatellite,
                              'product' => $this->id,
                              'firm_id' => $this->firmID )
                );

                if(count($status)){

                    url::redirect(url::site() . "products/recommend/catid/" . $this->template->content->item->cat_id .
                              "/catssubid/" . $this->template->content->item->catsub_id . "/id/" . $id .'?recommendDroped');
                    exit();
                }else{
                    Event::run('system.404');
                }

            }

            $table = "recommends";
            $where = "recommends.product = " . $id  . " and recommends.firm_id = " . $this->firmID ;
            $this->satellites = $this->db->select('*')->from($table)
                    ->join('products', 'products.product_id',
                           'recommends.recommend_product')
                    ->where($where)->orderby('products.title', 'asc')->get();


            if ($_POST){

                $satellite = @trim($_POST['product']['recommend']);

                if(empty($satellite)){
                    $this->error = "К сожалению, по вашему запросу ничего не найдено так как не указанно что именно искать.";
                }

                $this->template->title = 'Результат поиска рекомендованных товаров для «' . ($this->template->content->item->title) . '» по запросу «' . $satellite . '»';
                $SQL = "select * from `products` where (`title` like '%" . mysql_escape_string($satellite).
                       "%' OR `desc` like '%" . mysql_escape_string($satellite).
                       "%' OR product_id = " . intval($satellite). ") AND firm_id = " . $this->firmID .
                       ' order by title limit 20';

                $this->template->content->satelliteResult = $this->db->query($SQL);

                if(!count($this->template->content->satelliteResult)){
                    $this->info = "К сожалению, по вашему запросу ничего не найдено.";
                }
            }

        } else{
            Event::run('system.404');
        }
    }





    public function productcopy() {

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));

        $table = "products";
        $where = "product_id = " . $id . " and firm_id = " . $this->firmID;

        $this->item = $this->db->select('*')->from($table)->
                where($where)->get();

        $this->item = $this->item[0];
        
        if($this->item){


 
            $dataUser['title'] = 'Копия ' . $this->item->title;
            $dataUser['cat_id'] = $this->item->cat_id;
            $dataUser['catsub_id'] = $this->item->catsub_id;
            
            $dataUser['price'] = $this->item->price;
            $dataUser['price1'] = $this->item->price1;
            $dataUser['price2'] = $this->item->price2;
            $dataUser['price3'] = $this->item->price3;
            $dataUser['price4'] = $this->item->price4;
            $dataUser['price5'] = $this->item->price5;

            $dataUser['desc'] = $this->item->desc;
            $dataUser['desc_mini'] = $this->item->desc_mini;

            $dataUser['discount'] = $this->item->discount;
            $dataUser['weight'] = $this->item->weight;

            if(preg_match("/(копия [0-9]{5})/", $this->item->arcitule)){
                $dataUser['arcitule'] = substr($this->item->arcitule, 0, -6) . sprintf("%05s", rand(0,99999)) . ')';
            }else{
                $dataUser['arcitule'] = $this->item->arcitule . ' (копия ' . sprintf("%05s", rand(0,99999)) . ')';
            }

            $dataUser['searchingId'] = $this->item->searchingId;
            $dataUser['source'] = $this->item->source;
            $dataUser['replace'] = $this->item->replace;
            $dataUser['replace_to'] = $this->item->replace_to;

            $dataUser['new'] = $this->item->new;
            $dataUser['week'] = $this->item->week;
            $dataUser['unic'] = $this->item->unic;
            $dataUser['counter'] = $this->item->counter;
            $dataUser['metric'] = $this->item->metric;
            $dataUser['status'] = STATUS_HIDE;
  
            $dataUser['moder_id'] = $this->moderId; 
            $dataUser['firm_id'] = $this->firmID;

            $dataUser['url_link'] = format::do_latin($dataUser['title']);

            $status = $this->db->insert('products', $dataUser); 
            $newID = $status->insert_id();
 

            if($this->item->source == 0){

                $table = "product_fields";
                $where = "product_id = " . $id   ;
                $this->fields = $this->db->select('*')->from($table)
                        ->where($where)->get();

                foreach ($this->fields as $item) {

                    $content = array(
                        "field_value" => trim($item->field_value),
                        "field_id" => $item->field_id,
                        "product_id" => $newID,
                    );

                    $this->db->insert('product_fields', $content);

                }

                $table = "product_imgs";
                $where = "product_id = " . $id   ;
                $this->imgs = $this->db->select('*')->from($table)
                        ->where($where)->get();

                foreach ($this->imgs as $item) {

                    $content = array(
                        "product_id" => $newID,
                        "favorite" => $item->favorite,
                        "img_size" => $item->img_size,
                        'firm_id' => $this->firmID
                    );

                    $status = $this->db->insert('product_imgs', $content);
                    if(count($status)){

                        $imageId = $status->insert_id();

                        $sourceFile = SuperPath::get($item->id. ".jpg")  ;
                        $targetFile = SuperPath::get($imageId. ".jpg")  ;
                        copy($sourceFile, $targetFile);

                        $sourceFile = SuperPath::get($item->id. "m.jpg")  ;
                        $targetFile = SuperPath::get($imageId. "m.jpg")  ;
                        copy($sourceFile, $targetFile);

                        $sourceFile = SuperPath::get($item->id. "b.jpg")  ;
                        $targetFile = SuperPath::get($imageId. "b.jpg")  ;
                        copy($sourceFile, $targetFile);

                    }
                }
            }
            
            url::redirect(url::site() . "products/edit/catid/" . $this->item->cat_id .
                "/catssubid/" . $this->item->catsub_id . "/id/" . $newID .'?copied');
            exit();
        
		} else{
            Event::run('system.404');
        }

    }

    public function ajax() {

        if(!$this->haveAccess()){
            return;
        };

        $searching = trim($_REQUEST['term']);
        $id = intval($this->uri->segment('id'));

        $return_arr = array();

        $table = "products";
        $where = "source = 0 and status in (" . STATUS_WORK . ") and firm_id = ". $this->firmID. " and product_id != ". $id. " and (title like '%" . mysql_escape_string($searching) . "%' or arcitule like '%" . mysql_escape_string($searching) . "%')" ;
        $this->fields = $this->db->select('*')->from($table)
                ->where($where)->limit(10)->get();

        foreach ($this->fields as $item) {

            $content = array(
                "value" => trim($item->title . ' (артикул: ' . $item->arcitule . ')'),
                "price" => ($item->price),
                "id" => $item->product_id
            );
            array_push($return_arr,$content); 
        }

        /* Toss back results as json encoded array. */
        echo json_encode($return_arr);
        exit();

    }
 
    public function excel() {

        if(!$this->haveAccess()){
            return;
        };

        $this->template->content = new View('products/excel');
        $this->selected_subpage = self::SUBPAGE_EXCEL;

        set_include_path(SYSPATH . 'vendor/php');

        require_once (SYSPATH . 'vendor/php/PEAR.php');
        require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Writer/BIFFwriter');
        require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Writer/Format');
        require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Writer/Parser');
        require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Writer/Validator');
        require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Writer/Workbook');
        require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Writer/Worksheet');
        require_once Kohana::find_file('vendor', '/php/Spreadsheet/Excel/Writer');


        $priceFile = SuperPath::get($this->firmID, false, IMAGES_TYPE_PRICE). ".xls"  ;

        //Creating a workbook
        $workbook = new Spreadsheet_Excel_Writer($priceFile);

        //Creating a worksheet
        $worksheet=&$workbook->addWorksheet('PriseList');

        $worksheet->setColumn(0,1,20.00);
        $worksheet->setColumn(2,2,34.00);




        $worksheet->setInputEncoding('CP1251');
        $worksheet->setLandscape();

        //Setup different styles
        $sheetTitleFormat =& $workbook->addFormat(array('bold'=>1,
                                                       'size'=>12));
        $sheetTitleAddon =& $workbook->addFormat(array('bold'=>0,  'size'=>10));
        $sheetLink =& $workbook->addFormat(
            array('Color'=>'blue',
                 'size'=>9,'textWrap'=>1,
                 'Underline'=>1));
        $sheetTitleSubAddon =& $workbook->addFormat(array('bold'=>0,
                                                         'size'=>8));
        $columnTitleFormat =& $workbook->addFormat(array('bold'=>1,

                                                        'BgColor' => 'black',
                                                        'Color' => 'white',
                                                        'size'=>9));
        $columnTitleFormatBor =& $workbook->addFormat(array('bold'=>1,

                                                           'Top' => 1,
                                                           'Bottom' => 1,
                                                           'Bold' => 1,
                                                           'Align' => 'center',
                                                           'size'=>9));

        $regularFormat =& $workbook->addFormat(array('size'=>9,  'align'=>'left',  'textWrap'=>1,  'vjustify' => 1));
        $regularFormatCenter =& $workbook->addFormat(array('size'=>9,  'align'=>'left', 'Align' => 'center', 'textWrap'=>0));

        /*Speadsheet writer is in format y,x (row, column)
         *  column1  |  column2 |  column3
         *   (0,0)      (0,1)      (0,2) */

        $column = 0;
        $row    = 0;


        $sheetTitle = iconv('UTF-8', "CP1251", 'Интернет-магазин ' . strip_tags($this->firm->title));
        $prise = iconv('UTF-8', "CP1251", strip_tags("Дата формирования прайса: ".date(DATE_FORMAT_LITE)));
        $address = iconv('UTF-8', "CP1251", strip_tags($this->firm->address));
        $WorkFlow = iconv('UTF-8', "CP1251", strip_tags($this->firm->worktime));
        $Phones = iconv('UTF-8', "CP1251", strip_tags($this->firm->tele));
        $mail = iconv('UTF-8', "CP1251", strip_tags($this->firm->mail));
        $fax = iconv('UTF-8', "CP1251", strip_tags($this->firm->fax));
        $title_firm = iconv('UTF-8', "CP1251", strip_tags($this->firm->title_firm));
        $description = iconv('UTF-8', "CP1251", strip_tags($this->firm->description));




        //Write sheet title in upper left cell
        $worksheet->write($row, $column, ($sheetTitle), $sheetTitleFormat);$row++;
        if(!empty($description)) $worksheet->write($row, $column, ($description), $sheetTitleAddon);$row++;
        $worksheet->write($row, $column, ($prise), $sheetTitleAddon);$row++;

        $worksheet->writeUrl($row, $column, 'http://'.$this->firm->domain.'/', ($this->firm->domain), $sheetLink);$row++;
        if(!empty($mail)) $worksheet->write($row, $column, ($mail), $sheetTitleSubAddon);$row++;
        if(!empty($address)) $worksheet->write($row, $column, ($address), $sheetTitleSubAddon);$row++;
        if(!empty($WorkFlow)) $worksheet->write($row, $column, ($WorkFlow), $sheetTitleSubAddon);$row++;
        if(!empty($Phones)) $worksheet->write($row, $column, ($Phones), $sheetTitleSubAddon);$row++;
        if(!empty($fax)) $worksheet->write($row, $column, ($fax), $sheetTitleSubAddon);$row++;




        $table = 'products';

        $this->groups = $this->db->select('*')->from('cats')->
                orderby('sort')->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->orderby('title')->get();

                      $this->items = $this->db->select($table.'.product_id,products.title,products.cat_id,products.desc_mini,products.source,products.price,products.price1,products.price2,products.price3,products.price4,products.price5
		  , catssub.title as subTitle, product_imgs.id as img, searchingImg.id as imgSearch')
                ->join('catssub', 'catssub.catsub_id',
                       'products.catsub_id' )
                ->join('product_imgs', array('product_imgs.product_id' => $table.'.product_id',
                                            'product_imgs.favorite' => 1), null, 'left')
                        ->join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table.'.searchingId',
                        'searchingImg.favorite' => 1), null, 'left')


                ->from($table)->where("products.firm_id = " . $this->firmID . ' and products.status = ' . STATUS_WORK)->
                groupby('products.title')->orderby(array('catssub.sort' => 'ACS', 'products.title' => 'ACS'))->get();

        foreach ($this->groups as $group) {

            $column = 0;
            $gr_title = iconv('UTF-8', "CP1251", $group->title);

            $worksheet->write($row, $column, $gr_title, $columnTitleFormat);

            $titleRow = $row;
            $titleCol = $column;


            $row++;

            $worksheet->write($row, 0, iconv('UTF-8', "CP1251", 'Подраздел'), $columnTitleFormatBor);
            $worksheet->write($row, 1, iconv('UTF-8', "CP1251", 'Название'), $columnTitleFormatBor);
            $worksheet->write($row, 2, iconv('UTF-8', "CP1251", 'Описание'), $columnTitleFormatBor);
            $worksheet->write($row, 3, iconv('UTF-8', "CP1251", 'Цена на сайте'), $columnTitleFormatBor);

            $columnDF = 4;
            if($this->firm->prices->enabled & 1 && $this->firm->prices->visible & 1){
                $worksheet->write($row, $columnDF, iconv('UTF-8', "CP1251", strip_tags($this->firm->prices->list->price1)), $columnTitleFormatBor);
                $columnDF ++;
            }
            if($this->firm->prices->enabled & 2 && $this->firm->prices->visible & 2){
                $worksheet->write($row, $columnDF, iconv('UTF-8', "CP1251", strip_tags($this->firm->prices->list->price2)), $columnTitleFormatBor);
                $columnDF ++;
            }
            if($this->firm->prices->enabled & 4 && $this->firm->prices->visible & 4){
                $worksheet->write($row, $columnDF, iconv('UTF-8', "CP1251", strip_tags($this->firm->prices->list->price3)), $columnTitleFormatBor);
                $columnDF ++;
            }
            if($this->firm->prices->enabled & 8 && $this->firm->prices->visible & 8){
                $worksheet->write($row, $columnDF, iconv('UTF-8', "CP1251", strip_tags($this->firm->prices->list->price4)), $columnTitleFormatBor);
                $columnDF ++;
            }
            if($this->firm->prices->enabled & 16 && $this->firm->prices->visible & 16){
                $worksheet->write($row, $columnDF, iconv('UTF-8', "CP1251", strip_tags($this->firm->prices->list->price5)), $columnTitleFormatBor);
                $columnDF ++;
            }

            $worksheet->setColumn(3,$columnDF,11.00);

            $worksheet->write($row, $columnDF, iconv('UTF-8', "CP1251", ''), $columnTitleFormatBor);$columnDF ++;

            $worksheet->setMerge($titleRow, 0, $titleRow, $columnDF - 1);

            $row++;

            foreach ($this->items as $item) {

                if($item->cat_id == $group->cat_id){

                    $worksheet->write($row, $column, iconv('UTF-8', "CP1251", strip_tags($item->subTitle)), $regularFormat); $column ++;
                    $model = iconv('UTF-8', "CP1251", strip_tags($item->title));

                    $worksheet->writeUrl($row, $column, 'http://'.$this->firm->domain.'/products/item/id/'.$item->product_id, $model , $sheetLink);$column ++;
                    // $worksheet->write($row, $column, iconv('UTF-8', "CP1251", strip_tags($item->desc_mini)), $regularFormat); $column ++;
                    $worksheet->write($row, $column, iconv('UTF-8', "CP1251", strip_tags($item->desc_mini)), $regularFormat); $column ++;

                    $worksheet->write($row, $column, iconv('UTF-8', "CP1251", money::ru($item->price)), $regularFormatCenter); $column ++;

                    if($this->firm->prices->enabled & 1 && $this->firm->prices->visible & 1){
                        $worksheet->write($row, $column, iconv('UTF-8', "CP1251", money::ru($item->price1)), $regularFormatCenter); $column ++;
                    }
                    if($this->firm->prices->enabled & 3 && $this->firm->prices->visible & 3){
                        $worksheet->write($row, $column, iconv('UTF-8', "CP1251", money::ru($item->price2)), $regularFormatCenter); $column ++;
                    }
                    if($this->firm->prices->enabled & 4 && $this->firm->prices->visible & 4){
                        $worksheet->write($row, $column, iconv('UTF-8', "CP1251", money::ru($item->price3)), $regularFormatCenter); $column ++;
                    }
                    if($this->firm->prices->enabled & 8 && $this->firm->prices->visible & 8){
                        $worksheet->write($row, $column, iconv('UTF-8', "CP1251", money::ru($item->price4)), $regularFormatCenter); $column ++;
                    }
                    if($this->firm->prices->enabled & 16 && $this->firm->prices->visible & 16){
                        $worksheet->write($row, $column, iconv('UTF-8', "CP1251", money::ru($item->price5)), $regularFormatCenter); $column ++;
                    }

                    if($item->source == 0){
                        $sourceFile = SuperPath::get($item->img). "m.jpg"  ;
                        $targetFile = SuperPath::get($item->img). ".bmp"  ;
                    }else{
                        $sourceFile = SuperPath::get($item->imgSearch). "m.jpg"  ;
                        $targetFile = SuperPath::get($item->imgSearch). ".bmp"  ;
                    }



                    if(!file_exists($sourceFile)){
                        $cmd_command = ('convert -depth 24 rgb:image ' . escapeshellarg($sourceFile).' ' . escapeshellarg($targetFile));
                        $this->exec($cmd_command);
                    }

                    if(file_exists($targetFile)){ 
                        $worksheet->setRow($row, 90);
                        $worksheet->insertBitmap($row, $column, $targetFile, 0.2);
                    }else{
                        $worksheet->write($row, $column, '-', $regularFormatCenter);
                    }

                    $row++;
                    $column = 0;
                }
            }
            $row++;
        }

        $workbook->close();


        $zipFile = SuperPath::get($this->firmID, false, IMAGES_TYPE_PRICE). ".zip"  ;

        if($GLOBALS['runningOn'] != '1'){

            if(file_exists($priceFile)){
                rename($priceFile, '/tmp/price.xls');
            }

             if(file_exists($zipFile)) {
                 unlink($zipFile);
             }

             $sys_command = 'zip -mj9 '.$zipFile.' /tmp/price.xls';
             exec($sys_command);
        }

         url::redirect(url::site() . "products/?priceUpdated");
    }

} 