<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>



<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th width="170">Время отправки</th>
        <th>Пользователь</th>
        <th>Состояние</th>
        <th>Комментарий к</th>
        <th width="150"></th>
    </tr>

<?php

if(!isset($current_first_item)){
    $current_first_item = 1;
}

$count = 0;

foreach ($items as $item) {

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }

?>

    <tr class="hightLight <?php echo $class ?>" >

        <td class="catalog" width="20"><?php echo $current_first_item ?></td>
        <td class="catalog"><?php echo time::date($item->createDate, DATE_FORMAT) ?></td>
        <td ><?php echo html::specialchars($item->name) ?> <?php if(!empty($item->mail)) { echo ' <small>('.html::specialchars($item->mail).')</small>'; } ?></td>
        <td class="catalog"><?php echo $GLOBALS['COMMENT_STATUS'][($item->status)] ?></td>
        <td class="catalog"><?php echo $GLOBALS['COMMENT_ON'][($item->coment_type)] ?></td>

        <td class="catalog" style="text-align:left !important;">

            <a class="viewBtn" href="<?php echo url::site(); ?>comments/info/id/<?=$item->coment_id?>/">Посмотреть</a>


            <? switch ($item->coment_type) {
                case COMMENT_ON_ITEMS: ?> <a target="_blank" class="viewOnSiteBtn" href="http://<?=$this->firm->domain?>/products/item/id/<?php echo ($item->item_id) ?>/#comment<?=$item->coment_id?>">Посмотреть на сайте</a>
                    <? break ;
                case COMMENT_ON_NEWS: ?> <a target="_blank" class="viewOnSiteBtn" href="http://<?=$this->firm->domain?>/news/index/item/<?php echo ($item->item_id) ?>/return_page/1/#comment<?=$item->coment_id?>">Посмотреть на сайте</a>
                    <? break ;
               case COMMENT_ON_ARTICLE: ?> <a target="_blank" class="viewOnSiteBtn" href="http://<?=$this->firm->domain?>/pages/index/id/<?php echo ($item->item_id) ?>/#comment<?=$item->coment_id?>">Посмотреть на сайте</a>
                    <? break ; } ?>

            <? if($item->status != COMMENT_STATUS_ANSWERED && $item->status != COMMENT_STATUS_DELETED) { ?>
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить этот комментарий пользователя?',
                    function(){SPAdmin.goToURL('<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>">Удалить</a>

                <? if($item->status != COMMENT_STATUS_ANSWER) { ?>
                    <a onclick="SPAdmin.showConfirmMessage('Подтвердите блокировку', 'Коментарий будет удалён, а этот пользователь больше не сможет оставлять сообщенияи комментарии. Вы уверены?',
                        function(){SPAdmin.goToURL('<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>/?block');}); return false;" class="blockBtn" href="<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>">Блокировать</a>
                <? } ?>

            <? } ?>

        </td>

    </tr>

<?php
    $current_first_item ++;
    }
?>

</table>
