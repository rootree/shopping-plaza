<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_CALLBACK] & $this->access){ ?>

<td class="side_menu">
 

    <div id="" class="body_left_panel shadow" >

        <b>Сообщения по статусам:</b>
        <ol id="nav">

            <li><a <?php if(empty($this->type)) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>callback/">Все</a></li>

            <li><a <?php if($this->type == CALLBACK_STATUS_NEW) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>callback/index/type/<?=CALLBACK_STATUS_NEW?>">Новые</a></li>
 
            <li><a <?php if($this->type == CALLBACK_STATUS_PROCEEDED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>callback/index/type/<?=CALLBACK_STATUS_PROCEEDED?>">Обработанные</a></li>

            <li><a <?php if($this->type == CALLBACK_STATUS_CANCEL) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>callback/index/type/<?=CALLBACK_STATUS_CANCEL?>">Проигнорированные</a></li>

        </ol>

    </div>
 
</td>

<?PHP } ?>