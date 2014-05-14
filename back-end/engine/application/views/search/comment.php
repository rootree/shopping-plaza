<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<? if(count($items)){?>
    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comments/list_items', TRUE),
                                         array('items' => $items, 'pagination' => null, 'count_records' => count($items), 'current_first_item' => 1)); ?>

<? } ?>

