<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * API для работы с манагизом
 * @package    Notify
 * @author     Ivan Chura
 */

class API_Controller  extends Template_Controller {

    const ERROR_DB = '042';
    const ERROR_PARAM = '023';
    const ERROR_NOT_FIND = '033';
    const ERROR_API_KEY = '053';
    const ERROR_CHECK_SUM = '063';

    public function __construct() {

        Kohana::config('common.php');

        $this->db = new Database();
        $this->input = new Input();

        $this->result = new stdClass();
 
        if($_SERVER['REQUEST_URI'] != '/api/'){

            if(!isset($_REQUEST['key']) || !isset($_REQUEST['checksum'])){
                $this->sendResult('Error:#'.self::ERROR_PARAM . ' (Empty checksum or key)');
            }

            $api_key = trim($_REQUEST['key']);


            $table = "firms";
            $firm = $this->db->select('id')->from($table)->
                    where(array('api_key' => $api_key))->get();
            $firm = $firm[0];

            if($firm){
                $this->firmID = $firm->id;
            }else{
                $this->sendResult('Error:#'.self::ERROR_API_KEY . ' (Wrong API Key)');
            }

            $parameters = ($_REQUEST);
            ksort($parameters);
            $gotSum = $parameters['checksum'];
            unset($parameters['checksum']);
			 
            $checkSum = md5(implode($parameters,""));

            if($gotSum != $checkSum){
                $this->sendResult('Error:#'.self::ERROR_CHECK_SUM . ' (Wrong Check Sum)');
            }

        }
 
        $this->accessRules = array(
            'index' => ACCESS_GUEST + ACCESS_ADMIN + ACCESS_MODER +ACCESS_VIEWER,
        ); 
    }


    public function index(){

        $this->template = 'public/template';
        $this->access = ACCESS_GUEST;

        parent::__construct();

        $this->template->content = new View('public/api');

        $this->template->title = 'API Интернет-магазина';

        $this->selected_page = PAGE_API;

    }

    /**
     * @return void http://shopping-plaza.loc/api/cats?desc=0
     */

    public function cats() {

        $desc = @intval($_REQUEST['desc']);

        $table = 'catssub';
        $this->groupssub = $this->db->select('catssub.sort, catssub.catsub_id, catssub.cat_id, catssub.relatedId, catssub.title' . ($desc ? ', catssub.desc':''))->from($table)->
                join('cats', array(
                                  'cats.cat_id' => 'catssub.cat_id',
                                  'cats.status' => STATUS_WORK))->
                where("catssub.firm_id = " . $this->firmID . ' and catssub.status = '. STATUS_WORK)->
                orderby('catssub.sort')->orderby('catssub.title')->get();

        $this->result->subgroups = array();
        $this->result->groups = array();

        if(count($this->groupssub)) {
            foreach ($this->groupssub as $key_SUB ){
                $this->result->subgroups[$key_SUB->catsub_id] = $key_SUB;
            }
        }

        $table = 'cats';
        $this->groupsR = $this->db->select('sort, relatedId,cat_id, title' . ($desc ? ', desc':''))->from($table)->
                where("cats.firm_id = " . $this->firmID . ' and cats.status = '. STATUS_WORK)->
                orderby('cats.sort')->orderby('cats.title')->get();

        if(count($this->groupsR)) {
            foreach ($this->groupsR as $key_SUB ){
                $this->result->groups[$key_SUB->cat_id] = $key_SUB;
            }
        }

        $this->sendResult();

    }

