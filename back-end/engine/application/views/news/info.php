<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>
 
    <table class="form">

        <tr >
            <td class="label"></td>
            <td class="elements topHandler ">

                <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>
                <a  class="editBtnText" href="<?php echo url::site(); ?>news/edit/id/<?php echo ($item->news_id) ?>">Отредактировать</a>
                <a  onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить новость «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>news/delete/id/<?=$item->news_id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>news/delete/id/<?=$item->news_id?>">Удалить</a>
                <a  target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/news/index/item/<?php echo ($item->news_id) ?>/return_page/1">Посмотреть на сайте</a>

            </td>
        </tr>

        <tr>
            <td class="label">Анонс:</td>
            <td class="elements topHandler view">
                <?php echo @html::specialchars($item->annonce) ?>
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
                <a  class="editBtnText" href="<?php echo url::site(); ?>news/edit/id/<?php echo ($item->news_id) ?>">Отредактировать</a>
                <a  onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить новость «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>news/delete/id/<?=$item->news_id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>news/delete/id/<?=$item->news_id?>">Удалить</a>
                <a  target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/news/index/item/<?php echo ($item->news_id) ?>/return_page/1">Посмотреть на сайте</a>

            </td>
        </tr>

    </table>


</center>

<?php } ?>
 