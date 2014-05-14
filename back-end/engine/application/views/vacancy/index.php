<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="addOnMenu">

    <a class="addImageBtnText" href="<?php echo url::site(); ?>vacancy/add/">Добавить партнёра</a>

</div>

<?php if($items->count()) { ?>

    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'vacancy/list_items', TRUE),
             array('items' => $items, 'pagination' => $pagination, 'count_records' => $count_records, 'current_first_item' => $current_first_item)); ?>

<?php }else{ ?>



<? } ?>