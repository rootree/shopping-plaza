<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_ORDERS] & $this->access){ ?>

<td class="side_menu">
 

<div id="" class="body_left_panel shadow" >
    <b>Поиск:</b>

    <form action="/dashboard" method="post" target="_self" id="searchForm">

        <input name="search[word]" title="Поиск производится по номеру заказа, сумме или дате заказа (формат: 2011-12-01)"
			   class="search" value="<?php echo html::specialchars(@$_POST['search']['word']) ?>" />

        <a href="" class="searchBtn" onclick="$('#searchForm' ).submit(); return false;">Начать поиск</a>

        <input type="hidden" name="search[type]"  value="<?=SEARCH_TYPE_ORDER?>" >

    </form>
 
</div>

    <div id="" class="body_left_panel shadow" >

        <b>Сортировка по статусам:</b>
        <ol id="nav">

            <li><a <?php if(empty($this->type)) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/">Все</a></li>

            <li><a <?php if($this->type == ORDER_STATUS_NEW) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/index/type/<?=ORDER_STATUS_NEW?>">Новые</a></li>

            <li><a <?php if($this->type == ORDER_STATUS_VIEWED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/index/type/<?=ORDER_STATUS_VIEWED?>">Просмотренные</a></li>

            <li><a <?php if($this->type == ORDER_STATUS_PROCEEDED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/index/type/<?=ORDER_STATUS_PROCEEDED?>">Обработанные</a></li>

            <li><a <?php if($this->type == ORDER_STATUS_DELIVERED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/index/type/<?=ORDER_STATUS_DELIVERED?>">Отправленные</a></li>

            <li><a <?php if($this->type == ORDER_STATUS_PAYED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/index/type/<?=ORDER_STATUS_PAYED?>">Оплаченные</a></li>

            <li><a <?php if($this->type == ORDER_STATUS_CANCEL) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/index/type/<?=ORDER_STATUS_CANCEL?>">Отменённые</a></li>

        </ol>

    </div>


    <div id="" class="body_left_panel shadow" >

        <b>По способу доставки:</b>
        <ol id="nav">

            <? foreach ($this->delivery as $cost) { ?>

                <li><a <?php if(!empty($this->deliverytype) && $cost->del_id == $this->deliverytype) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>orders/index/deliverytype/<?=$cost->del_id?>"><?=html::specialchars($cost->title)?></a></li>
            
            <?php } ?>

        </ol>

    </div>
 
</td>

<?PHP } ?>