<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Поиск по сайту, через Яндекс
 *
 * @package    Core
 * @author     Ivan Chura
 * @copyright  (c) 2010-2013 Ivan Chura
 * @license    http://shopping-plaza.ru/license.html
 */


class Search_Controller extends Web_Controller
{

    const ALLOW_PRODUCTION = false;

    var $all_count = 0;

    function index()
    {

        $this->template->content        = new ViewMod('search');
        $this->template->content->error = false;

        $this->template->content->input_error = false;

        if ($_POST) {

            $lookingFor = trim($_POST['lookingFor']);

            if (strlen($lookingFor) < 4) {

                $this->template->content->error = true;

            } else {


                // обработка полей формы
                $host = $this->firm->domain;

                $query = $lookingFor;


                $esc   = htmlspecialchars($query);
                $ehost = htmlspecialchars($host);

                $search_tail = htmlspecialchars(" host:$ehost");


                if ($_SERVER["REQUEST_METHOD"] == 'GET') {
                    $page = array_key_exists('page', $_GET) ? $_GET['page'] : 0;

                } else $page = 0;

                $found = 0;
                $pages = 10;


                // XML запрос
                $doc = <<<DOC
<?xml version='1.0' encoding='utf-8'?>
<request>
    <query>$esc $search_tail</query>

    <groupings>
        <groupby attr="" mode="flat" groups-on-page="10"  docs-in-group="1" />
    </groupings>

    <page>$page</page>
</request>
DOC;

                $context = stream_context_create(array(

                    'http' => array(
                        'method'  => "POST",
                        'header'  => "Content-type: application/xml\r\n" .
                            "Content-length: " . strlen($doc),
                        'content' => $doc

                    )
                ));

                $response = file_get_contents('http://xmlsearch.yandex.ru/xmlsearch?user=chura-ivan&key=03.106511913:9757e40d373fef7213322a121c50383a', true, $context);


                if ($response) {


                    $xmldoc = new SimpleXMLElement($response);

                    $error     = $xmldoc->response->error;
                    $found_all = $xmldoc->response->found;
                    $found     = $xmldoc->xpath("response/results/grouping/group/doc");

                    if ($error) {

                        //  print "Ошибка: " . $error[0];

                        $this->template->content->error = true;

                    } else {

                        $this->template->content->found_all = $found_all;
                        $this->template->content->result    = array();

                        //  print "<p style='font-size: 80%'>Результат поиска: страниц — <b>$found_all</b></p><br/>\n";
                        //  print "<ol start='" . ($page * 10 + 1) . "'>\n";
                        foreach ($found as $item) {

                            //     print "<li>";
                            //    print "<a href='{$item->url}'>" . highlight_words($item->title) . "</a><br/>\n";

                            //    print "<ul>";

                            $passed = array();
                            if ($item->passages) {

                                foreach ($item->passages->passage as $passage) {

                                    $passed[] = highlight_words($passage);
                                }

                            }
                            //      print "<span style='color: gray; font-size: 80%'>{$item->url}</span>";
                            //     print "</ul></li><br/>\n";

                            $this->template->content->result[] = array(
                                'url'    => $item->url . '',
                                'title'  => $item->title . '',
                                'passed' => $passed
                            );

                        }


                        //    print "</ol>\n";
                        // print_pager ($found_all, $query, $host, $page);
                    }

                } else {
                    // print "Внутренняя ошибка сервера.\n";
                    $this->template->content->error = true;
                }

                $data   = array(
                    'firm_id' => $this->firmID,
                    'request' => $lookingFor,
                    'dat'     => date("Y-m-d H:i:s"),

                );
                $status = $this->db->insert('searchinger', $data);

            }
        }

        $this->title    = $this->template->title = 'Результаты поиска';
        $this->keywords = getKeyWords($this->title);


    }

}

function highlight_words($node)

{
    $stripped = preg_replace('/<\/?(title|passage)[^>]*>/', '', $node->asXML());
    return str_replace('</hlword>', '</strong>', preg_replace('/<hlword[^>]*>/', '<strong>', $stripped));

}

function print_pager($found_links, $query, $host, $page = 0, $links_on_page = 10)

{
    $query = htmlspecialchars($query);
    $host  = htmlspecialchars($host);
    if ($page != 0)
        print "<a href='?page=" . ($page - 1) . "&query={$query}&host={$host}'>&#8592; предыдущая</a> ";
    print " страница № " . ($page + 1);

    if ($found_links > ($page + 1) * $links_on_page)
        print " <a href='?page=" . ($page + 1) . "&query=$query&host={$host}'>следующая &#8594;</a> ";

}

?>