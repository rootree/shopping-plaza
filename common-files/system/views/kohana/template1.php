<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?=html::specialchars($this->firm->meta)?>"/>
    <meta name="<?=html::specialchars($this->firm->meta_name)?>" content="<?=html::specialchars($this->firm->meta_text)?>"/>
    <meta name="description" content="<?=html::specialchars($this->descriptionHTML)?>"/>

    <base href="http://<?=SERVER_SITE?>" />

    <script type="text/javascript" src="/js/jquery.js" ></script>
 
    <link href="/css/style.css" rel="stylesheet" type="text/css"  media="screen"/>
    <link href="/css/<?=$this->firm->template?>.css" rel="stylesheet" type="text/css"  media="screen"/>

    <link href="/css/highslide.css" rel="stylesheet" type="text/css"  media="screen"/>

    <link href="/css/print.css" rel="stylesheet" type="text/css"  media="print"/>

    <!--[if IE]><link rel="stylesheet" href="/css/css-ie.css" type="text/css"  media="screen"/><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="/css/css-ie7.css" type="text/css"  media="screen"/><![endif]-->

    <title><?php echo  ((!empty($title)) ? @html::specialchars(strip_tags($title)).' - '  : '') . html::specialchars($this->firm->title) ?></title>

 




</head>

<body>

<div id="header">


    <div id="header-content">
        <table style="width: 100%; height: 75px;">
            <tr>
                <td style="  vertical-align:middle; text-align:left;">
                    <div id="logo">

                        <a href="/">

                            <? if(file_exists(SuperPath::get($this->firmID, false, IMAGES_TYPE_LOGO).'.png')) { ?>
                            <img src="<?=SuperPath::get($this->firmID, true, IMAGES_TYPE_LOGO)?>.png" alt="<?=html::specialchars($this->firm->title)?>" />
                            <? }else{ ?>
                            <?=html::specialchars($this->firm->title)?><span></span><vat></vat>
                            <? } ?>

                        </a>
                        <div class="firmDesc"><?=(!empty($this->firm->description)) ? html::specialchars(trim($this->firm->description)) : '&nbsp;'?></div>

                    </div>
                </td>
                <td style="  vertical-align:middle; text-align:center; z-index:200;">

                    <? if (!empty($this->firm->main_phone) && strlen($this->firm->main_phone) != 4){?>

                    <div class="mainPhone">
                        <?=html::specialchars($this->firm->main_phone)?><span></span>
                    </div>

                    <? } ?>
                </td>
                <td style="width: 171px; vertical-align:middle; text-align:left; z-index:500;">

                    <? if(!empty($this->firm->tele) && strlen($this->firm->tele) != 4 && empty($this->phone)) {?>
                    <p class="phone-callback" id="phone-callback-block">

                        <a href="/" onclick="$('#callbackMessage').toggle(); return false;"><img src="/img.<?=$this->firm->template?>/phone-callback-icon.gif" alt="Заказать обратный звонок" /></a><br/>
                        Не дозвонились?<br/>Закажите обратный звонок

                    </p>
                    <? } ?>

                </td>
                <td style="width: 101px; vertical-align:middle;">

                    <? if(count($this->groups)) { ?>
                    <div class="status-bar"><div class="login">

                        <? if($this->userId) { ?>
                        <p class="reg">Вы авторизованы как <a href="/settings"><?=$this->userName?></a> [<a href="/login/out">выйти</a>]</p>
                        <p class="auto"><a href="/dashboard">Личный кабинет</a></p>
                        <? }else{ ?>
                        <p class="reg"><a href="/reg">Зарегистрироваться</a></p>
                        <p class="auto"><a href="/login">Авторизоваться</a></p>
                        <? } ?>

                    </div>
                    </div>
                    <? } ?>
                </td>

                <td style="width: 241px; vertical-align:middle;">
                    <? if(count($this->groups)) { ?>

                    <div class="add" style=" "><p><a href="/bin"><img alt="Корзина" src="/img.<?=$this->firm->template?>/icons/add.png" /></a>
                        Товаров: <span id="charCountItems"><?=$this->count_bin_items?></span> шт. <br />
                        На сумму: <span id="charPriceItems"><?=$this->totalSum?></span>
                    </p></div>

                    <? } ?>
                </td>

            </tr>


        </table>




    </div>

