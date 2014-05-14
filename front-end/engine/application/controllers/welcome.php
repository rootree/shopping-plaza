<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Главная страница магазина
 *
 * @package    Core
 * @author     Ivan Chura
 * @copyright  (c) 2010-2013 Ivan Chura
 * @license    http://shopping-plaza.ru/license.html
 */
class Welcome_Controller extends Web_Controller
{

    // Disable this controller when Kohana is set to production mode.
    // See http://docs.kohanaphp.com/installation/deployment for more details.
    const ALLOW_PRODUCTION = false;


    public function index()
    {

        // In Kohana, all views are loaded and treated as objects.
        $this->template->content = new ViewMod('welcome_content');
        // You can assign anything variable to a view by using standard OOP
        // methods. In my welcome view, the $title variable will be assigned
        // the value I give it here.
        $this->template->title = '';
        ;
        $this->selected_page = 'main';


        $this->already_been = cookie::get('already_been');

        if ($this->already_been != 1) {
            cookie::set('already_been', 1);
        }

        if ($this->firm->shownews) {

            $table = 'news';
            $query = $this->db->select('date, annonce, news_id, title, link')->where("firm_id = " . $this->firmID)->from($table)->limit(5)->orderby('date', 'desc')
                ->orderby('title')->get();

            $this->news = array();

            foreach ($query as $item) {
                $this->news[] = $item;
            }
        }

        if ($this->firm->showcatalog) {

            $table                     = 'catssub';
            $this->groupssub           = $this->db->select($table . '.*, cats.url_link as url_link_cat')->from($table)->

                join('cats', array('cats.cat_id' => $table . '.cat_id', 'cats.status' => STATUS_WORK), null, 'left')->

                where("catssub.firm_id = " . $this->firmID . ' and catssub.status = ' . STATUS_WORK)->
                orderby('catssub.sort')->orderby('catssub.title')->get();
            $this->template->groupssub = $this->groupssub;

        }

        $orderby = 'price';
        switch ($this->firm->showfirstpro) {
            case MAINPAGE_PRICE_NEW:
                $orderby = 'new';
                break;
            case MAINPAGE_PRICE_WEEK:
                $orderby = 'week';
                break;
            case MAINPAGE_PRICE_SPEC:
                $orderby = 'unic';
                break;
            case MAINPAGE_PRICE_BUY:
                $orderby = 'counter';
                break;
            case MAINPAGE_PRICE_POPULAR:
                $orderby = 'viewed';
                break;
        }

        $page_limit = 20;

        $table = 'products';
        $where = 'products.firm_id = ' . $this->firmID . ' and products.status = ' . STATUS_WORK;

        $this->template->content->items =
            $this->db->select($table . '.*, product_imgs.id as img, searchingImg.id as imgSearch')->from($table)->
            // join('product_imgs', 'product_imgs.product_id', $table.'.product_id', 'left')->

                join('product_imgs', array('product_imgs.product_id' => $table . '.product_id',
                                           'product_imgs.favorite'   => 1), null, 'left')->
                join('product_imgs` `searchingImg', array('searchingImg.product_id' => $table . '.searchingId',
                                                          'searchingImg.favorite'   => 1), null, 'left')->

                join('cats', array('products.cat_id' => 'cats.cat_id',
                                   'cats.status'     => STATUS_WORK))->
                join('catssub', array('products.catsub_id' => 'catssub.catsub_id',
                                      'catssub.status'     => STATUS_WORK))->

                where($where)->groupby($table . '.product_id')->limit(7)->
                orderby($table . '.' . $orderby . '` desc, `' . $table . '.product_id` desc, `' . $table . '.title')->get();

        $table                             = "firms";
        $where                             = "id = " . $this->firmID;
        $this->template->content->mainpage = $this->db->select('mainpage')->from($table)->
            where($where)->get();

        $this->template->content->mainpage = $this->template->content->mainpage[0];
        $this->template->content->mainpage = $this->template->content->mainpage->mainpage;

    }

} // End Welcome Controller