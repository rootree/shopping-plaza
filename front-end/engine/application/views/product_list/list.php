<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>



<? foreach ($items as $key ){   ?>

    <div style=" height: 125px;  padding-left: 15px;">
	 
        <? if(!empty($key->img) || (isset($key->imgSearch) && !empty($key->imgSearch))){ ?>
            <span style="cursor:pointer;" onclick='location.href = "/products/item/title/<?=$key->url_link?>"; '>
	            <span title="<?=html::specialchars($key->title)?>" class="screenshot" rel="<?=  SuperPath::get($key->source == 0 || !isset($key->imgSearch) ? $key->img : $key->imgSearch, true)?>b.jpg" id="photoclip" style="background: url(<?=  SuperPath::get($key->source == 0 || !isset($key->imgSearch) ? $key->img : $key->imgSearch, true)?>m.jpg) center; background-repeat: no-repeat;" >
		        </span>
            </span>
        <? } ?>
	 
        <p style=" padding-left: 130px;">
            <a class="itemTitleInList" href="/products/item/title/<?=$key->url_link?>"><?=html::specialchars($key->title)?></a>
            <?=(!empty($key->desc_mini) ? '<br/><br/>'. html::specialchars($key->desc_mini) : '')?>
        </p>
 
        <div class="buy"  style=" padding-left: 130px;">

            <? if ($this->firm->enabled == 1) { ?>

                <p class="cost" id="catalogItemID<?=$key->product_id?>" >

                    <? if(!isset($items_ses[$key->product_id])) {?>

                        <? if($key->counter < 1 ):  ?>

                            <? if($this->firm->sales == 2 ):  ?>

                                <a href="#store_up" title="" onClick="SPHandler.showCounterMessage(<?=$key->product_id?>, event, 'catalogItemID<?=$key->product_id?>'); return false;"><img  alt="Заказать" title="Заказать" src="img.<?=$this->firm->template?>/icons/order.png"/></a>
                                <b><?=money::ru(formula($key))?></b>
                                <div class="notEnouth">Нет в наличии</div>

                            <? else : ?>

                                <b><?=money::ru(formula($key))?></b>
                                <div class="notEnouth">Нет в наличии</div>

                            <? endif ?>

                        <? else : ?>

                            <a href="#store_up" title="" onClick="SPHandler.showCounterMessage(<?=$key->product_id?>, event, 'catalogItemID<?=$key->product_id?>'); return false;"><img  alt="Добавить в корзину" title="Добавить в корзину"   src="img.<?=$this->firm->template?>/icons/add.png"/></a>
                            <b><?=money::ru(formula($key))?></b>

                         <? endif ?>

                    <? }else{   ?>
                         Товар уже в корзине
                    <? } ?>

                </p>

            <? } ?>
            
            <p><a class="news-link" href="/products/item/title/<?=$key->url_link?>">Подробное описание</a></p>

        </div>
    </div>

<?  } ?>

