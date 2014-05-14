<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($items->count()) { ?>

<?php echo $pagination ?>

 
<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
		<th width="20">№</th> 
		<th>Должность</th>
		<th width="140">Уровень ЗП</th>
		<th width="140"></th>
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
        
		<td class="catalog" ><?php echo $current_first_item ?></td>
		<td ><?php echo html::specialchars($item->title) ?></td>
		<td class="catalog" ><?php echo money::ru($item->wage_level) ?></td>
            <td class="catalog" >
			
                <a class="viewBtn" href="<?php echo url::site(); ?>vacancy/info/id/<?=$item->vacancy_id?>">Посмотреть</a>
                <a class="editBtn" href="<?php echo url::site(); ?>vacancy/edit/id/<?=$item->vacancy_id?>">Редактировать</a>
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить вакансию «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>vacancy/delete/id/<?=$item->vacancy_id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>vacancy/delete/id/<?=$item->vacancy_id?>">Удалить</a>

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
		​Ни одна вакансия не заведёна. Вы можете <a href="/vacancy/add">завести</a> новую вакансию прямо сейчас.
	</p>

<? } ?>