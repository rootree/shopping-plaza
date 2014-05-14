<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="addOnMenu">
    <a class="addImageBtnText" href="/settings/catsaddsub/catid/<?=$this->mainGroup?>">Добавить новую подкатегорию</a>
</div>

<?php
 
if(count($items)) { ?>

<?php echo $pagination ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th width="30%">Основная категория</th>
        <th>Название</th>
        <th width="270">Действия</th>
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

    <tr class="hightLight <?php echo $class ?>"  <? if($item->status == STATUS_HIDE){?> style="background-color: #e2e1e1;" <? } ?>>
        <td class="catalog" ><?=$item->status?><?php echo $current_first_item ?></td>
        <td><?php echo html::specialchars($item->cat_title) ?></td>
        <td><?php echo html::specialchars($item->title) ?></td>
        <td class="catalog <?php echo $class ?>" >
		
            <a  class="mainCatBtn" href="<?php echo url::site(); ?>settings/catsedit/id/<?php echo ($item->cat_id) ?>">Редактировать основную категорию</a>

            &nbsp;
            <a class="editBtn" href="<?php echo url::site(); ?>settings/catseditsub/id/<?php echo ($item->catsub_id) ?>">Редактировать</a>

            &nbsp;
		    <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить подкатегорию «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>settings/catsdeletesub/id/<?php echo ($item->catsub_id) ?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>settings/catsdeletesub/id/<?php echo ($item->catsub_id) ?>">Удалить</a>
            <a class="powerBtn" href="?id=<?php echo ($item->catsub_id) ?>&<?= (($item->status == STATUS_WORK) ? 'pleaseHide' : 'pleaseShow') ?>"><?= (($item->status == STATUS_WORK) ? 'Отображаеться на сайте. <b>Скрыть?</b>' : 'Скрыто на сайте. <b>Показать?</b>') ?></a>

			&nbsp;
            <a  class="fieldsBtn" href="<?php echo url::site(); ?>settings/fields/catsubid/<?php echo ($item->catsub_id) ?>">Характеристики</a>
            <a  class="addFieldBtn" href="<?php echo url::site(); ?>settings/fieldsadd/catsubid/<?php echo ($item->catsub_id) ?>">Добавить характеристику</a>
            &nbsp;

            <a  class="copyBtn" href="<?php echo url::site(); ?>settings/subcatcopy/catsubid/<?php echo ($item->catsub_id) ?>">Скопировать подгруппу</a>

        </td>
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<?php echo $pagination ?>

<?php }else{ ?>
	
	<p>
		Ни одна подкатегория не заведёна. Интернет-магазин не сможет полноценно работать.
	</p>
	
<?php } ?> 



<h3 class="help">Пояснение</h3>

<p>Для каждой подгруппы товаров вы можете добавить набор характеристик. </p>

<p>Для чего? Для удобного занесения информации в панель управления и красивого отображения на сайте.
</p>

    <p>Какие могут быть характеристики? К примеру:</p><i>
<ul>
    <li> Габариты</li> <li>Производитель </li><li> Цвет</li>
</ul>
</i>
<p>
    Как добавить? Нажмите на плюсик на против нужной подкатегории.
</p>
