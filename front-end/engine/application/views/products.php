<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="podtv">

<h2><?=$this->title?></h2>

<? if(isset($this->cat) && !isset($this->catSub) && strlen($this->cat->desc) > 4) { ?>
    <div class="podtv" id="news_content" style="border: 0px; padding: 0px;"><?=$this->cat->desc?></div><br/>
<? } ?>

<? if(isset($this->catSub) && strlen($this->catSub->desc) > 4) { ?>
    <div class="podtv" id="news_content" style="border: 0px; padding: 0px;"><?=$this->catSub->desc?></div><br/>
<? } ?>
    
</div>

<div class="new">

<? if(count($items)) { ?>

<span style="display:block; margin-bottom: 18px;" class="naviIE">

    <span style="float:left; display:block;">
        <?=$pagination?>
    </span>
    
    <? if (isset($this->sortBy)) {?>

            <a name="items"></a>

            <p style="text-align:right; margin-bottom: 10px; display:block;">
    Сортировать по:

            <a <?=(isset($this->sortBy) && $this->sortBy == 'price asc') ? 'style="font-weight: bold;"':''?> href="<?=$_SERVER['PATH_INFO']?>?sortBy=priceUp#items">возрастающей</a> / <a <?=(isset($this->sortBy) && $this->sortBy == 'price desc') ? 'style="font-weight: bold;"':''?> href="<?=$_SERVER['PATH_INFO']?>?sortBy=priceDown#items">убывающей</a> цене,

            <a <?=(isset($this->sortBy) && $this->sortBy == 'viewed asc') ? 'style="font-weight: bold;"':''?> href="<?=$_SERVER['PATH_INFO']?>?sortBy=ratingUp#items">возрастающей</a> / <a <?=(isset($this->sortBy) && $this->sortBy == 'viewed desc') ? 'style="font-weight: bold;"':''?> href="<?=$_SERVER['PATH_INFO']?>?sortBy=ratingDown#items">убывающей</a> популярности или

            по <a <?=(isset($this->sortBy) && $this->sortBy == 'title asc') ? 'style="font-weight: bold;"':''?> href="<?=$_SERVER['PATH_INFO']?>?sortBy=title#items">названию</a> товара
         </p>
    <? } ?>

</span>

<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'product_list/list', TRUE),
    array('items' => $items, 'items_ses' => isset($items_ses) ? $items_ses : array())); ?>
 
<?=$pagination?>

<? }else {?>
    Данная категория пуста
<? }?>

</div>