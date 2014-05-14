<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_VACANCY] & $this->access){ ?>

<td class="side_menu">

    <div id="" class="body_left_panel shadow" >
        <b>Поиск:</b><br/>

        <form action="/dashboard" method="post" target="_self" id="searchForm">

            <input name="search[word]" class="search" value="<?php echo html::specialchars(@$_POST['search']['word']) ?>" />

            <a href="" class="searchBtn" onclick="$('#searchForm' ).submit(); return false;">Начать поиск</a>

            <input type="hidden" name="search[type]"  value="<?=SEARCH_TYPE_NEWS?>" >

        </form>
    </div>

    <div id="" class="body_left_panel shadow" >

        <b>Меню:</b>
        <ol id="nav">
            <?PHP if($this->accessRules['index'] & $this->access){ ?>
                <li><a <?php if($selected_subpage == News_Controller::SUBPAGE_MAIN) { ?>id="selected"<?php } ?> title="Перейте к списку новостей"  href="<?php echo url::site(); ?>news">Список новостей</a></li>
            <?PHP } ?>
            <?PHP if($this->accessRules['add'] & $this->access){ ?>
                <li><a <?php if($selected_subpage == News_Controller::SUBPAGE_ADD) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>news/add/">Добавить новость</a></li>
            <?PHP } ?>
        </ol>

    </div>

</td>

<?PHP } ?>