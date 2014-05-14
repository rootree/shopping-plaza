<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="adress">



<? if(array_key_exists('updated', $_REQUEST)){ ?>

    <div class="errordesc infodesc" >
        <h4>Отлично!</h4>
        <p class="last-child">Информация о вас успешно обновлена.</p>
    </div>

<? }?>

<? if(array_key_exists('repeat', $_REQUEST)){ ?>

    <div class="errordesc infodesc" >
        <h4>Спасибо !</h4>
        <p class="last-child">Код подтверждения выслан.</p>
    </div>

<? }?>

<? if(array_key_exists('updatedMail', $_REQUEST)){ ?>
 
    <div class="errordesc infodesc" >
        <h4>Спасибо !</h4>
        <p class="last-child">Подтвердите свой электронный адрес.</p>
    </div>

<? }?>

<? if($this->error) : ?>

    <div class="errordesc" >
        <h4>Произошла ошибка</h4>
        <p class="last-child"><?=$this->error?></p>
    </div>

<? endif ?>

<form action="/settings?name" method="POST">

    <h2>Новое имя</h2>

    <div class="svyaz" id="svyaz" style="height: 35px;">

        <div class="svyazList">
            <p><?=form::label('nameSET', 'Ваще имя');?>:</p>
        </div>

        <div class="svyazForm"> 
            <p>
                <input id="nameSET" name="firms[userName]" value="<?php echo isset($_POST['firms']['userName']) ? html::specialchars($_POST['firms']['userName']) : $this->userName ?>" />
            </p>
            <p>
                <Br/><input type="submit" value="" style="margin-top: -10px;">
            </p>
        </div>

    </div>

</form>
    

<!--
<form action="/settings?mail"  method="POST">

    <Br/>

    <h2>Новый адрес электронной почты</h2>


    <? if(isset($this->userMailNew) && !empty($this->userMailNew)) { ?>
        <br/>На самом деле активный майл не подтверждён, активный этот: <b><?=$this->userMailNew?></b>

        <? if(!array_key_exists('repeat', $_REQUEST)){ ?>
            , <a href="/settings?repeat" >повторить</a> письмо подтвержения.
        <? }else{ ?>
            .    
        <? } ?>

    <? } ?>

    <div class="svyaz" id="svyaz" style="height: 35px;">

        <div class="svyazList">
            <p><?=form::label('mailSET', 'Электронный адрес');?>:</p> 
        </div>

        <div class="svyazForm">
 
            <p>
                <input id="mailSET" name="firms[userMail]" value="<?php echo isset($_POST['firms']['userMail']) ? html::specialchars($_POST['firms']['userMail']) :
                        ($this->userMail) ?>" />
            </p>
            <p>

                <Br/><input type="submit" value="" style="margin-top: -10px;">
            </p>

        </div>

    </div>



</form>

-->

<form action="/settings?pass"  method="POST">

    <Br/>

    <h2>Новый пароль</h2>

    <div class="svyaz" id="svyaz" style="height: 95px;">

        <div class="svyazList">
            <p><?=form::label('oldSET', 'Старый пароль');?>:</p>
            <p><?=form::label('passSET', 'Пароль');?>:</p>
            <p><?=form::label('repassSET', 'Подтвердение');?>:</p>
        </div>

        <div class="svyazForm">

            <p>
                <input type="password" id="oldSET" name="firms[old]" value="" />
            </p>
            <p>
                <input type="password" id="passSET" name="firms[pass]" value="" />
            </p>
            <p>
                <input type="password" id="repassSET" name="firms[repass]" value="" />
            </p>
            <p>
                <Br/><input type="submit" value="" style="margin-top: -10px;">
            </p>

        </div>

    </div>

</form>

 </div>