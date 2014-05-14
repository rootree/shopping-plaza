<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<br/>
Здравствуйте <?=html::specialchars($content['name'])?>, в Интернет-магазине <?=html::specialchars($content['firmName'])?> вы сделали заказ №<?=($content['orderID'])?>.
<br/><br/>
На данный момент, заказ №<?=($content['orderID'])?> имеет статус: отправленный.
<br/>

<? if($firm->mail_inside){ ?> 
    <div><br/>
         <?=$firm->mail_inside?>
   </div> <br/>
<? } ?>