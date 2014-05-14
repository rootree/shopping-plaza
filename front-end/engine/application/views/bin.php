<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<? if (!$empty_bin) : ?>

<?
$timeOrder = false;
?>
<div class="podtv">
    
    <h2>Отложенные товары в корзине</h2>

    <div class="cartList">

    </div>

    <form action="/bin" method ="POST" name="form">

        <table class="cartList" cellspacing="0" cellpadding="0">
            <tr class="top">
                <td class="num"><p>№</p></td>
                <td ><p>Тип</p></td>
                <td style="width:100px;"><p>Цена за ед.</p></td>
                <td  nowrap="nowrap" style="width:120px;"><p>Кол-во.</p></td>
                <td nowrap="nowrap"  style="width:110px;"  ><p>Ед.изм.</p></td>
                <td nowrap="nowrap" style="width:110px;"><p>Цена</p></td>
                <td    class="back0"><p>&nbsp;</p></td>
            </tr>
 
            <? $counter = 1; $sum_internet = $sum_shop = $sum_econom = 0?>
            <?foreach ($items as $key ){ ?>

            <? $internet_prise = formula($key); ?>
            <? if ($counter % 2 == 0) {$bg = '#f0f9fb';}else{$bg = '#FFFFFF';}; ?>


            <tr id="item_id_<?=$key->product_id?>">
                <td><p class="11"><?=$counter?>.</p></td>
                <td class="itemTitle"><p>
                    <a class="book" href="/products/item/id/<?=$key->product_id?>" title="Более подробно о <?=html::specialchars($key->title)?>"><?=$key->title?></a>

                    <? if($key->counter < 1) { $timeOrder = true; ?>
                        (На заказ)
                    <? } ?>
                    
                </p></td>
                <td><p class="price1"><b><?=money::ru($internet_prise);  ?></b></p></td>
                <td class="kolvoOtl itemTitle"><p class="11" id="edit_item_<?=$key->product_id?>">
                        <div id="" class="count_it">
                            <?=$items_ses[$key->product_id]->counter?>
                            [<a class="book" href="#" title="Изменить кол-во данной позиции" onClick="SPHandler.editItems(0); return false;">Изм.</a>]
                        </div>
                        <div id="" class="count_it_edit" style="display: none;">

                            <a href="" style="margin-right:-2px;" onClick="SPHandler.changeCounter(false, '#itemEdit<?=$key->product_id?>'); return false;"><img class="left" src="/img.<?=$this->firm->template?>/icons/minus.png" alt="-" title="-"/></a>
                                <input class="binEdit"   type="text"  id="itemEdit<?=$key->product_id?>" name="items[<?=$key->product_id?>]" value="<?=$items_ses[$key->product_id]->counter?>" />
                            <a href="" onClick="SPHandler.changeCounter(true, '#itemEdit<?=$key->product_id?>'); return false;"><img class="right" src="/img.<?=$this->firm->template?>/icons/plus.png"  alt="+" title="+" /></a>

                        </div>
                    </p></td>
                <td class="edizm"><p class="11">шт.</p></td>
                <td><p class="price2"><b><?=money::ru($internet_prise * $items_ses[$key->product_id]->counter) ; $sum_internet += ($internet_prise * $items_ses[$key->product_id]->counter) ?></b></p></td>
                <td><a href="#" title="Удалить данную позицию" onClick="return SPHandler.deleteItem(<?=$key->product_id?>)"><img src="/img.<?=$this->firm->template?>/icons/del.gif"  alt="Удалить" title="Удалить позицию" /></a></td>
            </tr>
  
            <? $counter ++;?>

            <?}?>
 
        </table>



    <div id="count_button" class="" style="display: none; padding-top: 10px;">
        <input  class="sub" type="submit" name="" value="Изменить"/> | <a href="#" title="Изменить кол-во данной позиции" onClick="SPHandler.editItems(1); return false;">Отмена</a>
    </div>

    </form>

    <div class="allPrice">
        <form id="oformit" onsubmit="return false;">
            <p><input type="submit" value=" " onclick="$('.svyazForm').show();$('.allPrice').hide();;return false;"/></p>
        </form>
        <div class="itogo2">
            <p><b class="min">Итого:</b><b><?=money::ru($sum_internet)?></b></p>
        </div>
    </div>

    <div class="svyazForm" style="margin-top: 14px; text-align: right; padding-right: 11px; display: none;">
        <form  action="#" onsubmit="checkPhone(); return false;">
            <p><input id="deliverySubmit" type="submit" value=""></p>
        </form>
        <div class="itogo2">
            Укажите ваш номер телефона: <input class="spec" id="phone" name="phone" type="input"
                   value="<?=(cookie::get('phone')) ? cookie::get('phone') : ''?>"/>
        </div>
    </div>

    <script type="text/javascript">

        function checkPhone(){

            var phone = $('#phone').val();
            if(phone){
                document.location.href = '/order?phone='+phone;
            }else{
                alert('Вы почти оформили заказ. \nДело за малым.\n\nУкажите ваш номер телефона.');
            }

        }

    </script>

    <? if($timeOrder) { ?>
        <h3>
            Что обозначает <b>«На заказ»</b>
        </h3>
        <p style="color:#333333;">«На заказ» обозначает, что данного товара нет в наличии,
            но его можно будет получить в течении нескольких дней. Сколько именно? На этот вопрос сможет ответить наш менеджер.
            Вы можете перед оформлением заказа, позвонить и узнать, когда будет товар. Или наш менеджер сам с вами свяжется
            после оформления заказа.
        </p>
    <? } ?>
    
    <div class="clear"></div>

</div>


<? else : ?>

<h2>Ваша корзина пуста</h2>
<br/>
Вы не выбрали ни одного товара.
<br/><br/>
Для предварительного оформления заказа, следует выбрать товар и отложить.
<br/><br/>
Затем, отложенный товар появиться на этой странице, где его будет предложено оформить как заказ.


<? endif?> 