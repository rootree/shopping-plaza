<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_COMMENTS] & $this->access){ ?>

<td class="side_menu">
 
    <div   class="body_left_panel shadow" >

        <b>Поиск:</b>

        <br/>

        <form action="/dashboard" method="post" id="searchForm">

            <input name="search[word]" class="search" value="<?php echo html::specialchars(@$_POST['search']['word']) ?> " />

            <input type="hidden" name="search[type]"  value="<?=SEARCH_TYPE_COMMENTS?>" >

            <a href="" class="searchBtn" onclick="$('#searchForm' ).submit(); return false;">Начать поиск</a>
        </form>

    </div>

    <div id="" class="body_left_panel shadow" >

        <b>Комментарии по статусам:</b>
        <ol id="nav">

            <li><a <?php if(empty($this->type)) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>comments/">Все</a></li>

            <li><a <?php if($this->type == COMMENT_STATUS_NEW) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>comments/index/type/<?=COMMENT_STATUS_NEW?>">Новые</a></li>
 
            <li><a <?php if($this->type == COMMENT_STATUS_VIEWED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>comments/index/type/<?=COMMENT_STATUS_VIEWED?>">Просмотренные</a></li>

            <li><a <?php if($this->type == COMMENT_STATUS_DELETED) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>comments/index/type/<?=COMMENT_STATUS_DELETED?>">Удалённые</a></li>

        </ol>

    </div>
 
</td>

<?PHP } ?>