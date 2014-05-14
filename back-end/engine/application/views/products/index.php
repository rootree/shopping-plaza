<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<div id="addOnMenu">

    <a class="addImageBtnText" href="<?php echo url::site(); ?>products/add/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>">Добавить товар</a>

    <a title="Переключение между режимоми отображения товаров (С изображениями/Без изображений)" class="viewMode" href="?changeViewMode">Изменить отображение</a>

</div>

<?php if($items->count()) { ?>

    <? if($this->productView == PRODUCTS_VIEW_LIST) { ?>
            
        <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'products/list_items', TRUE),
                 array('items' => $items, 'pagination' => $pagination, 'count_records' => $count_records, 'current_first_item' => $current_first_item)); ?>

    <? }else{ ?>

        <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'products/list_pic_items', TRUE),
                 array('items' => $items, 'pagination' => $pagination, 'count_records' => $count_records, 'current_first_item' => $current_first_item)); ?>

    <? } ?>

<?php }else{ ?>

<p  style="margin-top: 0px;">
    Данная категория товар на данный момент пуста.
</p>

<? } ?>






<h3 class="help">Пояснение</h3>



<p>
Мы сделали всё возможное, чтобы управление карточками товаров было как можно эффективно и просто.
</p><p>
Добавить или отредактировать информацию о товаре в панели управления очень просто. Вы сможете указать название товара, краткое описание, цену. Так же есть возможность сделать расширенное описание, в котором можно сделать форматирование текста, выделять его цветами, вставлять изображения, таблицы.
</p><p> 
К каждому товару можно прикреплять изображения. Из нескольких вариантов изображения, можно назначить основное, оно будет показываться в списках товаров.
  </p>

