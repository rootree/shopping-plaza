<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
 
<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'orders/index', TRUE),
         array('items' => $items)); ?>
