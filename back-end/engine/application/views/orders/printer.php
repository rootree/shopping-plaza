<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($this->item)) { ?>

<div id="addOnMenu">

    <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
 
<? if($this->item->status == ORDER_STATUS_NEW || $this->item->status == ORDER_STATUS_VIEWED) { ?>

    <a class="orderOkBtnText" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_PROCEEDED?>/order/<?=$this->item->id?>">Обработан</a>
    <a class="orderDeliveredBtnText" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_DELIVERED?>/order/<?=$this->item->id?>">Отправлен</a>
    <a class="orderPayedBtnText" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_PAYED?>/order/<?=$this->item->id?>">Оплачен</a>

    <a onclick="SPAdmin.showConfirmMessage('Подтвердите анулирование', 'Вы действительно хотите отменить заказ #<?=$this->item->id?>? <br/><br/>Информация о заказе не будет удалена, все отменённые заказы помечаються как «Отменённые»', function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_CANCEL?>/order/<?=$this->item->id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_CANCEL?>/order/<?=$this->item->id?>">Анулировать</a>
                          
<? }elseif($this->item->status == ORDER_STATUS_CANCEL || $this->item->status == ORDER_STATUS_DELIVERED){ ?>

<? }elseif($this->item->status == ORDER_STATUS_PAYED){ ?>

    <a class="orderDeliveredBtnText" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_DELIVERED?>/order/<?=$this->item->id?>">Отправлен</a>
    <a onclick="SPAdmin.showConfirmMessage('Подтвердите анулирование', 'Вы действительно хотите отменить заказ #<?=$this->item->id?>? <br/><br/>Информация о заказе не будет удалена, все отменённые заказы помечаються как «Отменённые»', function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_CANCEL?>/order/<?=$this->item->id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_CANCEL?>/order/<?=$this->item->id?>">Анулировать</a>

<? }elseif($this->item->status == ORDER_STATUS_PROCEEDED){ ?>

    <a class="orderDeliveredBtnText" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_DELIVERED?>/order/<?=$this->item->id?>">Отправлен</a>
    <a class="orderPayedBtnText" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_PAYED?>/order/<?=$this->item->id?>">Оплачен</a>
    <a onclick="SPAdmin.showConfirmMessage('Подтвердите анулирование', 'Вы действительно хотите отменить заказ #<?=$this->item->id?>? <br/><br/>Информация о заказе не будет удалена, все отменённые заказы помечаються как «Отменённые»', function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_CANCEL?>/order/<?=$this->item->id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>orders/index/typeaction/<?=ORDER_STATUS_CANCEL?>/order/<?=$this->item->id?>">Анулировать</a>

<? } ?>

    <a onclick="$('#orderComment').toggle();" class="commentTextBtn" >Написать комментарий</a>


</div>



<center>

<? if($this->items->count()){

$total = 0;

?>

<div id="orderContent">

    <table id="bin" cellspacing="0" cellpadding="5" >

        <tr>
            <th width="20">№</th>
            <th >Товар</th>
            <th width="170">Кол-во</th>
            <th  >Цена</th>
            <th  >Стоимость</th>
            <th width="60"></th>
        </tr>

    <?php

    $count = 0;
    $current_first_item = 1;

    foreach ($this->items as $this->itemT) {

        $count ++;

        $class = "";

        if ($count % 2 == 0) {
                $class="modTwo";
        }

    ?>

        <tr class="hightLight <?php echo $class ?>" >

            <td class="catalog" ><?php echo $current_first_item ?></td>
            <td  ><?=$this->itemT->title?></td>
            <td class="catalog"><?php echo ($this->itemT->count) ?> шт. </td>
            <td class="catalog">
                 <?=money::ru($this->itemT->price)  ?>
            </td>
            <td class="catalog">
                 <?=money::ru($this->itemT->price * $this->itemT->count); $total += ($this->itemT->price * $this->itemT->count)?>
            </td>
            <td class="catalog">
                 <a class="viewBtn" href="<?php echo url::site(); ?>products/info/catid/<?=$this->itemT->cat_id?>/catssubid/<?=$this->itemT->catsub_id?>/id/<?=$this->itemT->product_id?>/">Посмотреть</a>
            </td>
        </tr>

    <?php
        $current_first_item ++;
    }
    ?>

        <? if($this->item->delivery_cost > 0){

            $count ++;
            $class = "";

            if ($count % 2 == 0) {
                    $class="modTwo";
            }

            ?>

            <tr class="hightLight <?php echo $class ?>" >

                <td class="catalog" ><?php echo $current_first_item ?></td>
                <td  >Доставка - <?php echo $this->item->delivery ?></td>
                <td class="catalog"> </td>
                <td class="catalog">

                </td>
                <td class="catalog">
                     <?=money::ru($this->item->delivery_cost); $total += ($this->item->delivery_cost)?>
                </td>
                <td class="catalog">

                </td>
            </tr>


        <? } ?>

    </table>
<p>
        <div style="float:right; padding-right: 20px;">
            Итого: <?=money::ru($total)?>
        </div>
   </p>

    </div>

<?php } ?>


<div id="orderInfo">

 
    <table class="form">

        <tr>
            <td class="label">Номер:</td>
            <td class="elements view">
                #<?php echo ($this->item->id) ?>
            </td>
        </tr>


        <tr>
            <td class="label">Поступил:</td>
            <td class="elements view">
                <?php echo time::date($this->item->date, DATE_FORMAT) ?>
            </td>
        </tr>
 

        <tr>
            <td class="label">Способ оплаты:</td>
            <td class="elements view">
                <b>
                    <? if(count($GLOBALS['PAY_WAY_TYPE'][$this->item->field_type_pay])) { ?>
                        <?php echo $this->item->payment ?>
                    <? }else{ ?>
                        <?php echo $this->item->payment ?>
                    <? } ?>
                </b>
            </td>
        </tr>

        <tr>
            <td class="label">Способ доставки:</td>
            <td class="elements view">
                <b>
                    <? if(count($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery])) { ?>
                        <?php echo $this->item->delivery ?>
                    <? }else{ ?>
                        <?php echo $this->item->delivery ?>
                    <? } ?>
                </b>
            </td>
        </tr>
     

        <tr>
            <td class="label">Текушее состояние:</td>
            <td class="elements view"  >
                <?php echo $GLOBALS['ORDER_STATUS'][($this->item->status)] ?>
            </td>
        </tr>


        <tr>
            <td class="label"> </td>
            <td class="view bottomHandler"  >
                <a onclick="$('#orderComment').toggle();" class="commentTextBtn" >Написать комментарий</a>
            </td>
        </tr>
 
    </table>

    <div id="orderComment" style="display:none;">

        <center>

            <form action="/orders/info/id/<?=$this->item->id?>" method="post">

                <table class="form">

                    <tr>
                        <td class="label">Содержание комментария:</td>
                        <td class=" view">

                            <textarea id="pages_content" name="order[content]" style="height: 100px;"><?php
                                echo @html::specialchars($_POST['order']['content'])
                                ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                        </td>
                    </tr>

                    <tr>
                        <td class="label"></td>
                        <td class="">
                            <input type="submit" value="Отправить">
                        </td>
                    </tr>

                </table>

            </form>

        </center>

    </div>


    <? if($this->comments->count()){ ?>

        <table class="form">

            <tr>
                <td class="label bottomHandler">Комментарии:</td>
                <td class=" bottomHandler">

                    <table id="bin" cellspacing="0" cellpadding="5" >

                        <tr>
                            <th width="70">Дата отправки</th>
                            <th>Комментарий</th>
                            <th width="70">Менеджер</th>
                        </tr>

                        <?php

                    $count = 0;
                    $current_first_item = 1;

                        foreach ($this->comments as $history) {

                            $count ++;
                            $class = "";

                            if ($count % 2 == 0) {
                                    $class="modTwo";
                            }

                        ?>

                            <tr class="hightLight <?php echo $class ?>" >

                                <td  class="catalog"><?=time::date($history->date, DATE_FORMAT)?></td>
                                <td><?=$history->content?></td>
                                <td class="catalog" >
                                    <? if(!empty($history->user_name)) { ?>
                                        <?=$history->user_name?>
                                    <?php } ?>
                                </td>

                            </tr>

                        <?php } ?>

                    </table>

                </td>
            </tr>

            <tr>
                <td class="label"> </td>
                <td class=" "  >
                    <a onclick="$('#orderComment').toggle();" class="commentTextBtn" >Написать комментарий</a>
                </td>
            </tr>

        </table>

    <?php } ?>



