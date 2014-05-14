<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

    <? if(count($items)) { ?>

    <h2>Новости</h2>
    <div id="news-blog">

        <?=$pagination?><br/>

        <? $count = 0 ?>

        <? foreach($items as $item) { ?>

        <div class="news">
            <p><em>Дата размещения: <?=html::specialchars(time::date($item->date, DATE_FORMAT)) ?></em><br />

                <? if(!empty($item->link)) ?>
                 

                <a <?=(!empty($item->link)) ? 'target="blank"' : '';?> href="<?=(!empty($item->link)) ? $item->link : 'news/index/item/'.$item->news_id . '/return_page/'.$page ; ?>" title=""><b><?=html::specialchars($item->title) ?></b></a><br/>
                <?=html::specialchars($item->annonce) ?></p>

        </div>

        <?}?>

        <?=$pagination?>

    </div>

<? }else{ ?>

    <div id="errordesc infodesc">
        <p class="last-child"><br/><br/>Новости скоро появиться.</p>
    </div>

<? } ?>