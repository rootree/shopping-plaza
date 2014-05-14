<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<p><b>Контактное лицо:</b></p>
 
<div class="svyaz" id="svyaz" style="height:  92px;">

    <div class="svyazList">
        <p><?=form::label('name', 'Ваше имя', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['name']->must ? ' style="font-weight:bold;" ' : '')); ?>:</p>
        <p><?=form::label('mail', 'Электронный адрес', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('phone', 'Номер телефона', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="name" name="request<?=DELIVERY_TYPE_CURIER?>[name]" type="input" value="<?=(cookie::get('name')) ? cookie::get('name') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['name']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="mail" name="request<?=DELIVERY_TYPE_CURIER?>[mail]" type="input" value="<?=(cookie::get('mail')) ? cookie::get('mail') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['mail']?>"/>
        </p>
        <p>
            <input  class="inpt"    id="phone" type="text" name="request<?=DELIVERY_TYPE_CURIER?>[phone]" value="<?=(cookie::get('phone')) ? cookie::get('phone') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['phone']?>" />
        </p>
     </div>
 </div>

<p><b>Адрес доставки:</b></p>


 <div class="svyaz" id="svyaz" style="height: 333px;">

    <div class="svyazList">
        <p><?=form::label('metro', 'Метро', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['metro']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('street', 'Улица', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['street']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('house', 'Дом', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['house']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('houseAddOn', 'Строение/корпус', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['houseAddOn']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('podiezd', 'Подъезд', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['podiezd']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('floor', 'Этаж', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['floor']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('apr', 'Квартира/Офис', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['apr']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('domoph', 'Домофон', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['domoph']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('comment', 'Комментарии', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="metro" name="request<?=DELIVERY_TYPE_CURIER?>[metro]" type="input" value="<?=(cookie::get('metro')) ? cookie::get('metro') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['metro']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="street" name="request<?=DELIVERY_TYPE_CURIER?>[street]" type="input" value="<?=(cookie::get('street')) ? cookie::get('street') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['street']?>"/>
       </p>
        <p>
            <input   class="inpt"   id="house" name="request<?=DELIVERY_TYPE_CURIER?>[house]" type="input" value="<?=(cookie::get('house')) ? cookie::get('house') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['house']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="houseAddOn" name="request<?=DELIVERY_TYPE_CURIER?>[houseAddOn]" type="input" value="<?=(cookie::get('houseAddOn')) ? cookie::get('houseAddOn') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['houseAddOn']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="podiezd" name="request<?=DELIVERY_TYPE_CURIER?>[podiezd]" type="input" value="<?=(cookie::get('podiezd')) ? cookie::get('podiezd') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['podiezd']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="floor" name="request<?=DELIVERY_TYPE_CURIER?>[floor]" type="input" value="<?=(cookie::get('floor')) ? cookie::get('floor') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['floor']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="apr" name="request<?=DELIVERY_TYPE_CURIER?>[apr]" type="input" value="<?=(cookie::get('apr')) ? cookie::get('apr') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['apr']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="domoph" name="request<?=DELIVERY_TYPE_CURIER?>[domoph]" type="input" value="<?=(cookie::get('domoph')) ? cookie::get('domoph') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['domoph']?>"/>
        </p>
        <p> 
            <?=form::textarea('request' . DELIVERY_TYPE_CURIER . '[comment]', (cookie::get('comment')) ? cookie::get('comment') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER]['comment']    , 'class="text" rows="3"');?>
         </p>
     </div>
 </div>
 