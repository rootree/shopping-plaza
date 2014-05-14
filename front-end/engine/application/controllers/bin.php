<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Корзина при заказе
 */
class Bin_Controller extends Web_Controller
{

    // Do not allow to run in production

    const ALLOW_PRODUCTION = false;

    function index($input_error = false)
    {

        // In Kohana, all views are loaded and treated as objects.
        $this->template->content              = new ViewMod('bin');
        $this->template->content->input_error = $input_error;
        $this->selected_page                  = 'bin';
        $this->template->title                = 'Отложенные товары';
        $table                                = 'products';

        $this->template->content->items_ses = $items = $this->session->get('items');

        $this->template->content->empty_bin = true;

        if (!empty($items)) {

            if ($_POST) {

                foreach ($_REQUEST['items'] as $key => $counter) {

                    if (array_key_exists($key, $items)) {

                        $counter = intval($counter);
                        if ($counter > 0) {
                            $items[$key]->counter = $counter;
                            $items[$key]->counter = $counter;
                        } else {
                            unset($items[$key]);
                        }
                    }

                }

                $this->session->set('items', $items);
                $this->template->content->items_ses = $items = $this->session->get('items');

                $totalSum = 0;

                foreach ($items as $charItem) {
                    $totalSum += ($charItem->counter * $charItem->price);
                }

                $this->session->set('totalSum', money::ru($totalSum));
                $this->totalSum = money::ru($totalSum);

            }

            $this->template->content->empty_bin = false;

            $where = null;
            $count = count($items);

            reset($items);
            for ($i = 0; $i < $count; $i++) {
                $item = (current($items));
                next($items);
                $where .= $item->item_id . ', ';
            }

            $this->template->content->items = $this->db->
                select($table . ".*")->from($table)->
                where('product_id in (' . substr($where, 0, -2) . ')')->orderby('title')->get();

        } else {

        }

    }

    function store()
    {

        $item_id = intval($this->uri->segment('itemid'));
        $counter = intval($this->uri->segment('counter'));

        if ($item_id != 0 && $counter != 0) {

            $table = "products";
            $where = "product_id = " . $item_id . ' and firm_id = ' . $this->firmID;
            ;
            ;

            $item = $this->db->select('*')->from($table)->
                where($where)->get();

            if (!isset($item[0])) {
                exit();
            }

            $item = $item[0];

            $charItem          = new stdClass();
            $charItem->item_id = $item_id;
            $charItem->counter = $counter;
            $charItem->price   = $item->price;

            $sess_items = $this->session->get('items');

            if (!count($sess_items)) {
                $sess_items = array();
            }
            $sess_items[$item_id] = $charItem;
            $this->session->set('items', $sess_items);
        } else {
            exit();
        }

        $totalSum   = 0;
        $itemsCount = 0;

        foreach ($sess_items as $charItem) {

            $totalSum += ($charItem->counter * $charItem->price);
            $itemsCount++;
        }

        $forSend             = new stdClass();
        $forSend->totalSum   = money::ru($totalSum);
        $forSend->itemsCount = ($itemsCount);

        $this->session->set('totalSum', $forSend->totalSum);


        echo(json_encode($forSend));
        exit();

    }

    function trash()
    {

        $item_id = $this->uri->segment('itemid');
        $items   = $this->session->get('items');

        unset($items[$item_id]);
        $this->session->set('items', $items);

        $totalSum = 0;

        foreach ($items as $charItem) {
            $totalSum += ($charItem->counter * $charItem->price);
        }

        $this->session->set('totalSum', money::ru($totalSum));
        $this->totalSum = money::ru($totalSum);

        exit();

    }

