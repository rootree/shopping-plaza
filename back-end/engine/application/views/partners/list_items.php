<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($items->count()) { ?>

<?php echo $pagination ?>
 
<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th>Наименовение парьнёра</th>
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
        
        <td class="catalog" width="20"><?php echo $current_first_item ?></td>
        <td ><?php echo html::specialchars($item->title) ?></td>
            <td class="catalog" >

                <a class="viewBtn" href="<?php echo url::site(); ?>partners/info/id/<?=$item->partner_id?>">Посмотреть</a>
                <a class="editBtn" href="<?php echo url::site(); ?>partners/edit/id/<?=$item->partner_id?>">Редактировать</a>
             
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить информацию о партнёре «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>partners/delete/id/<?=$item->partner_id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>partners/delete/id/<?=$item->partner_id?>">Удалить</a>

            </td>
        
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>
 
<?php echo $pagination ?>

<?php }else{ ?>

    

<? } ?>