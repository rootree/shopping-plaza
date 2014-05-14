<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($items->count()) { ?>


<? if(isset($pagination)) { ?>
     <?php echo $pagination ?>
<? } ?>

	<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comments/list_items', TRUE),
		 array('items' => $items, 'pagination' => $pagination, 'count_records' => $count_records, 'current_first_item' => $current_first_item)); ?>

<?php }else{ ?>

    <p  style="margin-top: 0px;">На данный коментариев нет.</p>

<? } ?>


<? if(isset($pagination)) { ?>
     <?php echo $pagination ?>
<? } ?>