<?php

/**
 * Пример обновление новостей интернет-магазина
 * через API
 */

$url = 'http://news.yandex.ru/auto.rss'; //адрес RSS ленты

$rss = simplexml_load_file($url); //Интерпретирует XML-файл в объект

$freshNews = array();

//цикл для обхода всей RSS ленты
foreach ($rss->channel->item as $item) {

    $freshNews[$item->title . ''] = array(
        'title'       => $item->title . '',
        'description' => $item->description . '',
        'link'        => $item->link . ''
    );
}

$keyDVR = '******';

function generateLink($action, $parameters)
{

    ksort($parameters);
    $checkSum = md5(implode($parameters, ""));

    $params = '';

    foreach ($parameters as $key => $value) {
        $params .= urlencode($key) . '=' . urlencode($value) . '&';
    }

    return 'http://shopping-plaza.ru/api/' . $action . '/?' . $params . 'checksum=' . $checkSum;
}


$parameters = array(
    "dateFrom" => strtotime("-24 hours"),
    "key"      => $keyDVR
);
$url        = generateLink('news', $parameters);
$dvrNews    = json_decode(file_get_contents($url));


foreach ($freshNews as $itemNew) {

    $newsExsist = false;
    foreach ($dvrNews as $item) {

        if ($item->title == $itemNew['title']) {
            $newsExsist = true;
            break;
        }

    }

    if (!$newsExsist) {
        $parameters = array(
            "title"   => $itemNew['title'],
            "annonce" => $itemNew['description'],
            "link"    => $itemNew['link'],
            "key"     => $keyDVR
        );
        $url        = generateLink('newsadd', $parameters);
        $result     = json_decode(file_get_contents($url));
        print_r($result);
    }

}

?>

 
