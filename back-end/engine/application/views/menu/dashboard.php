<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_DASHBOARD] & $this->access){ ?>

<td class="side_menu">

    <div id="" class="body_left_panel shadow" >

        <b>Перейти к добавлению:</b>
        <ol id="nav">

            <?PHP if(($GLOBALS['ACCESS'][PAGE_VACANCY] & $this->access && $this->firm->show & SHOW_ON_SITE_VACANCY)){ ?>
            <li><a title="On-"  href="/vacancy/add/">Вакансий</a></li>
            <?PHP } ?>

            <?PHP if(($GLOBALS['ACCESS'][PAGE_NEWS] & $this->access && $this->firm->show & SHOW_ON_SITE_NEWS)){ ?>
            <li><a title=""   href="/news/add/">Новостей</a></li>
            <?PHP } ?>

            <?PHP if(($GLOBALS['ACCESS'][PAGE_PARTNERS] & $this->access && $this->firm->show & SHOW_ON_SITE_PARTNERS)){ ?>
            <li><a title="On-"  href="/partners/add/">Партнёров</a></li>
            <?PHP } ?>

            <?PHP if(($GLOBALS['ACCESS'][PAGE_PAGES] & $this->access && $this->firm->show & SHOW_ON_SITE_PAGES)){ ?>
            <li><a title="On-"  href="/pages/add/">Страниц</a></li>
            <?PHP } ?>

            <li><a title="On-"  href="/products/add/catid/0/catssubid/0">Нового товара</a></li>
        </ol>

    </div>

    <div id="" class="body_left_panel shadow" >
 
        <b>Поиск:</b><br/>

        <form action="/dashboard" method="post"  id="searchForm">

            <input name="search[word]" class="search" value="<?php echo (@trim($_POST['search']['word'])) ?> " />
            <a href="" class="searchBtn" onclick="$('#searchForm' ).submit(); return false;">Начать поиск</a>

            <br/>
            <br/>

            <?PHP if(($GLOBALS['ACCESS'][PAGE_VACANCY] & $this->access && $this->firm->show & SHOW_ON_SITE_VACANCY)){ ?>
            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_VACANCY) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_VACANCY?>" > поиск по вакансиям</label><br/>

            <?PHP } ?>

            <?PHP if(($GLOBALS['ACCESS'][PAGE_NEWS] & $this->access && $this->firm->show & SHOW_ON_SITE_NEWS)){ ?>
            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_NEWS) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_NEWS?>" > поиск в новостях</label><br/>

            <?PHP } ?>

            <?PHP if(($GLOBALS['ACCESS'][PAGE_PARTNERS] & $this->access && $this->firm->show & SHOW_ON_SITE_PARTNERS)){ ?>
            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_PARTNER) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_PARTNER?>" > поиск в партнёрах</label><br/>

            <?PHP } ?>

            <?PHP if(($GLOBALS['ACCESS'][PAGE_PAGES] & $this->access && $this->firm->show & SHOW_ON_SITE_PAGES)){ ?>
            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_PAGES) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_PAGES?>" > поиск на страницах</label><br/>

            <?PHP } ?>

            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_PRODUCTS) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_PRODUCTS?>" > поиск по товарам</label><br/>
            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_ORDER) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_ORDER?>" > поиск по номеру заказа</label><br/>
            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_FEEDBACK) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_FEEDBACK?>" > поиск в сообщениях</label><br/>
            <label><input type="radio" name="search[type]"  <?php echo (isset($_POST['search']['type']) && $_POST['search']['type'] == SEARCH_TYPE_COMMENTS) ? 'checked="checked"' : "" ?>  value="<?=SEARCH_TYPE_COMMENTS?>" > поиск в комментариях</label><br/>

        </form>

    </div>

</td>

<?PHP } ?>