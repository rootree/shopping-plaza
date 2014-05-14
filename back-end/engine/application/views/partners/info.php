<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

 
<table class="form">

    <tr >
        <td class="label"></td>
        <td class="elements topHandler">

            <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
            <a  class="editBtnText" href="<?php echo url::site(); ?>partners/edit/id/<?php echo ($item->partner_id) ?>">Отредактировать</a>

            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить информацию о партнёре «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>pages/delete/id/<?=$item->partner_id?>/');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>pages/delete/id/<?=$item->partner_id?>">Удалить</a>

        </td>
    </tr>

    <tr>
        <td class="label">Описание:</td>
        <td class="elements view">
            <?php echo (!empty($item->annonce) ? ($item->annonce) : "-") ?>
        </td>
    </tr>

    <tr>
        <td class="label">Телефон(ы):</td>
        <td class="elements view">
            <?php echo (!empty($item->tel) ? html::specialchars($item->tel) : "-") ?>
        </td>
    </tr>
    <tr>
        <td class="label">Адрес:</td>
        <td class="elements view">
            <?php echo (!empty($item->address) ? html::specialchars($item->address) : "-") ?>
        </td>
    </tr>
    <tr>
        <td class="label">Факс:</td>
        <td class="elements view">
            <?php echo (!empty($item->fax) ? html::specialchars($item->fax) : "-") ?>
        </td>
    </tr>
    <tr>
        <td class="label">Электронный адрес:</td>
        <td class="elements view">
            <?php echo (!empty($item->mail) ? html::specialchars($item->mail) : "-") ?>
        </td>
    </tr>
    <tr>
        <td class="label">Адрес в Интернете:</td>
        <td class="elements view">
            <?php echo (!empty($item->www) ? html::specialchars($item->www) : "-") ?>
        </td>
    </tr>
           
    <tr >
        <td class="label"></td>
        <td class="elements bottomHandler">

            <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
            <a  class="editBtnText" href="<?php echo url::site(); ?>partners/edit/id/<?php echo ($item->partner_id) ?>">Отредактировать</a>

            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить информацию о партнёре «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>pages/delete/id/<?=$item->partner_id?>/');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>pages/delete/id/<?=$item->partner_id?>">Удалить</a>

        </td>
    </tr>


</table>

 
</center>

<?php } ?>
 