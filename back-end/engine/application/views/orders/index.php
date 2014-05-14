<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($items->count()) { ?>

<? if(isset($pagination)) { ?>
     <?php echo $pagination ?> 
<? } ?>


<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№ заказа</th>
        <th width="120">Время заказа</th>
        <th>Доставка</th>
        <th>Оплата</th>
        <th>Состояние</th>
        <th>Сумма заказа</th>
        <th width="200" ></th>
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
         
        <td class="catalog">#<?php echo html::specialchars($item->id) ?></td>
        <td class="catalog" ><?php echo time::date($item->date, DATE_FORMAT) ?></td> 
        <td ><?php echo !empty($item->devivery) ? html::specialchars($item->devivery) : '<i>На соглосовании</i>' ?></td>
        <td ><?php echo !empty($item->devivery) ? html::specialchars($item->payment) : '<i>На соглосовании</i>'  ?></td>



        <td class="catalog">
            <?php echo $GLOBALS['ORDER_STATUS'][($item->status)] ?>
        </td>


        <td class="catalog" nowrap="nowrap"><?php echo money::ru($item->total) ?></td>
            <td align="left">

                <? if($item->status == ORDER_STATUS_NEW || $item->status == ORDER_STATUS_VIEWED) { ?>

                    <a class="orderOkBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PROCEEDED?>/id/<?=$item->id?>">Отметить заказ как обработанный</a>
                    <a class="orderDeliveredBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_DELIVERED?>/id/<?=$item->id?>">Отметить заказа как <b>Отправлен</b>.Будет отправлено письмо клиенту об отправке</a>
                    <a class="orderPayedBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PAYED?>/id/<?=$item->id?>">Заказ Оплачен</a>

                <? }elseif($item->status == ORDER_STATUS_CANCEL || $item->status == ORDER_STATUS_PAYED){ ?>

                <? }elseif($item->status == ORDER_STATUS_DELIVERED){ ?>

                    <a class="orderPayedBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PAYED?>/id/<?=$item->id?>">Заказ Оплачен</a>

                <? }elseif($item->status == ORDER_STATUS_PROCEEDED){ ?>

                    <a class="orderDeliveredBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_DELIVERED?>/id/<?=$item->id?>">Отметить заказ как <b>Отправлен</b>.Будет отправлено письмо клиенту об отправке</a>
                    <a class="orderPayedBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PAYED?>/id/<?=$item->id?>">Заказ Оплачен</a>

                <? } ?>

                <div style="float:right;">

                    <? if($item->status != ORDER_STATUS_CANCEL) { ?>
                        &nbsp;
                        <a onclick="SPAdmin.showConfirmMessage('Подтвердите анулирование', 'Вы действительно хотите отменить заказ #<?=$item->id?>? <br/><br/>Информация о заказе не будет удалена, все отменённые заказы помечаються как «Отменённые»', function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$item->id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$item->id?>">Анулировать заказ</a>
                    <? } ?>
                    
                    &nbsp;
                    <a class="viewBtn" href="<?php echo url::site(); ?>orders/info/id/<?=$item->id?>">Посмотреть</a>
                </div>

            </td>
        
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>



<? if(isset($pagination)) { ?>
     <?php echo $pagination ?>
<? } ?>

<?php }else{ ?>

	<p  style="margin-top: 0px;">Заказов на данный момент нет.</p>

<? } ?>