<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="adress">

<form action="/login" method="POST" name="form"  onsubmit="return SPHandler.checkLogin();" >

<h2>Авторизация</h2>

<? if($this->error) : ?>

    <div class="errordesc" >
        <h4>Произошла ошибка.</h4><br/>
        <p class="last-child"><?=$this->error?></p>
    </div>

<? endif ?>

<div class="svyaz" id="svyaz" style="height:  62px;">

    <div class="svyazList">
        <p><?=form::label('mailLogin', 'Электронный адрес');?>:</p>
        <p><?=form::label('wordLogin', 'Пароль');?>:</p>
    </div>

    <div class="svyazForm"> 
        <p>
            <input id="mailLogin" name="singin[mail]" value="<?php echo @html::specialchars($_POST['singin']['mail']) ?>" />
        </p>
        <p>
            <input  id="wordLogin" name="singin[word]" value="<?php echo @html::specialchars($_POST['singin']['word']) ?>" type="password" />
        </p>
     </div>
 </div>

<div class="svyaz" id="svyaz" style="background-color: #FFFFFF; border: 0px;  height: 32px; ">
    <div class="svyazList">
        <p>&nbsp;</p>
    </div>
    <div class="svyazForm">
        <input  id="deliverySubmit"  type="submit"  value="" />
    </div>
</div>

</form>

</div>
 