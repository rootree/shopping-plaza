<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
 
<div class="adress">

     <a href="/order">Изменить способ доставки</a>

    <h2 id="input_error">Способ оплаты</h2>

    <div class="errordesc infodesc" >
        <h4>Шаг 2-ой из 3-х</h4> 
        <p class="last-child">Укажите способ оплаты (шаг 2), затем проверте указанные данные и отправте заказ нам (шаг 3)</p>
    </div>

    <? if(count($input_error)) : ?>

        <div class="errordesc" id="errorInfo" >
            <h4>Произошла ошибка при проверке указанных вами данных.</h4>

                <?php foreach ($input_error as $error_val) {  ?>
                    <p class="last-child"><?=$error_val?></p>
                <?php } ?>
 
        </div>

    <? endif ?>
 
    <form action="/order/payway" method="POST" name="form">

        <br/>

        <p><b>Выберите тип клиента:</b></p>
        

        <div class="form2-radio">

            <?php
            $typeOfClient = array();
            $typeOfDelivery = array();
            $selectedDeliveryID = 0;
            foreach ($pay_way as $cat_val) {

                if(array_key_exists($cat_val->client_type, $typeOfClient)){
                    continue;
                }
                
                $typeOfClient[$cat_val->client_type] = true;

                ?>

                <p><label for="del_<?php echo $cat_val->client_type ?>">
                    <input onclick="$('#errorInfo').hide(); SPHandler.showAddonFormClient(<?=$cat_val->client_type?>);this.selected = true; "
                           id="del_<?php echo $cat_val->client_type ?>" type="radio" 
                           type="text" name="request[type_of_client]"
                           value="<?=$cat_val->client_type?>"
                        <? /* if(isset($_POST['request']['type_of_client']) && $_POST['request']['type_of_client'] == $cat_val->client_type) { $cat_val_type = $cat_val->client_type; echo 'checked="checked"'; }*/ ?>
                            /><?php echo $GLOBALS['CLIENT_TYPE'][$cat_val->client_type] ?></label>
                </p>
                 

                <?php } ?>
 
            </div>
        <br/>
 
        <?php

        foreach ($typeOfClient as $clientType => $we) { ?>

            <div class="form2-radio" id="client_type_<?=$clientType?>" style="display:none;">

                <p><b>Способ оплаты:</b></p>
                 
                    <?

                    foreach ($pay_way as $cat_val) { $typeOfDelivery[$cat_val->field_type] = true;

                        if($cat_val->client_type !=  $clientType) {
                            continue;
                        }
                        ?>
 
                        <p><label for="pay<?=$cat_val->pay_id?>">
                            <input onclick="$('#errorInfo').hide();SPHandler.showAddonFormNext('<?=$cat_val->field_type?>');SPHandler.showPayWayDesc('pay<?=$cat_val->pay_id?>'); "
                                   id="paywayDesc<?=$cat_val->pay_id?>" type="radio"  type="text" name="request[pay_way]"
                                   value="<?php echo $cat_val->pay_id ?>"
                                <? /* if(isset($_POST['request']['field_type']) && $_POST['request']['field_type'] == $cat_val->field_type) {
                                    $selectedDeliveryID = $cat_val->pay_id;
                                    $field_type = $cat_val->field_type; echo 'checked="checked"';
                                } */?> /><?php echo $cat_val->title ?></label></p>
                         


                    <?php } ?>

                </div>

        <?} ?>

        <?php

            foreach ($pay_way as $cat_val) {  ?>

                <p class="deliveryDesc" id="paywayDesc<?=$cat_val->pay_id?>" style="display: none;">
                    <?php echo $cat_val->conditions ?>
                </p>

        <?php } ?>


        <input type="hidden" name="request[field_type]" id="field_type" value="0" />

        <?php foreach ($typeOfDelivery as $type => $cat_val) {  ?>

            <div id="pay_type_<?=$type?>" style="display:none;">


                <? switch ($type) {

                case FIELD_TYPE_BANK: ?>

                    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'pay_way/bank', TRUE), array()); ?>

                <? break; ?>
                <? case FIELD_TYPE_BANK_FIZ_LICO: ?>
                <? case FIELD_TYPE_NONE: ?>

                    <div style="float:left;">
                         
                        <input  id="deliverySubmit"  type="submit"  value="" />
                    </div>
 
                <?  break; } ?>

            </div>

        <?php } ?>
 
    </form>

<? if(!empty($client_type_check) && !empty($pay_way_check)) {?>

    <script language="JavaScript">

        $(document).ready(function() {
         //   SPHandler.showAddonFormClient(<?=$client_type_check?>);
        //    SPHandler.showAddonFormNext(<?=$pay_way_check?>);
        //    SPHandler.showPayWayDesc('paywayDesc<?=$selectedDeliveryID?>');

        });

    </script>

<? } ?>
</div>