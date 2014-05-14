<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<? if(count($groups)) { ?>

    <div class="podtv">

    <? foreach ($groups as $group ){  ?>

        <? $counter = 0;  ?>
        <h2><?=html::specialchars($group->title)?></h2>

    <table class="cartList" cellspacing="0" cellpadding="0">
      <tr class="top">
        <td class="num"><p>№</p></td>
        <td class="tip" style="width:auto;"><p>Тип</p></td>

          <? if ($this->firm->enabled == 1) { ?>

            <td   style="width:120px;" ><p>Цена</p></td>

              <? if($this->firm->prices) {?>

                <? if($this->firm->prices->enabled & 1 && $this->firm->prices->visible & 1){?>
                    <td   style="width:120px;" ><p><?=html::specialchars($this->firm->prices->list->price1)?></p></td>
                <? }?>
                <? if($this->firm->prices->enabled & 2 && $this->firm->prices->visible & 2){?>
                    <td   style="width:120px;" ><p><?=html::specialchars($this->firm->prices->list->price2)?></p></td>
                <? }?>
                <? if($this->firm->prices->enabled & 4 && $this->firm->prices->visible & 4){?>
                    <td   style="width:120px;" ><p><?=html::specialchars($this->firm->prices->list->price3)?></p></td>
                <? }?>
                <? if($this->firm->prices->enabled & 8 && $this->firm->prices->visible & 8){?>
                    <td   style="width:120px;" ><p><?=html::specialchars($this->firm->prices->list->price4)?></p></td>
                <? }?>
                <? if($this->firm->prices->enabled & 16 && $this->firm->prices->visible & 16){?>
                    <td   style="width:120px;" ><p><?=html::specialchars($this->firm->prices->list->price5)?></p></td>
                <? }?>

              <? }?>
 
             <td  style="width:100px;" ><p></p></td>
        <? }?>

      </tr>

        <? foreach ($items as $key ){  ?>

            <? if ($key->cat_id == $group->cat_id) {  ?>
                <? $counter ++;?>


        <tr>
            <td><p class="11"><?=$counter?>.</p></td>
            <td class="itemTitle"><p><a class="book" href="/products/item/title/<?=$key->url_link?>"><?=html::specialchars($key->title)?></td></a></p></td>

            <? if ($this->firm->enabled == 1) { ?>

                <td><p class="price1"><b><?=money::ru(formula($key));?></b></p></td>
 
                <? if($this->firm->prices) {?>
                    <? if($this->firm->prices->enabled & 1 && $this->firm->prices->visible & 1){?>
                        <td><p class="price1"><b><?=money::ru(($key->price1));?></b></p></td>
                    <? }?>
                    <? if($this->firm->prices->enabled & 2 && $this->firm->prices->visible & 2){?>
                        <td><p class="price1"><b><?=money::ru(($key->price2));?></b></p></td>
                    <? }?>
                    <? if($this->firm->prices->enabled & 4 && $this->firm->prices->visible & 4){?>
                        <td><p class="price1"><b><?=money::ru(($key->price3));?></b></p></td>
                    <? }?>
                    <? if($this->firm->prices->enabled & 8 && $this->firm->prices->visible & 8){?>
                        <td><p class="price1"><b><?=money::ru(($key->price4));?></b></p></td>
                    <? }?>
                    <? if($this->firm->prices->enabled & 16 && $this->firm->prices->visible & 16){?>
                        <td><p class="price1"><b><?=money::ru(($key->price5));?></b></p></td>
                    <? }?>
                <? }?>


                 <td>

                    <p  id="catalogItemID<?=$key->product_id?>">

                        <? if(!isset($items_ses[$key->product_id])) {?>

                            <? if($key->counter < 1 ):  ?>

                                <? if($this->firm->sales == 2 ):  ?>
                                    <a href="#"  onClick="SPHandler.showCounterMessage(<?=$key->product_id?>, event, 'catalogItemID<?=$key->product_id?>'); return false;">На заказ</a>
                                <? else : ?>
                                    Нет в наличии
                                <? endif ?>

                            <? else : ?>

                                <a href="#"  onClick="SPHandler.showCounterMessage(<?=$key->product_id?>, event, 'catalogItemID<?=$key->product_id?>'); return false;">Купить</a>

                             <? endif ?>

                        <? }else{   ?>
                             Товар в корзине
                        <? } ?>

                    </p>

                </td>
                <? }?>
              </tr>
            <? }?>
        <? }?>
        </table>
    <? }?>

    </div>
 
<? }else{ ?>

    <div id="errordesc infodesc">
        <p class="last-child"><br/><br/>Каталог продукции находиться в процессе наполнения.</p>
    </div>

<? } ?>