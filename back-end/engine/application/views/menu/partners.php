<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_VACANCY] & $this->access){ ?>

<td class="side_menu">

<div id="" class="body_left_panel shadow" >

    <b>Поиск:</b><br/>
    <form action="/dashboard" method="post" id="searchForm">

        <input name="search[word]" class="search" value="<?php echo html::specialchars(@$_POST['search']['word']) ?> " />

        <input type="hidden" name="search[type]"  value="<?=SEARCH_TYPE_PARTNER?>" >

        <a href="" class="searchBtn" onclick="$('#searchForm' ).submit(); return false;">Начать поиск</a>
        
    </form>
     
</div>

<div id="" class="body_left_panel shadow" >
 
    <ol id="nav">
        <?PHP if($this->accessRules['index'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Partners_Controller::SUBPAGE_MAIN) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>partners">Все партнёры</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['add'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Partners_Controller::SUBPAGE_ADD) { ?>id="selected"<?php } ?> href="<?php echo url::site(); ?>partners/add/">Добавить нового</a></li>
        <?PHP } ?>
    </ol>
 
</div>

</td>

<?PHP } ?>