    function printing()
    {

        // In Kohana, all views are loaded and treated as objects.
        $this->template->content = new ViewMod('print');

        if ($_POST) {

            $user_data['name']    = $_POST['request']['name'];
            $user_data['phone']   = $_POST['request']['phone'];
            $user_data['mail']    = $_POST['request']['mail'];
            $user_data['date']    = date('Y-m-d H:i:s');
            $user_data['total']   = 0;
            $user_data['ip']      = $this->input->ip_address();
            $user_data['firm_id'] = $this->firmID;

            if ((!valid::email($user_data['mail']) || !valid::phone($user_data['phone'])
                || !valid::alpha($user_data['name']))
            ) {
                $_POST = false;
                $this->index(true);
                return;
                ;
            }

            cookie::set('name', $user_data['name']);
            cookie::set('mail', $user_data['mail']);
            cookie::set('phone', $user_data['phone']);

            $this->template->content->items_ses = $items = $this->session->get('items');
            $this->template->content->data      = $user_data;

            $user_data['clientName']  = $user_data['name']; // TODO
            $user_data['clientPhone'] = $user_data['phone'];
            $user_data['clientMail']  = $user_data['mail'];

            $res = $this->db->insert('order', $user_data);
            if ($res) {


                $this->template->content->order_id = $res->insert_id();

                $this->template->content->title = 'Заявка №' . $this->template->content->order_id;
                $table                          = 'order_items';

                $this->template->content->empty_bin = true;
                $this->template->content->items     = $items;

                if (count($items) > 0) {

                    $this->template->content->empty_bin = false;

                    $total = $total_internet = 0;
                    foreach ($this->template->content->items as $key => $value) {

                        $data = array();

                        $data['order_id'] = $this->template->content->order_id;
                        $data['count']    = $value;
                        $data['it_id']    = $key;

                        //		$total += $data['oi_count'] * $key->it_first_price;
                        //		$total_internet += $data['oi_count'] * formula($key);

                        $this->db->insert('order_items', $data);

                    }

                    $this->session->set('items', array());

                    unset($_POST);

                } else {
                }

                header('Location: /?thanx');
                exit();


            } else {
                header('Location: /?trace#4');
            }

        } else {
            header('Location: /?trace#3');
        }

        exit();
    }


    function quickorder()
    {

        if ($_GET) {

            $user_data['date']    = date('Y-m-d H:i:s');
            $user_data['total']   = 0;
            $user_data['ip']      = $this->input->ip_address();
            $user_data['firm_id'] = $this->firmID;

            $user_data['devivery'] = 0;
            $user_data['payment']  = 0;
            $user_data['status']   = ORDER_STATUS_NEW;

            $deliveryInfo        = new stdClass();
            $deliveryInfo->name  = $_GET['name'];
            $deliveryInfo->phone = $_GET['phone'];


            $user_data['clientName']  = $deliveryInfo->name; // TODO
            $user_data['clientPhone'] = $deliveryInfo->phone;


            $user_data['paymentInfo']  = json_encode($deliveryInfo);
            $user_data['deliveryInfo'] = '';

            $user_data['user_mail'] = cookie::get('mail') ? cookie::get('mail') : '';

            cookie::set('name', $deliveryInfo->name);
            cookie::set('phone', $deliveryInfo->phone);

            $items      = $this->session->get('items');
            $this->data = $user_data;


            $id    = $_GET['id'];
            $table = "products";
            $where = "product_id = " . $id . ' and firm_id = ' . $this->firmID;
            ;
            ;

            $item = $this->db->select('*')->from($table)->
                where($where)->get();

            if (!isset($item[0])) {
                header('Location: /?trace#3');
                exit();
            }

            $item = $item[0];

            $charItem          = new stdClass();
            $charItem->item_id = $id;
            $charItem->counter = 1;
            $charItem->price   = $item->price;

            $items[$id] = $charItem;

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
                    foreach ($items as $key => $value) {

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
                            'Поступил новый заказ быстрого оформления №' . $this->order_id,
                            $this->firm->sms_title);
                    }
                }

                $this->session->set('items', array());
                $this->session->set('totalSum', money::ru(0));

                $this->session->set('orderID', $this->order_id);
                $this->session->set('itemsConfirm', $items);

                // header('Location: /?thanx=' . $this->order_id);
                header('Location: /order?orderID=' . $this->order_id);
                exit();
            }

        } else {
            header('Location: /?trace#3');
        }

        exit();
    }


    public function priselist()
    {
        download::force(FILE_PRISE, 'Price list is not available', format::do_latin($this->firm->title) . '_' . date(DATE_FORMAT_LITE) . '.zip');
    }
} //