</div>

<? if(count($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery])) { ?>

<div id="orderDelivery">
 
    <table class="form">

        <tr>
            <td align="center" colspan="2" class="view bottomHandler"><h4>Информация о доставке</h4></td>
        </tr>

        <? foreach ($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery] as $field => $fieldDesc) { ?>

            <tr>
                <td class="label"><?=$fieldDesc->name?>:</td>
                <td class="elements view">
                    <?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? $this->deliveryInfo->{$field} : "-"); ?>
                </td>
            </tr>

        <? } ?>


        <tr>
            <td class="label">Адрес на картах:</td>
            <td class="elements view">

                <?

                $q = '';

                switch($this->item->field_type_devivery){
                    case DELIVERY_TYPE_CURIER:
                        $q = 'ул. ' . $this->deliveryInfo->street . ', д.' . $this->deliveryInfo->house  ;
                        break;
                    case DELIVERY_TYPE_CURIER_TO_METRO:
                        $q = 'метро ' . $this->deliveryInfo->metro;
                        break;
                    case DELIVERY_TYPE_EMS:
                        $q = $this->deliveryInfo->region . ', '.$this->deliveryInfo->city . ', ул. '.
                             $this->deliveryInfo->street . ', д.' . $this->deliveryInfo->house  ;
                        break;
                }

                ?>

                <a target="_blank" href="http://maps.yandex.ru/?sll=&sspn=&z=&source=form&text=<?=urlencode($q)?>">Яндекс карты</a><br/>
                <a target="_blank" href="http://maps.google.ru/maps?hl=ru&newwindow=1&nord=1&q=<?=urlencode($q)?>">Карты Google</a>
            </td>
        </tr>

    </table>
    
