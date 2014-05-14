<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div>

	<h3>Содержание заказа:</h3>

	<table width="97%" cellpadding="5" cellspacing="0" id="bin" border="1">
		<tr>
			<th>№</th>
			<th>Товар</th>
			<th>Цена за ед.</th>
			<th>Кол-во.</th>
			<th>Ед.изм.</th>
			<th>Стоимость</th>
		</tr>

	<? $counter = 1; $sum_internet = $sum_shop = $sum_econom = 0?>
	<?foreach ($content->items as $key ){ ?>

		<? $internet_prise = formula($key); ?>
		<? if ($counter % 2 == 0) {$bg = '#f0f9fb';}else{$bg = '#FFFFFF';}; ?>
		<tr bgcolor="<?=$bg?>" id="item_id_<?=$key->product_id?>">
			<td align="center"><?=$counter?>.</td>
			<td>

                <a href="http://<?=SERVER_SITE?>/products/item/id/<?=$key->product_id?>" title="Более подробно о <?=html::specialchars($key->title)?>"><?=$key->title?></a>
                    <? if($key->counter < 1) {  ?>
                        (На заказ)
                    <? } ?>
                </td>
			<td align="center"nowrap="nowrap"><?=money::ru($internet_prise);  ?></td>
            <td  align="center"> <?=$content->items_ses[$key->product_id]->counter?></td>

			<td align="center">шт.</td>
			<td align="center" nowrap="nowrap"><?=money::ru($internet_prise * $content->items_ses[$key->product_id]->counter) ; $sum_internet += ($internet_prise * $content->items_ses[$key->product_id]->counter) ?></td>
		    
		</tr>

		<? $counter ++;?>

	<?}?>

    <? if(isset($content->delivery) && $content->delivery->cost){ ?>

        <? if ($counter % 2 == 0) {$bg = '#f0f9fb';}else{$bg = '#FFFFFF';}; ?>

		<tr bgcolor="<?=$bg?>">
			<td align="center"><?=$counter?>.</td>
			<td >
                 <?=html::specialchars($content->delivery->title)?>
            </td>
			<td nowrap="nowrap">-</td>
			<td nowrap="nowrap">-</td>
			<td align="center">-</td>
			<td align="center" nowrap="nowrap"><?=money::ru($content->delivery->cost); $sum_internet += $content->delivery->cost; ?></td>

		</tr>

        <? $counter ++;?>
    <? } ?>

		<? if ($counter % 2 == 0) {$bg = '#f0f9fb';}else{$bg = '#FFFFFF';}; ?>

		<tr bgcolor="<?=$bg?>">
			<td colspan="5"  style="text-align: right;"><strong>Итого:</strong></td>
			<td  align="center" nowrap="nowrap"><?=money::ru($sum_internet)?></td>
		</tr>

	</table>

 
	<? if (isset($deliveryInfo)) { ?>
		<br/> 
		<h3>Телефон для связи: <?=$deliveryInfo->phone ?> <?=(!empty($deliveryInfo->name) ? '('.$deliveryInfo->name.')' : '')?></h3>
		
	<? } ?>
	
	<? if (isset($content->delivery)) { ?>
    <h3>Способ доставки: <?= $content->delivery->title ?></h3>


    <? if(count($GLOBALS['DELIVERY_FIELDS'][$content->baseDeliveryType])) { ?>

        <table width="97%" cellpadding="5" cellspacing="0" id="bin">

        <? foreach ($GLOBALS['DELIVERY_FIELDS'][$content->baseDeliveryType] as $field => $fieldDesc) { ?>


            <tr>
                <td><?=$fieldDesc->name?></td>
                <td><?=((isset($content->deliveryInfo->{$field}) && !empty($content->deliveryInfo->{$field}))  ? html::specialchars($content->deliveryInfo->{$field}) : "-"); ?></td>
            </tr>

        <? } ?>

        </table>
        
    <? } ?>
    <? } ?>
 
	<? if (isset($content->pay_way)) { ?>
    <h3>Способ оплаты: <?= $content->pay_way->title ?></h3>

    <? if(count($GLOBALS['PAY_WAY_TYPE'][$content->basePayWay])) { ?>

        <table width="97%" cellpadding="5" cellspacing="0" id="bin">

        <? foreach ($GLOBALS['PAY_WAY_TYPE'][$content->basePayWay] as $field => $fieldDesc) { ?>
 
            <tr>
                <td><?=$fieldDesc->name?></td>
                <td><?=((isset($content->paymentInfo->{$field}) && !empty($content->paymentInfo->{$field})) ? html::specialchars($content->paymentInfo->{$field}) : "-"); ?></td>
            </tr>

        <? } ?>

        </table>
        
    <? } ?>
	<? } ?>

</div>