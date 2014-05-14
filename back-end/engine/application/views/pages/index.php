<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="addOnMenu">

    <a class="addImageBtnText" href="<?php echo url::site(); ?>pages/add/">Добавить страницу</a>

</div>
    
<?php if($items->count()) { ?>

    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'pages/list_items', TRUE),
             array('items' => $items, 'pagination' => $pagination, 'count_records' => $count_records, 'current_first_item' => $current_first_item)); ?>
 
<?php }else{ ?>

    

<? } ?>





<h3 class="help">Пояснение</h3>

<p>
    Очень полезный модуль для размещения дополнительной информации.
</p>


<p>


Вы с лёгкостью сможете размещать страницы в вашем магазине. Богатый функционал редактора страниц позволит создавать страницы любой сложности. При этом вы будете видеть результат ваших изменений тут же.
</p>