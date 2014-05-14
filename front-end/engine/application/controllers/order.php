<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Детали заказа
 */
class Order_Controller extends Web_Controller
{

    // Do not allow to run in production

    const ALLOW_PRODUCTION = false;

    function index($input_error = null)
    {

        // In Kohana, all views are loaded and treated as objects.
        $this->template->content              = new ViewMod('order_start');
        $this->template->content->input_error = $input_error;
        $this->selected_page                  = 'bin';
        $this->template->title                = 'Детали заказа';
        $table                                = 'products';

        $this->template->content->items_ses = $items = $this->session->get('items');
        $this->template->content->empty_bin = true;

        if (empty($items)) {
            //  header('Location: /');
            // exit();
        }

        if (array_key_exists('phone', $_REQUEST)) {

            $phone = trim($_REQUEST['phone']);

            $user_data['date']    = date('Y-m-d H:i:s');
            $user_data['total']   = 0;
            $user_data['ip']      = $this->input->ip_address();
            $user_data['firm_id'] = $this->firmID;

            $user_data['devivery'] = 0;
            $user_data['payment']  = 0;
            $user_data['status']   = ORDER_STATUS_NEW;

            $deliveryInfo       = new stdClass();
            $deliveryInfo->name = cookie::get('name') ? cookie::get('name') : '';
            ;
            $deliveryInfo->phone = $phone;

            $user_data['paymentInfo']  = json_encode($deliveryInfo);
            $user_data['deliveryInfo'] = '';

            $user_data['user_mail'] = cookie::get('mail') ? cookie::get('mail') : '';
            cookie::set('phone', $deliveryInfo->phone);

            $this->data = $user_data;

            $res = $this->db->insert('order', $user_data);

            if ($res) {

                $this->order_id = $res->insert_id();

                $this->title = 'Заявка №' . $this->order_id;
                $table       = 'order_items';

                $this->empty_bin = true;
                $this->items     = $items;

                if (count($items) > 0) {

                    $this->empty_bin = false;

                    $total = 0;
                    $where = null;
                    foreach ($items as $key => $value) {

                        $where .= $key . ', ';

                        $data = array();

                        $data['order_id'] = $this->order_id;
                        $data['count']    = $value->counter;
                        $data['it_id']    = $key;

                        $total += $value->counter * $value->price;

                        $this->db->insert('order_items', $data);
                        // $this->db->query("update products set counter = counter - " . $value->counter . " where product_id = " . $key);

                    }

                    $data = array(
                        'total' => $total,
                        'count' => count($items)
                    );

                    $this->db->update('order', $data, 'id = ' . $this->order_id);

                    if ($this->firm->sms_settings & SMS_ON_AMDIN_NEW_ORDER) {
                        SMSer::send($this->firm->sms_number,
                            'Поступил новый заказ №' . $this->order_id . ' на сумму ' . money::ru($total),
                            $this->firm->sms_title);
                    }

                    $content = new stdClass();

                    $content->items = $this->db->
                        select("*")->from("products")->
                        where('product_id in (' . substr($where, 0, -2) . ')')->orderby('title')->get();

                    $content->items_ses = $this->template->content->items_ses;

                    $content->cost        = $total;
                    $content->orderNumber = $this->order_id;

                    Mailer::orderToAdmin($this->order_id, $content, $deliveryInfo);
                }

                $this->session->set('items', array());
                $this->session->set('itemsConfirm', $items);
                $this->session->set('totalSum', money::ru(0));
                $this->session->set('orderID', $this->order_id);

                header('Location: /order?orderID=' . $this->order_id);
                exit();
            }

        }
        $error = array();

        $newOrder['orderID'] = $this->session->get('orderID');

        if ($newOrder['orderID']) {

            if ($_POST && !isset($_POST['address'])) {

                $newOrder['delivery_type'] = $_POST['request']['type'];
                $type_base                 = $_POST['request']['type_base'];

                cookie::set('delivery_type', $newOrder['delivery_type']);

                $fields       = $GLOBALS['DELIVERY_FIELDS'][$type_base];
                $deliveryInfo = new  stdClass();

                foreach ($fields as $fieldName => $desc) {

                    if ($desc->must && (!array_key_exists($fieldName, $_POST['request' . $type_base])
                        || (array_key_exists($fieldName, $_POST['request' . $type_base]) && empty($_POST['request' . $type_base][$fieldName])))
                    ) {
                        $error[] = "- " . $desc->name;
                    }
                    if (array_key_exists($fieldName, $_POST['request' . $type_base])) {
                        $deliveryInfo->{$fieldName} = trim($_POST['request' . $type_base][$fieldName]);
                        cookie::set($fieldName, trim($_POST['request' . $type_base][$fieldName]));
                    }

                }

                if (!count($error)) {

                    $this->session->set('newOrder', $newOrder);
                    $this->session->set('deliveryInfo', $deliveryInfo);
                    $this->session->set('deliveryID', $newOrder['delivery_type']);
                    $this->session->set('baseDeliveryType', $type_base);

                    $user_data['devivery']     = $newOrder['delivery_type'];
                    $user_data['deliveryInfo'] = json_encode($deliveryInfo);
                    $this->db->update('order', $user_data, array('id' => $newOrder['orderID']));

                    header('Location: /order/payway');
                    exit();
                }

            }


            if (!$_POST) {
                $_POST                    = array();
                $_POST['request']         = array();
                $_POST['request']['type'] = cookie::get('delivery_type');
            }

            if ($_POST && isset($_POST['address'])) {
                $address = json_decode(urldecode($_POST['address']));

                $_REQUEST['request' . DELIVERY_TYPE_CURIER]               = array();
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['name']       = $address->firstname . ' ' . $address->lastname;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['mail']       = $address->email;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['phone']      = $address->phone;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['metro']      = $address->metro;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['street']     = $address->street;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['house']      = $address->building;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['houseAddOn'] = $address->suite;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['podiezd']    = $address->entrance;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['floor']      = $address->floor;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['apr']        = $address->flat;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['domoph']     = $address->intercom;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER]['comment']    = $address->comment;

                $_REQUEST['request' . DELIVERY_TYPE_CURIER_TO_METRO]            = array();
                $_REQUEST['request' . DELIVERY_TYPE_CURIER_TO_METRO]['name']    = $address->firstname . ' ' . $address->lastname;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER_TO_METRO]['mail']    = $address->email;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER_TO_METRO]['phone']   = $address->phone;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER_TO_METRO]['metro']   = $address->metro;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER_TO_METRO]['street']  = $address->street;
                $_REQUEST['request' . DELIVERY_TYPE_CURIER_TO_METRO]['comment'] = $address->comment;

                $_REQUEST['request' . DELIVERY_TYPE_EMS]              = array();
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['name']      = $address->firstname;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['thirdName'] = $address->lastname;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['soname']    = $address->fathersname;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['mail']      = $address->email;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['phone']     = $address->phone;

                $_REQUEST['request' . DELIVERY_TYPE_EMS]['index']      = $address->zip;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['city']       = $address->city;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['street']     = $address->street;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['house']      = $address->building;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['houseAddOn'] = $address->suite;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['podiezd']    = $address->entrance;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['floor']      = $address->floor;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['apr']        = $address->flat;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['domoph']     = $address->intercom;
                $_REQUEST['request' . DELIVERY_TYPE_EMS]['comment']    = $address->comment;


                $_REQUEST['request' . DELIVERY_TYPE_HIMSELF]          = array();
                $_REQUEST['request' . DELIVERY_TYPE_HIMSELF]['name']  = $address->firstname . ' ' . $address->lastname;
                $_REQUEST['request' . DELIVERY_TYPE_HIMSELF]['mail']  = $address->email;
                $_REQUEST['request' . DELIVERY_TYPE_HIMSELF]['phone'] = $address->phone;

            }

            $table = 'delivery';
            $where = 'firm_id = ' . $this->firmID . ' and status = ' . STATUS_WORK;

            $this->template->content->input_error = $error;

            $this->template->content->delivery = $this->db->select('*')->from($table)->
                where($where)->orderby('sort', 'asc')->get();


        } else {

        }

    }

    function payway()
    {

        // In Kohana, all views are loaded and treated as objects.
        $this->template->content = new View('order_pay_way');
        $this->selected_page     = 'bin';
        $this->template->title   = 'Способ доставки';

        $this->template->content->input_error = null;
        // $this->template->content->items_ses = $items = $this->session->get('items');
        $this->template->content->empty_bin = true;

        $newOrder = $this->session->get('newOrder');

        if (isset($newOrder['type_of_client'])) {
            $this->template->content->client_type_check = $newOrder['type_of_client'];
            $this->template->content->pay_way_check     = cookie::get('field_type');
        }

        $error = array();

        $newOrder['orderID'] = $this->session->get('orderID');

        if ($newOrder['orderID']) {

            if ($_POST) {

                $newOrder['pay_way']        = $_POST['request']['pay_way'];
                $newOrder['type_of_client'] = $_POST['request']['type_of_client'];

                $type_base = $_POST['request']['field_type'];

                cookie::set('type_of_client', $newOrder['type_of_client']);
                cookie::set('field_type', $type_base);

                $fields       = $GLOBALS['PAY_WAY_TYPE'][$type_base];
                $deliveryInfo = new  stdClass();

                if (count($fields)) {

                    foreach ($fields as $fieldName => $desc) {

                        if ($desc->must && (!array_key_exists($fieldName, $_POST['request'])
                            || (array_key_exists($fieldName, $_POST['request']) && empty($_POST['request'][$fieldName])))
                        ) {
                            $error[] = "Незаполенно обязательно поле " . $desc->name;
                        }
                        if (array_key_exists($fieldName, $_POST['request'])) {
                            $deliveryInfo->{$fieldName} = trim($_POST['request'][$fieldName]);
                            cookie::set($fieldName, trim($_POST['request'][$fieldName]));
                        }

                    }

                }
                if (!count($error)) {

                    $this->session->set('newOrder', $newOrder);
                    $this->session->set('paymentInfo', $deliveryInfo);
                    $this->session->set('basePayWay', $type_base);

                    $user_data['payment']     = $newOrder['pay_way'];
                    $user_data['paymentInfo'] = json_encode($deliveryInfo);

                    $this->db->update('order', $user_data, array('id' => $newOrder['orderID']));

                    $this->session->write_close();

                    header('Location: /order/confirm');
                    exit();
                }
            }

            if (!$_POST) {
                $_POST                              = array();
                $_POST['request']                   = array();
                $_POST['request']['type_of_client'] = cookie::get('type_of_client');
                $_POST['request']['field_type']     = cookie::get('field_type');
            }

            $deliveryID = intval($this->session->get('deliveryID'));

            $this->template->content->input_error = $error;
            $this->template->content->pay_way     = $this->db->select('*')->from('pay_type')
                ->where('1=1 and firm_id = ' . $this->firmID . ' and delivery = ' . $deliveryID . ' and status = ' . STATUS_WORK)
                ->orderby('sort', 'asc')->get();

        } else {

        }

    }

    function confirm()
    {

        // In Kohana, all views are loaded and treated as objects.
        $this->template->content = new View('order_confirm');
        $this->selected_page     = 'bin';
        $this->template->title   = 'Подтверждение заказа';
        $table                   = 'products';


        $this->template->content->input_error = null;
        $this->template->content->items_ses   = $items = $this->session->get('itemsConfirm');
        $this->template->content->empty_bin   = true;

        $newOrder = $this->session->get('newOrder');

        if (!empty($items)) {

            $this->template->content->empty_bin = false;
            $this->template->content->order     = $newOrder;

            if (empty($newOrder['delivery_type']) || empty($newOrder['pay_way'])) {
                header('Location: /order/');
                exit();
            }

            $table = 'delivery';
            $where = 'firm_id = ' . $this->firmID . " and del_id = " . $newOrder['delivery_type'] . ' and status = ' . STATUS_WORK;

            $this->template->content->delivery = $this->db->select('*')->from($table)->
                where($where)->orderby('sort', 'asc')->get();
            $this->template->content->delivery = $this->template->content->delivery[0];

            $this->template->content->pay_way = $this->db->select('*')->from('pay_type')
                ->where('1=1 and firm_id = ' . $this->firmID . " and pay_id = " . $newOrder['pay_way'] . ' and status = ' . STATUS_WORK)
                ->orderby('sort', 'asc')->get();
            $this->template->content->pay_way = $this->template->content->pay_way[0];

            $where = null;
            foreach ($items as $key => $count) {
                $where .= $key . ', ';
            }

            $this->template->content->items = $this->db->
                select("*")->from("products")->
                where('product_id in (' . substr($where, 0, -2) . ')')->orderby('title')->get();

            $this->template->content->basePayWay       = $this->session->get('basePayWay');
            $this->template->content->baseDeliveryType = $this->session->get('baseDeliveryType');

            $this->template->content->paymentInfo  = $this->session->get('paymentInfo');
            $this->template->content->deliveryInfo = $this->session->get('deliveryInfo');

        } else {

        }

    }

    function printing()
    {

        // In Kohana, all views are loaded and treated as objects.
        $this->template->content = new View('print');

        if ($_POST) {

            $newOrder = $this->session->get('newOrder');

            $orderID = $this->session->get('orderID');

            $user_data['devivery'] = $newOrder['delivery_type'];
            $user_data['payment']  = $newOrder['pay_way'];

            $deliveryInfo = $this->session->get('deliveryInfo');

            $user_data['paymentInfo']  = json_encode($this->session->get('paymentInfo'));
            $user_data['deliveryInfo'] = json_encode($deliveryInfo);

            $this->template->content->items_ses = $items = $this->session->get('itemsConfirm');
            $this->template->content->data      = $user_data;

            $user_data['user_mail'] = $deliveryInfo->mail;

            //$res = $this->db->update('order', $user_data, array('id' => $orderID)); 
            if ($orderID) {

                $this->template->content->order_id = $orderID;

                $this->template->content->title = 'Заявка №' . $this->template->content->order_id;
                $table                          = 'order_items';

                $this->template->content->empty_bin = true;
                $this->template->content->items     = $items;

                if (count($items) > 0) {

                    $this->template->content->empty_bin = false;

                    $total = 0;
                    foreach ($this->template->content->items as $key => $value) {

                        $data = array();

                        $data['order_id'] = $this->template->content->order_id;
                        $data['count']    = $value->counter;
                        $data['it_id']    = $key;

                        $total += $value->counter * $value->price;
                    }

                    $table = 'delivery';
                    $where = 'firm_id = ' . $this->firmID . " and del_id = " . $newOrder['delivery_type'];

                    $delivery = $this->db->select('*')->from($table)->
                        where($where)->orderby('sort', 'asc')->get();
                    $delivery = $delivery[0];

                    $total += $delivery->cost;

                    $data = array(
                        'total' => $total
                    );

                    $this->db->update('order', $data, 'id = ' . $this->template->content->order_id);

                    $content = new stdClass();

                    $table = 'delivery';
                    $where = 'firm_id = ' . $this->firmID . " and del_id = " . $newOrder['delivery_type'];

                    $content->delivery = $this->db->select('*')->from($table)->
                        where($where)->orderby('sort', 'asc')->get();
                    $content->delivery = $content->delivery[0];

                    $content->pay_way = $this->db->select('*')->from('pay_type')
                        ->where('1=1 and firm_id = ' . $this->firmID . " and pay_id = " . $newOrder['pay_way'])
                        ->orderby('sort', 'asc')->get();
                    $content->pay_way = $content->pay_way[0];

                    $where = null;
                    foreach ($items as $key => $count) {
                        $where .= $key . ', ';
                    }

                    $content->items = $this->db->
                        select("*")->from("products")->
                        where('product_id in (' . substr($where, 0, -2) . ')')->orderby('title')->get();

                    $content->basePayWay       = $this->session->get('basePayWay');
                    $content->baseDeliveryType = $this->session->get('baseDeliveryType');

                    $content->paymentInfo  = $this->session->get('paymentInfo');
                    $content->deliveryInfo = $this->session->get('deliveryInfo');


                    $content->items_ses = $this->template->content->items_ses;


                    $content->cost        = $total;
                    $content->orderNumber = $this->template->content->order_id;

                    Mailer::orderToUser($content->deliveryInfo->mail, $content->deliveryInfo->name, $this->template->content->order_id, $content);

                    // Mailer::orderSent($content->deliveryInfo->mail , $content->deliveryInfo->name, $this->template->content->order_id, $content);
                }

                $this->session->set('items', array());
                $this->session->set('itemsConfirm', array());
                $this->session->set('totalSum', money::ru(0));

                header('Location: /?thanx=' . $this->template->content->order_id);
                exit();
            }
        } else {
            header('Location: /?trace#4');
        }

    }

    public function priselist()
    {
        download::force(FILE_PRISE, 'Price list is not available');
    }
} //
