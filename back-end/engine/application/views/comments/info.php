<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>
     
<div id="addOnMenu">
 
    <a class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>

    <? if($item->status != COMMENT_STATUS_DELETED ) { ?>

        <a class="editBtnText" href="<?php echo url::site(); ?>comments/edit/id/<?=$item->coment_id?>">Отредактировать</a>

        <? if($item->status != COMMENT_STATUS_ANSWERED ) { ?>

            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить этот комментарий пользователя?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>">Удалить</a>

             <? if($item->status != COMMENT_STATUS_ANSWER) { ?>
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите блокировку', 'Коментарий будет удалён, а этот пользователь больше не сможет оставлять сообщения и комментарии. Вы уверены?',
                    function(){SPAdmin.goToURL('<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>/?block');}); return false;" class="blockTextBtn" href="<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>">Блокировать</a>
            <? } ?>

        <? } ?>

    <? } ?>

</div>
<form action="" method="post">
<center>

<table class="form">
 
    <tr>
        <td class="label">Поступил:</td>
        <td class="elements view">
            <?php echo time::date($item->createDate, DATE_FORMAT) ?>
        </td>
    </tr>

    <tr>
        <td class="label">От пользователя:</td>
        <td class="elements view">
            <?php echo html::specialchars($item->name) ?>
        </td>
    </tr>

 
    <tr>
        <td class="label">Электронный адрес:</td>
        <td class="elements view">
            <?php if(!empty($item->mail)) { echo html::specialchars($item->mail); }else{ ?>Не оставлен<? } ?>
        </td>
    </tr>

    <tr>
        <td class="label">Содержание:</td>
        <td class="elements view">
            <?php echo str_replace("\n", "<br/>", html::specialchars($item->content)) ?>
        </td>
    </tr>

 <? if($item->status != COMMENT_STATUS_ANSWERED && $item->status != COMMENT_STATUS_ANSWER && $item->status != COMMENT_STATUS_DELETED) { ?>

        <tr>
            <td class="label">Ответ:</td>
            <td class="elements view">
                    <textarea id="msg" rows="3" cols="4"   name="msg"><?php
                        echo @str_replace("\n", "<br/>", html::specialchars($_POST['msg']))
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                <div class="smallInfo">
                    Вы можете написать пользователю ответное сообщение, оно будет сохранено на сайте, а так же отправлено ему по электронной почте.
                </div>
            </td>
        </tr>

        <tr>
            <td class="label"></td>
            <td class="elements">
                <input type="submit" value="Отправить ответ">
            </td>
        </tr>

<? } ?>

    <tr>
        <td class="label bottomHandler">Текущее состояние:</td>
        <td class="elements view bottomHandler">
            <?php echo $GLOBALS['COMMENT_STATUS'][($item->status)] ?>
        </td>
    </tr>


    <tr>
        <td class="label bottomHandler">Комментарий к :</td>
        <td class="elements view bottomHandler">


            <? switch ($item->coment_type) {
                case COMMENT_ON_ITEMS: ?> <a target="_blank"  href="http://<?=$this->firm->domain?>/products/item/id/<?php echo ($item->item_id) ?>/#comment<?=$item->coment_id?>">товару «<?=$commentFor?>»</a>
                    <? break ;
                case COMMENT_ON_NEWS: ?> <a target="_blank"   href="http://<?=$this->firm->domain?>/news/index/item/<?php echo ($item->item_id) ?>/return_page/1/#comment<?=$item->coment_id?>">новости «<?=$commentFor?>»</a>
                    <? break ;
                case COMMENT_ON_ARTICLE: ?> <a target="_blank"  href="http://<?=$this->firm->domain?>/pages/index/id/<?php echo ($item->item_id) ?>/#comment<?=$item->coment_id?>">странице «<?=$commentFor?>»</a>
                    <? break ; } ?>
 
        </td>
    </tr>
  
</table>

</center>
    
<div id="addOnMenu">

    <a class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>

    <? if($item->status != COMMENT_STATUS_DELETED ) { ?>

        <a class="editBtnText" href="<?php echo url::site(); ?>comments/edit/id/<?=$item->coment_id?>">Отредактировать</a>

        <? if($item->status != COMMENT_STATUS_ANSWERED ) { ?>

            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить этот комментарий пользователя?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>">Удалить</a>

             <? if($item->status != COMMENT_STATUS_ANSWER) { ?>
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите блокировку', 'Коментарий будет удалён, а этот пользователь больше не сможет оставлять сообщения и комментарии. Вы уверены?',
                    function(){SPAdmin.goToURL('<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>/?block');}); return false;" class="blockTextBtn" href="<?php echo url::site(); ?>comments/index/typeaction/<?=COMMENT_STATUS_DELETED?>/id/<?=$item->coment_id?>">Блокировать</a>
            <? } ?>

        <? } ?>

    <? } ?>

</div>

<?php } ?>
 