    /**
     * @return void http://shopping-plaza.loc/api/catsdelete?id=14
     */
    public function catsdelete() { //////// TODO чтото тут дофига всего

        $id = @intval($_REQUEST['id']);

        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        $status = $this->db->update('cats', array('status'=> STATUS_DELETED), array('cat_id' => $id,'firm_id' => $this->firmID ));

        if(count($status)){
            $this->result = 'Ok';
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }


    private function sendResult($response = null) {

        if(!is_null($response)){
            $this->result = $response;
        }

        echo json_encode($this->result); exit();
    }

    /**

    $params = array(
    // (integer) Номер редактируемой группы
    'id' => '133',
    // (string) Заголовок
    'title' => 'Тестовая группа',
    // (string) Описание <не обязательное поле>
    'desc' => 'Описание тестовой группы, можно с HTML',
    // (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
    'sort' => '13',
    );

    $url = 'http://shopping-plaza.loc/api/catsedit?';
     *
     */
    public function catsedit() {

        $id = @intval($_REQUEST['id']);
        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        $data['title'] =  @trim($_REQUEST['title']);
        if(empty($data['title'])){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' Название');
        }else{

            if(strlen($data['title']) > 55){
                $this->sendResult('Error:#'.self::ERROR_PARAM. ' Название - содержит больще 55 символов');
            }

        }

        if(array_key_exists('desc', $_REQUEST)){
            $data['desc'] =  @trim($_REQUEST['desc']);
        }
        if(array_key_exists('sort', $_REQUEST)){
            $data['sort'] =  @intval($_REQUEST['sort']);
        }
        $data['firm_id'] = $this->firmID;

        if(array_key_exists('sort', $_REQUEST)){
            $this->db->query('UPDATE cats SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);;
        }

        $data['url_link'] = format::do_latin($data['title']);
        $status = $this->db->update('cats', $data, array('cat_id' => $id, 'firm_id' => $this->firmID ));

        if(count($status)){
            $this->result = 'Ok';
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }

/*
$params = array(
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с <b>HTML</b>',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
);

$url = 'http://shopping-plaza.loc/api/catsadd?';
 */
    public function catsadd() {

        $dataUser['relatedId'] = @trim($_REQUEST['relatedId']);
        $dataUser['title'] = @trim($_REQUEST['title']);
        $dataUser['desc'] = @trim($_REQUEST['desc']);
        $dataUser['sort'] = @intval($_REQUEST['sort']);
        $dataUser['firm_id'] = $this->firmID;
        $dataUser['status'] = STATUS_WORK;

        if(empty($dataUser['title'])){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' Название');
        }else{
            if(strlen($dataUser['title']) > 55){
                $this->sendResult('Error:#'.self::ERROR_PARAM. ' Название - содержит больще 55 символов');
            }
        }

        $this->db->query('UPDATE cats SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $dataUser['sort']);;

        $dataUser['url_link'] = format::do_latin($dataUser['title']);

        $status = $this->db->insert('cats', $dataUser);
        if(count($status)){
            $this->result = 'Ok:#' . $status->insert_id();
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }















    /**
     * @return void http://shopping-plaza.loc/api/catssubdelete?id=14
     */
    public function catssubdelete() {

        $id = @intval($_REQUEST['id']);

        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        $status = $this->db->update('catssub', array('status'=> STATUS_DELETED), array('cat_id' => $id,'firm_id' => $this->firmID ));

        if(count($status)){
            $this->result = 'Ok';
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }



    /**

    $params = array(
    // (integer) Номер редактируемой группы
    'id' => '133',
    // (string) Заголовок
    'title' => 'Тестовая группа',
    // (integer) Номер основной группы, если надо перенести <не обязательное поле>
    'cat_id' => '1',
    // (string) Описание <не обязательное поле>
    'desc' => 'Описание тестовой группы, можно с HTML',
    // (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
    'sort' => '13',
    );

    $url = 'http://shopping-plaza.loc/api/catssubedit?';
     *
     */
    public function catssubedit() {

        $id = @intval($_REQUEST['id']);
        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        $data['title'] =  @trim($_REQUEST['title']);

        if(empty($data['title'])){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' Название');
        }


        if(array_key_exists('desc', $_REQUEST)){
            $data['desc'] =  @trim($_REQUEST['desc']);
        }
        if(array_key_exists('sort', $_REQUEST)){
            $data['sort'] =  @intval($_REQUEST['sort']);
        }
        if(array_key_exists('cat_id', $_REQUEST)){
            $data['cat_id'] =  @intval($_REQUEST['cat_id']);
        }
        $data['firm_id'] = $this->firmID;

        if(array_key_exists('sort', $_REQUEST)){
            $this->db->query('UPDATE catssub SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);;
        }

        $data['url_link'] = format::do_latin($data['title']);
        $status = $this->db->update('catssub', $data, array('catsub_id' => $id, 'firm_id' => $this->firmID ));

        if(count($status)){
            $this->result = 'Ok';
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }

/*
$params = array(
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с <b>HTML</b>',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
	// (integer) Номер основной группы
	'cat_id' => '13',
);

$url = 'http://shopping-plaza.loc/api/catssubadd?';
 */
    public function catssubadd() {

        $dataUser['relatedId'] = @trim($_REQUEST['relatedId']);
        $dataUser['title'] = @trim($_REQUEST['title']);
        $dataUser['desc'] = @trim($_REQUEST['desc']);
        $dataUser['sort'] = @intval($_REQUEST['sort']);
        $dataUser['cat_id'] = @intval($_REQUEST['cat_id']);
        $dataUser['firm_id'] = $this->firmID;
        $dataUser['status'] = STATUS_WORK;

        if(empty($dataUser['title'])){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' title');
        }else{
            if(strlen($dataUser['title']) > 55){
                $this->sendResult('Error:#'.self::ERROR_PARAM. ' title');
            }
        }

        if(empty($dataUser['cat_id'])){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' cat_id');
        }

        $this->db->query('UPDATE cats SET sort = sort + 1 WHERE firm_id = ' . $this->firmID . " and sort >=  " . $dataUser['sort']);;

        $dataUser['url_link'] = format::do_latin($dataUser['title']);

        $status = $this->db->insert('catssub', $dataUser);
        if(count($status)){
            $this->result = 'Ok:#' . $status->insert_id();
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }




/*

$params = array(
	// (integer) Заголовок <не обязательное поле>
	'type' => '2',
	// (integer) Дата с <не обязательное поле>
	'dateFrom' => '23314422',
	// (integer) Дата по <не обязательное поле>
	'dateTill' => '23314422',
);

$url = 'http://shopping-plaza.loc/api/orders?';



 [orders] => stdClass Object
        (
            [264] => stdClass Object
                (
                    [id] => 264
                    [date] => 2012-03-25 22:54:45
                    [total] => 700
                    [status] => 3
                )



*/
    public function orders() {

        $this->status = @intval($_REQUEST['status']);
        $this->dateFrom = @intval($_REQUEST['dateFrom']);
        $this->dateTill = @intval($_REQUEST['dateTill']);

        $table = 'order';
        $where = '1=1 and order.firm_id = ' . $this->firmID .
                 (!empty($this->status) ? " and order.status = " . $this->status : "") .
                 (!empty($this->dateFrom) ? " and order.date >= '" . $this->db->escape_str(date('Y-m-d H:i:s', $this->dateFrom))."'" : "") .
                 (!empty($this->dateTill) ? " and order.date <= '" . $this->db->escape_str(date('Y-m-d H:i:s', $this->dateTill))."'" : "") .

                 '';


        $items = $this->db->select(
            'id, date, total, status, relatedId')->from($table)->
                where($where)->limit(150)->orderby('id', 'desc')->get();


        $this->result->orders = array();

        if(count($items)) {
            foreach ($items as $item ){
                $this->result->orders[$item->id] = $item;
            }
        }

        $this->sendResult();
    }





/*

$params = array(
	// (integer) Номер заказа
	'id' => '211',
);

$url = 'http://shopping-plaza.loc/api/orderinfo?';


Class Object
(
    [order] => stdClass Object
        (
            [id] => 211
            [date] => 2011-12-06 12:57:28
            [total] => 3300
            [count] => 1
            [status] => 8
            [devivery] => 7
            [payment] => Банковский перевод
            [user_mail] => conference@pochta.ru
            [delivery] => «Почтой России» по России
            [delivery_cost] => 450
            [statusStr] => Оплаченный
        )

    [deliveryInfo] => stdClass Object
        (
            [soname] => Волобуев
            [name] => Алексей
            [thirdName] => Сергеевич
            [mail] => conference@pochta.ru
            [phone] => 8-911-115-88-00
            [index] => 197372
            [region] => РФ
            [city] => Санкт-Петербург
            [street] => Планерная
            [house] => 23
            [houseAddOn] => 1
            [podiezd] =>
            [apr] => 94
            [domoph] => Есть
            [comment] =>
        )

    [paymentInfo] => stdClass Object
        (
        )

    [items] => Array
        (
            [0] => stdClass Object
                (
                    [title] => Автомобильный видеорегистратор КАРКАМ K2000
                    [price] => 4000
                    [status] => 1
                    [arcitule] => SP-Carcam-200-K20001-1
                    [product_id] => 210
                    [currentPrice] => 4000
                    [statusStr] => На сайте
                    [ref_id] => 332
                )

        )

    [comments] => Array
        (
            [0] => stdClass Object
                (
                    [manager] => Савельев Сергей
                    [comment_id] => 52
                    [date] => 2012-03-28 22:30:41
                    [content] => Содержание комментария
                )

            [1] => stdClass Object
                (
                    [manager] => Савельев Сергей
                    [comment_id] => 51
                    [date] => 2012-03-28 22:30:36
                    [content] => order
                )

        )

)


 
 */
    public function orderinfo() {

        $id = @intval($_REQUEST['id']);
        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        $table = "order";
        $where = "order.id = " . $id . " and order.firm_id = " . $this->firmID;

        $this->result->order = $this->db->
                select($table.'.*, pay_type.title as payment, delivery.title as delivery, delivery.cost as delivery_cost
                , pay_type.field_type as field_type_pay, delivery.type as field_type_devivery')->from($table)->
                join("pay_type", 'pay_type.pay_id', 'order.payment', 'left')->
                join("delivery", 'delivery.del_id', 'order.devivery', 'left')->
                where($where)->get();

        $this->result->order = $this->result->order[0];

        if($this->result->order){

            $this->result->deliveryInfo = json_decode($this->result->order->deliveryInfo);
            $this->result->paymentInfo = json_decode($this->result->order->paymentInfo);

            $this->result->order->statusStr = $GLOBALS['ORDER_STATUS'][$this->result->order->status];

            $where = "order_id = " . $id ;


            $items = $this->db->select('
            products.title,
            products.price,
            products.status,
            products.arcitule, 
            products.relatedId,

             products.product_id as product_id,  product_cost.coster as costerFM')->from("order_items")->
                    join("products", 'products.product_id', 'order_items.it_id', 'left')->

                    join('product_cost', array('product_cost.product_id' => 'products.product_id'), null, 'left')->
                    join('order', array('order.id' => 'order_items.order_id') )->

                    where($where )->orderby('products.title', 'acs')->orderby('product_cost.date', 'acs')->groupby('products.product_id')->get();

            $this->result->items = array();

            if(count($items)) {
                foreach ($items as $item ){
                    $item->currentPrice = $item->price;
                    $item->price = ($item->costerFM) ? $item->price : $item->costerFM;
                    unset($item->costerFM);
                    $item->statusStr = $GLOBALS['ITEM_STATUS'][$item->status];
                    $this->result->items[] = $item;
                }
            }


            $this->result->comments = array();
            $comments = $this->db->select('moders.user_name as manager,  comments.comment_id, comments.date, comments.content')->from("comments")->
                    join("moders", 'moders.user_id', 'comments.moder_id', 'left')->
                    where($where)->orderby('date', 'desc')->get();
            if(count($comments)) {
                foreach ($comments as $item ){
                    $this->result->comments[] = $item;
                }
            }

            unset($this->result->order->paymentInfo);
            unset($this->result->order->deliveryInfo);
            unset($this->result->order->moder_id);
            unset($this->result->order->firm_id);
            unset($this->result->order->ip);
            unset($this->result->order->field_type_pay);
            unset($this->result->order->field_type_devivery);

            $this->sendResult();

        }else{
            $this->sendResult('Error:#'.self::ERROR_NOT_FIND);
        }

    }






	public function orderadd() {


        $dataUser['relatedId'] = @trim($_REQUEST['relatedId']);
        $dataUser['title'] = @trim($_REQUEST['title']);
        $dataUser['desc'] = @trim($_REQUEST['desc']);
        $dataUser['sort'] = @intval($_REQUEST['sort']);
        $dataUser['firm_id'] = $this->firmID;
        $dataUser['status'] = STATUS_WORK;




        $id = @intval($_REQUEST['id']);
        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

		$user_data['relatedId'] = date('Y-m-d H:i:s'); // TODO
		$user_data['date'] = date('Y-m-d H:i:s');
		$user_data['total'] = 0;
		$user_data['ip'] = $this->input->ip_address();
		$user_data['firm_id'] = $this->firmID;

		$user_data['devivery'] = 0;
		$user_data['payment'] = 0;
		$user_data['status'] = ORDER_STATUS_NEW;

		$deliveryInfo = new stdClass();
		$deliveryInfo->name = $_GET['name'];
		$deliveryInfo->phone = $_GET['phone'];

		$user_data['paymentInfo'] = json_encode($deliveryInfo);
		$user_data['deliveryInfo'] = '';

		$items =  $_GET['items'];;
		$this->data = $user_data;



		$res = $this->db->insert('order', $user_data);

		if($res){

			$this->order_id = $res->insert_id();

			$table = 'order_items';

			if(count($items) > 0){

				$total = 0;
				foreach ($items as $key => $value ){

					$data = array();

					$data['order_id'] = $this->order_id;
					$data['count'] = $value->counter;
					$data['it_id'] =  $key;

					$total += $value->counter * $value->price;

					$this->db->insert('order_items', $data);
					// $this->db->query("update products set counter = counter - " . $value->counter . " where product_id = " . $key);

				}

				$data = array(
					'total' => $total,
					'count' => count($items)
				);

				$this->db->update('order', $data, 'id = '. $this->order_id);

			}
		}



        if($this->result->order){


            $this->sendResult();

        }else{
            $this->sendResult('Error:#'.self::ERROR_NOT_FIND);
        }

    }

/*


 $params = array(
	// (integer) Номер заказа
	'catssubid' => '23',
	// (integer) Номер заказа
	'catid' => '23',
	// (integer) Номер заказа
	'id' => '23',
);

$url = 'http://shopping-plaza.loc/api/products?';

    [products] => stdClass Object
        (
            [40] => stdClass Object
                (
                    [product_id] => 40
                    [title] => MicroSD 16GB
                    [price] => 1100
                    [cat_id] => 29
                    [catsub_id] => 23
                    [desc_mini] => Карта памяти MicroSD с SD переходником
                    [url_link] => MicroSD_16GB
                    [status] => 1
                    [arcitule] => 40
                    [source] => 0
                    [img] => http://static.shopping-plaza.loc/products/00/00/00/263.jpg
                    [imgSearch] =>
                )
 * 
 */

    public function products() {

        $desc = @intval($_REQUEST['desc']);
        $origImage = @intval($_REQUEST['origImage']);

        $this->catid = @intval($_REQUEST['catid']);
        $this->catssubid = @intval($_REQUEST['catssubid']);
        $this->id = @intval($_REQUEST['id']);

        $table = 'products';
        $where = '1=1 and '.$table.'.firm_id = ' . $this->firmID . ' and '.$table.'.status = ' . STATUS_WORK.
                 (!empty($this->catid) ? " and products.cat_id = " . $this->catid : "") .
                 (!empty($this->catssubid) ? " and products.catsub_id = " . $this->catssubid : "") .
                 (!empty($this->id) ? " and products.product_id = " . $this->id : "") .

                 '';

        $this->result->products = array();

        $this->items = $this->db->select(
            'products.product_id, '.
            'products.title, '.
            'products.price, '.
            'products.price1, '.
            'products.price2, '.
            'products.price3, '.
            'products.price4, '.
            'products.price5, '.
            'products.cat_id, '.
            'products.catsub_id, '.
            'products.desc_mini, '.
            'products.status, '.  ($desc ? 'products.desc, ':'') .
            'products.arcitule, '.
            'products.counter, '.
            'products.relatedId, '. 
            'products.source, '.  
            'products.searchingId, '.
            'product_imgs.id as img, searchingImg.id as imgSearch')->from($table)->


					join('cats', array('cats.cat_id' => $table.'.cat_id', 'cats.status' => STATUS_WORK))->
					join('catssub', array('catssub.catsub_id' => $table.'.catsub_id', 'catssub.status' => STATUS_WORK))->
                
                join('product_imgs', array('product_imgs.product_id' => $table.'.product_id',
                                          'product_imgs.favorite' => 1), null, 'left')->

                join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table.'.searchingId',
                                                         'searchingImg.favorite' => 1), null, 'left')->

                where($where)->orderby('product_id', 'acs') ->get();

        require Kohana::find_file('vendor', 'SuperPath');

        if(count($this->items)) {
            foreach ($this->items as $item ){

                $item->imgId = $item->img;
                $item->img = SuperPath::get($item->source == 0 ? $item->img : $item->imgSearch, true).($origImage ? 'orig' : '').'.jpg';
                $item->statusStr = $GLOBALS['ITEM_STATUS'][$item->status];

                $this->result->products[$item->product_id] = $item;
            }
        }


        $this->sendResult();
    }






    /*



$params = array(
	// (integer) Номер заказа
	'id' => '198',
);

$url = 'http://shopping-plaza.loc/api/productinfo?';

     




    [product] => stdClass Object
        (
            [product_id] => 198
            [title] => Автомобильный видеорегистратор Aikitec Carkit DVR-07HD Lite
            [price] => 1500
            [desc] => <b style="">Комплект поставки
            [cat_id] => 28
            [catsub_id] => 26
            [desc_mini] => Обзор 120°, TFT-экран 2.5", SD до 64 ГБ, miniUSB выход
            [status] => 1
            [arcitule] => SP-DVR-127-Aikitec
            [source] => 1
            [searchingId] => 372
            [img] => http://static.shopping-plaza.loc/products/00/00/02/2736.jpg
            [imgSearch] => 2736
            [statusStr] => На сайте
        )

    [fields] => Array
        (
            [0] => stdClass Object
                (
                    [field_id] => 153
                    [field_value] =>
                    [field_title] => Матрица
                ) 
        )

    [imgs] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 2729
                    [img] => http://static.shopping-plaza.loc/products/00/00/02/2729.jpg
                )



     */

    public function productinfo() {


        $id = @intval($_REQUEST['id']);
        $origImage = @intval($_REQUEST['origImage']);
        
        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }


        $table = 'products';
        $where = '1=1 and '.$table.'.firm_id = ' . $this->firmID . " and products.product_id = " . $id  .

                 '';

        $this->result->product = array();

        $this->items = $this->db->select(
            'products.product_id, '.
            'products.title, '.
            'products.price, '.
            'products.price1, '.
            'products.price2, '.
            'products.price3, '.
            'products.price4, '.
            'products.price5, '.
            'products.counter, '. // TODO
            'products.desc, '.
            'products.cat_id, '.
            'products.catsub_id, '.
            'products.desc_mini, '.
            'products.status, '.
            'products.arcitule, '.
            'products.source, '.
            'products.searchingId, '.
            'products.relatedId, '.
            'product_imgs.id as img, searchingImg.id as imgSearch')->from($table)->
                join('product_imgs', array('product_imgs.product_id' => $table.'.product_id',
                                          'product_imgs.favorite' => 1), null, 'left')->

                join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table.'.searchingId',
                                                         'searchingImg.favorite' => 1), null, 'left')->

                where($where)->orderby('title', 'acs')->get();

        require Kohana::find_file('vendor', 'SuperPath');

        if(count($this->items)) {
            foreach ($this->items as $item ){

                $item->img = SuperPath::get($item->source == 0 ? $item->img : $item->imgSearch, true).($origImage ? 'orig' : '').'.jpg';

                if($item->source != 0){
                    $sql = 'select products.desc from products where product_id = ' . $item->searchingId;
                    $desc = $this->db->query($sql);
                    $item->desc = $desc[0];
                    $item->desc = $item->desc->desc;
                }

                $item->statusStr = $GLOBALS['ITEM_STATUS'][$item->status];
                unset($item->imgSearch);

                $this->result->product = $item;
            }
        }



        if($item->source != 0){
            $id = $item->searchingId;
        }

        $this->result->fields = array();
        $this->result->imgs = array();

        $table = "product_fields";
        $where = "product_id = " . $id  . ' AND field_value != "" ' ;
        $this->fields = $this->db->select('fields.field_id, product_fields.id, product_fields.relatedId,product_fields.field_value, fields.title as field_title')->from($table)
                ->join('fields', 'fields.field_id',
                       'product_fields.field_id' )
                ->where($where)->orderby('fields.sort', 'asc')->get();

        if(count($this->fields)) {
            foreach ($this->fields as $field ){

                $this->result->fields[$field->field_id] = $field;
            }
        }


        $table = "product_imgs";
        $where = "product_id = " . $id   ;
        $this->imgs = $this->db->select('product_imgs.id')->from($table)
                ->where($where)->orderby('product_imgs.id', 'asc')->get();


        if(count($this->imgs)) {
            foreach ($this->imgs as $img ){

                $img->img = SuperPath::get($img->id, true).'.jpg';
                $this->result->imgs[$img->id] = $img;
            }
        }

        $this->sendResult();
    }




/*


$params = array(
	// (integer) Номер заказа
	'title' => 'Номер заказа',
	// (integer) Номер заказа
	'cat_id' => '29',
	// (floatval) Номер заказа
	'catsub_id' => '24',
	// (integer) Номер заказа
	'price' => '198',
	// (integer) Номер заказа
	'arcitule' => '198',
	// (integer) Номер заказа
	'price1' => '198',
	// (integer) Номер заказа
	'price2' => '198',
	// (integer) Номер заказа
	'price3' => '198',
	// (integer) Номер заказа
	'price4' => '198',
	// (integer) Номер заказа
	'price5' => '198',
	// (integer) Номер заказа
	'desc' => 'desc',
	// (integer) Номер заказа
	'desc_mini' => 'desc_mini',
	// (integer) Номер заказа
	'new' => '1',
	// (integer) Номер заказа
	'week' => '1',
	// (integer) Номер заказа
	'counter' => '1',
	// (integer) Номер заказа
	'unic' => '1',
);



$url = 'http://shopping-plaza.loc/api/productadd?';

 


 */

    public function productadd() {

        $dataUser['relatedId'] = @trim($_REQUEST['relatedId']); // TODO
        $dataUser['title'] = @trim($_REQUEST['title']);
        $dataUser['cat_id'] = @intval($_REQUEST['cat_id']);
        $dataUser['catsub_id'] = @intval($_REQUEST['catsub_id']);
        $dataUser['arcitule'] = @trim($_REQUEST['arcitule']);
        $dataUser['price'] = @floatval($_REQUEST['price']);

        if(isset($_REQUEST['price1'])){
            $dataUser['price1'] = @floatval($_REQUEST['price1']);
        }
        if(isset($_REQUEST['price2'])){
            $dataUser['price2'] = @floatval($_REQUEST['price2']);
        }
        if(isset($_REQUEST['price3'])){
            $dataUser['price3'] = @floatval($_REQUEST['price3']);
        }
        if(isset($_REQUEST['price4'])){
            $dataUser['price4'] = @floatval($_REQUEST['price4']);
        }
        if(isset($_REQUEST['price5'])){
            $dataUser['price5'] = @floatval($_REQUEST['price5']);
        }

        $dataUser['desc'] = @trim($_REQUEST['desc']);
        $dataUser['desc_mini'] = @trim($_REQUEST['desc_mini']);

        $dataUser['discount'] = @intval($_REQUEST['discount']);
        $dataUser['weight'] = @intval($_REQUEST['weight']);
        $dataUser['counter'] = @intval($_REQUEST['counter']); // TODO

        $dataUser['new'] = (isset($_REQUEST['new']) ? 1 : 0);
        $dataUser['week'] = (isset($_REQUEST['week']) ? 1 : 0);
        $dataUser['unic'] = (isset($_REQUEST['unic']) ? 1 : 0);

        $dataUser['moder_id'] = 0;
        $dataUser['status'] = STATUS_WORK;
        $dataUser['metric'] = MECRIC_TYPE_SHT;
        $dataUser['viewed'] = 0;

        $dataUser['firm_id'] = $this->firmID;

        if( $dataUser['cat_id'] <= 0){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' cat_id');
        }     
        if( $dataUser['catsub_id'] <= 0){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' catsub_id');
        }
        if(!($dataUser['title'])){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' title');
        }
        if( $dataUser['price'] <= 0){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' price');
        }

        if(!($dataUser['arcitule'])){
            $dataUser['arcitule'] = 'SP-'.sprintf("%03s", $this->firmID).'-'.sprintf("%05s", rand(0,99999));
        }

        $dataUser['url_link'] = format::do_latin($dataUser['title']);

        try{


            $where =  array('arcitule' => $dataUser['arcitule'],'firm_id' => $this->firmID );

            $count_records = $this->db->from('products')->
                where($where)->count_records();
             
            if($count_records) {
                $this->db->delete('products', $where);
            }


            $status = $this->db->insert('products', $dataUser);
            if(count($status)){
                $this->result = 'Ok:#' . $status->insert_id();
            }else{
                $this->result = 'Error:#1-'.self::ERROR_DB;
            }
        }catch(Exception $e){
            $this->result = 'Error:#'.self::ERROR_DB . ' ' . $e->getMessage();
        }

        $this->sendResult();
    }





    /**
     * @return void http://shopping-plaza.loc/api/catssubdelete?id=14
     */
    public function productdelete() {

        $id = @intval($_REQUEST['id']);

        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        $status = $this->db->update('products', array('status'=> STATUS_DELETED), array('product_id' => $id,'firm_id' => $this->firmID ));

        if(count($status)){
            $this->result = 'Ok';
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }








/*


$params = array(
	// (integer) Номер заказа
	'id' => '205',
	// (integer) Номер заказа
	'title' => 'Номер заказа',
	// (integer) Номер заказа
	'price' => '198',
	// (integer) Номер заказа
	'arcitule' => '19в28',
	// (integer) Номер заказа
	'price1' => '198',
	// (integer) Номер заказа
	'price2' => '198',
	// (integer) Номер заказа
	'price3' => '198',
	// (integer) Номер заказа
	'price4' => '198',
	// (integer) Номер заказа
	'price5' => '198',
	// (integer) Номер заказа
	'desc' => 'desc',
	// (integer) Номер заказа
	'desc_mini' => 'desc_mini',
	'counter' => '1',
);



$url = 'http://shopping-plaza.loc/api/productedit?';


  
 */

    public function productedit() {

        $id = @intval($_REQUEST['id']);
        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }
        
        $data = array();
        $data['weight'] = rand(1, 100);
                
        if(array_key_exists('title', $_REQUEST)){
            $data['title'] =  @trim($_REQUEST['title']);
            $data['url_link'] = format::do_latin($data['title']);
        }
        if(array_key_exists('arcitule', $_REQUEST)){
            $data['arcitule'] =  @trim($_REQUEST['arcitule']);
        }
        if(array_key_exists('price', $_REQUEST)){
            $data['price'] =  @floatval($_REQUEST['price']);
        }
        if(array_key_exists('desc', $_REQUEST)){
            $data['desc'] =  @trim($_REQUEST['desc']);
        }
        if(array_key_exists('desc_mini', $_REQUEST)){
            $data['desc_mini'] =  @trim($_REQUEST['desc_mini']);
        }

        if(array_key_exists('price1', $_REQUEST)){
            $data['price1'] =  @floatval($_REQUEST['price1']);
        }
        if(array_key_exists('price2', $_REQUEST)){
            $data['price2'] =  @floatval($_REQUEST['price2']);
        }
        if(array_key_exists('price3', $_REQUEST)){
            $data['price3'] =  @floatval($_REQUEST['price3']);
        }
        if(array_key_exists('price4', $_REQUEST)){
            $data['price4'] =  @floatval($_REQUEST['price4']);
        }
        if(array_key_exists('price5', $_REQUEST)){
            $data['price5'] =  @floatval($_REQUEST['price5']);
        }
        if(array_key_exists('counter', $_REQUEST)){
            $data['counter'] =  @floatval($_REQUEST['counter']); // TODO
        }

        if(array_key_exists('cat_id', $_REQUEST)){
            $data['cat_id'] =  @intval($_REQUEST['cat_id']); // TODO
        }
        if(array_key_exists('catsub_id', $_REQUEST)){
            $data['catsub_id'] =  @intval($_REQUEST['catsub_id']); // TODO
        }
        if(array_key_exists('source', $_REQUEST)){
            $data['source'] =  @intval($_REQUEST['source']); // TODO
        }
        if(array_key_exists('searchingId', $_REQUEST)){
            $data['searchingId'] =  @intval($_REQUEST['searchingId']); // TODO
        }
        if(array_key_exists('status', $_REQUEST)){
            $data['status'] =  @intval($_REQUEST['status']); // TODO
        }


		


        try{
            $status = $this->db->update('products', $data, array('product_id' => $id, 'firm_id' => $this->firmID));
            if(count($status)){
                $this->result = 'Ok';
            }else{
                $this->result = 'Error:#'.self::ERROR_DB;
            }
        }catch(Exception $e){
            $this->result = 'Error:#'.self::ERROR_DB;
        }

        $this->sendResult();
    }































	/**
	 * @return void http://shopping-plaza.loc/api/cats?desc=0
	 */

	public function news() {

        $this->dateFrom = @intval($_REQUEST['dateFrom']);
        $this->dateTill = @intval($_REQUEST['dateTill']);

		$desc = @intval($_REQUEST['full']);

        $table = 'news';
        $where = '1=1 and news.firm_id = ' . $this->firmID .
                 (!empty($this->dateFrom) ? " and news.date >= '" . $this->db->escape_str(date('Y-m-d H:i:s', $this->dateFrom))."'" : "") .
                 (!empty($this->dateTill) ? " and news.date <= '" . $this->db->escape_str(date('Y-m-d H:i:s', $this->dateTill))."'" : "") . 
                 '';


		$this->groupsR = $this->db->select('news_id, title, annonce, date' . ($desc ? ', content':''))->from($table)->
				where($where )->
				orderby('news.date', 'desc') ->get();

		if(count($this->groupsR)) {
			foreach ($this->groupsR as $key_SUB ){
				$this->result->news[$key_SUB->news_id] = $key_SUB;
			}
		}

		$this->sendResult();

	}

	/**
	 * @return void http://shopping-plaza.loc/api/catsdelete?id=14
	 */
	public function newsdelete() { //////// TODO чтото тут дофига всего

		$id = @intval($_REQUEST['id']);

		if(!$id){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}

		$status = $this->db->update('news', array('status'=> STATUS_DELETED), array('news_id' => $id,'firm_id' => $this->firmID ));

		if(count($status)){
			$this->result = 'Ok';
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}



	/**

	$params = array(
	// (integer) Номер редактируемой группы
	'id' => '133',
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с HTML',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
	);

	$url = 'http://shopping-plaza.loc/api/catsedit?';
	 *
	 */
	public function newsedit() {

		$id = @intval($_REQUEST['id']);
		if(!$id){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}

		$data['title'] =  @trim($_REQUEST['title']);
		if(empty($data['title'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' Название');
		}else{

			if(strlen($data['title']) > 55){
				$this->sendResult('Error:#'.self::ERROR_PARAM. ' Название - содержит больще 55 символов');
			}

		}

		if(array_key_exists('content', $_REQUEST)){
			$data['content'] =  @trim($_REQUEST['content']);
		}
		if(array_key_exists('link', $_REQUEST)){
			$data['link'] =  @trim($_REQUEST['link']); // TODO
		}
		if(array_key_exists('annonce', $_REQUEST)){
			$data['annonce'] =  @trim($_REQUEST['annonce']);
		}

		$data['firm_id'] = $this->firmID;

		$data['url_link'] = format::do_latin($data['title']);
		$status = $this->db->update('news', $data, array('news_id' => $id, 'firm_id' => $this->firmID ));

		if(count($status)){
			$this->result = 'Ok';
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}

/*
$params = array(
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с <b>HTML</b>',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
);

$url = 'http://shopping-plaza.loc/api/catsadd?';
 */
	public function newsadd() {
 
		$dataUser['title'] = @trim($_REQUEST['title']);
		$dataUser['link'] = @trim($_REQUEST['link']);
		$dataUser['content'] = @trim($_REQUEST['content']);
		$dataUser['annonce'] = @trim($_REQUEST['annonce']);
		$dataUser['firm_id'] = $this->firmID;
		$dataUser['date'] = date("Y-m-d H:i:s");

		if(empty($dataUser['title'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' Название');
		}else{
			 
		}

		$dataUser['url_link'] = format::do_latin($dataUser['title']);

		$status = $this->db->insert('news', $dataUser);
		if(count($status)){
			$this->result = 'Ok:#' . $status->insert_id();
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}






    /*



$params = array(
	// (integer) Номер заказа
	'id' => '198',
);

$url = 'http://shopping-plaza.loc/api/productinfo?';






    [product] => stdClass Object
        (
            [product_id] => 198
            [title] => Автомобильный видеорегистратор Aikitec Carkit DVR-07HD Lite
            [price] => 1500
            [desc] => <b style="">Комплект поставки
            [cat_id] => 28
            [catsub_id] => 26
            [desc_mini] => Обзор 120°, TFT-экран 2.5", SD до 64 ГБ, miniUSB выход
            [status] => 1
            [arcitule] => SP-DVR-127-Aikitec
            [source] => 1
            [searchingId] => 372
            [img] => http://static.shopping-plaza.loc/products/00/00/02/2736.jpg
            [imgSearch] => 2736
            [statusStr] => На сайте
        )

    [fields] => Array
        (
            [0] => stdClass Object
                (
                    [field_id] => 153
                    [field_value] =>
                    [field_title] => Матрица
                )
        )

    [imgs] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 2729
                    [img] => http://static.shopping-plaza.loc/products/00/00/02/2729.jpg
                )



     */

    public function imageinfo() {


        $id = @intval($_REQUEST['id']);

        if(!$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        $table = "product_imgs";
        $where = "product_id = " . $id  . " and firm_id = " .$this->firmID ;
        $this->imgs = $this->db->select('*')->from($table)
                ->where($where)->orderby('product_imgs.id', 'asc')->get();
 require Kohana::find_file('vendor', 'SuperPath');
 $this->result->imgs = array();
        if(count($this->imgs)) {
            foreach ($this->imgs as $img ){

                $img->img = SuperPath::get($img->id, true).'orig.jpg';
                $this->result->imgs[$img->id] = $img;
            }
        }

        $this->sendResult();
    }





    public function imageadd() {

        $tempFile = @trim($_REQUEST['link']);
        $id = @intval($_REQUEST['id']);
        $relatedID = @intval($_REQUEST['relatedID']);
        $favorite = @intval($_REQUEST['favorite']);

        if(!$tempFile || !$id){
            $this->sendResult('Error:#'.self::ERROR_PARAM. ' title');
        }

        try{
            require Kohana::find_file('vendor', 'SuperPath');

            $size = getimagesize($tempFile);

            if(!is_array($size)){
                $this->sendResult('Error:# Указанное изображение не подходит. Выберите другое изображение.')  ;
                exit();;
            }

            $hash = hash_file('md5', $tempFile);

            $content = array(
                "product_id" => $id,
                "img_size" => 0,
                "img_hash" => $hash,
                'firm_id' => $this->firmID,
                'relatedID' => $relatedID
            );


                $table = "product_imgs";
                $where = "product_id = " . $id . " and favorite = 1 and firm_id = " . $this->firmID;

                $item = $this->db->select('*')->from($table)->
                        where($where)->get();

                if(!isset($item[0])){
                    $content['favorite'] = 1;
                }else{
					$content['favorite'] = $favorite;

                    if($favorite){
                        $status = $this->db->update('product_imgs', array('favorite' => 0), array('product_id' => $id, 'firm_id' => $this->firmID));
                    }
				}


            $status = $this->db->insert('product_imgs', $content);
            if(count($status)){



                $imageId = $status->insert_id();
                $ext = "." . substr (strrchr ($tempFile, "."), 1);  //".gif";
                $targetFile = SuperPath::get($imageId)  ;

                $origFile = $targetFile. "orig". $ext;


                copy($tempFile, $origFile) ;

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
                    $cmd_command = 'composite -gravity Center -dissolve 40 ' . escapeshellarg($fileWaterMark) .
                                   ' ' . escapeshellarg($targetFile. ".jpg")  . ' ' . escapeshellarg($targetFile . ".jpg") . ' ';
                    $this->exec($cmd_command);
                }

			  	$this->result = 'Ok:#' . $imageId;

            }else{
                $this->result = 'Error:#1-'.self::ERROR_DB;
            }

        }catch(Exception $e){
            $this->result = 'Error:#'.self::ERROR_DB . ' ' . $e->getMessage();
        }

        $this->sendResult();
    }





    /**
     * @return void http://shopping-plaza.loc/api/catssubdelete?id=14
     */
    public function imagedelete() {

        $deleteimage = @intval($_REQUEST['deleteimage']);
        $id = @intval($_REQUEST['id']);

        if(!$id || !$deleteimage){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

		$status = $this->db->delete('product_imgs', array(
			'product_id' => $id,
			'id' => $deleteimage,
			'firm_id' => $this->firmID )
		);

        if(count($status)){
            $this->result = 'Ok';
        }else{
            $this->result = 'Error:#'.self::ERROR_DB;
        }
        $this->sendResult();
    }




    public function imageedit() {

        $id = @intval($_REQUEST['id']);
        $favorite = @intval($_REQUEST['favorite']);
        if(!$id ){
            $this->sendResult('Error:#'.self::ERROR_PARAM);
        }

        try{
            $status = $this->db->update('product_imgs', array('favorite' => $favorite), array('id' => $id, 'firm_id' => $this->firmID));
            if(count($status)){
                $this->result = 'Ok';
            }else{
                $this->result = 'Error:#'.self::ERROR_DB;
            }
        }catch(Exception $e){
            $this->result = 'Error:#'.self::ERROR_DB;
        }

        $this->sendResult();
    }























	/**
	 * @return void http://shopping-plaza.loc/api/catssubdelete?id=14
	 */
	public function parametersdelete() {

		$id = @intval($_REQUEST['id']);

		if(!$id){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}

		$status = $this->db->delete('fields', array('field_id' => $id, 'firm_id' => $this->firmID ));

		if(count($status)){
			$this->result = 'Ok';
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}



	/**

	$params = array(
	// (integer) Номер редактируемой группы
	'id' => '133',
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (integer) Номер основной группы, если надо перенести <не обязательное поле>
	'cat_id' => '1',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с HTML',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
	);

	$url = 'http://shopping-plaza.loc/api/catssubedit?';
	 *
	 */
	public function parametersedit() {

		$id = @intval($_REQUEST['id']);
		if(!$id){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}

		$data['title'] =  @trim($_REQUEST['title']);

		if(empty($data['title'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' Название');
		}

		if(array_key_exists('sort', $_REQUEST)){
			$data['sort'] =  @intval($_REQUEST['sort']);
		}
		if(array_key_exists('catsub_id', $_REQUEST)){
			$data['catsub_id'] =  @intval($_REQUEST['catsub_id']);
		}
		//$data['firm_id'] = $this->firmID;

		if(array_key_exists('sort', $_REQUEST)){
			// $this->db->query('UPDATE fields SET sort = sort + 1 WHERE  catsub_id = ' . $data['catsub_id'] . ' and firm_id = ' . $this->firmID . " and sort >=  " . $data['sort']);;
		}

		$status = $this->db->update('fields', $data, array('field_id' => $id, 'firm_id' => $this->firmID ));

		if(count($status)){
			$this->result = 'Ok';
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}

/*
$params = array(
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с <b>HTML</b>',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
	// (integer) Номер основной группы
	'cat_id' => '13',
);

$url = 'http://shopping-plaza.loc/api/catssubadd?';
 */
	public function parametersadd() {

		$dataUser['relatedTitle'] = @trim($_REQUEST['relatedId']);
		$dataUser['title'] = @trim($_REQUEST['title']);
		$dataUser['sort'] = @trim($_REQUEST['sort']);
		$dataUser['catsub_id'] = @intval($_REQUEST['catsub_id']);
		$dataUser['excel'] = @intval($_REQUEST['excel']);
		$dataUser['firm_id'] = $this->firmID; 

		if(empty($dataUser['title'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' title');
		}else{ 
		}

		if(empty($dataUser['catsub_id'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' catsub_id');
		}

	 /*   	$status = $this->db->query('UPDATE fields SET sort = sort + 1 WHERE catsub_id = ' . $dataUser['catsub_id'] .
						 ' and firm_id = ' . $this->firmID . " and sort >=  " . $dataUser['sort']);;
    if(!$status){
            $this->result = 'Error:#!'.self::ERROR_DB;
        }*/
		$status = $this->db->insert('fields', $dataUser);
		if(count($status)){
			$this->result = 'Ok:#' . $status->insert_id();
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}











	public function parameters() {

		$this->idSubCat = @intval($_REQUEST['idSubCat']);

		if(empty($this->idSubCat)){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' idSubCat');
		}

		$table = 'fields';
		$where = '1=1 and fields.firm_id = ' . $this->firmID . ' and catsub_id = ' . $this->idSubCat;


		$items = $this->db->select(
			'*')->from($table)->
				where($where)->orderby('sort', 'desc')->get();

 
		$this->result->parameters = array();

		if(count($items)) {
			foreach ($items as $item ){
				$this->result->parameters[$item->field_id] = $item;
			}
		}

		$this->sendResult();
	}





















	/**
	 * @return void http://shopping-plaza.loc/api/catssubdelete?id=14
	 */
	public function fielddelete() {

		$field_id = @intval($_REQUEST['field_id']);
		$product_id = @intval($_REQUEST['product_id']);

		if(!$field_id || !$product_id){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}

		$status = $this->db->delete('product_fields', array('product_id' => $product_id,'field_id' => $field_id));

		if(count($status)){
			$this->result = 'Ok';
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}



	/**

	$params = array(
	// (integer) Номер редактируемой группы
	'id' => '133',
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (integer) Номер основной группы, если надо перенести <не обязательное поле>
	'cat_id' => '1',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с HTML',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
	);

	$url = 'http://shopping-plaza.loc/api/catssubedit?';
	 *
	 */
	public function fieldedit() {

		$id = @intval($_REQUEST['field_id']);
		$product_id = @intval($_REQUEST['product_id']);
		if(!$id || !$product_id){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}

		$field_value =  @trim($_REQUEST['field_value']);

		if(empty($field_value)){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' field_value');
		}

		$status = $this->db->update('product_fields', array('field_value' => $field_value),
									array('field_id' => $id, 'product_id' => $product_id  ));

		if(count($status)){
			$this->result = 'Ok';
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}

/*
$params = array(
	// (string) Заголовок
	'title' => 'Тестовая группа',
	// (string) Описание <не обязательное поле>
	'desc' => 'Описание тестовой группы, можно с <b>HTML</b>',
	// (integer) Позиция перед другой категорией (полученая из метода:cats)  <не обязательное поле>
	'sort' => '13',
	// (integer) Номер основной группы
	'cat_id' => '13',
);

$url = 'http://shopping-plaza.loc/api/catssubadd?';
 */
	public function fieldadd() {

		$dataUser['relatedId'] = @trim($_REQUEST['relatedId']);
		$dataUser['product_id'] = @trim($_REQUEST['product_id']);
		$dataUser['field_id'] = @trim($_REQUEST['field_id']);
		$dataUser['field_value'] = @trim($_REQUEST['field_value']); 

		if(empty($dataUser['product_id'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' product_id');
		}else{
		}

		if(empty($dataUser['field_id'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' field_id');
		}
		if(empty($dataUser['field_value'])){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' field_value');
		}

		$status = $this->db->insert('product_fields', $dataUser);
		if(count($status)){
			$this->result = 'Ok:#' . $status->insert_id();
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}

































	/**
	 * @return void http://shopping-plaza.loc/api/catssubdelete?id=14
	 */
	public function satelitedelete() {

		$product = @intval($_REQUEST['product']);
		$main_product = @intval($_REQUEST['main_product']);
		$type = @intval($_REQUEST['type']);

		if(!$product || !$main_product){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}
		$table =  $type == 1 ?  'recommends' : 'satellites';
		$status = $this->db->delete($table,
									array(($type == 1 ? 'recommend_product' : 'satellite_product') => $product,
										 'product' => $main_product, 'firm_id' => $this->firmID ));

		if(count($status)){
			$this->result = 'Ok';
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}


	public function sateliteadd() {

		$product = @intval($_REQUEST['product']);
		$main_product = @intval($_REQUEST['main_product']);
		$relatedId = @intval($_REQUEST['relatedId']);
		$type = @intval($_REQUEST['type']);

		if(!$product || !$main_product){
			$this->sendResult('Error:#'.self::ERROR_PARAM);
		}
		$table =  $type == 1 ?  'recommends' : 'satellites';
		$status = $this->db->insert($table,
									array(($type == 1 ? 'recommend_product' : 'satellite_product') => $product,
										 'product' => $main_product, 'firm_id' => $this->firmID , 'relatedId' => $relatedId ));

		if(count($status)){
			$this->result = 'Ok:#' . $status->insert_id();
		}else{
			$this->result = 'Error:#'.self::ERROR_DB;
		}
		$this->sendResult();
	}






	public function satelite() {

		$main_product = @intval($_REQUEST['main_product']);
		$type = @intval($_REQUEST['type']);

		if(empty($main_product)){
			$this->sendResult('Error:#'.self::ERROR_PARAM. ' main_product');
		}

		$table = ( $type == 1 ) ?  'recommends' : 'satellites';
		$where = '1=1 and firm_id = ' . $this->firmID . ' and product = ' . $main_product;

		$items = $this->db->select(
			'*')->from($table)->
				where($where)->get();

		$this->result->list = array();

		if(count($items)) {
			foreach ($items as $item ){
				$this->result->list[($type == 1 ? $item->recommend_product : $item->satellite_product) ] = $item;
			}
		}

		$this->sendResult();
	}









    protected function exec($command){
        if($GLOBALS['runningOn'] == 3){
            pclose(popen($command, 'r'));;
        }else{
            exec('' . $command) ;
        }
    }




}