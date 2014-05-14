<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_VACANCY] & $this->access){ ?>

<td class="side_menu">

    <div id="" class="body_left_panel shadow" >
        
        <b>Поиск:</b>

        <br/>

        <form action="/dashboard" method="post" id="searchForm">

            <input name="search[word]" class="search" value="<?php echo html::specialchars(@$_POST['search']['word']) ?> " />

            <input type="hidden" name="search[type]"  value="<?=SEARCH_TYPE_PRODUCTS?>" > 

            <a href="" class="searchBtn" onclick="$('#searchForm' ).submit(); return false;">Начать поиск</a>
        </form>

    </div>

    <div id="" class="body_left_panel shadow" >

        <ol id="nav">

            <li><a <?php if($selected_subpage == Products_Controller::SUBPAGE_ADD) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/add/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>">Добавить продукт</a></li>
            <li>
                <a <?php if($selected_subpage == Products_Controller::SUBPAGE_IMPORT) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/import/">Обновление из файла</a>
            </li>

            <li>
                <a <?php if($selected_subpage == Products_Controller::SUBPAGE_IMPORT_YML) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/yml/">Обновление из YML</a>
            </li>

            <li><a <?php if($selected_subpage == Products_Controller::SUBPAGE_JUNKYARD) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/junkyard/">Неотсортированный товар</a></li>
 
            <li><a onclick="SPAdmin.showConfirmMessage('Формирование прайс-листа', 'Старый прайс-лист будет удалён. Сформировать новый прайс-лист?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>products/excel/');}); return false;"   <?php if($selected_subpage == Products_Controller::SUBPAGE_EXCEL) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/excel/">Сформировать прайс-лист</a></li>

            <li><a <?php if($selected_subpage == Products_Controller::SUBPAGE_YANDEX) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/yandex/">YML-формат (Яндекс.Маркет)</a></li>

			<? if($this->catssubid){?>
            	<li><a href="<?php echo url::site(); ?>settings/fields/catsubid/<?=$this->catssubid?>">Характеристики товара</a></li>
            	<li><a href="<?php echo url::site(); ?>settings/fieldsadd/catsubid/<?=$this->catssubid?>">Добавить характеристку</a></li>
			<? } ?>

        </ol>

    </div>

        <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'menu/products_plan', TRUE), array('selected_subpage' => $this->selected_subpage)); ?>
 
        
    </td>

<?PHP } ?>

