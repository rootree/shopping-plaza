<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($items->count()) { ?>

<? if(isset($pagination)) { ?>
     <?php echo $pagination ?>
<? } ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th> 
        <th width="170">Время отсылки</th>
        <th>Пользователь</th>
        <th>Электронный адрес</th>
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
        <td class="catalog"><?php echo time::date($item->fb_date, DATE_FORMAT) ?></td>
        <td ><?php echo html::specialchars($item->fb_name) ?></td>
        <td ><?php echo html::specialchars($item->fb_email) ?></td>
        <td class="catalog"><?php echo $GLOBALS['FEEDBACK_STATUS'][($item->status)] ?></td>

        <td>
 
            <? if($item->status == FEEDBACK_STATUS_NEW || $item->status == FEEDBACK_STATUS_VIEWED) { ?>

                <a class="orderOkBtn" href="<?php echo url::site(); ?>feedback/index/typeaction/<?=FEEDBACK_STATUS_PROCEEDED?>/feedbackid/<?=$item->fb_id?>">Обработан</a>
              
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите игнорирование', 'Вы действительно хотите игнорировать этот вопрос пользователя?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>feedback/index/typeaction/<?=FEEDBACK_STATUS_CANCEL?>/feedbackid/<?=$item->fb_id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>feedback/index/typeaction/<?=FEEDBACK_STATUS_CANCEL?>/feedbackid/<?=$item->fb_id?>">Игнорировать</a>

            <? }elseif($item->status == FEEDBACK_STATUS_CANCEL || $item->status == FEEDBACK_STATUS_PROCEEDED){ ?>

            <? } ?>
            
            <div style="float:right;">
                &nbsp;<a class="viewBtn" href="<?php echo url::site(); ?>feedback/info/id/<?=$item->fb_id?>">Посмотреть</a>
            </div>
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


 <p style="margin-top: 0px;">
Благодаря форме обратной связи, любой пользователь без проблем и с минимальными усилиями сможет написать вам сообщение
     на любую тему, будь то вопрос по продукции или коммерческое предложение. В свою очередь вы, тут же узнаете что вам
     написали сразу с помощью двух каналов связи. Это электронная почта, вам придёт содержимое письма пользователя по почте, или/и SMS-уведомление.
     Сообщения от ваших клиентов будут показаны на этой странице.
 </p>


<? } ?>


