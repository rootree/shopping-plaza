<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>
     
<div id="addOnMenu">

    <? if($item->status == FEEDBACK_STATUS_NEW || $item->status == FEEDBACK_STATUS_VIEWED) { ?>

        <a class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
        <a class="orderOkBtnText" href="<?php echo url::site(); ?>feedback/index/typeaction/<?=FEEDBACK_STATUS_PROCEEDED?>/feedbackid/<?=$item->fb_id?>">Обработан</a>
        <a onclick="SPAdmin.showConfirmMessage('Подтвердите игнорирование', 'Вы действительно хотите игнорировать этот вопрос пользователя?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>feedback/index/typeaction/<?=FEEDBACK_STATUS_CANCEL?>/feedbackid/<?=$item->fb_id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>feedback/index/typeaction/<?=FEEDBACK_STATUS_CANCEL?>/feedbackid/<?=$item->fb_id?>">Игнорировать</a>

    <? }elseif($item->status == FEEDBACK_STATUS_CANCEL || $item->status == FEEDBACK_STATUS_PROCEEDED){ ?>

    <? } ?>

</div>

<center>
 
<form action="" method="post">
 
<table class="form">
 
    <tr>
        <td class="label">Поступил:</td>
        <td class="elements view">
            <?php echo time::date($item->fb_date, DATE_FORMAT) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Тема сообщения:</td>
        <td class="elements view">
            <?php echo html::specialchars($item->fb_title) ?>
        </td>
    </tr>

    <tr>
        <td class="label">От пользователя:</td>
        <td class="elements view">
            <?php echo html::specialchars($item->fb_name) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Электронный адрес:</td>
        <td class="elements view">
            <?php echo html::specialchars($item->fb_email) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Содержание:</td>
        <td class="elements view">
            <?php echo str_replace("\n", "<br/>", html::specialchars($item->fb_questing)) ?>
        </td>
    </tr>

    <tr>
        <td class="label bottomHandler">Текущее состояние:</td>
        <td class="elements view bottomHandler">
            <?php echo $GLOBALS['FEEDBACK_STATUS'][($item->status)] ?>
        </td>
    </tr>
 
    <? if($item->status == FEEDBACK_STATUS_NEW || $item->status == FEEDBACK_STATUS_VIEWED) { ?>

        <tr>
            <td class="label">Ответ:</td>
            <td class="elements view">
                    <textarea id="feedback_ansver" rows="3" cols="4" id="pages_content" name="feedback[ansver]"><?php
                        echo @str_replace("\n", "<br/>", html::specialchars($_POST['feedback']['ansver']))
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                <div class="smallInfo">
                    Ответ будет показан в Панеле управления, и будет отправлен по электронной почте на адрес пользователя.
                </div>
            </td>
        </tr>

        <tr>
            <td class="label"></td>
            <td class="elements">
                <input type="submit" value="Отправить ответ">
            </td>
        </tr>
    
    <? }elseif($item->status == FEEDBACK_STATUS_PROCEEDED){ ?>

        <? if(!empty($item->fb_ansver)) { ?>

            <tr>
                <td class="label">Ответ операциониста:</td>
                <td class="elements view">
                    <?php echo str_replace("\n", "<br/>", html::specialchars($item->fb_ansver)) ?>
                </td>
            </tr>
            <tr>
                <td class="label">Ответ отправлен:</td>
                <td class="elements view">
                    <?php echo time::date($item->fb_ansver_date, DATE_FORMAT)  ?>
                </td>
            </tr>

        <? }else{ ?>
 
            <tr>
                <td class="label">Результат обработки:</td>
                <td class="elements view">
                    Запрос закрыт без ответа
                </td>
            </tr>

        <? } ?>

    <? } ?>

</table>

     </form>
    
<? if($order_history->count()){ ?>

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

                foreach ($order_history as $history) {

                    $count ++;
                    $class = "";

                    if ($count % 2 == 0) {
                            $class="modTwo";
                    }

                ?>

                    <tr class="hightLight <?php echo $class ?>" >

                        <td class="catalog" ><?php echo $current_first_item ?></td>
                        <td  class="catalog"><?=time::date($history->date, DATE_FORMAT)?></td>
                        <td class="catalog"><?=$GLOBALS['FEEDBACK_STATUS'][$history->type]?></td>
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
<?php } ?>
 
</center>

<?php } ?>
 