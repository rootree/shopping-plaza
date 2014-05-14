<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>




<p><b>Контактное лицо:</b></p>

 <div class="svyaz" id="svyaz" style="height: 153px;">

    <div class="svyazList">
        <p><?=form::label('name', 'Ваше имя', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['name']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('thirdName', 'Отчество', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['thirdName']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('soname', 'Фамилия', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['soname']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('mail', 'Электронный адрес', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['mail']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('phone', 'Номер телефона', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['phone']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="name" name="request<?=DELIVERY_TYPE_EMS?>[name]" type="input" value="<?=(cookie::get('name')) ? cookie::get('name') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['name']?>"/>
        </p>
        <p> 
            <input   class="inpt"   id="thirdName" name="request<?=DELIVERY_TYPE_EMS?>[thirdName]" type="input" value="<?=(cookie::get('thirdName')) ? cookie::get('thirdName') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['thirdName']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="soname" name="request<?=DELIVERY_TYPE_EMS?>[soname]" type="input" value="<?=(cookie::get('soname')) ? cookie::get('soname') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['soname']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="mail" name="request<?=DELIVERY_TYPE_EMS?>[mail]" type="input" value="<?=(cookie::get('mail')) ? cookie::get('mail') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['mail']?>"/>
        </p>
        <p>
            <input  class="inpt"    id="phone" type="text" name="request<?=DELIVERY_TYPE_EMS?>[phone]" value="<?=(cookie::get('phone')) ? cookie::get('phone') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['phone']?>" />
        </p>
     </div>

 </div>
 

<p><b>Адрес доставки:</b></p>


 <div class="svyaz" id="svyaz" style="height: 392px;">

    <div class="svyazList">
        <p><?=form::label('index', 'Индекс', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['index']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('region', 'Регион', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['region']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('city', 'Город', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['city']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('street', 'Улица', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['street']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('house', 'Дом', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['house']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('houseAddOn', 'Строение/корпус', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['houseAddOn']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('podiezd', 'Подъезд', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['podiezd']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('floor', 'Этаж', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['floor']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('apr', 'Квартира/Офис', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['apr']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('domoph', 'Домофон', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['domoph']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
        <p><?=form::label('comment', 'Комментарии', ($GLOBALS['DELIVERY_FIELDS'][DELIVERY_TYPE_EMS]['comment']->must ? ' style="font-weight:bold;" ' : ''));?>:</p>
    </div>

    <div class="svyazForm">
        <p>
            <input   class="inpt"   id="index" name="request<?=DELIVERY_TYPE_EMS?>[index]" type="input" value="<?=(cookie::get('index')) ? cookie::get('index') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['index']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="region" name="request<?=DELIVERY_TYPE_EMS?>[region]" type="input" value="<?=(cookie::get('region')) ? cookie::get('region') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['region']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="city" name="request<?=DELIVERY_TYPE_EMS?>[city]" type="input" value="<?=(cookie::get('city')) ? cookie::get('city') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['city']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="street" name="request<?=DELIVERY_TYPE_EMS?>[street]" type="input" value="<?=(cookie::get('street')) ? cookie::get('street') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['street']?>"/>
       </p>
        <p>
            <input   class="inpt"   id="house" name="request<?=DELIVERY_TYPE_EMS?>[house]" type="input" value="<?=(cookie::get('house')) ? cookie::get('house') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['house']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="houseAddOn" name="request<?=DELIVERY_TYPE_EMS?>[houseAddOn]" type="input" value="<?=(cookie::get('houseAddOn')) ? cookie::get('houseAddOn') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['houseAddOn']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="podiezd" name="request<?=DELIVERY_TYPE_EMS?>[podiezd]" type="input" value="<?=(cookie::get('podiezd')) ? cookie::get('podiezd') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['podiezd']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="floor" name="request<?=DELIVERY_TYPE_EMS?>[floor]" type="input" value="<?=(cookie::get('floor')) ? cookie::get('floor') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['floor']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="apr" name="request<?=DELIVERY_TYPE_EMS?>[apr]" type="input" value="<?=(cookie::get('apr')) ? cookie::get('apr') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['apr']?>"/>
        </p>
        <p>
            <input   class="inpt"   id="domoph" name="request<?=DELIVERY_TYPE_EMS?>[domoph]" type="input" value="<?=(cookie::get('domoph')) ? cookie::get('domoph') : @$_REQUEST['request' .DELIVERY_TYPE_EMS]['domoph']?>"/>
        </p>
        <p>

            <?=form::textarea('request' . DELIVERY_TYPE_EMS . '[comment]', (cookie::get('comment')) ? cookie::get('comment') : @$_REQUEST['request'.DELIVERY_TYPE_EMS]['comment']    , 'class="text" rows="3"');?>
         </p>
     </div>
 </div> 