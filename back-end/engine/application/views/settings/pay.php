<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="addOnMenu">

    <a  title="Добавить новый способ оплаты" class="addImageBtnText" href="<?php echo url::site(); ?>/settings/payadd">Добавить</a>

</div>

<?php

if(count($items)) { ?>

<?php echo $pagination ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th>Доставка</th>
        <th>Оплата</th>
        <th>Тип клиента</th>
        <th>Требуемые поля</th>
        <th width="120"></th>
    </tr>

<?php

$count = 0;
 $name = "";$class = "";
foreach ($items as $item) {



    if($name == ''){

          $name = $item->dev_title;
    }


    if ($name !=  $item->dev_title) {
        if ($count % 2 == 0) {
                $class="modTwo";
        }else{
            $class = "";
        }$count ++;
    } 


   $name = $item->dev_title;
?>

    <tr class="hightLight <?php echo $class ?>"   <? if($item->status == STATUS_HIDE){?>style="background-color: #e2e1e1;" <? } ?>>
        <td class="catalog" width="20"><?php echo $current_first_item ?></td>
        <td><?php echo html::specialchars($item->dev_title) ?></td>
        <td><?php echo html::specialchars($item->title) ?></td>
        <td><?php echo html::specialchars($GLOBALS['CLIENT_TYPE'][$item->client_type]) ?></td>
        <td><?php echo html::specialchars($GLOBALS['FIELD_TYPE'][$item->field_type]) ?></td>
        <td>
		
			<a class="editBtn" href="<?php echo url::site(); ?>settings/payedit/id/<?php echo ($item->pay_id) ?>">Редактировать</a>
			<a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить способ оплаты «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>settings/paydelete/id/<?php echo ($item->pay_id) ?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>settings/paydelete/id/<?php echo ($item->pay_id) ?>">Удалить</a>

            <a class="powerBtn" href="?id=<?php echo ($item->pay_id) ?>&<?= (($item->status == STATUS_WORK) ? 'pleaseHide' : 'pleaseShow') ?>"><?= (($item->status == STATUS_WORK) ? 'Отображаеться на сайте. <b>Скрыть?</b>' : 'Скрыто на сайте. <b>Показать?</b>') ?></a>

        </td>
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<?php echo $pagination ?>

<?php }else{ ?>
	
	<p  style="margin-top: 0px;">
		Не один способ оплаты не заведён. Интернет-магазин не сможет полноценно работать.  
	</p>
	
<?php } ?>



<h3 class="help">Пояснение</h3>

<p>Способы оплаты привязыватся к способам доставки. Если в вашем магазинет нет ещё ни одного способа доставки,
    рекомендуем сначала <a href="/settings/deliveryadd">добавить</a> его, а затем перейти к добавлению вариантов оплаты.
   <br/><br/> Заметим, что для каждоко способа доставки необходимо заводить свой способ оплаты, даже если они будут повторяться.</p>

<p>К примеру:
</p>

<ul>
    <li>Способ доставки «Курьером»
        <ul><li>Способ оплаты <b>«Наличными»</b></li></ul>
        <ul><li>Способ оплаты «Через Интернет»</li></ul>
    </li>
    <li>Способ доставки «Курьером до метро»
        <ul><li>Способ оплаты <b>«Наличными»</b></li></ul>
    </li>
</ul>

<p>
    Т.е. если даже способы оплаты одинаковые, их надо будет добавить как два отдельных способа оплаты, каждый для своего способа доставки.

</p>