</div>



<ul class="top-menu" id="mainMenu">

    <li <? if($this->selected_page == 'main') { ?>  class="current" <? } ?>><a href="/"><span>Главная страница</span></a></li>
    <li class="bullet"></li>
    <? if(count($this->groups)) { ?>
    <li <? if($this->selected_page == 'catalog') { ?>  class="current" <? } ?>><a  href="/catalog"><span>Каталог</span></a></li>
    <li class="bullet"></li>
    <? } ?>
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

<div id="wrapper"  >

<div id="content" >

    <table width="100%"><tr>


        <? if(count($this->groups)){ ?>


        <td class="leftSide">

            <div id="l-side">


                <? if(count($this->groups)) { ?>

                    <? if((file_exists(FILE_PRISE))){?>

                        <div class="download">
                            <p class="prise"><a href="/bin/priselist">Скачать прайс</a>
                                <b class="size">(<?=text::bytes(filesize(FILE_PRISE)) ?>)</b><br />
                                <b class="date">Дата обновления: <?=$this->datePriceUpdate?></b>
                            </p>
                        </div>

                    <? } ?>


                    <div class="l-side-menu" <? if (  (!isset($this->viewed) || (isset($this->viewed) && !count($this->viewed)))) { ?>id="sidebar" style="width: 180px !important;"<?}?>>



                        <? if (($GLOBALS['_SERVER']['REQUEST_URI'] != '/bin') && (!isset($this->viewed) || (isset($this->viewed) && !count($this->viewed)))) { ?>
                            
                            <div style=" color:#5F5D5D; text-align:center; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #DFDFDF;<?if($this->count_bin_items == 0){?>display: none;<?}?>" id="binSide" >

                                <a href="/bin"><img alt="Корзина" src="/img.<?=$this->firm->template?>/icons/goToBin.png" /></a>

                                    <table style="width:100%;">
                                        <tr>
                                            <td style=" color:#999999; padding-right: 10px;" align="right">Товаров:</td>
                                            <td align="left"><span id="charCountItemsSide"><?=$this->count_bin_items?></span> шт. </td>
                                        </tr>
                                        <tr>
                                            <td style=" color:#999999; padding-right: 10px;" align="right">На сумму:</td>
                                            <td align="left"><span id="charPriceItemsSide"><?=$this->totalSum?></span></td>
                                        </tr>
                                    </table>

                            </div>

                        <? }?>



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


                            <p><?=html::specialchars($item->annonce) ?></p>


                            <a class="news-link" <?=(!empty($item->link)) ? 'target="blank"' : '';?> href="<?=(!empty($item->link)) ? $item->link : 'news/index/item/'.$item->news_id . '/return_page/1' ; ?>">Новость полностью</a>
                        </div>

                        <? }?>

                    <a href="/news/" title="">Архив</a>

                <? } ?>



                <? if (isset($this->delivery) && count($this->delivery)) { ?>

                    <br/>
                    <div class="l-side-menu">

                        <h2><b>Доставка:</b></h2>

                        <? foreach ($this->delivery as $cat_val) { ?>
                        <div class="news">
                            <p>
                                <?php echo html::specialchars($cat_val->title) ?>

                            <div style="float:right; color:#5F5D5D;"><?php echo (!is_null($cat_val->cost) ? 'стоимость:
                                                                        <b>'.money::ru($cat_val->cost).'</b>' :
                                    '<span style="font-size:11px;">Рассчитывается индивидуально</span>')
                                ?></div>
                            </p></div>

                        <?php } ?>

                    </div>

                <?php } ?>



                <? if (isset($this->viewed) && count($this->viewed)) { ?>


                    <br/>


                    <div class="l-side-menu" id="sidebar" style="width: 180px !important;">

                        <? if(($GLOBALS['_SERVER']['REQUEST_URI'] != '/bin') ){?>

                            <div style=" color:#5F5D5D; text-align:center; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #DFDFDF;<?if($this->count_bin_items == 0){?>display: none;<?}?>" id="binSide" >

                                <a href="/bin"><img alt="Корзина" src="/img.<?=$this->firm->template?>/icons/goToBin.png" /></a>

                                    <table style="width:100%;">
                                        <tr>
                                            <td style=" color:#999999; padding-right: 10px;" align="right">Товаров:</td>
                                            <td align="left"><span id="charCountItemsSide"><?=$this->count_bin_items?></span> шт. </td>
                                        </tr>
                                        <tr>
                                            <td style=" color:#999999; padding-right: 10px;" align="right">На сумму:</td>
                                            <td align="left"><span id="charPriceItemsSide"><?=$this->totalSum?></span></td>
                                        </tr>
                                    </table>

                            </div>

                        <? } ?>

                        <h2><b>Просмотренный товар:</b></h2>

                        <? foreach ($this->viewed as $key) { ?>

                        <div style="width: 180px;  text-align:center; margin-top: 15px;">

                            <div style=" width: 180px; height: 125px; text-align:left; margin-left: 35px; ">

                                <? if(!empty($key->img) || (isset($key->imgSearch) && !empty($key->imgSearch))){ ?>
                                <span style=" cursor:pointer;" onclick='location.href = "/products/item/title/<?=$key->url_link?>"; '>
                                        <span title="<?=html::specialchars($key->title)?>" class="screenshot" rel="<?=  SuperPath::get($key->source == 0 || !isset($key->imgSearch) ? $key->img : $key->imgSearch, true)?>b.jpg" id="photoclip" style="background: url(<?=  SuperPath::get($key->source == 0 || !isset($key->imgSearch) ? $key->img : $key->imgSearch, true)?>m.jpg) center; background-repeat: no-repeat;" >

                                        </span>
                                    </span>
                                <? } ?>

                            </div>

                            <a class="itemTitleInList" href="/products/item/title/<?=$key->url_link?>"><?=html::specialchars($key->title)?></a>

                        </div>

                        <?php } ?>

                    </div>

                <?php } ?>


            </div>

        </td>

        <? } ?>

        <td valign="top" id="mainContent">

            <div id="wrp">

                <div id="contentNT" style="margin: 0;" >

                    <? if(count($this->groups)) { ?>

                    <form id="form1" action="/search"  method="post">
                        <p><input onblur="SPHandler.onBlurSearchForm();" onfocus="SPHandler.onFocusSearchForm();" type="text" id="lookingFor" name="lookingFor" <?=(isset($_POST['lookingFor']) && !empty($_POST['lookingFor'])) ? 'style="color:#000"' : '';?> value="<?=(isset($_POST['lookingFor']) && !empty($_POST['lookingFor'])) ? html::specialchars($_POST['lookingFor']) : 'Поиск по сайту...';?>" /></p>
                        <p><input type="submit" /></p>
                    </form>

                    <? } ?>


                    <?php echo $content ?>
                </div>
                
            </div>

        </td></tr></table>

    <div class="clear"></div>

</div>
</div>

<div id="footer">

    <p class="copy">© 2011 <a href="/">«<?=strtoupper(substr(SERVER_SITE, 0, -1))?>»</a></p>

    <ul class="footer-menu">

        <li <? if($this->selected_page == 'main') { ?>  class="current" <? } ?>><a href="/"><span>Главная страница</span></a></li>

        <? if(count($this->groups)) { ?>
        <li <? if($this->selected_page == 'catalog') { ?>  class="current" <? } ?>><a href="/catalog"><span>Каталог</span></a></li>
        <? } ?>
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