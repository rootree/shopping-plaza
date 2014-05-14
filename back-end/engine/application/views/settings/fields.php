<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

 
<div id="addOnMenu">
				
    <a class="addFieldBtnText" href="<?php echo url::site(); ?>settings/fieldsadd/catsubid/<?php echo ($catsubid) ?>">Добавить характеристику</a>
    <a  title="Открыть страницу редактирования подкатегории<br/>к которой относятся данные характеристики" class="editBtnText"  href="<?php echo url::site(); ?>settings/catseditsub/id/<?php echo ($catsubid) ?>">Редактировать подгруппу</a>

</div>
 
<p>
	Характеристики товаров служат для удобства занесения данных в панель управления и отображения их в Интернет-магазине.
</p>

<? if ($items->count()) { ?>
 
    <?php

    if(count($items)) { ?>

	<?php echo $pagination ?>

    <table id="bin" cellspacing="0" cellpadding="5" >

        <tr>
            <th width="20">№</th>
            <th>Название</th> 
            <th width="70">Действия</th>
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

        <tr class="hightLight <?php echo $class ?>" >
            <td class="catalog" width="20"><?php echo $current_first_item ?></td>
            <td><?php echo html::specialchars($item->title) ?></td>
            <td>
 
			<a class="editBtn" href="<?php echo url::site(); ?>settings/fieldsedit/catsubid/<?=$catsubid?>/id/<?php echo ($item->field_id) ?>">Редактировать</a>
			<a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите характеристику под названием «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>settings/fieldsdelete/catsubid/<?=$catsubid?>/id/<?php echo ($item->field_id) ?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>settings/fieldsdelete/catsubid/<?=$catsubid?>/id/<?php echo ($item->field_id) ?>">Удалить</a>
 
 
            </td>
        </tr>

    <?php
        $current_first_item ++;
    }
    ?>

    </table>

    <?php echo $pagination ?>
	
    <?php } ?>



<?php }else{ ?>

 <p>
	На данный момент, для выбранной категории не заведено ни одной характеристики.
 </p>

<?php } ?>