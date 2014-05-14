<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>



<?php
 
if($items->count()) { ?>

<?php echo $pagination ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
       <!--  <th>Дата создания</th>-->
        <th>Уровень</th>
        <th style="background-color: #cccccc;">Опыт до следущего</th>
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
        <td ><a href="<?php echo url::site(); ?>levels/edit/id/<?php echo ($item->level) ?>"><?php echo html::specialchars($item->level) ?></a></td>
        <td class="catalog" width="320"><?php echo html::specialchars($item->nextExperiance) ?></td>
        
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>
 <?php echo $pagination ?>
<?php } ?>

