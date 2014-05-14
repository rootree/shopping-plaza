<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

 
<p><b>Контактное лицо:</b></p>

 <div class="svyaz" id="svyaz" style="height: 92px;">

    <div class="svyazList">
        <p><?=form::label('name', 'Ваше имя', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_HIMSELF]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('mail', 'Электронный адрес', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_HIMSELF]['mail']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('phone', 'Номер телефона', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_HIMSELF]['phone']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="name" name="request<?=DELIVERY_TYPE_HIMSELF?>[name]" type="input" value="<?=(cookie::get('name')) ? cookie::get('name') : @$_REQUEST['request'.DELIVERY_TYPE_HIMSELF]['name']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="mail" name="request<?=DELIVERY_TYPE_HIMSELF?>[mail]" type="input" value="<?=(cookie::get('mail')) ? cookie::get('mail') : @$_REQUEST['request'.DELIVERY_TYPE_HIMSELF]['mail']?>"/>
        </p>
        <p>
            <input  class="inpt"    id="phone" type="text" name="request<?=DELIVERY_TYPE_HIMSELF?>[phone]" value="<?=(cookie::get('phone')) ? cookie::get('phone') : @$_REQUEST['request' .DELIVERY_TYPE_HIMSELF]['phone']?>" />
        </p>
     </div>
 </div>
