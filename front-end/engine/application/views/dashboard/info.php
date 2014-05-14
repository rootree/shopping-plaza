<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<div class="podtv">

<br/> 
<a href="#" onclick="history.back(); return false;">К списку заказов</a>

<? if($this->items->count()){ ?>

    <h2>Содержание заказа №<?php echo ($this->item->id) ?></h2>

    <table class="cartList" cellspacing="0" cellpadding="0">
        
        <tr class="top">
            <td class="num"><p>№</p></td>
            <td ><p>заказа</p></td>
            <td nowrap="nowrap" style="width:110px;"><p>Цена</p></td>
            <td style="width:50px;" nowrap="nowrap"><p>Кол-во.</p></td>
            <td style="width:50px;" nowrap="nowrap"  ><p>Ед.из.</p></td>
            <td nowrap="nowrap" style="width:110px;"><p>Стоимость</p></td>
        </tr>

    <?php

    $current_first_item = 1;

    $sum_internet = 0;

    foreach ($this->items as $this->itemT) {  ?>

            <tr>
                <td><p class="11"><?=$current_first_item?>.</p></td>
                <td class="itemTitle"><p>

                    <a target="_blank" href="/products/item/id/<?=$this->itemT->product_id?>"  ><?=$this->itemT->title?></a>

                </p></td>
                <td>
                    <p class="price1"><b><?=money::ru($this->itemT->price );?></b></p>
                </td>
                <td class="itemTitle"><p>
                   <?php echo ($this->itemT->count) ?>
                </p></td>
                <td class="itemTitle"><p>
                    шт.
                </p></td>
                <td><p class="price1"><b><?=money::ru($this->itemT->price * $this->itemT->count);
                    $sum_internet += $this->itemT->price * $this->itemT->count; ?></b></p>
                </td>
             </tr>

    <?php  $current_first_item ++;
    } ?>

        <? if($this->item->delivery_cost > 0){ ?>

            <tr >
                <td><p class="11"><?=$current_first_item?>.</p></td>
                <td class="itemTitle"><p>
                    Доставка
                </p></td>
                <td class="itemTitle"><p>

                </p></td>
                <td class="itemTitle"><p>

                </p></td>
                <td class="itemTitle"><p>

                </p></td>
                <td><p class="price1"><b><?=money::ru($this->item->delivery_cost); $sum_internet += $this->item->delivery_cost; ?></b></p></td>

             </tr>

        <? } ?>

    </table>

    <div class="allPrice">
        <div class="itogo"><p><b class="min">Итого:</b><b><?=money::ru($sum_internet)?></b></p></div>
    </div>

<?php } ?>



<div class="sposob">

    <div class="left">

    <h2>Информация о заказе</h2>

    <table class="form">
 
        <tr>
            <td class="labelTD"><p><b>Номер:</b></p></td>
            <td class="comments">
                <p><?php echo ($this->item->id) ?></p>
            </td>
        </tr> 
        <tr>
            <td class="labelTD"><p><b>Поступил:</b></p></td>
            <td class="comments">
                <p><?php echo time::date($this->item->date, DATE_FORMAT) ?></p>
            </td>
        </tr>
        <tr>
            <td class="labelTD"><p><b>Способ оплаты:</b></p></td>
            <td class="comments">
                <p><?php echo $this->item->payment ?></p>
            </td>
        </tr>
        <tr>
            <td class="labelTD"><p><b>Способ доставки:</b></p></td>
            <td class="comments">
                <p><?php echo $this->item->delivery ?></p>
            </td>
        </tr>
        <tr>
            <td class="labelTD"><p><b>Текушее состояние:</b></p></td>
            <td class="comments">
                <p><?php echo $GLOBALS['ORDER_STATUS'][($this->item->status)] ?></p>
            </td>
        </tr>
  
    </table>

    </div>
 
</div>
 

<? if(count($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery])) { ?>
 
    <div class="sposob">

        <div class="left">

        <h2>Данные о доставке</h2>

        <table class="form">

            <? foreach ($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery] as $field => $fieldDesc) { ?>

                <tr>
                    <td class="labelTD"><p><b><?=$fieldDesc->name?></b></p></td>
                    <td class="comments">
                        <p><?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? $this->deliveryInfo->{$field} : "-"); ?></p>
                    </td>
                </tr>

            <? } ?>

        </table>

        </div>

    </div>
 

<? } ?>



<? if(count($GLOBALS['PAY_WAY_TYPE'][$this->item->field_type_pay])) { ?>

    <div class="sposob">

    <div class="left">

    <h2>Данные о платиже</h2>

        <table class="form">

        <? foreach ($GLOBALS['PAY_WAY_TYPE'][$this->item->field_type_pay] as $field => $fieldDesc) { ?>

            <tr>
                <td class="labelTD"><p><b><?=$fieldDesc->name?></b></p></td>
                <td class="comments">
                    <p><?=((isset($this->paymentInfo->{$field}) && !empty($this->paymentInfo->{$field})) ? $this->paymentInfo->{$field} : "-"); ?></p>
                </td>
            </tr>

            <? } ?>

        </table>

    </div>

    </div>
        
<? } ?>     
 
</div>