</div>

<? } ?>


<div id="orderPayway">

    <? if(count($GLOBALS['PAY_WAY_TYPE'][$this->item->field_type_pay]) && count($GLOBALS['PAY_WAY_TYPE'][$this->item->field_type_pay])) { ?>

        <table width="97%" cellpadding="5" cellspacing="0" id="bin">

            <tr>
                <td align="center" colspan="2" class="view bottomHandler"><h4>Информация о платеже</h4></td>
            </tr>

        <? foreach ($GLOBALS['PAY_WAY_TYPE'][$this->item->field_type_pay] as $field => $fieldDesc) { ?>

            <tr>
                <td><?=$fieldDesc->name?></td>
                <td><?=((isset($this->paymentInfo->{$field}) && !empty($this->paymentInfo->{$field})) ? $this->paymentInfo->{$field} : "-"); ?></td>
            </tr>
 
        <? } ?>

        </table>

    <? } ?>

</div>



<? if($this->order_history->count()){ ?>

<div id="orderHistory">


<table class="form">

    <tr>
        <td class="label bottomHandler">Операции над сообщением:</td>
        <td class="view bottomHandler">

            <table id="bin" cellspacing="0" cellpadding="5" >

                <tr>
                    <th width="20">№</th>
                    <th width="170">Дата операции</th>
                    <th width="170">Присвоен статус</th>
                    <th>Менеджер</th>
                </tr>

                <?php

            $count = 0;
            $current_first_item = 1;

                foreach ($this->order_history as $history) {

                    $count ++;
                    $class = "";

                    if ($count % 2 == 0) {
                            $class="modTwo";
                    }

                ?>

                    <tr class="hightLight <?php echo $class ?>" >

                        <td class="catalog" ><?php echo $current_first_item ?></td>
                        <td  class="catalog"><?=time::date($history->date, DATE_FORMAT)?></td>
                        <td class="catalog"><?=$GLOBALS['ORDER_STATUS'][$history->type]?></td>
                        <td class="catalog" >
                            <? if(!empty($history->user_name)) { ?>
                                <?=$history->user_name?>
                            <?php } ?>
                        </td>

                    </tr>

                <?php } ?>

            </table>

        </td>
    </tr>

</table>


 

</div>

<?php } ?>

</center>

<?php } ?>
 