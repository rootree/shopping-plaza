<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($items->count()) { ?>

<? if(isset($pagination)) { ?>
     <?php echo $pagination ?>
<? } ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th> 
        <th width="170">Время отправки</th>
        <th>Номер телефона</th>
        <th>Состояние</th>
        <th width="120"></th>
    </tr>

<?php

if(!isset($current_first_item)){
    $current_first_item = 1;
}

$count = 0;

foreach ($items as $item) {

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }
  
?>

    <tr class="hightLight <?php echo $class ?>" >
        
        <td class="catalog" width="20"><?php echo $current_first_item ?></td> 
        <td class="catalog"><?php echo time::date($item->date, DATE_FORMAT) ?></td>
        <td ><?php echo html::specialchars(format::phone($item->phone)) ?></td>
        <td class="catalog"><?php echo $GLOBALS['CALLBACK_STATUS'][($item->status)] ?></td>

        <td class="catalog">
 
            <? if($item->status == CALLBACK_STATUS_NEW) { ?>

                <a class="orderOkBtn" href="<?php echo url::site(); ?>callback/index/typeaction/<?=FEEDBACK_STATUS_PROCEEDED?>/callbackid/<?=$item->id?>">Обработан</a>
              
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите игнорирование', 'Вы действительно хотите проигнорировать этот запрос пользователя?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>callback/index/typeaction/<?=CALLBACK_STATUS_CANCEL?>/callbackid/<?=$item->id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>callback/index/typeaction/<?=CALLBACK_STATUS_CANCEL?>/callbackid/<?=$item->id?>">Игнорировать</a>

            <? }elseif($item->status == CALLBACK_STATUS_CANCEL || $item->status == CALLBACK_STATUS_PROCEEDED){ ?>

            <? } ?>
         
        </td>
        
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<? if(isset($pagination)) { ?>
     <?php echo $pagination ?>
<? } ?>

<?php }else{ ?>

    <p  style="margin-top: 0px;">На данный момент заказов на обратный звонок нет.</p>

<? } ?>


<h3 class="help">Пояснение</h3>
 <p>
В настройка Интернет-магазина вы можете указать номер контактного телефона, который будет виден на всех страницах сайта. Но бывают случаи, когда клиент будет пытаться дозвониться, но по каким либо причинам ответа не получит.
  </p><p>
На этот случай для клиента, в Интернет-магазине, предусмотрена возможность, оставить его номер телефона для связи с ним.
    Это форма с одним полем, где клиент будет оставлять свой номер телефона. Как только он оставит его, вы тут же получите
    SMS-сообщение, почтовое сообщение и увидите запрос на обратный звонок на этой странице.
 </p> <p>
Это очень полезный инструмент чтобы удержать как можно больше клиентов.
     </p>