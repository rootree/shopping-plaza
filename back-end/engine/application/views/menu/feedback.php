<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_FEEDBACK] & $this->access){ ?>

<td class="side_menu">
 
    <div id="" class="body_left_panel shadow" >
        <b>Поиск:</b>

        <form action="/dashboard" method="post" target="_self" id="searchForm">

            <input name="search[word]" class="search" value="<?php echo html::specialchars(@$_POST['search']['word']) ?>" />

            <a href="" class="searchBtn" onclick="$('#searchForm' ).submit(); return false;">Начать поиск</a>

            <input type="hidden" name="search[type]"  value="<?=SEARCH_TYPE_FEEDBACK?>" >

        </form>

    </div>

    <div id="" class="body_left_panel shadow" >

        <b>Сообщения по статусам:</b>
        <ol id="nav">

            <li><a <?php if(empty($this->type)) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>feedback">Все</a></li>

            <li><a <?php if($this->type == FEEDBACK_STATUS_NEW) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>feedback/index/type/<?=FEEDBACK_STATUS_NEW?>">Новые</a></li>

            <li><a <?php if($this->type == FEEDBACK_STATUS_VIEWED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>feedback/index/type/<?=FEEDBACK_STATUS_VIEWED?>">Просмотренные</a></li>
     
            <li><a <?php if($this->type == FEEDBACK_STATUS_PROCEEDED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>feedback/index/type/<?=FEEDBACK_STATUS_PROCEEDED?>">Обработанные</a></li>

            <li><a <?php if($this->type == FEEDBACK_STATUS_CANCEL) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>feedback/index/type/<?=FEEDBACK_STATUS_CANCEL?>">Проигнорированные</a></li>

        </ol>

    </div>
 
</td>

<?PHP } ?>