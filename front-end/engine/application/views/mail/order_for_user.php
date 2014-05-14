<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<? $timeOrder = false; ?>

<br/>
Здравствуйте <?=html::specialchars($content->deliveryInfo->name)?>, ваш заказ имеет номер
№<?=($content->orderNumber)?> и находиться в очереди обработки. Наш менеджер свяжется с вами в ближайшее время.
<br/><br/>


<div>

	<strong>Содержимое заказа:</strong>

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
                    <? if($key->counter < 1) { $timeOrder = true; ?>
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

    <? if($content->delivery->cost){ ?>

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

    <? if($timeOrder) { ?>
        <p>
            Что обозначает <b>«На заказ»</b>
        </p>
        <p>«На заказ» обозначает, что данного товара нет в наличии,
            но его можно будет получить в течении нескольких дней. Сколько именно? На этот вопрос сможет ответить наш менеджер.
            Вы можете перед оформлением заказа, позвонить и узнать, когда будет товар. Или наш менеджер сам с вами свяжется
            после оформления заказа.
        </p>
    <? } ?>
 
    <br/>
    <strong>Способ доставки: <?= $content->delivery->title ?></strong>

    <? if(count($GLOBALS['DELIVERY_FIELDS'][$content->baseDeliveryType])) { ?>

        <table cellpadding="5" cellspacing="0" id="bin">

        <? foreach ($GLOBALS['DELIVERY_FIELDS'][$content->baseDeliveryType] as $field => $fieldDesc) { ?>

            <tr>
                <td><?=$fieldDesc->name?>:</td>
                <td><?=((isset($content->deliveryInfo->{$field}) && !empty($content->deliveryInfo->{$field}))  ? html::specialchars($content->deliveryInfo->{$field}) : "-"); ?></td>
            </tr>

        <? } ?>

        </table>
        
    <? } ?>

    <br/>
    <strong>Способ оплаты: <?= $content->pay_way->title ?></strong>

    <? if(count($GLOBALS['PAY_WAY_TYPE'][$content->basePayWay])) { ?>

        <table cellpadding="5" cellspacing="0" id="bin">

        <? foreach ($GLOBALS['PAY_WAY_TYPE'][$content->basePayWay] as $field => $fieldDesc) { ?>
 
            <tr>
                <td><?=$fieldDesc->name?>:</td>
                <td><?=((isset($content->paymentInfo->{$field}) && !empty($content->paymentInfo->{$field})) ? html::specialchars($content->paymentInfo->{$field}) : "-"); ?></td>
            </tr>

        <? } ?>

        </table>
        
    <? }else{ ?>

            <table cellspacing="0" cellpadding="0">

                    <tr>
                        <td style="color: #666666;"><?= html::specialchars($content->pay_way->conditions) ?></td>

                    </tr>

            </table>

    <? } ?>
 

</div>

<? if($firm->mail_inside){ ?>

    <div>
        <br/>
         <?=$firm->mail_inside?>
    </div>

<? } ?>