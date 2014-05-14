<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * История заказов и информация о заказов
 *
 * @package    Core
 * @author     Ivan Chura
 * @copyright  (c) 2010-2013 Ivan Chura
 * @license    http://shopping-plaza.ru/license.html
 */
class Dashboard_Controller extends Web_Controller
{

    const ALLOW_PRODUCTION = false;

    var $all_count = 0;

    public function __construct()
    {

        parent::__construct();

        if ($this->userId == 0) {
            url::redirect(url::site() . "");
            exit();
        }
    }

    function index()
    {

        $this->template->content        = new ViewMod('dashboard/index');
        $this->template->content->error = false;


        $this->template->title = 'История заказов';

        $offset = $this->uri->segment('page');


        $page_limit = 25;

        $table = 'order';
        $where = '1=1 and order.firm_id = ' . $this->firmID .
            " and order.user_mail = '" . mysql_real_escape_string($this->userMail) . "'";

        $offset = $page_limit * ($offset - 1);

        if (!isset($offset) || $offset <= 0) {
            $offset = 0;
        }

        $this->template->content->items = $this->db->select(
            $table . '.*, pay_type.title as payment, delivery.title as devivery')->from($table)->
            join("pay_type", 'pay_type.pay_id', 'order.payment', 'left')->
            join("delivery", 'delivery.del_id', 'order.devivery', 'left')->
            where($where)->offset($offset)->limit($page_limit)->orderby('date', 'acs')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(

            // Base_url will default to the current URI
            'base_url'       => 'dashboard/index',

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
            'auto_hide'      => true,
        ));

        $this->template->content->pagination         = $pagination->render('digg');
        $this->template->content->count_records      = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;
    }

    public function order()
    {

        $this->template->content = new ViewMod('dashboard/info');

        $id = intval($this->uri->segment('id'));

        $this->template->title = 'Информация о заказе ' . $id;

        $table = "order";
        $where = "order.id = " . $id . " and order.firm_id = " . $this->firmID .
            " and order.user_mail = '" . mysql_real_escape_string($this->userMail) . "'";
        ;

        $this->item = $this->db->
            select($table . '.*, pay_type.title as payment, delivery.title as delivery, delivery.cost as delivery_cost
                , pay_type.field_type as field_type_pay, delivery.type as field_type_devivery')->from($table)->
            join("pay_type", 'pay_type.pay_id', 'order.payment', 'left')->
            join("delivery", 'delivery.del_id', 'order.devivery', 'left')->
            where($where)->get();

        if ($this->item->count() == 0) {
            url::redirect(url::site() . "dashboard/");
            exit();
        }

        $this->item = $this->item[0];

        $this->deliveryInfo = json_decode($this->item->deliveryInfo);
        $this->paymentInfo  = json_decode($this->item->paymentInfo);

        $this->type = $this->item->status;

        $where       = "order_id = " . $id;
        $this->items = $this->db->select('*')->from("order_items")->
            join("products", 'products.product_id', 'order_items.it_id', 'left')->
            where($where)->orderby('title', 'acs')->get();


    }
}

?>