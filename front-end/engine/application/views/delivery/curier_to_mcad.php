<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<p><b>Контактное лицо:</b></p>
 
<div class="svyaz" id="svyaz" style="height:  92px;">

    <div class="svyazList">
        <p><?=form::label('name', 'Ваше имя', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['name']->must ? ' style="font-weight:bold;" ' : '')); ?>:</p>
        <p><?=form::label('mail', 'Электронный адрес', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('phone', 'Номер телефона', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="name" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[name]" type="input" value="<?=(cookie::get('name')) ? cookie::get('name') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['name']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="mail" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[mail]" type="input" value="<?=(cookie::get('mail')) ? cookie::get('mail') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['mail']?>"/>
        </p>
        <p>
            <input  class="inpt"    id="phone" type="text" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[phone]" value="<?=(cookie::get('phone')) ? cookie::get('phone') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['phone']?>" />
        </p>
     </div>
 </div>

<p><b>Адрес доставки:</b></p>


 <div class="svyaz" id="svyaz" style="height: 362px;">

    <div class="svyazList">
        <p><?=form::label('metro', 'Город/Поселение', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['metro']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('distance', 'Расстояние от МКАД(км)', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['distance']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('street', 'Улица', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['street']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('house', 'Дом', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['house']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('houseAddOn', 'Строение/корпус', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['houseAddOn']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('podiezd', 'Подъезд', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['podiezd']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('floor', 'Этаж', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['floor']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('apr', 'Квартира/Офис', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['apr']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('domoph', 'Домофон', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['domoph']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('comment', 'Комментарии', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_CURIER_TO_MCAD]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="metro" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[metro]" type="input" value="<?=(cookie::get('metro')) ? cookie::get('metro') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['metro']?>"/>
        </p>

        <p>
            <input   class="inpt"   id="distance" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[distance]" type="input" value="<?=(cookie::get('distance')) ? cookie::get('distance') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['distance']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="street" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[street]" type="input" value="<?=(cookie::get('street')) ? cookie::get('street') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['street']?>"/>
       </p>
        <p>
            <input   class="inpt"   id="house" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[house]" type="input" value="<?=(cookie::get('house')) ? cookie::get('house') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['house']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="houseAddOn" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[houseAddOn]" type="input" value="<?=(cookie::get('houseAddOn')) ? cookie::get('houseAddOn') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['houseAddOn']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="podiezd" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[podiezd]" type="input" value="<?=(cookie::get('podiezd')) ? cookie::get('podiezd') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['podiezd']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="floor" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[floor]" type="input" value="<?=(cookie::get('floor')) ? cookie::get('floor') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['floor']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="apr" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[apr]" type="input" value="<?=(cookie::get('apr')) ? cookie::get('apr') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['apr']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="domoph" name="request<?=DELIVERY_TYPE_CURIER_TO_MCAD?>[domoph]" type="input" value="<?=(cookie::get('domoph')) ? cookie::get('domoph') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['domoph']?>"/>
        </p>
        <p> 
            <?=form::textarea('request' . DELIVERY_TYPE_CURIER_TO_MCAD . '[comment]', (cookie::get('comment')) ? cookie::get('comment') : @$_REQUEST['request'.DELIVERY_TYPE_CURIER_TO_MCAD]['comment']    , 'class="text" rows="3"');?>
         </p>
     </div>
 </div>
 