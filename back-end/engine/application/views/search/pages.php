<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

 
<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'pages/list_items', TRUE),
         array('items' => $items, 'pagination' => null,  'current_first_item' => 1)); ?>
 