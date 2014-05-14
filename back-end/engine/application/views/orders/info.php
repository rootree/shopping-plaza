<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<?php if(count($this->item)) { ?>

<? $deliveryTime = false;

    if($this->item->field_type_devivery == DELIVERY_TYPE_CURIER || $this->item->field_type_devivery == DELIVERY_TYPE_CURIER_TO_MCAD){
    $deliveryTime = true;
}?>

<div id="addOnMenu">

    <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
 
<? if($this->item->status == ORDER_STATUS_NEW || $this->item->status == ORDER_STATUS_VIEWED) { ?>

    <a title="Отметить заказ как обработанный" class="orderOkBtnText" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PROCEEDED?>/id/<?=$this->item->id?>">Обработан</a>
    <a title="Отметить заказ как <b>Отправлен</b>.<br/>Будет отправлено письмо клиенту об отправке" class="orderDeliveredBtnText" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_DELIVERED?>/id/<?=$this->item->id?>">Отправлен</a>
    <a title="Отметить как заказ Оплачен" class="orderPayedBtnText" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PAYED?>/id/<?=$this->item->id?>">Оплачен</a>

    <a onclick="SPAdmin.showConfirmMessage('Подтвердите анулирование', 'Вы действительно хотите отменить заказ #<?=$this->item->id?>? <br/><br/>Информация о заказе не будет удалена, все отменённые заказы помечаються как «Отменённые»', function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$this->item->id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$this->item->id?>">Анулировать</a>
                          
<? }elseif($this->item->status == ORDER_STATUS_CANCEL || $this->item->status == ORDER_STATUS_PAYED){ ?>

<? }elseif($this->item->status == ORDER_STATUS_DELIVERED){ ?>

    <a  title="Отметить как заказ Оплачен" class="orderPayedBtnText" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PAYED?>/id/<?=$this->item->id?>">Оплачен</a>
    <a onclick="SPAdmin.showConfirmMessage('Подтвердите анулирование', 'Вы действительно хотите отменить заказ #<?=$this->item->id?>? <br/><br/>Информация о заказе не будет удалена, все отменённые заказы помечаються как «Отменённые»', function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$this->item->id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$this->item->id?>">Анулировать</a>

<? }elseif($this->item->status == ORDER_STATUS_PROCEEDED){ ?>

    <a  title="Отметить заказ как <b>Отправлен</b>.<br/>Будет отправлено письмо клиенту об отправке"  class="orderDeliveredBtnText" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_DELIVERED?>/id/<?=$this->item->id?>">Отправлен</a>
    <a  title="Отметить как заказ Оплачен" class="orderPayedBtnText" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_PAYED?>/id/<?=$this->item->id?>">Оплачен</a>
    <a onclick="SPAdmin.showConfirmMessage('Подтвердите анулирование', 'Вы действительно хотите отменить заказ #<?=$this->item->id?>? <br/><br/>Информация о заказе не будет удалена, все отменённые заказы помечаються как «Отменённые»', function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$this->item->id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_CANCEL?>/id/<?=$this->item->id?>">Анулировать</a>

<? } ?>

    <a  title="Оставить комментарий к этому заказу" onclick="$('#orderComment').toggle('fade');" class="commentTextBtn" >Написать комментарий о заказе</a>


</div>



<center>

<? if($this->items->count()){

$total = 0;

?>

<div id="orderContent">

    <form action="/orders/info/id/<?=$this->item->id?>" method="post">

    <table id="bin" cellspacing="0" cellpadding="5" >

        <tr>
            <th width="20">№</th>
            <th <?  if (isset($this->productView) && $this->productView != PRODUCTS_VIEW_LIST) { ?> colspan="2" <? } ?></th>
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

            <td class="catalog" ><?php echo $current_first_item ?>
 
            </td>
 
            <?  if (isset($this->productView) && $this->productView != PRODUCTS_VIEW_LIST) { ?>

                <td style=" width: 120px; height: 120px;background: url(<?=SuperPath::get($this->itemT->source == 0 ? $this->itemT->img : $this->itemT->imgSearch , true)?>m.jpg) center no-repeat;background-repeat: no-repeat;">
 
                    <span  >
                    </span>
                    
                </td>

            <? }  ?>


            <td  >
                <?=$this->itemT->title?>

                <? if($this->itemT->sCounter < 1 ):  ?>
                    <i>(На заказ)</i>
                <? endif ?>

            </td>

            <td class="catalog" >
				<span class="countView">
					<?php echo ($this->itemT->counteS) ?>
					шт.
					<i>(На складе: <?php echo ($this->itemT->sCounter) ?>)</i>
				</span>
				<span class="countEdit" style="display: none;">
					<input style="text-align:center;" value="<?php echo ($this->itemT->counteS) ?>" type="input" name="countItems[<?=$this->itemT->product_id?>]"/>
				</span>
			</td>

            <td class="catalog">

                <? $costDD = (empty($this->itemT->costerFM)) ? $this->itemT->price : $this->itemT->costerFM ?>

                 <?=money::ru($costDD)  ?> <? if (!empty($this->itemT->costerFM) ) { ?><br/><small><i>(на время заказа)</i></small><? } ?>
                
            </td>
            <td class="catalog">
                 <?=money::ru($costDD * $this->itemT->counteS); $total += ($costDD * $this->itemT->counteS)?>
            </td>
            <td class="catalog" width="100px;">
                 <a title="Перейти к карточке товара" class="viewBtn" href="<?php echo url::site(); ?>products/info/catid/<?=$this->itemT->cat_id?>/catssubid/<?=$this->itemT->catsub_id?>/id/<?=$this->itemT->product_id?>/">Посмотреть</a>
 
				<a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить «<?=$this->itemT->title?>» из заказа?',
								   function(){SPAdmin.goToURL('<?php echo url::site(); ?>orders/info/id/<?=$this->item->id?>?dropItem=<?=$this->itemT->product_id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>orders/info/id/<?=$this->item->id?>?dropItem=<?=$this->itemT->product_id?>">Удалить</a>

            </td>
        </tr>

    <?php
        $current_first_item ++;
    } ?>

        <? if($this->item->delivery_cost > 0){

            $count ++;
            $class = "";

            if ($count % 2 == 0) {
                    $class="modTwo";
            }

            ?>

            <tr class="hightLight <?php echo $class ?>" id="deliveryTR">

                <td class="catalog" ><?php echo $current_first_item ?></td>
                <td <?  if (isset($this->productView) && $this->productView != PRODUCTS_VIEW_LIST) { ?> colspan="2" <? } ?> >Доставка - <?php echo $this->item->delivery ?></td>
                <td class="catalog"> </td>
                <td class="catalog">

                </td>
                <td class="catalog">
                     <? $total += ($this->item->delivery_cost)?>

                    <?php echo (($this->item->delivery_cost=='') ? 'рассчитывается индивидуально' : money::ru($this->item->delivery_cost)) ?>
                </td>
                <td class="catalog">

                </td>
            </tr>


        <? } ?>



		 <tr id="editCountButton" style="display:none;">

            <td></td>
			<?  if (isset($this->productView) && $this->productView != PRODUCTS_VIEW_LIST) { ?>  <td></td> <? } ?>
            <td></td>
<td class="view bottomHandler" colspan="4"  >
            
				<input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all"   value="Изменить кол-во">
                <a href="#" title="Менять количество позиций в заказе не требуеться" class="cancelBtn" onclick="cancelChangeItemsCount(); return false;">Отмена</a>
			</td>


        </tr>


    </table>

    </form>

		<div style="float:right; padding-right: 20px; padding-top: 10px ;">

            <div id="addOnMenuItems" style="margin-right:  0px; padding-bottom: 10px;">

                <a  title="Изменить количество товара в заказе" onclick="changeItemsCount();" class="editBtnText " >Изменить кол-во</a>
                <a  title="Добавить товар в заказ" onclick="addItemInOrder();" class="addImageBtnText  " >Добавить товар</a>

            </div>

            Итого: <?=money::ru($total)?>
            <br/><i><?=ucwords(money::writePrice($total))?></i> <br/>



		</div>


   		<p></p>

    </div>










<div id="addItemFormPlease" style="display:none;">

	<form action="/orders/info/id/<?=$this->item->id?>" method="post">

	<table class="form">

            <tr>
                <td></td>
                <td align=" "  class="elements view bottomHandler"><h4>Добавление товара в заказ</h4></td>
            </tr>

        <tr>
            <td class="label">Товар:</td>
            <td class="elements">

                <input class="text" name="" value="" id="searching" />
                <input class="text" name="addItem[id]" value="" id="searchingId" type="hidden" />
                <input class="text" name="W" value="" id="itemPrice" type="hidden" />

                <div class="smallInfo">
                    Введите для поиска часть названия товара или артикул.
                </div> 

            </td>
        </tr>


        <tr>
            <td class="label">Кол-во:</td>
            <td class="elements">
                <input name="addItem[count]" id="addItemCount" class="text" type="text" value="1" onchange="updateAddItemInfo();" />
            </td>
        </tr>


        <tr>
            <td class="label">Цена:</td>
            <td class="elements view" id="addItemPrice">

                    -

            </td>
        </tr>

        <tr>
            <td class="label">Стоимость:</td>
            <td class="elements view"  id="addItemPriceTotal">

				-

            </td>
        </tr>

        <tr>
            <td class="label"> </td>
            <td class="view bottomHandler"  >

				<input type="submit" value="Добавить в заказ"  onclick="return checkAddFrom(); return false;">
				<a href="#" title="Отменить редактивароние" class="cancelBtn" onclick=" cancelAddItemInOrder(); return false;">Отмена</a>

            </td>
        </tr>

    </table>

	</form>

    <br/>
    
</div>










<?php } ?>


<div id="orderDelivery">



    <table class="form">

        <tr>
            <td class="label">Номер:</td>
            <td class="elements view">
                #<?php echo ($this->item->id) ?>
                <? if(!$this->item->field_type_devivery){ ?>
                    <i>(быстрое оформление заказа)</i>
                <? } ?>
            </td>
        </tr>


        <tr>
            <td class="label">Поступил:</td>
            <td class="elements view">
                <?php echo time::date($this->item->date, DATE_FORMAT) ?>
            </td>
        </tr>


        <tr>
            <td class="label">Способ доставки:</td>
            <td class="elements view">

                    <? if($this->item->field_type_devivery && count($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery])) { ?>
                        <b><?php $paymentInfo = NULL; echo $this->item->delivery ?></b>
                    <? }else{ ?>
                        <i>На соглосовании</i>

                        <? $paymentInfo = json_decode($this->item->paymentInfo) ?>
                    <? } ?>

            </td>
        </tr>

        <tr>
            <td class="label">Способ оплаты:</td>
            <td class="elements view">

                    <? if($this->item->field_type_pay  ) { ?>
                        <b><?php echo $this->item->payment ?></b>
                    <? }else{ ?>
                        <i>На соглосовании</i>
                    <? } ?>

            </td>
        </tr>

        <? if(!empty($paymentInfo)) { ?>
 
            <tr>
                <td class="label">Имя:</td>
                <td class="elements view">

                        <?=empty($paymentInfo->name) ? '<i>Не указано</i>' : '<b>'.html::specialchars($paymentInfo->name).' </b>'?>

                </td>
            </tr>

            <tr>
                <td class="label">Номер телефона:</td>
                <td class="elements view">
                    <b>
                        <a class="tel" href="tel:<?=html::specialchars($paymentInfo->phone)?>"><?=html::specialchars(format::phone($paymentInfo->phone))?></a>
                    </b>
                </td>
            </tr>

        <? } ?>

        <tr>
            <td class="label">Текушее состояние:</td>
            <td class="elements view"  >
                <?php echo $GLOBALS['ORDER_STATUS'][($this->item->status)] ?>
            </td>
        </tr>

 
 


        <? if(!$this->item->field_type_pay  ) { ?>


            <form action="/orders/info/id/<?=$this->item->id?>" method="post">

            <input type="hidden" name="settings[name]" value="<?=isset($paymentInfo->name) ? $paymentInfo->name : ''?>"/>
            <input type="hidden" name="settings[phone]" value="<?=isset($paymentInfo->phone) ? $paymentInfo->phone : ''?>"/> 

            <tr>
                 <td></td>
                 <td align=" "  class="elements view bottomHandler"><h4>Выбрать способы доставки и оплаты</h4></td>
             </tr>


            <tr >
                <td class="label">Доставка:</td>
                <td class="elements"  >
                    <select name="settings[deliv]" class="selectEr" onchange="getPayWayByDelivery(this.value); $('#settingsPayWay').show('fast');">
                        <option>Не указана</option>
                        <? foreach ($this->deliveryType as $deliveryS) {

                            ?><option value="<?=$deliveryS->del_id?>"><?=$deliveryS->title?> - <?php echo (($deliveryS->cost == '') ? 'рассчитывается индивидуально' : money::ru($deliveryS->cost)) ?></option><?

                        } ?>
                    </select>
                </td>
            </tr>

            <tr id="settingsPayWay" style="display:none;">
                <td class="label">Оплата:</td>
                <td class="elements"  >


                    <img id="settingsPayWayImg" src="/CSS/images/ui-anim_basic_16x16.gif" alt="Загрузка...">

                    <select id="settingsPayWaySelect" name="settings[payway]" class="selectEr"  onchange="$('#settingsButton').show('fast');">
 
                    </select>
                </td>
            </tr>

            <tr id="settingsButton" style="display:none;">
                <td class="label"> </td>
                <td class="view bottomHandler"  >
                    <input type="submit" title="Сохранить тип доставки и оплаты" value="Сохранить">
                </td>
            </tr>

            </form>
        
        <? } ?>


        <tr>
            <td class="label"> </td>
            <td class="view bottomHandler"  >
                <a onclick="$('#orderComment').toggle('fade');" class="commentTextBtn" >Написать комментарий о заказе</a>
            </td>
        </tr>
 
        <tr id="orderComment" style="display:none;">
            <td class="label">Содержание комментария:</td>
            <td class="view bottomHandler"  >

                <form action="/orders/info/id/<?=$this->item->id?>" method="post">

                    <textarea id="pages_content" name="order[content]" style="height: 100px;"><?php
                        echo @html::specialchars($_POST['order']['content'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div><br/>

                    <input type="submit" value="Отправить">
 
                </form>
            </td>
        </tr>

    </table>

    <? if($this->comments->count()){ ?>

        <table class="form">

            <tr>
                <td class="label bottomHandler">Комментарии:</td>
                <td class=" bottomHandler">

                    <table id="bin" cellspacing="0" cellpadding="5" style="margin-left:0 !important;">

                        <tr>
                            <th width="140">Дата отправки</th>
                            <th>Комментарий</th>
                            <th width="120">Менеджер</th>
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
                    <a onclick="$('#orderComment').toggle('fade');window.location.hash = '#orderComment';" class="commentTextBtn" >Написать комментарий о заказе</a>
                </td>
            </tr>

        </table>

    <?php } ?>



</div>



<? if($this->item->field_type_devivery && count($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery])) { ?>

<div id="orderDelivery">



            <?

                    $q = '';
try{

    if(isset($this->deliveryInfo->street) ){


                    switch($this->item->field_type_devivery){
                        case DELIVERY_TYPE_CURIER:
                            $q = 'г. '.$this->firm->city. ', ул. ' . $this->deliveryInfo->street . ', д.' . $this->deliveryInfo->house .
                                 (!empty($this->deliveryInfo->houseAddOn) ? ', cтр./кор.' . $this->deliveryInfo->houseAddOn : '') .
                                 (!empty($this->deliveryInfo->podiezd) ? ', подъезд.' . $this->deliveryInfo->podiezd : '') .
                                 (!empty($this->deliveryInfo->floor) ? ', эт.' . $this->deliveryInfo->floor : '') .
                                 (!empty($this->deliveryInfo->apr) ? ', кв.' . $this->deliveryInfo->apr : '')
                                   ;
                            break;
                        case DELIVERY_TYPE_CURIER_TO_MCAD:
                            $q = 'г. '.$this->deliveryInfo->metro. ', ул. ' . $this->deliveryInfo->street . ', д.' . $this->deliveryInfo->house .
                                 (!empty($this->deliveryInfo->houseAddOn) ? ', cтр./кор.' . $this->deliveryInfo->houseAddOn : '') .
                                 (!empty($this->deliveryInfo->podiezd) ? ', подъезд.' . $this->deliveryInfo->podiezd : '') .
                                 (!empty($this->deliveryInfo->floor) ? ', эт.' . $this->deliveryInfo->floor : '') .
                                 (!empty($this->deliveryInfo->apr) ? ', кв.' . $this->deliveryInfo->apr : '')
                                   ;
                            break;
                        case DELIVERY_TYPE_CURIER_TO_METRO:
                            $q = $this->firm->city. ', метро ' . $this->deliveryInfo->metro;
                            break;
                        case DELIVERY_TYPE_EMS:
                            $q = $this->deliveryInfo->region . ', '.$this->deliveryInfo->city . ', ул. '.
                                 $this->deliveryInfo->street . ', д.' . $this->deliveryInfo->house .
                                    (!empty($this->deliveryInfo->houseAddOn) ? ', cтр./кор.' . $this->deliveryInfo->houseAddOn : '') .
                                 (!empty($this->deliveryInfo->podiezd) ? ', подъезд.' . $this->deliveryInfo->podiezd : '') .
                                 (!empty($this->deliveryInfo->floor) ? ', эт.' . $this->deliveryInfo->floor : '') .
                                 (!empty($this->deliveryInfo->apr) ? ', кв.' . $this->deliveryInfo->apr : '')  ;
                            break;
                    }


        }
}catch(Exception $e){

}
                    ?>
        
    <? if($deliveryTime){?>

        <form action="/orders/info/id/<?=$this->item->id?>" method="post">

        <table class="form">
 
            <tr>
                <td></td>
                <td align=" "  class="elements view bottomHandler"><h4>Информация о доставке</h4></td>
            </tr>

            <? if($deliveryTime && ($this->item->status == ORDER_STATUS_NEW || $this->item->status == ORDER_STATUS_VIEWED || $this->item->status == ORDER_STATUS_PROCEEDED)) { ?>

                <tr class="viewDelivery">
                    <td class="label"> </td>
                    <td class=" elements view"  >

                        <a title="Задать время и дату доставки" onclick="window.location.href = '/orders/info/id/<?=$this->item->id?>?setDeliveryDate='+($('#datepicker').val())+'&setDeliveryTimeFrom='+($( '#slider-range' ).slider( 'values', 0 ))+'&setDeliveryTimeTo='+($( '#slider-range' ).slider( 'values', 1 ));return false;" class="commentTextBtn" >Установить</a>
                        <a title="Установить время доставки и отметить заказ как <b>Отправлен</b>.<br/>Будет отправлено письмо клиенту об отправке" class="orderDeliveredBtnText" onclick="window.location.href = '<?php echo url::site(); ?>orders/info/typeaction/<?=ORDER_STATUS_DELIVERED?>/id/<?=$this->item->id?>?setDeliveryDate='+($('#datepicker').val())+'&setDeliveryTimeFrom='+($( '#slider-range' ).slider( 'values', 0 ))+'&setDeliveryTimeTo='+($( '#slider-range' ).slider( 'values', 1 ));return false;">Отправить</a>

                    </td>
                </tr>

            <? } ?>





            <? $toDelivery = ($this->item->status == ORDER_STATUS_NEW || $this->item->status == ORDER_STATUS_VIEWED || $this->item->status == ORDER_STATUS_PROCEEDED); ?>


            <tr class="viewDelivery">
                <td class="label">
                    Время доставки
                    :</td>

                <? if($toDelivery){?>
                    <td class="elements view">
                        <div style="z-index: -1;"><span id="amounter" style="font-weight:bold;"></span> часов. <div title="Перетащите ползунки для указания интервала времени доставки" id="slider-range" style="width: 60%; margin: 10px 0;margin-left:5px;"></div></div>
                    </td>
                <? }else{ ?>
                    <td class="elements view">
                        <span style="font-weight:bold;">c <?=(!empty($this->deliveryInfo->deliveryTimeFrom) ? $this->deliveryInfo->deliveryTimeFrom : '10')?> по <?=(!empty($this->deliveryInfo->deliveryTimeTo) ? $this->deliveryInfo->deliveryTimeTo : '15')?></span> часов.</div>
                    </td>
                <? }?>

            </tr>

            <tr  class="viewDelivery">
                <td class="label">
                    Дата доставки
                    :</td>
                <td class="elements <?=($toDelivery)? '' : 'view'?> topHandler">
                    <? if($toDelivery) { ?>
                        <input type="text" id="datepicker" value="<?=(!empty($this->deliveryInfo->deliveryDate) ? $this->deliveryInfo->deliveryDate : date('Y-m-d', strtotime('+24 hour')))?>">
                    <? }else{ ?>
                        <?=(!empty($this->deliveryInfo->deliveryDate) ? $this->deliveryInfo->deliveryDate : '-')?>
                    <? }?>
                </td>
            </tr>

            <tr class="viewDelivery" >
                <td class="label">
                   </td>
                <td class="elements  ">
                    <br/>
                </td>
            </tr>

        </table>

        </form>
            
    <? } ?>

    <form action="/orders/info/id/<?=$this->item->id?>" method="post">

    <table class="form" id="tblNewAttendees">



        <? if($this->item->status == ORDER_STATUS_NEW || $this->item->status == ORDER_STATUS_VIEWED || $this->item->status == ORDER_STATUS_PROCEEDED) { ?>

            <tr class="viewDelivery">
                <td class="label"> </td>
                <td class="view bottomHandler"  >

                    <a title="Изменить адрес доставки" onclick="editDeliveryFn();" class="commentTextBtn" >Отредактировать адрес</a>
                 
                </td>
            </tr>

        <? } ?>
    
        <tr class="editDelivery" style="display:none;">
            <td class="label">
                  </td>
            <td class="elements">

                <input type="submit" value="Редактировать"> <a href="#" title="Отменить редактивароние" class="cancelBtn" onclick="cancelDeliveryFn(); return false;">Отмена</a>

            </td>
        </tr>



		<? if(isset($q) && !empty($q)){?>
			<tr class="viewDelivery">
				<td class="label">
					Адрес одной строкой
					:</td>
				<td class="elements view">
					<?=$q?>

				</td>
			</tr>
		<? }?>
        
		<? if($this->item->field_type_devivery == DELIVERY_TYPE_EMS){?>
			<tr class="viewDelivery">
				<td class="label">
					ФИО
					:</td>
				<td class="elements view topHandler" >
					<?=@$this->deliveryInfo->soname?> <?=@$this->deliveryInfo->name?> <?=@$this->deliveryInfo->thirdName?>

				</td>
			</tr>
		<? }?>

        <? foreach ($GLOBALS['DELIVERY_FIELDS'][$this->item->field_type_devivery] as $field => $fieldDesc) { ?>

            <tr class="viewDelivery">
                <td class="label">
                        <?=$fieldDesc->name?>
                    :</td>
                <td class="elements view"> 
                    <? if($field == 'index') { ?>
                        <?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? '<a href="http://www.rospt.ru/pochta_'.$this->deliveryInfo->{$field} . '.html" target="_blank">'.$this->deliveryInfo->{$field} . '</a>' : "-"); ?>
                    <? } elseif($field == 'phone') { ?>
                        <a class="tel" href="tel:<?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? $this->deliveryInfo->{$field} : "-")?>"><?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? format::phone($this->deliveryInfo->{$field}) : "-")?></a>
                    <? } else { ?>
                        <?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? $this->deliveryInfo->{$field} : "-"); ?>
                    <? }?>

                </td>
            </tr>
     
            <tr class="editDelivery" style="display:none;">
                <td class="label">
                        <?=$fieldDesc->name?>
                    :</td>
                <td class="elements">

                    <? if($field == 'comment') { ?>
                         <textarea rows="3" cols="4" name="deliv[<?=$field?>]"><?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? $this->deliveryInfo->{$field} : ""); ?></textarea>
                    <? } else { ?>
                        <input name="deliv[<?=$field?>]" class="text" type="input" value="<?=((isset($this->deliveryInfo->{$field}) && !empty($this->deliveryInfo->{$field}))  ? $this->deliveryInfo->{$field} : ""); ?>">
                    <? }?>

                </td>
            </tr>

        <? } ?>

        <tr class="editDelivery" style="display:none;">
            <td class="label">
                  </td>
            <td class="elements">

                <input type="submit" value="Редактировать"> <a href="#" class="cancelBtn" title="Отменить редактивароние" onclick="cancelDeliveryFn(); return false;">Отмена</a>

            </td>
        </tr>

    <script type="text/javascript">

        <? if($deliveryTime){?>
            $(function() {
                $( "#datepicker" ).datepicker({  showButtonPanel: true, dateFormat: 'yy-mm-dd', minDate: <?=(date('H')>22?+1:0)?>, maxDate: "+1M +10D" });

                $( "#slider-range" ).slider({
                    range: true,
                    min: 10,
                    max: 22,
                    values: [ <?=(!empty($this->deliveryInfo->deliveryTimeFrom) ? $this->deliveryInfo->deliveryTimeFrom : '10')?>, <?=(!empty($this->deliveryInfo->deliveryTimeTo) ? $this->deliveryInfo->deliveryTimeTo : '15')?> ],
                    stop: function( event, ui ) {
                        $( "#slider-range" ).slider("values", [ ui.values[ 0 ], ui.values[ 1 ] ] );
                    },
                    slide: function( event, ui ) {

                        $( "#amounter" ).html( "с " + ui.values[ 0 ] + " ч. по " + ui.values[ 1 ] + 'ч.' );
                    }
                });
                $( "#amounter" ).html( "с " + $( "#slider-range" ).slider( "values", 0 )
                        + " до " + $( "#slider-range" ).slider( "values", 1 ) + '' );
            });
            <? } ?>
        function editDeliveryFn(){
            $('#tblNewAttendees tr.editDelivery').each(function() {
                $(this).show('fade');
            });

            $('#tblNewAttendees tr.viewDelivery').each(function() {
                $(this).hide();
            });
        }
        function cancelDeliveryFn(){
            $('#tblNewAttendees tr.editDelivery').each(function() {
                $(this).hide();
            });

            $('#tblNewAttendees tr.viewDelivery').each(function() {
                $(this).show('fade');
            });
        }

      
        <? if(!isset($this->deliveryInfo->street) && $this->item->field_type_devivery != DELIVERY_TYPE_HIMSELF){ ?>
            editDeliveryFn();
        <? } ?>
    </script>

    <? if(isset($q) && !empty($q)){?>

        <tr>
            <td class="label">Адрес на картах:</td>
            <td class="elements view">


 
                <style>
                    form input.text {width:300px;}
                    #map {width: 600px; height: 800px;}
                    #Ymap {width: 100%; height: 90%;}
                    #Gmap {width: 100%; height: 90%;}

                    .seletedMap{
                        font-weight:bold;
                    }
                    .map{
                        font-weight:normal;
                    }

                    #mapTabs a{
                        border-bottom: 1px dotted black;
                        cursor: pointer;
                    }
                </style>

                <script src="https://maps.google.ru/maps?file=api&amp;v=2&amp;key=<?=GOOGLE_MAP_KEY?>&hl=ru" type="text/javascript"></script>
                <script type="text/javascript" src="https://www.google.com/jsapi?key=<?=GOOGLE_MAP_KEY?>"></script>
                <script type="text/javascript" src="http://api-maps.yandex.ru/1.1/index.xml?key=<?=YANDEX_MAP_KEY?>"></script>
                <script type="text/javascript">

                var POEMaps = {

                    longitude : 0,
                    latitude : 0,
                    zoom : 15, //сюда подставить адрес из переменной
                    address : '<?=($q)?>',//сюда подставить адрес из переменной
 
                    updateCoord : function (){

                        if (parseInt(this.latitude) == 0 || parseInt(this.longitude) == 0){

                            var geocoder = new YMaps.Geocoder(this.address, {results: 1, boundedBy: POEMaps.mapYandex.getBounds()});
                            YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
                                if (this.length()) {

                                    var result = (this.get(0));
                                    POEMaps.longitude = (result.getGeoPoint().getX());
                                    POEMaps.latitude = (result.getGeoPoint().getY());

                                } else {
                                    POEMaps.latitude = (0);
                                    POEMaps.longitude = (0);
                                }
 
                                POEMaps.updatePosition();
                            });
                            YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, errorMessage) {
                                alert("Произошла ошибка: " + errorMessage)
                            });
                        }
                    },

                    mapYandex : null,
                    mapGoogle : null,

                    placemarkYandex : null,
                    markerGoogle : null,

                    init : function() {

                        this.mapYandex = new YMaps.Map(YMaps.jQuery("#Ymap")[0]);
                        this.mapYandex.addControl(new YMaps.Zoom());

                        this.mapYandex.setCenter(new YMaps.GeoPoint(37.64, 55.76), 10);
                        var s = new YMaps.Style();
                        s.iconStyle = new YMaps.IconStyle();
                        // s.iconStyle.href = " ";
                        s.iconStyle.size = new YMaps.Point(40, 48);

                        this.placemarkYandex = new YMaps.Placemark(new YMaps.GeoPoint(this.longitude, this.latitude), {draggable: true, style:s});
                        this.mapYandex.addOverlay(this.placemarkYandex);
                        YMaps.Events.observe(this.placemarkYandex, this.placemarkYandex.Events.Click, function (obj) {
                            return false;
                        });
                        YMaps.Events.observe(this.placemarkYandex, this.placemarkYandex.Events.DragEnd, function (obj) {
                            POEMaps.longitude = obj.getGeoPoint().getX();
                            POEMaps.latitude = obj.getGeoPoint().getY();
                            POEMaps.updateCoord();
                            POEMaps.coordUpdate();
                        });


                        if (GBrowserIsCompatible()){

                            this.mapGoogle = new google.maps.Map2(document.getElementById("Gmap"));
                            this.mapGoogle.addControl(new GSmallMapControl());
                            this.markerGoogle = new GMarker(new GLatLng(this.longitude, this.latitude),{draggable: true});
                            GEvent.addListener(this.markerGoogle,'dragend',function(){
                                var p = POEMaps.markerGoogle.getLatLng();
                                POEMaps.longitude = p.lng();
                                POEMaps.latitude = p.lat();
                                POEMaps.updateCoord();
                                POEMaps.coordUpdate();
                            });
                            this.mapGoogle.addOverlay(this.markerGoogle);
                        }
                    },

                    updatePosition : function(){

                        if(POEMaps.mapYandex){

                            var newPoint = new YMaps.GeoPoint(POEMaps.longitude, POEMaps.latitude);

                            POEMaps.mapYandex.setCenter(newPoint, this.zoom);
                            POEMaps.placemarkYandex.setGeoPoint(newPoint);
                        }

                        if(POEMaps.mapGoogle){

                            var newPoint = new google.maps.LatLng(POEMaps.longitude, POEMaps.latitude);
                            var newPointBug = new google.maps.LatLng(POEMaps.latitude, POEMaps.longitude);

                            POEMaps.mapGoogle.setCenter(newPointBug, this.zoom);
                            POEMaps.markerGoogle.setLatLng(newPointBug);
                        }
                    },
                    findByAddress : function(){

                        POEMaps.latitude = 0;
                        POEMaps.longitude = 0;

                        var addressForSearch = null;
                        if(parseInt($('#regionInfo').val())){
                            addressForSearch = ($('#regionInfo_front').val());
                        }else{
                            addressForSearch = ($('#sectionregionInfo div[class=value]').html());
                        }

                        POEMaps.address = addressForSearch + ', ' + $('#address').val();

                        POEMaps.updateCoord();
                        POEMaps.coordUpdate();
                        POEMaps.updatePosition();
                    }
                };

                $(document).ready(function(){

                    selectRT(1);
                    
                    var Ymap = $('#Ymap');
                    var Gmap = $('#Gmap');
                    var selectYmap = $('#selectYmap');
                    var selectGmap = $('#selectGmap'); 
 

                    if (!POEMaps.zoom) POEMaps.zoom=15;
                    POEMaps.init();

                    POEMaps.updateCoord();  
                    POEMaps.updatePosition();

                    $('#Gmap').hide();

                    selectYmap.click(function(){
                        $(this).addClass('active');
                        selectGmap.removeClass('active');
                        $('#Gmap').hide();
                        $('#Ymap').show('fade');
                        POEMaps.updateCoord();  
                        POEMaps.updatePosition();
                    });
                    selectGmap.click(function(){
                        $(this).addClass('active');
                        selectYmap.removeClass('active');
                        $('#Ymap').hide();
                        $('#Gmap').show('fade');
                        POEMaps.updateCoord();
                        POEMaps.updatePosition();
                    });
 
                });

                    function selectRT(map){

                        var selectYmap = $('#selectYmap');
                        var selectGmap = $('#selectGmap');

                        if(map == 0){
                            selectGmap.attr('class', 'seletedMap');
                            selectYmap.attr('class', 'map');
                        }else{
                            selectGmap.attr('class', 'map');
                            selectYmap.attr('class', 'seletedMap');
                        }
                    }

                    
                 </script>
  
                <div id="map">
                    <ul id="mapTabs">
                        <li id="selectYmap" class="active"><a target="_blank" onclick="selectRT(1); return false; ">На картах Яндекс</a></li>
                        <li id="selectGmap"><a target="_blank" onclick="selectRT(0); return false;">На картах Google</a></li>
                    </ul>
                    <div id="Ymap"></div>
                    <div id="Gmap"></div>
                </div>
            </td>
        </tr>

    <? } ?>
    
        <tr id="regByNumber">
            <td class="label">Регион по номеру телефона:</td>
            <td class="elements view">
                <a target="_blank" href="http://www.kody.su/check-tel">Узнать</a>
                <div class="smallInfo">
                    Скопируйте в буфер обмена номер телефона клиента, затем вставте в форму поиска на открывшейся странице
                </div>
            </td>
        </tr>

        <? if(isset($q) && !empty($q)){?>
            <tr id="localTime">
                <td class="label">Местное время:</td>
                <td class="elements view">
                    <a target="_blank" href="http://time.yandex.ru/?city1=2&city2=213">Посмотреть</a>
                    <div class="smallInfo">
                        На открывшейся странице необходимо будет указать населённый пункт указанный в заказе (или возможно ближайщий крупный город)
                    </div>
                </td>
            </tr>
        <? } ?>
    
    </table>

    </form>
    
