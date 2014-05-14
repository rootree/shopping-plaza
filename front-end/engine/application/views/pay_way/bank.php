<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<br/>

<p><b>Банковские реквизиты:</b></p>
  
<div class="svyaz" id="svyaz" style="height: 394px;">

    <div class="svyazList">
        <p><?=form::label('metro', 'Название компании');?>:</p>
        <p><?=form::label('street', 'ИНН');?>:</p>
        <p><?=form::label('house', 'КПП');?>:</p>
        <p><?=form::label('houseAddOn', 'ОКПО');?>:</p>
        <p><?=form::label('podiezd', 'Юр.адрес');?>:</p>
        <p><?=form::label('floor', 'Расчётный счёт');?>:</p>
        <p><?=form::label('apr', 'Банк');?>:</p>
        <p><?=form::label('cityBank', 'Город банка');?>:</p>
        <p><?=form::label('korrAc', 'Корр.счёт');?>:</p>
        <p><?=form::label('bik', 'БИК');?>:</p>
        <p><?=form::label('comment', 'Комментарии');?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="metro" name="request[nameFirm]" type="input" value="<?=(cookie::get('nameFirm')) ? cookie::get('nameFirm') : @$_REQUEST['request']['nameFirm']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="street" name="request[inn]" type="input" value="<?=(cookie::get('inn')) ? cookie::get('inn') : @$_REQUEST['request']['inn']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="house" name="request[kpp]" type="input" value="<?=(cookie::get('kpp')) ? cookie::get('kpp') : @$_REQUEST['request']['kpp']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="houseAddOn" name="request[okpo]" type="input" value="<?=(cookie::get('okpo')) ? cookie::get('okpo') : @$_REQUEST['request']['okpo']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="podiezd" name="request[address]" type="input" value="<?=(cookie::get('address')) ? cookie::get('address') : @$_REQUEST['request']['address']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="floor" name="request[account]" type="input" value="<?=(cookie::get('account')) ? cookie::get('account') : @$_REQUEST['request']['account']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="apr" name="request[bank]" type="input" value="<?=(cookie::get('bank')) ? cookie::get('bank') : @$_REQUEST['request']['bank']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="cityBank" name="request[cityBank]" type="input" value="<?=(cookie::get('cityBank')) ? cookie::get('cityBank') : @$_REQUEST['request']['cityBank']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="korrAc" name="request[korrAc]" type="input" value="<?=(cookie::get('korrAc')) ? cookie::get('korrAc') : @$_REQUEST['request']['korrAc']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="bik" name="request[bik]" type="input" value="<?=(cookie::get('bik')) ? cookie::get('bik') : @$_REQUEST['request']['bik']?>"/>
        </p>
        <p>
            <?=form::textarea('request[comment]', @$_REQUEST['request']['comment'], ' class="text" rows="3"');?>
        </p>
    </div>
</div>

<div class="svyaz" id="svyaz" style="background-color: #FFFFFF; border: 0px;  height: 0px; ">
    <div class="svyazList">
        <p>&nbsp;</p>
    </div>
    <div class="svyazForm">
        <input  id="deliverySubmit"  type="submit"  value="" />
    </div>
</div>