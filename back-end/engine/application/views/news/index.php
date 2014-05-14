<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="addOnMenu">
    <a class="addImageBtnText" href="<?php echo url::site(); ?>news/add/">Добавить новость</a>
</div>

<?php if($items->count()) { ?>

    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'news/list_items', TRUE),
             array('items' => $items, 'pagination' => $pagination, 'count_records' => $count_records, 'current_first_item' => $current_first_item)); ?>

<?php }else{ ?>



<? } ?>



<h3 class="help">Пояснение</h3>

<p>Благодаря данному модулю в вашем Интернет-магазине вы сможете размещать новости разного характера. К примеру, новости вашей индустрии, или приход нового товара.
</p>

 
<p>
    Ваш Интернет-магазин превратиться в настоящие СМИ.
</p>


