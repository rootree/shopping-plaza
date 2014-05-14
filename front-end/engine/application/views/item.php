<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

 
<div class="notebook">
 
    <? if ($item->status != STATUS_WORK) { ?>
        <div class="errordesc"  id="errorInfo">
            <h4>Внимание! Данные об этом товаре не актуальны.</h4>
            <p class="last-child"><br/>


                     Информация взята из Архива.
            </p>
        </div>
    <? } ?>


    <h2><strong><?=html::specialchars($item->title)?></strong>
        <?=(!empty($item->desc_mini) ? ' ('. html::specialchars($item->desc_mini) . ')' : '')?>
    </h2>


    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="vertical-align:top; width:345px; ">

                <? if ($this->imgs && $this->imgs->count()) { ?>

                    <div class="gallery">

                        <div class="img"><!--<i class="ico-new"></i>-->

                            <?php
 
                                foreach ($this->imgs as $img) {

                                    if($img->favorite != 1){
                                        continue;
                                    }

                                    ?>

                                    <a href="<?php echo SuperPath::get($img->id, true) ?>.jpg" class="highslide"
                                       onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center', captionText: '' })" >
                                        <img src="<?php echo SuperPath::get($img->id, true) ?>b.jpg" alt="Изображение номер  <?=$img->id?>" title="Кликните для увеличения"   /></a>

                                <?php } ?>

                        </div>

                        <div class="preloader" style="display:none;">

                            <?php  foreach ($this->imgs as $img) { ?>

                                <img src="<?php echo SuperPath::get($img->id, true) ?>.jpg" alt="Изображение номер  <?=$img->id?>" title="Кликните для увеличения"   />

                            <?php } ?>

                        </div>

                        <div class="preview">

                            <?php  foreach ($this->imgs as $img) {

                                if($img->favorite == 1){
                                    continue;
                                }

                                ?>

                            <a href="<?php echo SuperPath::get($img->id, true) ?>.jpg" class="highslide"
                               onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center', captionText: '' })" >
                                <img src="<?php echo SuperPath::get($img->id, true) ?>m.jpg" alt="Изображение номер  <?=$img->id?>" title="Кликните для увеличения"   /></a>

                            <?php } ?>

                        </div>
                    </div>

                <?php }else { ?>
                    <br/> 
                    Изображения товара отсутствуют
                <? } ?>

            </td>
 
            <td style="vertical-align:top;" >


            <script type="text/javascript">
                document.clientLink = location.href;
            </script>

				<div style="margin-top: 10px; text-align: right;">
					<?php if (!empty($item->desc)) {?><a class="linker" onclick="location.href=document.clientLink + '#desc_info'; return false;" href="#desc_info">Прочитать описание</a><? }
					?>
					<?php if (isset($comments) && count($comments)) {?><a class="linker" onclick="location.href=document.clientLink + '#commentsList'; return false;" href="#commentsList">Посмотреть комментарии</a><? } ?>
				</div>

                <div class="descriptionBg" ><? if(count($this->fields) > 3) {?><div class="ygol"></div><? } ?>
 
                    <div class="description" >
 
                        <? if ($this->firm->enabled == 1) {  ?>

                            <div class="charInItem" id='RcatalogItemID'
                                 <? if(!isset($items_ses[$item->product_id])) {?>onmouseover='$("#RcatalogItemID").hide("fast"); $("#mainChar").show("fast");'<? } ?>  >

                                <? if(!isset($items_ses[$item->product_id])) {?>

                                    <? if($item->counter < 1 ):  ?>

                                        <? if($this->firm->sales == 2 ):  ?>
                                           <a  href="#store_up" title="" onClick="SPHandler.showCounterMessage(<?=$item->product_id?>, event, 'RScatalogItemID<?=$item->product_id?>'); $('#deliveryMessage').hide(); return false;"><img class="bottomChar"  alt="На заказ" title="На заказ"   src="/img.<?=$this->firm->template?>/icons/order.png"/></a>
                                        <? else : ?>
                                            Нет в наличии
                                        <? endif ?>

                                    <? else : ?>

                                        <a   href="#store_up" title="" onClick="SPHandler.showCounterMessage(<?=$item->product_id?>, event, 'RcatalogItemID'); $('#deliveryMessage').hide(); return false;"><img  alt="Добавить в корзину" title="Добавить в корзину"  src="/img.<?=$this->firm->template?>/icons/add.png"/></a>

                                    <? endif ?>

                                <? }else{   ?>

                                    Товар уже в корзине

                                <? } ?>

                            </div>

                            <div class="charInItem"   style="display: none;" id="mainChar"  >


                               <? if(!isset($items_ses[$item->product_id])) {?>

                                    <? if($item->counter < 1 ):  ?>

                                        <? if($this->firm->sales == 2 ):  ?>
                                           <a  href="#store_up" title="" onClick="SPHandler.showCounterMessage(<?=$item->product_id?>, event, 'RScatalogItemID<?=$item->product_id?>'); $('#deliveryMessage').hide(); return false;"><img class="bottomChar"  alt="На заказ" title="На заказ"   src="/img.<?=$this->firm->template?>/icons/order.png"/></a>
                                        <? else : ?>
                                            Нет в наличии
                                        <? endif ?>

                                    <? else : ?>

                                        <a   href="#store_up" title="" onClick="SPHandler.showCounterMessage(<?=$item->product_id?>, event, 'RcatalogItemID'); $('#deliveryMessage').hide(); return false;"><img  alt="Добавить в корзину" title="Добавить в корзину"  src="/img.<?=$this->firm->template?>/icons/add.png"/></a>

                                    <? endif ?>

                                <? }else{   ?>

                                    Товар уже в корзине

                                <? } ?>

                                
                                <span id="orderForm" >

                                <? if(!isset($items_ses[$item->product_id]) && count($this->delivery)) {?>

 
                                        <div>
                                            <u><a class="itemTitleInList" href="#" onclick="$('#deliveryMessage').toggle(); return false;">Показать цену с доставкой</a></u>
                                        </div>

                                        <div id="deliveryMessage" class="kolvo" style="margin-top:30px ;right: 20px ;display:none; width: 350px; text-align:left; padding-bottom: 0px;">

                                            <div class="ygol2"></div>

                                            <span>

                                                    <?

                                                    foreach ($this->delivery as $cat_val) {

                                                        $prevTotal = (intval($this->totalSum)) ? floatval(str_replace(' ', '', $this->totalSum)) : 0;

                                                        $total = $item->price + $prevTotal + $cat_val->cost;

                                                        ?>

                                                        <p><input id="del_<?php echo $cat_val->del_id ?>" onclick="$('#totalSum').html('<?php echo money::ru($total) ?>');this.selected = true;" type="radio" name="delivery"/>
                                                            <label for="del_<?php echo $cat_val->del_id ?>"><?php
																echo html::specialchars($cat_val->title) ?>
																(<?php echo (!is_null($cat_val->cost) ? 'стоимость:
																<b>'.money::ru($cat_val->cost).'</b>' : 'Рассчитывается индивидуально')
																?>)</label>
                                                        </p>

                                                    <?php } ?>

                                                <hr/>

                                                <div style="padding: 5px;">
                                                    <? if(intval($this->totalSum)) { ?>
                                                        <p>В вашей корзине товара на: <b><?=$this->totalSum?></b></p>
                                                    <? } ?>
                                                    <p>
                                                        Стоимость этого товара: <b><?=money::ru(formula($item)) ?></b>
                                                    </p>
                                                    <p>
                                                        Общая стоимость с доставкой: <b><span id="totalSum" style=" "><i>-- выберите доставку --</i></span></b>
                                                    </p>
                                                </div>

                                            </span>

                                        </div>
 
                                <? } ?>


                                <div  >

                                     <? if($item->counter > 0 ){  ?>
                                        <div class="onStore">Товар в наличии </div>
                                    <? } ?>

                                    <? if(!empty($this->firm->tele) && ($this->firm->sales == 2 || $item->counter > 0)) { ?>
                                        Можете заказать по телефону<br/>
                                        <h4><?=$this->firm->tele?></h4>
                                    <? } ?>

                                </div>

                                <? if($item->counter > 0 || $this->firm->sales == 2  ){  ?>

                                    <hr/>

                                    <div class="quickOrder" >

                                        <h4>Быстрый заказ</h4>

                                        <div style="line-height: normal; margin-bottom: 10px;">
Указываете только ваш номер и имя, <br/>наш менеджер перезвонит вам
                                            </div>
                                        <p>

                                            <input style="color:#666666;"  class="inpt" onfocus="this.style.color = '#000'; if(this.value == 'Ваше имя') this.value = '';" id="quick_user" name="user" type="input" value="<?=(cookie::get('name')) ? cookie::get('name') : 'Ваше имя'?>"/>

                                            <br/>

                                            <input   style="color:#666666;"  class="inpt"  onfocus="this.style.color = '#000'; if(this.value == 'Ваш номер телефона') this.value = '';"  id="quick_phone" name="phone" type="input" value="<?=(cookie::get('phone')) ? cookie::get('phone') : 'Ваш номер телефона' ?>"/>

                                        </p>

                                        <div>
                                            <a href="#" onclick="SPHandler.sendQuickOrder(<?=$item->product_id?>); return false;"><img  alt="Оформить" title="Оформить"  src="/img.<?=$this->firm->template?>/icons/oformit.png"/></a>
                                        </div>

                                    </div>

                                <? } ?>

                                </span>
                                
                                <a class="itemTitleInList" href="#" onclick='$("#RcatalogItemID").show("fast"); $("#mainChar").hide("fast");;return false;'>Скрыть/Показать форму заказа</a>


                            </div>



                        <? } ?>
                        
                        <table border="0" cellspacing="0" cellpadding="0" class="paramDesc" >

                            <col class="col1"/>
                            <col class="col2"/>

                            <tr>
                                <td class="padd2"><p><b>Цена:</b></p></td>
                                <td class="price mrg">
                                    <p><b><?=money::ru(formula($item)) ?></b></p>
                                </td>
                            </tr>

                            <? if ($this->fields && $this->fields->count()) { $countra = 0;?>
 
                            <?php  foreach ($this->fields as $field) {

                                if(empty($field->field_value)){
                                    continue;
                                }
                                
                                $countra++;

                                ?>

                                <tr >
                                    <td <? if($countra % 2 == 0){?> class="itemParam" <?}?>><p><b><?php echo @html::specialchars($field->title) ?>:</b></p></td>
                                    <td class="<? if($countra % 2 == 0){?> itemParam  <?}?>mrg"><p>
                                        <?php echo @html::specialchars($field->field_value) ?>
                                    </p></td>
                                    <td></td>
                                </tr>

                                <?php } ?>
 
                            <?php } ?>

                        </table>



                    </div><!--description-->

                </div>
  
            </td>
        </tr>
    </table>



    <div style="float: right;" >
		<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
		<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div>
    </div>

    <div class="textInfo" id="desc_info" >
        <?php echo  ($item->desc) ?>

        <? if($item->cat_id == 53): ?>
            
                                <? foreach ($this->imgs as $img) {

                                    if($img->favorite != 1){
                                        continue;
                                    }

                                    ?>
<br/><br/>
                                    <a href="<?php echo SuperPath::get($img->id, true) ?>.jpg" class="highslide"
                                       onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center', captionText: '' })" >
                                        <img src="<?php echo SuperPath::get($img->id, true) ?>b.jpg" alt="Изображение номер  <?=$img->id?>" title="Кликните для увеличения"   /></a>

                                <?php } ?>

            <br/>Фотография "<?=$item->title ?>"

        <? endif;?>

           <br/>
    <br/>
		<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
		<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div>

    </div>
 
 
    <br/>


    <? if(count($this->satellites)){ ?>

        <div class="new" id="satellites"  >

            <h2>Возможно вам понадобятся следующие товары</h2>

            <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'product_list/list', TRUE),
                array('items' => $this->satellites, 'items_ses' => isset($items_ses) ? $items_ses : array())); ?>

        </div>

    <? } ?>

    <? if(count($this->recommends)){ ?>

        <div class="new"  >

            <h2>Обратите внимание на следующие товары</h2>

            <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'product_list/list', TRUE),
                 array('items' => $this->recommends, 'items_ses' => isset($items_ses) ? $items_ses : array())); ?>

        </div>

    <? } ?>


    <? if($this->commentsEnabled){ ?>

        <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comment/list', TRUE),
                array('items' => $comments)); ?>

        <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comment/form', TRUE),
                array('type' => COMMENT_ON_ITEMS, 'id' => $item->product_id)); ?>

    <? } ?>

</div><!--l-side-->