</div>

<? } ?>


<div id="orderPayway">

    <? if($this->item->field_type_pay && count($GLOBALS['PAY_WAY_TYPE'][$this->item->field_type_pay])) { ?>

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

<script type="text/javascript">

	function changeItemsCount(){
		$('span.countEdit').each(function() {
			$(this).show('fade');
		});
		$('span.countView').each(function() {
			$(this).hide();
		});
		$('#addOnMenuItems').hide();
		$('#deliveryTR').hide();
		$('#editCountButton').show('fade');
	}

	function cancelChangeItemsCount(){
		$('span.countEdit').each(function() {
			$(this).hide();
		});
		$('span.countView').each(function() {
			$(this).show('fade');
		});
		$('#addOnMenuItems').show('fade');
		$('#deliveryTR').show('fade');
		$('#editCountButton').hide();
	}


	function addItemInOrder(){
		$('#addItemFormPlease').show('fade');
		$('#addOnMenuItems').hide();
	}

	function cancelAddItemInOrder(){
		$('#addItemFormPlease').hide();
		$('#addOnMenuItems').show('fade');
	}

    function updateAddItemInfo(){
        var addItemCount = $('#addItemCount').val();
        var itemPrice = $('#itemPrice').val();
        $('#addItemPrice').html(itemPrice + ' р.');
        $('#addItemPriceTotal').html((itemPrice * addItemCount ) + ' р.');
    }

    function checkAddFrom(){
        if($('#searchingId').val() == '' || parseInt($('#addItemCount').val()) < 1){
            SPAdmin.showAlertMessage('Ошибка!','Укажите товар для добавления и его количество.');
            return false;
        }
        return true;
    }

    <? if(!$this->item->field_type_pay  ) { ?>

        function getPayWayByDelivery(delivery){

             $('#settingsPayWayImg').show('fast');
             $('#settingsPayWaySelect').hide();

            $.ajax( {

                    url: '/orders/ajax/delivery/' + delivery ,
                    dataType:  "json"
            }
                    )
                .done(function(data) {


                    $('#settingsPayWaySelect')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="0">Не указана</option>')
                        .val('0')
                    ;

                    $.each(data, function(key, value) {
                         $('#settingsPayWaySelect')
                             .append($("<option></option>")
                             .attr("value", value.pay_id)
                             .text(value.title));
                    });

                 $('#settingsPayWayImg').hide();
                 $('#settingsPayWaySelect').show();

            })
                .fail(function() { SPAdmin.showAlertMessage("Произошла ошибка!", "Обратитесь к технической поддержке"); } 
            );

        }

    <? } ?>

    $( "#searching" ).autocomplete({
        source: "/products/ajax/id/0",
        minLength: 3,
        select: function( event, ui ) {
            if(ui.item){
                $('#searchingId').val(ui.item.id);
                $('#searching').val(ui.item.value);
                $('#itemPrice').val(ui.item.price);
                updateAddItemInfo();
            }
        }
    });

</script>
 