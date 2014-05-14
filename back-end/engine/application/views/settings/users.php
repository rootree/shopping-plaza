<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>



<?php

if(count($items)) { ?>

<?php echo $pagination ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th width="20">№</th>
        <th>Имя</th>
        <th>Электронный адрес</th>
        <!--<th>Роль</th>-->
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
        <td class="catalog" ><?php echo $current_first_item ?></td>
        <td class="catalog" width="150"><?php echo html::specialchars($item->user_name) ?> <?=($item->user_mail == $this->user->user_mail ? '<small><nobr>(это вы)</nobr></small>' : '')?></td>
        <td><?php echo html::specialchars($item->user_mail) ?></td>
        <!--<td class="catalog" width="180"><?php echo status::admin($item->user_right) ?></td>-->
        <td>
            <a class="editBtn" href="<?php echo url::site(); ?>settings/useredit/id/<?php echo ($item->user_id) ?>">Редактировать</a>
            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить администратора Интернет-магазина по имени <?php echo html::specialchars($item->user_name) ?>?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>settings/userdelete/id/<?php echo ($item->user_id) ?>');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>settings/userdelete/id/<?php echo ($item->user_id) ?>">Удалить</a>
 
        </td>
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<?php echo $pagination ?>

<?php } ?>





<h3 class="help">Пояснение</h3>

<p>Для разграничения обязанностей, и ускорения работы с покупателями и содержимым магазина есть возможность
    управлять магазином нескольким пользователям. Достаточно выслать приглашение по электронной почте новому
    управляющему, и он тут же может помогать вам разбираться с заказами.
</p>


    