<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?=html::specialchars($this->firm->meta)?>"/>
    <meta name="description" content="<?=html::specialchars($this->descriptionHTML)?>"/>

    <base href="http://<?=SERVER_SITE?>" />

    <script type="text/javascript" src="/js/jquery.js" ></script>
    
    <link href="/css/style.css" rel="stylesheet" type="text/css"  media="screen"/>
    <link href="/css/<?=$this->firm->template?>.css" rel="stylesheet" type="text/css"  media="screen"/>
    
    <link href="/css/highslide.css" rel="stylesheet" type="text/css"  media="screen"/>
 
    <link href="/css/print.css" rel="stylesheet" type="text/css"  media="print"/>

<!--[if IE]><link rel="stylesheet" href="/css/css-ie.css" type="text/css"  media="screen"/><![endif]-->
<!--[if IE 7]><link rel="stylesheet" href="/css/css-ie7.css" type="text/css"  media="screen"/><![endif]-->

    <title><?php echo  ((!empty($title)) ? @html::specialchars($title).' | '  : '') . html::specialchars($this->firm->title) ?></title>
 
</head>

<body>
 
<div id="header">

    <div id="header-content">

        <div id="logo">
 
            <a href="/">

                <? if(file_exists(SuperPath::get($this->firmID, false, IMAGES_TYPE_LOGO).'.png')) { ?>
                    <img src="<?=SuperPath::get($this->firmID, true, IMAGES_TYPE_LOGO)?>.png" alt="<?=html::specialchars($this->firm->title)?>" />
                <? }else{ ?>
                    <?=html::specialchars($this->firm->title)?>
                <? } ?>
               
            </a>
            <br/><?=html::specialchars($this->firm->description)?>

        </div>
 
        <div class="add"><p><a href="/bin"><img alt="Корзина" src="/img.<?=$this->firm->template?>/icons/add.png" /></a>
            Товаров: <span id="charCountItems"><?=$this->count_bin_items?></span> шт. <br />
            На сумму: <span id="charPriceItems"><?=$this->totalSum?></span>
        </p></div>

        <div class="status-bar">

            <div class="login">

                <? if($this->userId) { ?>
                    <p class="reg">Вы авторизованы как <a href="/settings"><?=$this->userName?></a> [<a href="/login/out">выйти</a>]</p>
                    <p class="auto"><a href="/dashboard">Личный кабинет</a></p>
                <? }else{ ?>
                    <p class="reg"><a href="/reg">Зарегистрироваться</a></p>
                    <p class="auto"><a href="/login">Авторизоваться</a></p>
                <? } ?>
 
            </div>

            <p class="phone">
                <b><?=$this->firm->tele?></b>
            </p>

            <? if(empty($this->phone)) {?>
                <p class="phone-callback" id="phone-callback-block">

                    <a href="/" onclick="$('#callbackMessage').toggle(); return false;"><img src="/img.<?=$this->firm->template?>/phone-callback-icon.gif" alt="Заказать обратный звонок" /></a><br/>
                    Не дозвонились?<br/>Закажите обратный<br/>звонок

                </p>
            <? } ?>

            <div class="clear"></div>

        </div>

        <div class="clear"></div>

    </div>

</div>

<ul class="top-menu" id="mainMenu">

    <li <? if($this->selected_page == 'main') { ?>  class="current" <? } ?>><a href="/"><span>Главная страница</span></a></li>
    <li class="bullet"></li>
    <li <? if($this->selected_page == 'catalog') { ?>  class="current" <? } ?>><a  href="/catalog"><span>Каталог</span></a></li>
    <li class="bullet"></li>
    <li <? if($this->selected_page == 'feedback') { ?>  class="current" <? } ?>><a  href="/feedback"><span>Контакты</span></a></li>

    <? if($this->firm->show & SHOW_ON_SITE_VACANCY){ ?>
    <li class="bullet"></li>
    <li <? if($this->selected_page == 'vanancy') { ?>  class="current" <? } ?>><a  href="/vanancy"><span>Вакансии</span></a></li>
    <? } ?>

    <? if($this->firm->show & SHOW_ON_SITE_NEWS){ ?>
    <li class="bullet"></li>
    <li <? if($this->selected_page == 'news') { ?>  class="current" <? } ?>><a  href="/news"><span>Новости</span></a></li>
    <? } ?>

    <? if($this->firm->show & SHOW_ON_SITE_PARTNERS){ ?>
    <li class="bullet"></li>
    <li <? if($this->selected_page == 'partners') { ?>  class="current" <? } ?>><a  href="/partners"><span>Партнеры</span></a></li>
    <? } ?>

    <?php

    if($this->firm->show & SHOW_ON_SITE_PAGES && $this->pages->count()){ ?>

        <li class="bullet"></li>

        <? if($this->pages->count()){
            foreach ($this->pages as $item) { ?>
                <li <? if($this->selected_page == $item->page_id) { ?>  class="current" <? } ?>><a href="/pages/index/title/<?=$item->url_link?>"><span><?=html::specialchars($item->title)?></span></a></li>
                <li class="bullet"></li>
        <? }} ?>


        <li class="more" id="morePages"><a href="#" class="up" onclick="return false;"><span>Дополнительно</span></a>
            <ul>

                <? $count = 0;
                if($this->pages->count()){
                    foreach ($this->pages as $item) { ?>

                        <li   <?php if($this->selected_page == $item->page_id) { ?>class="SP-active"<?php } ?>>
                            <a href="/pages/index/title/<?=$item->url_link?>" ><?=html::specialchars($item->title)?></a></li>
                        <? }}
                
                ?>
            </ul>
        </li>
        
    <? }?>

