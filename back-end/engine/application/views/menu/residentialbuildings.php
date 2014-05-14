<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_LEVELS] & $this->access){ ?>

<td class="side_menu">

<div id="" class="body_left_panel shadow" >

    <b>Меню:</b>
    <ol id="nav">
        <?PHP if($this->accessRules['index'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Residentialbuildings_Controller::SUBPAGE_MAIN) { ?>id="selected"<?php } ?> title="История рассылок"  href="<?php echo url::site(); ?>residentialbuildings">Все дома</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['add'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Residentialbuildings_Controller::SUBPAGE_ADD) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>residentialbuildings/add/">Добавить новый дом</a></li>
        <?PHP } ?>
    </ol>
 
</div>

</td>

<?PHP } ?>