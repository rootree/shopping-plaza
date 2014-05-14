<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Каталог товара, и отдельная карточка товара
 *
 * @package    Core
 * @author     Ivan Chura
 * @copyright  (c) 2010-2013 Ivan Chura
 * @license    http://shopping-plaza.ru/license.html
 */
class Products_Controller extends Web_Controller
{

    const ALLOW_PRODUCTION = false;

    var $all_count = 0;

    public function __construct()
    {

        parent::__construct();

        if (array_key_exists('sortBy', $_REQUEST)) {
            $this->sortBy = $this->setSorting($_REQUEST['sortBy']);
        }
    }

    function setSorting($sortByE)
    {
        $sortBy = false;
        switch ($sortByE) {

            case 'priceUp':
                $sortBy = 'price asc';
                break;
            case 'priceDown':
                $sortBy = 'price desc';
                break;
            case 'ratingUp':
                $sortBy = 'viewed asc';
                break;
            case 'ratingDown':
                $sortBy = 'viewed desc';
                break;
            case 'title':
                $sortBy = 'title asc';
                break;
            default :
                $sortBy = 'title `asc';
        }

        if ($sortBy) {
            cookie::set('sortBy', $sortBy);
        }

        return $sortBy;
    }

    function index()
    {

        $this->template->content        = new ViewMod('products');
        $this->template->content->error = false;

        $this->url_link    = ($this->uri->segment('topic'));
        $this->catsubTopic = ($this->uri->segment('catsub'));

        if (!$this->url_link) {
            Event::run('system.404');
            return;
        }


        if (empty($this->sortBy)) {
            $this->sortBy = cookie::get('sortBy');
            if (empty($this->sortBy)) {
                $this->sortBy = $this->setSorting('title');
            }
        }
        $table = "cats";
        $where = "cats.url_link = '" . mysql_escape_string($this->url_link) . '\' and cats.firm_id = ' . $this->firmID
            . ' and cats.status = ' . STATUS_WORK;
        ;


        $catID = $this->db->select('cat_id, title, desc')->from($table)->where($where)->get();
        $catID = $catID[0];

        if (!$catID) {
            Event::run('system.404');
            return;
        }

        $this->id        = $catID->cat_id;
        $this->catsub_id = null;

        if ($this->catsubTopic) {

            $table = "catssub";
            $where = "catssub.url_link = '" . mysql_escape_string($this->catsubTopic) . '\' and catssub.firm_id = ' . $this->firmID
                . ' and catssub.status = ' . STATUS_WORK;
            ;
            ;

            $catIDSub = $this->db->select('catsub_id, title, desc')->from($table)->where($where)->get();
            $catIDSub = $catIDSub[0];

            if (!$catIDSub) {
                Event::run('system.404');
                return;
            }

            $this->catsub_id = $catIDSub->catsub_id;
        }

        $this->template->content->items_ses = $items = $this->session->get('items');

        $offset = $this->uri->segment('page');

        $page_limit = 10;

        $table = 'products';
        $where = 'products.cat_id = "' . $this->id . '" and products.firm_id = ' . $this->firmID
            . ' and products.status = ' . STATUS_WORK;

        if ($this->catsub_id) {
            $where .= ' and products.catsub_id = "' . $this->catsub_id . '"';
        }

        if (!isset($offset) || $offset == 0) {
            $offset = 1;
        }

        $offset = $page_limit * ($offset - 1);


        $this->template->content->items = $this->db->select($table . '.*, product_imgs.id as img, searchingImg.id as imgSearch')->from($table)->

            join('product_imgs', array('product_imgs.product_id' => $table . '.product_id',
                                       'product_imgs.favorite'   => 1), null, 'left')->
            join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table . '.searchingId',
                                                      'searchingImg.favorite'   => 1), null, 'left')->

            join('cats', array('products.cat_id' => 'cats.cat_id',
                               'cats.status'     => STATUS_WORK))->
            join('catssub', array('products.catsub_id' => 'catssub.catsub_id',
                                  'catssub.status'     => STATUS_WORK))->

            where($where)->groupby($table . '.product_id')->offset($offset)->limit($page_limit)->
            groupby($table . '.title')->
            orderby(array(substr($this->sortBy, 0, strpos($this->sortBy, ' ')) => (substr($this->sortBy, -3) != 'asc' ? 'desc' : 'asc')))

            ->get();


        if (count($this->template->content->items)) {

            $count_records = $this->db->select(' count(`products`.`product_id`) as count ')->from($table)->

                join('cats', array('products.cat_id' => 'cats.cat_id',
                                   'cats.status'     => STATUS_WORK))->
                join('catssub', array('products.catsub_id' => 'catssub.catsub_id',
                                      'catssub.status'     => STATUS_WORK))->

                where($where)

                ->get();


            $count_records = $count_records[0];
            $count_records = $count_records->count;
            // $count_records = $count_records->count_records();

        } else {
            $count_records = 0;
        }


        $where = 'cat_id = "' . $this->id . '" and firm_id = ' . $this->firmID . ' and status = ' . STATUS_WORK;

        $this->catssub = $this->db->select('*')->from("catssub")->
            where($where)->orderby('sort')->get();


        $this->title  = $this->template->title = ($catID->title) . (isset($catIDSub) ? ' :: <strong>' . $catIDSub->title . '</strong>' : '');
        $this->catSub = (isset($catIDSub) ? $catIDSub : null);
        $this->cat    = $catID;
        // $this->crn;;
        $this->keywords = getKeyWords($this->title);

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'       => 'products/index/topic/' . $this->url_link .
                (($this->catsubTopic) ? '/catsub/' . $this->catsubTopic . '' : ''),

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


        $this->template->content->pagination = $pagination->render('digg');

        $this->template->content->empty_bin = true;

    }

    function item()
    {

        $this->template->content        = new ViewMod('item');
        $this->template->content->error = false;

        $this->url_title       = ($this->uri->segment('title'));
        $this->idItem          = ($this->uri->segment('id'));
        $this->commentsEnabled = ($this->firm->comment_settings & COMMENT_ON_ITEMS);

        if (!$this->url_title && !$this->idItem) {
            Event::run('system.404');
            return;
        }

        if (!$this->url_title) {

            $table = "products";
            $where = "product_id = " . $this->idItem . ' and products.firm_id = ' . $this->firmID
                . ' and products.status in (' . STATUS_WORK . ',' . STATUS_DELETED . ')';
            ;
            ;

            $this->template->content->item = $this->db->select('products.*')->from($table)->

                join('cats', array('cats.cat_id' => $table . '.cat_id', 'cats.status' => STATUS_WORK))->
                join('catssub', array('catssub.catsub_id' => $table . '.catsub_id', 'catssub.status' => STATUS_WORK))->

                where($where)->get();

            $this->template->content->item = $this->template->content->item[0];


            if (!$this->template->content->item) {

                url::redirect(url::site() . "products/index/topic/Videoregistratory");

                Event::run('system.404');
                return;

            }
        } else {

            $table = "products";
            $where = "products.url_link = '" . mysql_escape_string($this->url_title) . '\' and products.firm_id = ' . $this->firmID
                . ' and products.status in (' . STATUS_WORK . ',' . STATUS_DELETED . ')';
            ;
            ;

            $this->template->content->item = $this->db->select('products.*')->from($table)->
                join('cats', array('cats.cat_id' => $table . '.cat_id', 'cats.status' => STATUS_WORK))->
                join('catssub', array('catssub.catsub_id' => $table . '.catsub_id', 'catssub.status' => STATUS_WORK))->
                where($where)->get();

            $this->template->content->item = $this->template->content->item[0];


            if (!$this->template->content->item) {

                $item = $this->db->select('*')->from('product_link')->
                    where(array('link' => $this->url_title, 'firm_id' => $this->firmID))->get();
                $item = $item[0];

                if (!$item) {
                    url::redirect(url::site() . "products/index/topic/Videoregistratory");
                    Event::run('system.404');
                    return;
                } else {
                    header('Location: /products/item/id/' . $item->product_id);
                    exit();
                }
            }

            $this->idItem = $this->template->content->item->product_id;

        }

        $this->db->query('update products set viewed = viewed + 1 where product_id = \'' . mysql_escape_string($this->idItem) . '\' and firm_id = ' . $this->firmID);

        $this->template->title = $this->template->content->item->title;

        if (!empty($this->template->content->item->desc_mini)) {
            $this->descriptionHTML = $this->template->content->item->desc_mini;
        }


        $where = 'cat_id = "' . $this->template->content->item->cat_id . '" and firm_id = ' . $this->firmID . ' and status = ' . STATUS_WORK;
        ;

        $this->catssub = $this->db->select('*')->from("catssub")->
            where($where)->orderby('sort')->get();

        foreach ($this->template->groups as $key) {
            if ($key->cat_id == $this->template->content->item->cat_id) {
                $this->url_link = $key->url_link;
                break;
            }
        }


        $this->id        = $this->template->content->item->cat_id;
        $this->catsub_id = $this->template->content->item->catsub_id;

        $this->template->content->items_ses = $this->session->get('items');

        $this->keywords = getKeyWords($this->template->title);

        $where = 'firm_id = ' . $this->firmID . ' and status = ' . STATUS_WORK;

        $this->delivery = $this->db->select('*')->from('delivery')->
            where($where)->orderby('sort', 'asc')->get();


        if ($this->commentsEnabled) {

            $where = 'coment_type = ' . COMMENT_ON_ITEMS . ' and item_id = ' . $this->idItem .
                ' and  firm_id = ' . $this->firmID . ' and status in (  ' . COMMENT_STATUS_NEW . ',' . COMMENT_STATUS_VIEWED . ',' . COMMENT_STATUS_ANSWERED . ',' . COMMENT_STATUS_ANSWER . ')';

            $this->template->content->comments = $this->db->select('*')->from('comment_items')->
                where($where)->orderby('coment_id', 'asc')->get();

        }


        if ($this->template->content->item->source == 1 && $this->template->content->item->searchingId) {

            $this->idItem = $this->template->content->item->searchingId;

            $table    = "products";
            $where    = "product_id = " . $this->idItem . " and firm_id = " . $this->firmID;
            $relative = $this->db->select('*')->from($table)->
                where($where)->get();
            $relative = $relative[0];

            if (!empty($this->template->content->item->replace)) {
                $relative->desc = str_replace(
                    $this->template->content->item->replace,
                    $this->template->content->item->replace_to,
                    $relative->desc
                );
            }

            $this->template->content->item->desc = $relative->desc;

        }

        $table = "product_fields";
        $where = "product_fields.product_id = " . $this->idItem;
        ;
        $this->fields = $this->db->select('*')->from($table)
            ->join('fields', 'fields.field_id',
            'product_fields.field_id')
            ->where($where)->orderby('fields.sort', 'asc')->get();

        $alreadyViewed = $this->session->get("alreadyViewed"); // TODO

        if (empty($alreadyViewed)) {
            $alreadyViewed = array();
        }

        if (count($alreadyViewed) > 0) {
            $key = array_keys($alreadyViewed, $this->idItem);
            if (count($key)) {
                foreach ($key as $k) {
                    unset($alreadyViewed[$k]);
                }
            }

            if (count($alreadyViewed) > 0) {

                $where = "products.status = " . STATUS_WORK . " and products.product_id IN (" . implode(',', $alreadyViewed) . ') and products.firm_id = ' . $this->firmID;
                ;
                $this->viewed = $this->db->select('*, product_imgs.id as img')->from('products')
                    ->join('product_imgs', array('product_imgs.product_id' => 'products.product_id',
                                                 'product_imgs.favorite'   => 1), null, 'left')
                    ->where($where)->orderby('products.title', 'asc')->get();
            }
        }

        if (!count(array_keys($alreadyViewed, $this->idItem))) {

            $alreadyViewed[] = $this->idItem;

            if (count($alreadyViewed) > 2) {
                $alreadyViewed = array_slice($alreadyViewed, -3);
            }
            $this->session->set("alreadyViewed", $alreadyViewed);
        }


        $table = "product_fields";
        $where = "product_fields.product_id = " . $this->idItem;
        ;
        $this->fields = $this->db->select('*')->from($table)
            ->join('fields', 'fields.field_id',
            'product_fields.field_id')
            ->where($where)->orderby('fields.sort', 'asc')->get();

        $table = "product_imgs";
        $where = "product_imgs.product_id = " . $this->idItem . ' and product_imgs.firm_id = ' . $this->firmID;
        ;
        ;
        $this->imgs = $this->db->select('*')->from($table)
            ->where($where)->orderby('product_imgs.id', 'asc')->get();


        $table = "satellites";
        $where = "satellites.product = " . $this->idItem . ' and satellites.firm_id = ' . $this->firmID;
        ;
        $this->satellites = $this->db->select('*, product_imgs.id as img')->from($table)
            ->join('products',
            array(
                'products.product_id' => 'satellites.satellite_product',
                'products.status'     => STATUS_WORK
            ))
            ->join('product_imgs', array('product_imgs.product_id' => 'satellites.satellite_product',
                                         'product_imgs.favorite'   => 1), null, 'left')
            ->where($where)->orderby('products.title', 'asc')->get();

        $table = "recommends";
        $where = "recommends.product = " . $this->idItem . ' and recommends.firm_id = ' . $this->firmID;
        ;
        $this->recommends = $this->db->select('*, product_imgs.id as img')->from($table)
            ->join('products',
            array(
                'products.product_id' => 'recommends.recommend_product',
                'products.status'     => STATUS_WORK
            ))
            ->join('product_imgs', array('product_imgs.product_id' => 'recommends.recommend_product',
                                         'product_imgs.favorite'   => 1), null, 'left')
            ->where($where)->orderby('products.title', 'asc')->get();

        $table = "recommends";
        $where = "recommends.product = " . $this->idItem . ' and recommends.firm_id = ' . $this->firmID;
        ;
        $this->recommends = $this->db->select('*, product_imgs.id as img')->from($table)
            ->join('products',
            array(
                'products.product_id' => 'recommends.recommend_product',
                'products.status'     => STATUS_WORK
            ))
            ->join('product_imgs', array('product_imgs.product_id' => 'recommends.recommend_product',
                                         'product_imgs.favorite'   => 1), null, 'left')
            ->where($where)->orderby('products.title', 'asc')->get();


    }
}

?>