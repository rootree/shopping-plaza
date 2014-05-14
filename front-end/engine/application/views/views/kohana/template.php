<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="keywords"
          content="c-net23,antenna23,спутник,телевидение,спутниковое телевидение,спутниковый интернет,интернет,установка,монтаж,подключение,оборудование,краснодар<?=@strtolower($this->keywords)?>"/>
    <meta name="description"
          content="<?=@($title) . ' '?>Спутниковое телефидение и Интернет в г.Краснодаре. Установка, настройка, поддержка."/>

    <meta http-equiv="content-language" content="ru"/>
    <meta name="content-language" content="russian"/>
    <meta name="ROBOTS" content="FOLLOW"/>
    <meta name="author" content="Ivan Chura"/>
    <meta name="subject" content="Спутниковое телефидение и Интернет в г.Краснодаре. Установка, настройка, поддержка."/>
    <meta name="distribution" content="Global"/>
    <meta name="rating" content="General"/>
    <meta name="title" content="Спутниковое телефидение и Интернет в г.Краснодаре. Установка, настройка, поддержка."/>
    <meta name="page-topic"
          content="Спутниковое телефидение и Интернет в г.Краснодаре. Установка, настройка, поддержка."/>
    <meta name="resource-type" content="document"/>

    <link rel="shortcut icon" href="http://<?=SERVER_SITE?>/favicon.ico"/>
    <link rel="icon" type="image/gif" href="http://<?=SERVER_SITE?>/animated_favicon1.gif"/>

    <link rel="apple-touch-icon" href="http://<?=SERVER_SITE?>/apple-touch-icon.png">

    <title><?php echo (!empty($title)) ? @html::specialchars($title . ' - ') : '' ?>С-NET Shopping - Cпутниковый
        Интернет и телевидение</title>

    <base href="http://<?=SERVER_SITE?>/"/>

    <link rel="stylesheet" href="http://media.c-net-shopping.ru/CSS/css-base.css" type="text/css"/>
    <!--[if lte IE 6]>
    <link rel="stylesheet" href="http://media.c-net-shopping.ru/CSS/css-ie6.css" type="text/css"/><![endif]-->
    <!--[if IE 7]>
    <link rel="stylesheet" href="http://media.c-net-shopping.ru/CSS/css-ie7.css" type="text/css"/><![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" href="http://media.c-net-shopping.ru/CSS/css-ie8.css" type="text/css"/><![endif]-->

    <script type="text/javascript">

        var RealEs = new Object();
        RealEs.baseUrl = 'http://<?=SERVER_SITE?>';

    </script>

</head>

<body>


<div id="logo">

    <div id="" class="wight_limit">

        <div id="" class="" style="float: right;">
            <a href="/bin" title="" <? if ($this->selected_page == 'bin') { ?>  id="selected" <? } ?>>В вашей корзине
                <span id="counter"
                      class=""><?=texter::ru(array('%s товаров', '%s товар', '%s товара'), intval($this->count_bin_items))?></span>
            </a>
        </div>

        <a href="/" <? if ($this->selected_page == 'main') { ?>  id="selected" <? } ?> title="">Главная страница</a>|
        <a <? if ($this->selected_page == 'catalog') { ?>  id="selected" <? } ?>href="/catalog" title="">Каталог</a>|
        <a <? if ($this->selected_page == 'feedback') { ?>  id="selected" <? } ?>href="/feedback" title="">Контакты</a>|
        <a href="/bin/priselist" title="">Скачать прайс (<?=text::bytes(filesize(FILE_PRISE))?>)</a>
        <small>Дата обновления: <?=$this->datePriceUpdate?></small>
        |

        <a href="/vanancy" <?php if ($this->selected_page == "vanancy") { ?>id="selected"<?php } ?>>Вакансии</a>|

        <a href="/news" <?php if ($this->selected_page == "news") { ?>id="selected"<?php } ?>>Новости</a>|

        <a href="/partners" <?php if ($this->selected_page == "partners") { ?>id="selected"<?php } ?>>Партнёры</a>|


        <?php

        $count = 0;
        if ($this->pages->count()) {
            foreach ($this->pages as $item) {
                ?>

                <a href="/pages/index/id/<?=$item->page_id?>" <?php if ($this->selected_page == $item->page_id) { ?>id="selected"<?php } ?>><?=$item->title?></a>

                <? }
        }?>

    </div>

</div>


<div id="" class="body">
    <div id="" class="wight_limit">

        <div id="" class="logo_title">

            <a href="/"><?=$this->firm->title?></a> &nbsp;<sup><h2
                class="logo"><?=$GLOBALS['CITY'][$this->firm->city]?></h2></sup>

            <br/><?=$this->firm->skype?>
            <br/><?=$this->firm->mail?>
            <br/><?=$this->firm->icq?>
            <br/><?=$this->firm->address?>
            <br/><?=$this->firm->fax?>
            <br/><?=$this->firm->tele?>
            <br/><?=$this->firm->worktime?>

        </div>

        <div id="" class="body_line"></div>

        <div id="" class="body_container">

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td valign="top" style="width: 200px;">
                        <div id="" class="body_left_panel">
                            Мы предлагаем:
                            <ol id="nav">
                                <? foreach ($this->groups as $key) { ?>
                                <li>
                                    <a title="Перейти к разделу: <?=html::specialchars($key->title)?>" <? if (@$this->id == $key->cat_id) {
                                        $this->crn = $key->title; ?>id="selected"<? } ?>
                                       href="/products/index/id/<?=$key->cat_id?>"
                                       title=""><?=html::specialchars($key->title)?></a></li>
                                <? }?>
                            </ol>
                        </div>
                    </td>
                    <td valign="top">

                        <NOSCRIPT>
                            <div class="input_error" id="input_error">
                                <p>В вашем браузере отключена поддержка JavaScript. Советуем включить, так как часть
                                    функционала будет недоступно.</p>
                            </div>

                        </NOSCRIPT>

                        <?php echo $content ?>

                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>

<div id="menu" class="footer">

    <div id="" class="footer_firm"><br/>
        <img src="http://<?=SERVER_SITE?>/c-net/img/brend_1.jpg" alt="" class="brend"/>
        <img src="http://<?=SERVER_SITE?>/c-net/img/brend_2.jpg" alt="" class="brend"/>
        <img src="http://<?=SERVER_SITE?>/c-net/img/brend_3.jpg" alt="" class="brend"/>
        <img src="http://<?=SERVER_SITE?>/c-net/img/brend_4.jpg" alt="" class="brend"/>
        <img src="http://<?=SERVER_SITE?>/c-net/img/brend_5.jpg" alt="" class="brend"/>
        <img src="http://<?=SERVER_SITE?>/c-net/img/brend_6.jpg" alt="" class="brend"/>
    </div>
    <img src="/img/footer_line.jpg" alt=""/><br/>
    Copyright © <?=date('Y')?> «C-NET Shopping». <a href="/" title="" id="selected">Главная страница</a>|<a
        href="/feedback" title="">Контакты</a>|<a href="http://ichura.com/about/ru" title="">Разработка сайта</a>

</div>

<div id="message_box" style=" "></div>
<div id="message" class="jqmWindow jqmID1 "></div>

<script type="text/javascript" src="http://<?=SERVER_SITE?>/js/jquery.js"></script>
<script type="text/javascript" src="http://<?=SERVER_SITE?>/js/jquery.corner.js"></script>
<script type="text/javascript" src="http://<?=SERVER_SITE?>/js/highslide.js"></script>

<script type="text/javascript">

    var Lang = new Object();

    Lang.empty_fills = '<?=Kohana::lang('feedback.empty_fills')?>';
    Lang.min = '<?=Kohana::lang('search.form_till')?>';
    Lang.max = '<?=Kohana::lang('search.form_from')?>';

    //<![CDATA[
    hs.registerOverlay({
        html:'<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
        position:'top right',
        fade:2 // fading the semi-transparent overlay looks bad in IE
    });
    hs.outlineType = 'outer-glow';
    hs.wrapperClassName = 'outer-glow';

    hs.fadeInOut = true;
    //]]>


</script>
<script type="text/javascript" src="http://<?=SERVER_SITE?>/js/init.js"></script>

</body>

</html>