</ul>
 

<div id="content" >

    <table width="100%"><tr><td class="leftSide">

        <div id="l-side">


             <? if(count($this->groups)) { ?>

                <div class="download">
                    <p class="prise"><a href="#/bin/?priselist">Скачать прайс</a>
                        <b class="size">(<?=text::bytes(filesize(FILE_PRISE))?>)</b><br />
                        <b class="date">Дата обновления: <?=$this->datePriceUpdate?></b>
                    </p>
                </div>

                <div class="l-side-menu">
                    <ul>

                        <? foreach ($this->groups as  $key ){  ?>

                        <li <? if(@$this->id == $key->cat_id) { ?>class="active"<? } ?>>

                            <a title="Перейти к разделу: <?=html::specialchars($key->title)?>" <? if(@$this->id == $key->cat_id) { $this->crn = $key->title; ?>class="li-active"<? } ?>
                                href="/products/index/topic/<?=$key->url_link?>"><span><?=html::specialchars($key->title)?></span></a>

                            <? if (isset($this->id) && $this->id == $key->cat_id && count($this->catssub) > 0 ) : ?>

                                <ul>
                                    <? foreach ($this->catssub as $key ){  ?>
                                    <li><a title="Отфильтровать по типу товара: <?=html::specialchars($key->title)?>"
                                        <? if($this->catsub_id == $key->catsub_id) {   ?>class="SP-active"<? } ?> href="/products/index/topic/<?=$this->url_link?>/catsub/<?=$key->url_link?>" title="">
                                        <?=html::specialchars($key->title)?></a></li>
                                    <? }?>
                                </ul>

                            <? endif ?>

                        </li>

                        <? }?>

                    </ul>

                </div>

            <? } ?>

            <? if($this->firm->shownews && isset($this->news) && count($this->news)){ ?>

                <br/>
            
                <h2>Новости</h2>
    
                <? foreach($this->news as $item) { ?>

                    <div class="news">
                        <p>
                            <em><?=time::date($item->date, DATE_FORMAT)?></em><br /><br />

                            <?=ucfirst(html::specialchars($item->title)) ?></p>
                        <a class="news-link" href="/news/index/item/<?=$item->news_id?>/return_page/1">Новость полностью</a>
                    </div>

                    <? }?>

                <a href="/news/" title="">Архив</a>

            <? } ?>

        </div>

    </td><td valign="top">

        <div id="wrp">

            <form id="form1" action="/search"  method="post">
                <p><input onblur="SPHandler.onBlurSearchForm();" onfocus="SPHandler.onFocusSearchForm();" type="text" id="lookingFor" name="lookingFor" <?=(isset($_POST['lookingFor']) && !empty($_POST['lookingFor'])) ? 'style="color:#000"' : '';?> value="<?=(isset($_POST['lookingFor']) && !empty($_POST['lookingFor'])) ? html::specialchars($_POST['lookingFor']) : 'Поиск по товарам...';?>" /></p>
                <p><input type="submit" /></p>
            </form>
 
            <?php echo $content ?>

        </div>

    </td></tr></table>

    <div class="clear"></div>

</div>

<div id="footer">

    <p class="copy">© 2011 <a href="/">«<?=strtoupper(substr(SERVER_SITE, 0, -1))?>»</a></p>

    <ul class="footer-menu">

        <li <? if($this->selected_page == 'main') { ?>  class="current" <? } ?>><a href="/"><span>Главная страница</span></a></li>
        <li <? if($this->selected_page == 'catalog') { ?>  class="current" <? } ?>><a href="/catalog"><span>Каталог</span></a></li>
        <li <? if($this->selected_page == 'feedback') { ?>  class="current" <? } ?>><a href="/feedback"><span>Контакты</span></a></li>
     
        <? if($this->firm->show & SHOW_ON_SITE_VACANCY){ ?>
            <li <? if($this->selected_page == 'vanancy') { ?>  class="current" <? } ?>><a href="/vanancy"><span>Вакансии</span></a></li>
        <? } ?>

        <? if($this->firm->show & SHOW_ON_SITE_NEWS){ ?>
            <li <? if($this->selected_page == 'news') { ?>  class="current" <? } ?>><a href="/news"><span>Новости</span></a></li>
        <? } ?>

        <? if($this->firm->show & SHOW_ON_SITE_PARTNERS){ ?>
            <li <? if($this->selected_page == 'partners') { ?>  class="current" <? } ?>><a href="/partners"><span>Партнеры</span></a></li>
        <? } ?>

    <?php

        if($this->firm->show & SHOW_ON_SITE_PAGES && $this->pages->count()){ ?>
 
            <li class="more"><a href="#" onclick="return false;"><span>Дополнительно</span></a>
                <ul>
                    <?  $count = 0;
                    if($this->pages->count()){
                        foreach ($this->pages as $item) { ?>

                            <li><a href="/pages/index/topic/<?=$item->url_link?>"><?=html::specialchars(($item->title))?></a></li>

                    <? }} ?>
                </ul>
            </li>

        <? }?>

    </ul>
</div>

<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'takeOrder', TRUE),
                 array()); ?>

<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'takeCallback', TRUE),
                 array('phone' => $this->phone)); ?>

<script type="text/javascript" src="/highslide/highslide.js"></script>
<script type="text/javascript" src="/js/init.js" ></script>

<div style="display:none;">
    <?=($this->firm->code_inside)?>
</div>

</body>
</html>