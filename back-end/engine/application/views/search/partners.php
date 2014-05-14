<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'partners/list_items', TRUE),
         array('items' => $items, 'pagination' => null, 'count_records' => count($items), 'current_first_item' => 1)); ?>

