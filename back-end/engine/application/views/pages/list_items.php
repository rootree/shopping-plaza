<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
  
<?php if($items->count()) { ?>

<?php echo $pagination ?>
 
<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th>Заголовок страницы</th>
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
 

            <td class="catalog">
                <a class="viewBtn" href="<?php echo url::site(); ?>pages/info/id/<?=$item->page_id?>">Посмотреть</a>
                <a class="editBtn" href="<?php echo url::site(); ?>pages/edit/id/<?=$item->page_id?>">Редактировать</a>
                <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить страницу «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>pages/delete/id/<?=$item->page_id?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>pages/delete/id/<?=$item->page_id?>">Удалить</a>
                <a  target="_blank" class="viewOnSiteBtn" href="http://<?=$this->firm->domain?>/pages/index/id/<?php echo ($item->page_id) ?>">Посмотреть на сайте</a>
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