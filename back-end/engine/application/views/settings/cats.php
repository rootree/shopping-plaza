<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="addOnMenu">
    <a class="addImageBtnText" href="/settings/catsadd">Добавить новую категорию</a>
</div>

<?php

if(count($items)) { ?>


<?php echo $pagination ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th>Название категории</th>
        <th width="150"></th>
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

    <tr class="hightLight <?php echo $class ?>" <? if($item->status == STATUS_HIDE){?>style="background-color: #e2e1e1;" <? } ?>>
        <td class="catalog" width="20"><?php echo $current_first_item ?></td> 
        <td><?php echo html::specialchars($item->title) ?></td>
        <td>
		
			<a class="editBtn" href="<?php echo url::site(); ?>settings/catsedit/id/<?php echo ($item->cat_id) ?>">Редактировать</a>
			<a class="openBtn" href="<?php echo url::site(); ?>settings/catssub/id/<?php echo ($item->cat_id) ?>">Открыть подкатегории</a>

            &nbsp;

            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить категорию «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>settings/catsdelete/id/<?php echo ($item->cat_id) ?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>settings/catsdelete/id/<?php echo ($item->cat_id) ?>">Удалить</a>
            <a class="powerBtn" href="?id=<?php echo ($item->cat_id) ?>&<?= (($item->status == STATUS_WORK) ? 'pleaseHide' : 'pleaseShow') ?>"><?= (($item->status == STATUS_WORK) ? 'Отображаеться на сайте. <b>Скрыть?</b>' : 'Скрыто на сайте. <b>Показать?</b>') ?></a>

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
		​Ни одна категория не заведёна. Интернет-магазин не сможет полноценно работать.
	</p>
	
<?php } ?> 




<h3 class="help">Пояснение</h3>

<p>В вашем Интернет-магазине можно организовать двух уровневую структуру категорий.</p>

<p>
</p>

    <p>К примеру такой структуры:</p><i>
<ul>
    <li> Компьютеры 

<ul>
    <li>Компьютеры NT</li> <li>Компьютеры Эксимер</li><li>Неттопы</li>
</ul>

    </li>


    <li>Ноутбуки и планшеты 
<ul>
    <li> Ноутбуки</li> <li>Планшетные компьютеры </li><li> Нетбуки</li><li>Сумки для ноутбуков </li><li> Аксессуары</li>
</ul>


    </li><li>
Принтеры 
<ul>
    <li> Плоттеры</li> <li>Принтеры лазерные </li> 
</ul>

    
     </li>
</ul>
</i>
<p>
    Вы находитесь на странице основных категорий. Вложенные в них категории мы называем Подкатегориями.
</p>


