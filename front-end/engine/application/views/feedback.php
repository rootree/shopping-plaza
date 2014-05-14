<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
 
<div class="adress">



<? if (!empty($this->firm->descFirm) && strlen($this->firm->descFirm) != 4){?>

        <div id="news_content"><br/><?=$this->firm->descFirm?></div> 
<? } ?>


<? if (!empty($this->firm->address) && strlen($this->firm->address) != 4){?>
    <h2>Наш адрес:</h2>
    <p class="address"><?=$this->firm->address?></p>
<? } ?>

<? if (!empty($this->firm->worktime) && strlen($this->firm->worktime) != 4){?>
    <h2>Время работы:</h2>
    <p class="address"><?=$this->firm->worktime?></p>
<? } ?>

    <h2>Контакты:</h2><br/>

    <table class="list" border="0" cellspacing="0" cellpadding="0">

        <? if (!empty($this->firm->tele)){?>
            <tr>
                <td><p><img class="phone" src="/img.<?=$this->firm->template?>/icons/phone.gif" alt="" /><b class="phone">Телефон:</b> <?=($this->firm->tele)?></p></td>
            </tr>
        <? } ?>
        <? if (!empty($this->firm->fax)){?>
            <tr>
                <td><p><img src="/img.<?=$this->firm->template?>/icons/fax.gif" alt="" /><b>Факс:</b> <?=html::specialchars($this->firm->fax)?></p></td>
            </tr>
        <? } ?>

        <? if (!empty($this->firm->mail)){?>
            <tr>
                <td><p><img class="mail" src="/img.<?=$this->firm->template?>/icons/mail.gif" alt="" /><b>Электронный адрес:</b> <?=($this->firm->mail)?></p></td>
            </tr>
        <? } ?>

        <? if (!empty($this->firm->skype)){?>
            <tr>
                <td><p><img src="/img.<?=$this->firm->template?>/icons/skype.gif" alt="" /><b>Skype:</b> <?=html::specialchars($this->firm->skype)?> </p></td>
            </tr>
        <? } ?>
        <? if (!empty($this->firm->icq)){?>
            <tr>
                <td><p><img src="/img.<?=$this->firm->template?>/icons/icq.gif" alt="" /><b>ICQ:</b> <?=html::specialchars($this->firm->icq)?> </p></td>
                <td>&nbsp;</td>
            </tr>
        <? } ?>
    </table>

    <? if(isset($this->firm->urik) && !empty($this->firm->urik)){ ?> 
        <h2>Юридические данные:</h2>
        <div id="news_content"><br/><?=$this->firm->urik?></div>
    <? } ?>

    <br/>

    <h2  id="feedBackForm">Обратная связь</h2>
 
<? if(!$sended) { ?>
 
    <? if($input_error) : ?>

        <div class="errordesc" >
            <h4>Произошла ошибка при проверке указанных вами данных.</h4>
            <p class="last-child">Проверьте корректность заполненых полей.</p>
        </div>
 
    <? endif ?>


    <form action="/feedback#feedBackForm" onsubmit="return SPHandler.checkFeedback();" method="POST">

    <div class="svyaz" id="svyaz">

        <div class="svyazList">
            <p><?=form::label('title', 'Тема сообщения');?>:</p>
            <p><?=form::label('name', Kohana::lang('feedback.form_name'));?>:</p>
            <p><?=form::label('mail', 'Электронный адрес');?>:</p>
            <p><?=form::label('msg', Kohana::lang('feedback.form_msg'));?>:</p>
        </div>

        <div class="svyazForm">

            <p>
                <?=form::input('title', @($_REQUEST['title']), '  ');?>
            </p>
            <p>
                <?=form::input('name', (cookie::get('name')) ? cookie::get('name') : (@$_REQUEST['name']), '  ');?>
            </p>
            <p>
                <?=form::input('mail', (cookie::get('mail')) ? cookie::get('mail') : (@$_REQUEST['mail']), ' ');?>
            </p>
            <p>
                <?=form::textarea('msg', @($_REQUEST['msg']), ' class="text" rows="3"');?>
            </p> 
            <p>
                <input id="submiter" type="submit" class="sub" value=""/>
            </p>

        </div>
 
    </div>



    </form>

<? } else { ?>

    <div class="errordesc infodesc" >
        <h4>Спасибо. Ваше сообшение отправлено. Вы получите ответ в ближайшее время.</h4>
    </div>

<? } ?>

</div> 