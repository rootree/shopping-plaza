<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="changeProductions" style="display:none; ">
 
    <table width="100%" style="margin-top: 8px; ">
        <tr>
            <td class="label" style="text-align:right;">Цена:</td>
            <td class="elements">
                <input id="quickPrice" class="text" name="quickPrice" value="" />
            </td>
        </tr>
        <tr>
            <td class="label" style="text-align:right;">Количество:</td>
            <td class="elements">
                <input id="quickCount" class="text" name="quickCount" value="" /> 
            </td>
        </tr>
    </table>
 
</div>

<?php if($items->count()) { ?>

    <?php echo $pagination ?>
  
    <table id="bin" cellspacing="0" cellpadding="5" >

        <tr>
            <th width="20">№</th>
            <th>Название</th>
            <th width="90">Цена</th>
            <th width="90">Кол-во</th>
            <th width="390"></th>
            <? if (isset($this->yandexView) && $this->yandexView == PRODUCTS_VIEW_LIST) { ?><th width="30"></th><? }?>
        </tr>

    <?php

    $count = 0;

    foreach ($items as $item) {

        $count ++;

        $class = "";

        if ($count % 2 == 0) {
                $class="modTwo";
        }

    ?>

        <tr class="hightLight <?php echo $class ?>" <? if($item->status == STATUS_HIDE){?>style="background-color: #e2e1e1;" <? } ?>>

            <td class="catalog" width="20"><?php echo $current_first_item ?></td>
            <td class="<? if($item->source != 0){?>copyPro<? } ?>"><?php echo html::specialchars($item->title) ?></td>
            <td class="catalog" width="90" id="htmlValuePrice<?=$item->product_id?>"><?php echo money::ru($item->price) ?></td>
            <td class="catalog" width="90" id="htmlValueCount<?=$item->product_id?>"><?php echo ($item->counter) ?></td>
            <td class="catalog">

                <? if(!(!$item->cat_id || !$item->catsub_id)){ ?>

                    <a class="viewBtn" href="<?php echo url::site(); ?>products/info/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Посмотреть</a>
                    <a  target="_blank" class="viewOnSiteBtn" href="http://<?=$this->firm->domain?>/products/item/id/<?php echo ($item->product_id) ?>">Посмотреть на сайте</a>
&nbsp;

                <? } ?>

                <a class="editBtn" href="<?php echo url::site(); ?>products/edit/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Редактировать</a>
                <a class="cartBtn" href="#" onclick="SPAdmin.showChangeProductMessage('<?=html::specialchars($item->title)?>', '<?=$item->product_id?>', '<?=$item->price?>', '<?=$item->counter?>'); return false;">Изменить кол-во или цену</a>

&nbsp;
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить товар «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>products/delete/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>products/delete/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Удалить</a>

                <? if(!(!$item->cat_id || !$item->catsub_id)){ ?>
                    <a class="powerBtn" href="<?php echo url::site(); ?>products/info/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/?<?= (($item->status == STATUS_WORK) ? 'pleaseHide' : 'pleaseShow') ?>"><?= (($item->status == STATUS_WORK) ? 'Отображаеться на сайте. <b>Скрыть?</b>' : 'Скрыто на сайте. <b>Показать?</b>') ?></a>

&nbsp;
                    <a target="_blank" class="printBtn" href="<?php echo url::site(); ?>products/printer/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>">Распечатать</a>
&nbsp;
                    <a class="satelliteBtn" href="<?php echo url::site(); ?>products/satellite/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Сопутствующие товары</a>
                    <a class="recommendBtn" href="<?php echo url::site(); ?>products/recommend/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Рекомендованные товары</a>
&nbsp;
                    <a class="copyBtn" href="<?php echo url::site(); ?>products/productcopy/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Сделать копию</a>

                <? } ?> 
            </td>

            <? if (isset($this->yandexView) && $this->yandexView == PRODUCTS_VIEW_LIST) { ?><td>
                <? if($item->robot_updated & 1){ ?>
                    <span title='Обновлено работом'>R</span>
                <? }?>
                <? if($item->robot_updated & 2){ ?>
                    <span title='Роботом не обновляеться'>D</span>
                <? }?>
                <? if($item->robot_updated & 4){ ?>
                    <span title='Цены магазина нет, и есть на складе' style="background-color: #dc143c;">W</span>
                <? }?>
                <? if($item->robot_updated == 0){ ?>
                    <span title='Пропущено'>S</span>
                <? }?>
            </td><? }?>

        </tr>

    <?php
        $current_first_item ++;
    }
    ?>

    </table>

    <?php echo $pagination ?>

<?php } ?>
