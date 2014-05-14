<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="addOnMenu">
    <a  title="Создать способ доставки" class="addImageBtnText" href="<?php echo url::site(); ?>/settings/deliveryadd">Добавить</a>
</div>

<?php if(count($items)) { ?>

<?php echo $pagination ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th>Имя</th>
        <th>Шаблон</th>
        <th>Cтоимость</th>
        <th width="120"></th>
    </tr>

<?php

$count = 0;

foreach ($items as $item) {

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }
  
?>

    <tr class="hightLight <?php echo $class ?>"  <? if($item->status == STATUS_HIDE){?>style="background-color: #e2e1e1;" <? } ?>>
        <td class="catalog" ><?php echo $current_first_item ?></td> 
        <td><?php echo html::specialchars($item->title) ?></td>
        <td class="catalog"><?php echo html::specialchars($GLOBALS['DELIVERY'][$item->type]) ?></td>
        <td class="catalog" style="width:250px;"><?php echo (!is_null($item->cost) ? money::ru($item->cost) :
		        'Рассчитывается
        индивидуально'
        ) ?></td>
        <td >
 
			<a class="editBtn" href="<?php echo url::site(); ?>settings/deliveryedit/id/<?php echo ($item->del_id) ?>">Редактировать</a>
			<a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить способ доставки «<?php echo html::specialchars($item->title) ?>»? Также будут удалены все привязанные способы оплаты.', function(){SPAdmin.goToURL('<?php echo url::site(); ?>settings/deliverydelete/id/<?php echo ($item->del_id) ?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>settings/deliverydelete/id/<?php echo ($item->del_id) ?>">Удалить</a>

            <a class="powerBtn" href="?id=<?php echo ($item->del_id) ?>&<?= (($item->status == STATUS_WORK) ? 'pleaseHide' : 'pleaseShow') ?>"><?= (($item->status == STATUS_WORK) ? 'Отображаеться на сайте. <b>Скрыть?</b>' : 'Скрыто на сайте. <b>Показать</b>') ?></a>
   
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
		Не один способ доставки не заведён. Интернет-магазин не сможет полноценно работать. 
	</p>
	
<?php } ?>


<h3 class="help">Пояснение</h3>
<p>
Каждый из покупателей хочет знать, как он получит свою покупку, и как он её оплатит.
</p>
    <p>
Мы предлагаем несколько вариантов шаблонов для доставки и оплаты ваших товаров, из которых вы сможете выбрать более подходящий для вашего бизнеса.
</p>