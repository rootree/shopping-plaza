<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<p><b>Контактное лицо:</b></p>
    
<div class="svyaz" id="svyaz" style="height:  92px;">

    <div class="svyazList">
        <p><?=form::label('name', 'Ваше имя', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_METRO]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('mail', 'Электронный адрес', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_METRO]['mail']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('phone', 'Номер телефона', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_METRO]['phone']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="name" name="request<?=DELIVERY_TYPE_CURIER_TO_METRO?>[name]" type="input" value="<?=(isset($_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_METRO]['name'])) ? $_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_METRO]['name'] : cookie::get('name') ?>"/>
        </p>
        <p>
            <input   class="inpt"   id="mail" name="request<?=DELIVERY_TYPE_CURIER_TO_METRO?>[mail]" type="input" value="<?=(cookie::get('mail')) ? cookie::get('mail') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_METRO]['mail']?>"/>
        </p>
        <p>
            <input  class="inpt"    id="phone" type="text" name="request<?=DELIVERY_TYPE_CURIER_TO_METRO?>[phone]" value="<?=(cookie::get('phone')) ? cookie::get('phone') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_METRO]['phone']?>" />
        </p>
     </div>
 </div>

<p><b>Адрес доставки:</b></p>


 <div class="svyaz" id="svyaz" style="height: 153px; margin-bottom: 0px;">

    <div class="svyazList">
        <p><?=form::label('metro', 'Метро', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_METRO]['metro']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('street', 'Улица', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_METRO]['street']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('comment', 'Комментарии', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_METRO]['comment']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="metro" name="request<?=DELIVERY_TYPE_CURIER_TO_METRO?>[metro]" type="input" value="<?=(cookie::get('metro')) ? cookie::get('metro') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_METRO]['metro']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="street" name="request<?=DELIVERY_TYPE_CURIER_TO_METRO?>[street]" type="input" value="<?=(cookie::get('street')) ? cookie::get('street') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_METRO]['street']?>"/>
       </p>
        <p>
            <?=form::textarea('request' . DELIVERY_TYPE_CURIER_TO_METRO . '[comment]', (cookie::get('comment')) ? cookie::get('comment') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_METRO]['comment']    , 'class="text" rows="3"');?>
         </p>
     </div>
 </div>
 