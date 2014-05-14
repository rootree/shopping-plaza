<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Весь каталог товара, + формат для Yandex.Market и Товары.MailRU
 */
class Catalog_Controller extends Web_Controller
{

    const ALLOW_PRODUCTION = false;
    var $all_count = 0;

    function index()
    {

        $this->template->content        = new ViewMod('catalog');
        $this->template->content->error = false;
        $this->selected_page            = 'catalog';

        $this->template->title = 'Каталог';
        ;

        $table = 'products';

        $this->template->content->groups = $this->db->select('*')->from('cats')->
            orderby('sort')->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->orderby('title')->get();

        $this->template->content->items = $this->db->select($table . '.* ')->
            from($table)->groupby('title')->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->
            orderby(array('counter' => 'DESC', 'title' => 'ACS'))->get();
        //	$this->template->content->items = $this->db->query(
        //        "SELECT DISTINCT `products`.title, `products`.* FROM (`products`)
//WHERE firm_id = " . $this->firmID ." and status = ".STATUS_WORK." ORDER BY `counter` DESC, `title` ASC ");

        $this->template->content->items_ses = $items = $this->session->get('items');

    }

    function yandex()
    {

        // TODO доделать самовывоз, забор в магазине


        $message = new ViewMod('yandexMarket');

        $table = 'products';

        $message->groups = $this->db->select('*')->from('cats')->
            orderby('sort')->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->orderby('title')->get();

        $message->groupsSub = $this->db->select('*')->from('catssub')->
            orderby('sort')->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->orderby('title')->get();

        $message->items = $this->db->select($table . '.*, ' . $table . '.title as title, product_imgs.id as img, cats.title as title_cat, searchingImg.id as imgSearch')->
            join('product_imgs', array('product_imgs.product_id' => $table . '.product_id',
                                       'product_imgs.favorite'   => 1), null, 'left')->
            join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table . '.searchingId',
                                                      'searchingImg.favorite'   => 1), null, 'left')->
            join('cats', array('cats.cat_id' => $table . '.cat_id', 'cats.status' => STATUS_WORK))->
            join('catssub', array('catssub.catsub_id' => $table . '.catsub_id', 'catssub.status' => STATUS_WORK))->
            from($table)->where($table . ".firm_id = " . $this->firmID . ' and ' . $table . '.status = ' . STATUS_WORK)->orderby('title')->get();


        $table = "fields";
        $where = 'fields.firm_id = ' . $this->firmID;
        ;
        $message->fields = $this->db->select('*')->from($table)
            ->join('product_fields', array(
            'fields.field_id' => 'product_fields.field_id'
        ))
            ->where($where)->get();


        $table = "delivery";
        $where = "cost > 0 and type = " . DELIVERY_TYPE_CURIER . ' and delivery.firm_id = ' . $this->firmID . ' and status = ' . STATUS_WORK;
        ;

        $message->delivery = $this->db->select('*')->from($table)->
            where($where)->orderby("cost", "asc")->limit(1)->get();
        $message->delivery = $message->delivery[0];


        $message_body = $message->render();

        echo $message_body;
        exit();

    }

    function mailru()
    {

        // TODO доделать самовывоз, забор в магазине

        $message = new ViewMod('tovariNaMailRU');

        $table = 'products';

        $message->groups = $this->db->select('*')->from('cats')->
            orderby('sort')->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->orderby('title')->get();

        $message->groupsSub = $this->db->select('*')->from('catssub')->
            orderby('sort')->where("firm_id = " . $this->firmID . ' and status = ' . STATUS_WORK)->orderby('title')->get();

        $message->items = $this->db->select($table . '.*, ' . $table . '.title as title, product_imgs.id as img, cats.title as title_cat')->
            join('product_imgs', array('product_imgs.product_id' => $table . '.product_id',
                                       'product_imgs.favorite'   => 1), null, 'left')->
            join('cats', array('cats.cat_id' => $table . '.cat_id'), null, 'left')->
            from($table)->where($table . ".firm_id = " . $this->firmID)->orderby('title')->get();


        $table = "fields";
        $where = 'fields.firm_id = ' . $this->firmID;
        ;
        $message->fields = $this->db->select('*')->from($table)
            ->join('product_fields', array(
            'fields.field_id' => 'product_fields.field_id'
        ))
            ->where($where)->get();


        $table = "delivery";
        $where = "type = " . DELIVERY_TYPE_CURIER . ' and delivery.firm_id = ' . $this->firmID . ' and status = ' . STATUS_WORK;
        ;

        $message->delivery = $this->db->select('*')->from($table)->
            where($where)->orderby("cost", "asc")->limit(1)->get();
        $message->delivery = $message->delivery[0];


        $message_body = $message->render();

        echo $message_body;
        exit();

    }

}

?>