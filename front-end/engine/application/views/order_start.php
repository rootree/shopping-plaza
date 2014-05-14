<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<? if(array_key_exists('orderID', $_REQUEST) && intval($_REQUEST['orderID'])){ ?>

    <div class="errordesc infodesc" >
        <h4>Спасибо за заказ!</h4><br/>
        <p class="last-child">Ваш заказ <b>№<?=$_REQUEST['orderID'] ?></b>.​ Для дальнейшего работы с ним, наш менеджер свяжется с вами.</p>

        <? if(count($delivery)) { ?>
            <br/>
            <p class="last-child">Но уже сейчас вы можете указать информацию о доставке и  удобным для вас способе оплаты.</p>
        <? } ?>
        
    </div>

<? }?>


<? if(count($delivery)) { ?>

<div class="adress">


    <h2 id="input_error">Оформление заявки</h2>

    <? if(count($input_error)) : ?>

    <div class="errordesc"  id="errorInfo">
        <h4>Произошла ошибка при проверке указанных вами данных. Обратите внимание на следуюшие поля: </h4>

            <?php foreach ($input_error as $error_val) {  ?>
                <p class="last-child errorField"><?=$error_val?></p>
            <?php } ?>
 
    </div>

    <? endif ?>

    <form action="/order" method ="POST"   name="form">
 
         <br/>
        <a href="http://market.yandex.ru/addresses.xml?callback=<?=urlencode('http://'. $this->firm->domain . '/order')?>&type=json"><img src="http://cards2.yandex.net/hlp-get/5814/png/3.png" alt="Получить адрес из Яндекса"></a>
 
        <br/>
        <br/>
        <p><b>Выберите удобный для вас способ доставки:</b></p>
        <br/>

        <div class="form2-radio">

            <?php
            
            $typeOfDelivery = array();
            $selectedDeliveryID = 0;
            
            foreach ($delivery as $cat_val) { $typeOfDelivery[$cat_val->type] = true; ?>

                <p><input onclick="$('#errorInfo').hide();SPHandler.showAddonForm(<?=$cat_val->type?>);SPHandler.showDeliveryDesc('deliveryDesc<?=$cat_val->del_id?>');window.location.hash = 'formEr';"
                          id="del_<?php echo $cat_val->del_id ?>" type="radio" id="mail" type="text" name="request[type]"
                          value="<?=$cat_val->del_id?>" <? if(isset($_POST['request']['type']) && $_POST['request']['type'] == $cat_val->del_id) { $selectedDeliveryID = $cat_val->del_id; $cat_val_type = $cat_val->type; echo 'checked="checked"'; } ?>/>
                    <label for="del_<?php echo $cat_val->del_id ?>"><?php echo html::specialchars($cat_val->title) ?> (стоимость: <?php echo (($cat_val->cost=='') ? 'рассчитывается индивидуально' : money::ru($cat_val->cost)) ?>)</label>
 
                </p> 

                <?php } ?>

        </div>

        <?php
             
            foreach ($delivery as $cat_val) {  ?>

                <div class="deliveryDesc" id="deliveryDesc<?=$cat_val->del_id?>" style="display: none;">
                    <?php echo $cat_val->conditions ?>
                </div>
 
        <?php } ?>
 
        <input type="hidden" name="request[type_base]" value="0" id="type_base" />

        <span id="formEr">

        <?php foreach ($typeOfDelivery as $type => $cat_val) {  ?>

        <div id="delivery_type_<?=$type?>" style="display:none;">
 
         <!--   <div  >
                <div class="svyazList">
                    <p>&nbsp;</p>
                </div> 
                <div class="svyazForm">
                    <input  id="deliverySubmit"  type="submit"  value="" />
                </div>
            </div>-->

            
            <? switch ($type) {

            case DELIVERY_TYPE_CURIER: ?>

				<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'delivery/curier', TRUE), array()); ?>

				<? break; ?>

			<? case DELIVERY_TYPE_CURIER_TO_MCAD: ?>

				<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'delivery/curier_to_mcad', TRUE), array()); ?>

				<? break; ?>

            <? case DELIVERY_TYPE_HIMSELF: ?>

            <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'delivery/himself', TRUE), array()); ?>

            <? break; ?>
            <? case DELIVERY_TYPE_CURIER_TO_METRO: ?>

            <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'delivery/curier_to_metro', TRUE), array()); ?>


            <? break; ?>
            <? case DELIVERY_TYPE_EMS: ?>

            <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'delivery/ems', TRUE), array()); ?>

            <?  break; } ?>

            <div class="svyaz" id="svyaz" style="background-color: #FFFFFF; border: 0px;  height: 62px; ">
                <div class="svyazList">
                    <p>&nbsp;</p>
                </div> 
                <div class="svyazForm">
                    <input  id="deliverySubmit"  type="submit"  value="" />
                </div>
            </div>

        </div>

        <?php } ?>

        </span>

    </form>


</div>



<? if(!empty($cat_val_type)) {?>
<script language="JavaScript">

$(document).ready(function() {
    SPHandler.showAddonForm(<?=$cat_val_type?>);
    SPHandler.showDeliveryDesc('deliveryDesc<?=$selectedDeliveryID?>');


});
     
</script>
<? } ?>

           <? } ?>