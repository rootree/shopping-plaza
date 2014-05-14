<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
 
<div class="podtv">
<h2>Детализация заказа</h2>


<form id="yes"  action="/order/printing" method ="POST" name="form">
    <input type="hidden" name="DA" value="YES"/>
    <p><input  alt="Оформить" type="submit" value=""/></p>
</form>

<br/><br/><br/><br/>

<table class="cartList" cellspacing="0" cellpadding="0">
  <tr class="top">
    <td class="num"><p>№</p></td>
    <td  ><p>Тип</p></td>
    <td style="min-width:100px;"><p>Цена за ед.</p></td>
    <td  ><p>Кол-во.</p></td>
    <td  ><p>Ед.изм.</p></td>
    <td style="min-width:100px;" ><p>Цена на сайте</p></td>
  </tr>

 
<? $counter = 1; $sum_internet = $sum_shop = $sum_econom = 0?>
<?foreach ($items as $key ){ ?>

    <? $internet_prise = formula($key); ?>
 
        <tr id="item_id_<?=$key->product_id?>">
            <td><p class="11"><?=$counter?>.</p></td>
            <td class="itemTitle" ><p>
                <a target="_blank" href="/products/item/id/<?=$key->product_id?>" title="Более подробно о <?=html::specialchars($key->title)?>"><?=$key->title?></a>
                <? if($key->counter < 1) {   ?>
                    (На заказ)
                <? } ?>
            </p></td>
            <td><p class="price1"><b><?=money::ru($internet_prise);  ?></b></p></td>
            <td class="edizm"><p class="11"><?=$items_ses[$key->product_id]->counter ?></p></td>
            <td class="edizm"><p class="11">шт.</p></td>
            <td><p class="price2"><b><?=money::ru($internet_prise * $items_ses[$key->product_id]->counter) ;
                $sum_internet += ($internet_prise * $items_ses[$key->product_id]->counter) ?></b></p></td>
        </tr>
 
		<? $counter ++;?>

	<?}?>

    <? if($delivery->cost){ ?>

      <tr>
        <td><p class="11"><?=$counter?>.</p></td>
        <td><p><?=$delivery->title?></p></td>
        <td  ><p class="price1"><b></b></p></td>
        <td class="edizm"><p class="11"></p></td>
        <td   class="edizm"><p class="11"></p></td>
        <td  ><p class="price2"><b><?=money::ru($delivery->cost); $sum_internet += $delivery->cost; ?></b></p></td>
      </tr>

    <? } ?>

 
</table>

 
<div class="allPrice">
    <div class="itogo2"><p><b class="min">Итого:</b><b><?=money::ru($sum_internet)?></b></p></div>
</div>


<div class="sposob">

    <div class="left">

        <h2>Способ доставки: <?= html::specialchars($delivery->title) ?></h2>

        <? if(count($GLOBALS['DELIVERY_FIELDS'][$baseDeliveryType])) { ?>

            <table cellspacing="0" cellpadding="0">

            <? foreach ($GLOBALS['DELIVERY_FIELDS'][$baseDeliveryType] as $field => $fieldDesc) { ?>

                <tr>
                    <td class="labelTD"><p><b><?=$fieldDesc->name?></b></p></td>
                    <td class="comments"><p><?=((isset($deliveryInfo->{$field}) && !empty($deliveryInfo->{$field}))  ? $deliveryInfo->{$field} : "-"); ?></p></td>
                </tr>

            <? } ?>

            </table>



        <? } ?>

    </div>

</div>

<div class="clear"></div>

<a href="/order">Изменить</a>

<div class="sposob">

        <div class="left">

            <h2>Способ оплаты: <?= html::specialchars($pay_way->title) ?></h2>

     
         <? if(count($GLOBALS['PAY_WAY_TYPE'][$basePayWay])) { ?>

            <table cellspacing="0" cellpadding="0">

                <? foreach ($GLOBALS['PAY_WAY_TYPE'][$basePayWay] as $field => $fieldDesc) { ?>

                    <tr>
                        <td class="labelTD"><p><b><?=$fieldDesc->name?>:</b></p></td>
                        <td class="comments"><p><?=((isset($paymentInfo->{$field}) && !empty($paymentInfo->{$field})) ? $paymentInfo->{$field} : "-"); ?></p></td>
                    </tr>

                <? } ?>

            </table>



        <? }else{ ?>


            <table cellspacing="0" cellpadding="0">

                    <tr>
                        <td style="color: #666666;"><?= html::specialchars($pay_way->conditions) ?></td>
                        
                    </tr>

            </table>
  
        <? }?>
            
         </div>
</div>

<div class="clear"></div>
    
<a href="/order/payway">Изменить</a>

<form id="yes"  action="/order/printing" method ="POST" name="form">
    <input type="hidden" name="DA" value="YES"/>
    <p><input alt="Оформить" type="submit" value=""/></p>
</form>
</div>
 
 