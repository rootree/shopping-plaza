<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Обработка поступивших заказов
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Orders_Controller extends Web_Controller {

    const SUBPAGE_MAIN = 'main';
    const SUBPAGE_ADD = 'add';
    const SUBPAGE_ORDER_INFO = 'order_info';

    public function __construct() {

        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'info' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'ajax' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'delete' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
        ); 
        $this->selected_page   = PAGE_ORDERS;
 
        if(array_key_exists('statusChangedOnSent', $_REQUEST)){
            $this->info = 'Статус заказа изменён, клиенту отправленно сообщение о том что заказ отправлен';
        }
        if(array_key_exists('statusChanged', $_REQUEST)){
            $this->info = 'Статус заказа изменён';
        }

        $this->delivery = $this->db->select('del_id, title')->from('delivery')->
            where('firm_id =' . $this->firmID)->orderby('sort', 'desc')->get();

        $this->productView = cookie::get('productView') ? cookie::get('productView') : PRODUCTS_VIEW_LIST;
   
        if(array_key_exists('comment', $_REQUEST)){
            $this->info = 'Комментарий успешно добавлен.';
        }
        if(array_key_exists('itemsAdd', $_REQUEST)){
            $this->info = 'Товар добавлен в заказ.';
        }
        if(array_key_exists('itemsDrop', $_REQUEST)){
            $this->info = 'Товар убран из заказа.';
        }
        if(array_key_exists('itemsCountChanged', $_REQUEST)){
            $this->info = 'Количество позиций в заказе изменено.';
        }
        if(array_key_exists('statusChangedOnProceed', $_REQUEST)){
            $this->info = 'Заказ принят. Количество товарных позиций на складе уменьшено.';
        }
        if(array_key_exists('statusChangedOnCancel', $_REQUEST)){
            $this->info = 'Заказ отменён. Количество товарных позиций на складе увеличено.';
        }
        if(array_key_exists('dvtChanged', $_REQUEST)){
            $this->info = 'Способы доставки и оплаты установлены. Спасибо.';
        }
    }


    public function index() {

        $this->template->content = new View('orders/index');

        $this->template->title = 'Все заказы';
        $this->selected_subpage = Orders_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $this->type = $this->uri->segment('type');
        $this->deliverytype = $this->uri->segment('deliverytype');

        $addonURL = '';
        
        if(empty($this->type)){


        }else{

            $addonURL .= '/type/' . $this->type;

            switch($this->type){
                case ORDER_STATUS_NEW:
                    $this->template->title = 'Новые заказы';
                    break;
                case ORDER_STATUS_PAYED:
                    $this->template->title = 'Оплаченные заказы';
                    break;
                case ORDER_STATUS_CANCEL:
                    $this->template->title = 'Отменённые заказы';
                    break;
                case ORDER_STATUS_VIEWED:
                    $this->template->title = 'Просмотренные заказы';
                    break;
                case ORDER_STATUS_DELIVERED:
                    $this->template->title = 'Отправленные заказы';
                    break;
                case ORDER_STATUS_PROCEEDED:
                    $this->template->title = 'Обработанные заказы';
                    break;
                default:
                    $this->type = null;
            }
        }
/*
        if($this->type == ORDER_STATUS_NEW && $this->firm->new_orders > 0){

            $data = array(
                'new_orders' => 0,
            );

            $this->db->update('firms', $data, 'id = '. $this->firmID);
        }
*/
        $offset = $this->uri->segment('page');

        $page_limit = ELEMENTS_ON_PAGE;
 
        $deliverytype = '';

        if(!empty($this->deliverytype)){
            $deliverytype = ' and devivery = ' . $this->deliverytype . ' ';
            $addonURL .= '/deliverytype/' . $this->deliverytype;
        }

        $table = 'order';
        $where = '1=1 and order.firm_id = ' . $this->firmID . $deliverytype .
                 (!empty($this->type) ? " and order.status = " . $this->type : "");

        $offset = $page_limit * ($offset - 1); 
        if(!isset($offset) || $offset <= 0){
            $offset = 0;
        }


        $this->template->content->items = $this->db->select(
        $table.'.*, pay_type.title as payment, delivery.title as devivery')->from($table)->
            join("pay_type", 'pay_type.pay_id', 'order.payment', 'left')->
            join("delivery", 'delivery.del_id', 'order.devivery', 'left')->
            where($where)->offset($offset)->limit($page_limit)->orderby('id', 'desc')->get();



        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(

              // Base_url will default to the current URI
              'base_url'    => 'orders/index' . $addonURL,

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


    public function info() {

        $this->template->content = new View('orders/info');
        $this->selected_subpage = Orders_Controller::SUBPAGE_ORDER_INFO;;

        if(!$this->haveAccess()){
            return;
        };

        $id = intval($this->uri->segment('id'));
        $table = "order";
        $where = "order.id = " . $id . " and order.firm_id = " . $this->firmID;


        if ($_POST && isset($_POST['deliv'])){
            $status = $this->db->update('order',
            array(
                 'deliveryInfo' => json_encode($_POST['deliv'])
            ),
            array('id' => $id, 'firm_id' => $this->firmID ));
        }


        if ($_POST && isset($_POST['settings'])){
            
            $delivery = new stdClass();

            $delivery->name = $_POST['settings']['name'];
            $delivery->phone = $_POST['settings']['phone'];
        
            $data = array(
                 'devivery' => intval($_POST['settings']['deliv']),
                 'payment'  => intval($_POST['settings']['payway']),
                 'deliveryInfo'  => json_encode($delivery),
            );
            if($data['devivery'] > 0 && $data['payment'] > 0){
                $status = $this->db->update('order', $data, array('id' => $id, 'firm_id' => $this->firmID ));
                url::redirect("/orders/info/id/$id?dvtChanged");
            }else{
                $this->error = 'Нужно указать и способ доставки и способ оплаты.';
            }

        }

        if ($_POST && isset($_POST['addItem'])){

			$idPr = intval($_POST['addItem']['id']);

			$this->item = $this->db->
                select('price, title')->from('products')->
                where('product_id = '. $idPr .' and firm_id = '. $this->firmID)->get();

			$this->item = $this->item[0];

			if($this->item){

				$price = $this->item->price;
				$title = $this->item->title;

				$data['order_id'] = $id;
				$data['count'] = intval($_POST['addItem']['count']);
				$data['it_id'] =  $idPr;;

				$this->db->insert('order_items', $data);
 
				if($this->addComment('Товар «'.$title.'» добавлен в количестве '.$data['count'].' позиций.', $id)){
					url::redirect("/orders/info/id/$id?itemsAdd");
					exit();
				}

				$priceTotal = $price *  $data['count'];
				// TODO
			}
        }

		if (array_key_exists('dropItem', $_REQUEST)){

			$itemForDrop = $_REQUEST['dropItem'];

			$this->item = $this->db->
				select('products.price')->from('order_items')->
				join('products', array('order_items.it_id' => 'products.product_id', 'products.firm_id = ' . $this->firmID => ''))->
				where('order_items.it_id = '. $itemForDrop )->get();

			$this->item = $this->item[0];

			if($this->item){

				$this->db->delete('order_items',
				array('it_id' => $itemForDrop));

				if($this->addComment('Товар с №'.$itemForDrop.' удалён', $id)){
					url::redirect("/orders/info/id/$id?itemsDrop");
					exit();
				}
			}
		}

        if ($_POST && isset($_POST['countItems'])){

			$countItems = $_POST['countItems'];
			if(count($countItems)){

				foreach($countItems as $idItem => $count){

					$this->item = $this->db->
						select('products.price')->from('order_items')->
						join('products', array('order_items.it_id' => 'products.product_id', 'products.firm_id = ' . $this->firmID => ''))->
						where('order_items.it_id = '. $idItem )->get();

					$this->item = $this->item[0];

					if($this->item){

						$this->db->update('order_items',
						array(
							 'count' => $count
						),
						array('it_id' => $idItem));

					}
				}

				if($this->addComment('Изменено кол-во позиций в заказе', $id)){
					url::redirect("/orders/info/id/$id?itemsCountChanged");
					exit();
				}
			}
        }

        $this->item = $this->db->
                select($table.'.*, pay_type.title as payment, delivery.title as delivery, delivery.cost as delivery_cost
                , pay_type.field_type as field_type_pay, delivery.type as field_type_devivery')->from($table)->
                join("pay_type", 'pay_type.pay_id', 'order.payment', 'left')->
                join("delivery", 'delivery.del_id', 'order.devivery', 'left')->
                where($where)->get();

        $this->item = $this->item[0];

        if($this->item){
;
            $this->deliveryInfo = json_decode($this->item->deliveryInfo);
            $this->paymentInfo = json_decode($this->item->paymentInfo);
 ;
            $this->template->title = "Информация о заказе №" . $id;

            if($this->item->status == ORDER_STATUS_NEW){
                $this->item->status = ORDER_STATUS_VIEWED;
                $status = $this->db->update('order',
                                            array(
                                                 'status' => 3,
                                                 'moder_id' => $this->moderId
                                            ),
                                            array('id' => $id, 'firm_id' => $this->firmID ));
                if(count($status)){
                    $this->info = 'Статус заказа изменён на «просмотренный»';
                }
            }
            
            if(array_key_exists('setDeliveryDate',$_REQUEST)){

                $this->deliveryInfo->deliveryDate = trim($_REQUEST['setDeliveryDate']);
                $this->deliveryInfo->deliveryTimeFrom = intval($_REQUEST['setDeliveryTimeFrom']);
                $this->deliveryInfo->deliveryTimeTo = intval($_REQUEST['setDeliveryTimeTo']);

                // 2012-05-21
                preg_match("/(\d+)-(\d+)-(\d+)/ms", $this->deliveryInfo->deliveryDate, $res);
                if(count($res) > 1){
                    if(!checkdate($res[2], $res[3], $res[1])){
                        $this->error = 'Указана несуществующая дата!';
                    }
                }else{
                   $this->error = 'Указана несуществующая дата';
                }

                if(($this->deliveryInfo->deliveryTimeFrom < 0 && $this->deliveryInfo->deliveryTimeFrom > 22) && ($this->deliveryInfo->deliveryTimeFrom < 1 && $this->deliveryInfo->deliveryTimeFrom > 23) ){
                    $this->error = 'Указан несуществующий диапазон доставки';
                }

                if(is_null($this->error)){
                    $status = $this->db->update('order',
                                                array(
                                                      'deliveryInfo' => json_encode($this->deliveryInfo)
                                                ),
                                                array('id' => $id, 'firm_id' => $this->firmID ));
                    if(count($status)){
                        $this->info = 'Данные о времени и дате доставки изменены.';

						if($this->addComment($this->info.
											 ' Дата: '.$this->deliveryInfo->deliveryDate.
											 ', время с '.$this->deliveryInfo->deliveryTimeFrom.' по '.$this->deliveryInfo->deliveryTimeTo, $id)){
							//url::redirect("/orders/info/id/$id?comment");
							//exit();
						}
                    }
                }
 
            }

            $this->type = $this->item->status;

            $where = "order_id = " . $id ;
           // $where = "product_cost.date <= order.date"  ;

            if($this->productView == PRODUCTS_VIEW_LIST){

                $this->items = $this->db->select('*, products.title as title,catssub.title as catTitle, products.product_id as product_id, products.counter as sCounter,
                 (select coster from product_cost where product_cost.product_id = products.product_id and order.date < product_cost.date order by date asc limit 1  ) as costerFM, order_items.count as counteS')->from("order_items")->
                    join("products", 'products.product_id', 'order_items.it_id', 'left')->


                    join('order', array('order.id' => 'order_items.order_id') )->
                    join('catssub', array('catssub.catsub_id' => 'products.catsub_id') )->

                    where($where )->orderby('products.title', 'acs')->groupby('products.product_id')->get();

            }else{
                
                require Kohana::find_file('vendor', 'SuperPath');
                $this->items = $this->db->select('*, products.title as title, catssub.title as catTitle, products.product_id as product_id,

                products.counter as sCounter, product_imgs.id as img, searchingImg.id as imgSearch,

                (select coster from product_cost where product_cost.product_id = order_items.it_id and
                order.date < product_cost.`date` order by product_cost.`date` asc limit 1  ) as costerFM, order_items.count as counteS ')->

                    from("order_items")->
                    join("products", 'products.product_id', 'order_items.it_id', 'left')->

                     join('catssub', array('catssub.catsub_id' => 'products.catsub_id') )->

                    join('product_imgs', array('product_imgs.product_id' => 'products.product_id',
                                               'product_imgs.favorite' => 1), null, 'left')->
                    join('product_imgs` `searchingImg', array('searchingImg.product_id' => 'products.searchingId',
                                           'searchingImg.favorite' => 1), null, 'left')->
                    join('order', array('order.id' => 'order_items.order_id') )->
 
                    where($where )->orderby('products.title', 'acs')->groupby('products.product_id')->get();

            }
                     //   print_r($this->items);
            $this->order_history = $this->db->select('*')->from("order_history")->
                    join("moders", 'moders.user_id', 'order_history.moder_id', 'left')->
                    where($where)->orderby('date', 'desc')->get();



            $this->typeaction = $this->uri->segment('typeaction');

            if(!empty($this->typeaction)){

                if(array_key_exists($this->typeaction, $GLOBALS['ORDER_STATUS'])){
 
                    $status = $this->db->update('order',
                                                array(
                                                     'status' => $this->typeaction,
                                                     'moder_id' => $this->moderId
                                                ),
                                                array('id' => $id ));


                    switch($this->typeaction){

                        case ORDER_STATUS_DELIVERED:
 
                            if($GLOBALS['runningOn'] != '1' && isset($this->deliveryInfo) && isset($this->deliveryInfo->mail))  {
                                require Kohana::find_file('vendor', 'Mailer');
                                Mailer::orderSent($this->deliveryInfo->mail, $this->deliveryInfo->name, $id );
                            };

                            require Kohana::find_file('vendor', 'Axiomus');


                            if($this->firmID == 1){
 
                                $Axiomus = new Axiomus();
                                $result = false;$delivery_cost = 0;

								$total = 0;

                                switch($this->item->field_type_devivery){

                                    case DELIVERY_TYPE_EMS:
                                        $result = $Axiomus->newPost($this, $total);
                                        break;
                                    case DELIVERY_TYPE_CURIER_TO_MCAD:
                                        $result = $Axiomus->newOrder($this, true, $total);

                                        $distance = (isset($this->deliveryInfo->distance) &&
                                                     !empty($this->deliveryInfo->distance) ? $this->deliveryInfo->distance : 5);
                                        if($distance <= 5){
                                            $delivery_cost = 300 + 50;
                                        }elseif($distance <= 10){
                                            $delivery_cost = 300 + 100;
                                        }else{
                                            $delivery_cost = 300 + $distance * 15;
                                        } 

                                        break;
                                    case DELIVERY_TYPE_CURIER:
                                        $result = $Axiomus->newOrder($this, false, $total);
                                        break;
                                    case DELIVERY_TYPE_HIMSELF:
                                        $result = $Axiomus->newCarryOut($this, $total);
                                        break;
                                }
 
                                if($result){

                                    $this->deliveryInfo->result = $result;
                                    $status = $this->db->update('order',
                                    array(
                                        'deliveryInfo' => json_encode($this->deliveryInfo)
                                    ),
                                    array('id' => $id, 'firm_id' => $this->firmID ));

                                    $stringRes = false;
                                    preg_match("/objectid=\"(\d+).*?price=\"(.*?)\".*?>(.*?)<\/status>/ms", $result, $res);

                                    if(count($res) > 2){

                                        $objectid = $res[1];
                                        $price = $res[2];
                                        $stringRes = 'Ответ доставки: «'.$res[3].'». <br/>Номер отправления: '.$objectid.'. <br/>Cтоимость услуг курьера '. money::ru($price) . ($delivery_cost ? '. <br/><b>Стоимость доставки для клиента примерно '.money::ru($delivery_cost).'</b>': '');

										$phone = $this->deliveryInfo->phone;

                                        require Kohana::find_file('vendor', 'SMSer');
                                        
										switch($this->item->field_type_devivery){

											case DELIVERY_TYPE_CURIER_TO_MCAD:
											case DELIVERY_TYPE_CURIER:
 // TODO
                                                $sms = 'Ваш заказ №'.$id . ' на сумму ' . money::ru($total) . ' передан курьеру и будет доставлен в установленное с вами время. Перед тем как отпустить курьера, не забудьте проверить товар.' ;
												SMSer::send($phone,
												$sms ,
												'DVR-Plaza');

												break;
											case DELIVERY_TYPE_HIMSELF:

                                                $sms = 'Ваш заказ №'.$id . ' на сумму ' . money::ru($total) . ' подготовлен, номер самовывоза '.$objectid.'. Не забудьте взять паспорт.';
												SMSer::send($phone,
												$sms ,
												'DVR-Plaza');

												break;
										}
 

                                    }else{
                                         
                                        preg_match("/code=\"(\d+)\">(.*?)<\/status>/ms",$result, $res);
                                        if(count($res) > 2){
                                            $code = $res[1];
                                            $stringRes = 'Ответ доставки: '.$res[2]. '. <br/>Код ошибки '.$code;

                                            $status = $this->db->update('order',
                                                array(
                                                     'status' => ORDER_STATUS_PROCEEDED,
                                                     'moder_id' => $this->moderId
                                                ),
                                                array('id' => $id ));

                                        }

                                    }

                                    if($stringRes){


										if($this->addComment($stringRes, $id)){
											//url::redirect("/orders/info/id/$id?comment");
											//exit();
										}

                                    }
                                }
                            }

                            url::redirect("/orders/info/id/$id?statusChangedOnSent");
                            break;

						case ORDER_STATUS_PROCEEDED:

                            foreach ($this->items as $key => $value ){
                                // $this->db->query("update products set counter = counter + " . $value->counter . " where product_id = " . $value->product_id);


 
								$newCounter = $value->sCounter - $value->counteS;
 
								$data['counter'] = intval($newCounter);
							 	$idProduct = $value->product_id;

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
									'counter' => $data['counter']
									);

								if($value->source == 1){

									$idMainProduct = $value->searchingId;

									// Обновляем все копии
									$this->db->update('products', $data, array('searchingId' => $idMainProduct, 'firm_id' => $this->firmID));

									// Обвновляем оригинальный товар

									$this->db->update('products', $data, array('product_id' => $idMainProduct, 'firm_id' => $this->firmID));
								}else{
									// Обновляем все копии
									$this->db->update('products', $data, array('searchingId' => $idMainProduct, 'firm_id' => $this->firmID));
								}












                            }

							url::redirect("/orders/info/id/$id?statusChangedOnProceed");

                        case ORDER_STATUS_CANCEL:


                            if($this->item->status == ORDER_STATUS_PROCEEDED){




                                foreach ($this->items as $key => $value ){


                                    $newCounter = $value->sCounter + $value->counteS;

                                    $data['counter'] = intval($newCounter);
                                    $idProduct = $value->product_id;

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
                                        'counter' => $data['counter']
                                        );

                                    if($value->source == 1){

                                        $idMainProduct = $value->searchingId;

                                        // Обновляем все копии
                                        $this->db->update('products', $data, array('searchingId' => $idMainProduct, 'firm_id' => $this->firmID));

                                        // Обвновляем оригинальный товар

                                        $this->db->update('products', $data, array('product_id' => $idMainProduct, 'firm_id' => $this->firmID));
                                    }else{
                                        // Обновляем все копии
                                        $this->db->update('products', $data, array('searchingId' => $idMainProduct, 'firm_id' => $this->firmID));
                                    }


                                }

                                url::redirect("/orders/info/id/$id?statusChangedOnCancel");

                            }






                        default:
                            url::redirect("/orders/info/id/$id?statusChanged");
                    }

                    if($this->typeaction == ORDER_STATUS_DELIVERED){

                    }else{
                        url::redirect("/orders/info/id/$id?statusChanged");
                    }

                    exit();

                }
            }


             if ($_POST && isset($_POST['order']['content'])){

				if($this->addComment(($_POST['order']['content']), $id)){
					url::redirect("/orders/info/id/$id?comment");
					exit();
				}
            }
 
            $this->comments = $this->db->select('*')->from("comments")->
                    join("moders", 'moders.user_id', 'comments.moder_id', 'left')->
                    where($where)->orderby('date', 'desc')->get();

            if(!$this->item->field_type_pay  ) {

                $where = "status = ". STATUS_WORK . " and firm_id = " . $this->firmID;
                
                $this->deliveryType = $this->db->select('*')->from("delivery")-> 
                    where($where)->orderby('sort', 'desc')->get();
            }

        }else{
            Event::run('system.404');        
        }

    }



    public function ajax() {

        if(!$this->haveAccess()){
            return;
        };

        $delivery = intval($this->uri->segment('delivery'));

        $return_arr = array();

        $where = "delivery = ". $delivery . " and status = ". STATUS_WORK . " and firm_id = " . $this->firmID;

        $this->deliveryType = $this->db->select('*')->from("pay_type")->
            where($where)->orderby('sort', 'desc')->get();

        foreach ($this->deliveryType as $item) {

            $content = array(
                "title" => trim($item->title . ' (' . ($item->client_type == CLIENT_TYPE_FIZ ? 'физ.лицо' : 'юр.лицо') . ')'),
                "pay_id" => ($item->pay_id), 
            );
            array_push($return_arr, $content);
        }

        /* Toss back results as json encoded array. */
        echo json_encode($return_arr);
        exit();

    }

	private function addComment($content, $id){

		$data['content'] = $content;

		$data['firm_id'] = $this->firmID;
		$data['moder_id'] = $this->moderId;
		$data['order_id'] = $id;

		$data['date'] = date("Y.m.d H:i:s");

		if(!($data['content'])){
			$this->errorFields[] = "Содержание комментария";
		}

		if(is_null($this->error) && !count($this->errorFields)){

			$status = $this->db->insert('comments', $data);

			if(count($status)){
				return true;
			}

		}else{
			$this->error = $this->completeErrorFieldsMessage('Комментарий не добавлен. ');
		}

	}
} 