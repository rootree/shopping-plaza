<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_CUPS] & $this->access){ ?>

<td class="side_menu">

<div id="" class="body_left_panel shadow" >

    <b>Игроки:</b>
    <ol id="nav">
        <?PHP if($this->accessRules['index'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == cups_Controller::SUBPAGE_MAIN) { ?>id="selected"<?php } ?> title="История рассылок"  href="<?php echo url::site(); ?>cups">Уже добавленные</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['add'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == cups_Controller::SUBPAGE_ADD) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>cups/add/">Добавить новый чемпионат</a></li>
        <?PHP } ?>
    </ol>
 
</div>

</td>

<?PHP } ?>