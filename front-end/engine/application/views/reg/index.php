<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="adress">

<h2>Регистрация в магазине</h2>
<br/>
<p>
Регистрация в нашем магазине не обязательна для совершения покупок, но пройдя регистрацию, вы сможете просматривать ваши предыдущие заказы и их статусы.
</p>

<? if($this->error) : ?>

    <div class="errordesc" >
        <h4>Произошла ошибка</h4><br/>
        <p class="last-child"><?=$this->error?></p>
    </div>

<? endif ?>

<form action="/reg" onsubmit="return SPHandler.checkRegistration();" method="POST">

    <div class="svyaz" id="svyaz" style="height: 95px;">

        <div class="svyazList">
            <p><?=form::label('nameREG', 'Ваще имя');?>:</p>
            <p><?=form::label('passREG', 'Пароль');?>:</p>
            <p><?=form::label('mailREG', 'Электронный адрес');?>:</p>
        </div>

        <div class="svyazForm">

            <p>
                <input id="nameREG" name="firms[userName]" value="<?php echo @html::specialchars($_POST['firms']['userName']) ?>" />
            </p>
            <p>
                <input type="password" id="passREG" name="firms[userPass]" value="<?php echo @html::specialchars($_POST['firms']['userPass']) ?>" />
            </p>
            <p>
                <input id="mailREG" name="firms[userMail]" value="<?php echo @html::specialchars($_POST['firms']['userMail']) ?>" />
            </p>
            <p>
                <Br/><input type="submit" value="" style="margin-top: -10px;">
            </p>

        </div>

    </div>

    

</form>

 </div>