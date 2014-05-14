<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

 
<table class="form">

    <tr >
        <td class="label"></td>
        <td class="elements topHandler">

            <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
            <a  class="editBtnText" href="<?php echo url::site(); ?>pages/edit/id/<?php echo ($item->page_id) ?>">Отредактировать</a>

            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить страницу «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>pages/delete/id/<?=$item->page_id?>/');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>pages/delete/id/<?=$item->page_id?>">Удалить</a>
            <a  target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/pages/index/id/<?php echo ($item->page_id) ?>">Посмотреть на сайте</a>

        </td>
    </tr>

    <tr>
        <td class="label">Содержание:</td>
        <td class="elements view">
            <?php echo ($item->content) ?>
        </td>
    </tr>
 
    <tr >
        <td class="label"></td>
        <td class="elements bottomHandler">

            <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
            <a  class="editBtnText" href="<?php echo url::site(); ?>pages/edit/id/<?php echo ($item->page_id) ?>">Отредактировать</a>
 
            <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить страницу «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>pages/delete/id/<?=$item->page_id?>/');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>pages/delete/id/<?=$item->page_id?>">Удалить</a>
            <a  target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/pages/index/id/<?php echo ($item->page_id) ?>">Посмотреть на сайте</a>

        </td>
    </tr>
     

</table>

 
</center>

<?php } ?>
 