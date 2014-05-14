<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

        <? if ($this->imgs && $this->imgs->count()) { ?>
            <?php  foreach ($this->imgs as $img) { ?>
                <? if($img->favorite == 1) { ?>

                    <div class="productImage"><br/><br/><br/>
                        <a href="<?php echo SuperPath::get($img->id, true) ?>.jpg" class="highslide"
                            onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center'  })">
                            <img style="border: 2px #6495ed  solid  ;" src="<?php echo SuperPath::get($img->id, true) ?>m.jpg" alt="Номер <?=$img->id?>" title="Увеличить изображение" /></a>
                    </div>
                <? } ?>
            <?php } ?>
        <?php } ?>


<center>

        <table class="form">
            
            <tr >
                 
                <td class="elements topHandler " colspan="2">
                     
                    <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>

                    <? if($item->status != STATUS_DELETED) { ?>
                        <a  class="editBtnText" href="<?php echo url::site(); ?>products/edit/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Отредактировать</a>

                        <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить товар «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>products/delete/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>products/delete/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Удалить</a>

                        <a target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/products/item/id/<?php echo ($item->product_id) ?>/">Посмотреть на сайте</a>
                        <a target="_blank" class="printTextBtn" href="<?php echo url::site(); ?>products/printer/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Распечатать</a>
                    
                        <a class="powerTextBtn" href="<?php echo url::site(); ?>products/info/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/?<?= (($item->status == STATUS_WORK) ? 'pleaseHide' : 'pleaseShow') ?>"><?= (($item->status == STATUS_WORK) ? 'Скрыть' : 'Показать') ?></a>
                    <? } ?>
                    
                </td>
            </tr>

            <tr>
                <td class="label">Основная категория:</td>
                <td class="elements view">
                    <? foreach ($this->cats as $itemCat) { ?>

                        <?php if($this->catid == $itemCat->cat_id) { ?>
                            <?php echo ($itemCat->title) ?>
                        <?php break; } ?>

                    <?php } ?>
                </td>
            </tr>

            <tr>
                <td class="label">Дополнительная:</td>
                <td class="elements view">
                    <? foreach ($this->catssub as $itemCat) { ?>

                        <?php if($this->catssubid == $itemCat->catsub_id) { ?>
                            <?php echo ($itemCat->title) ?>
                        <?php break; } ?>

                    <?php } ?>
                </td>
            </tr>

            <tr>
                <td class="label"></td>
                <td class="elements view">
                    <hr/>
                </td>
            </tr>

            <tr>
                <td class="label">Артикул:</td>
                <td class="elements view">
                    <?php echo html::specialchars($item->arcitule) ?>
                </td>
            </tr>

            <tr>
                <td class="label">Статус:</td>
                <td class="elements view">
                    <? if(STATUS_HIDE == $item->status){?>
                        <span style="background-color: #E2E1E1">
                    <? } ?>
                    <?php echo $GLOBALS['ITEM_STATUS'][($item->status)] ?>
                    <? if(STATUS_HIDE == $item->status){?>
                       </span>
                    <? } ?>
                </td>
            </tr>

            <tr>
                <td class="label">Кол-во:</td>
                <td class="elements view">
                    <?php echo ($item->counter) ?>
                </td>
            </tr>

            <tr>
                <td class="label">Цена:</td>
                <td class="elements view">
                    <?php echo money::ru($item->price) ?>
                </td>
            </tr>


            <? if($this->firm->prices){?>

                <? if(isset($this->firm->prices->enabled) && $this->firm->prices->enabled & 1){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price1)?>:</td>
                        <td class="elements view">
                            <?php echo money::ru($item->price1) ?>
                        </td>
                    </tr>
                <? }?>

                <? if(isset($this->firm->prices->enabled) && $this->firm->prices->enabled & 2){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price2)?>:</td>
                        <td class="elements view">
                             <?php echo money::ru($item->price2) ?>
                        </td>
                    </tr>
                <? }?>

                <? if(isset($this->firm->prices->enabled) && $this->firm->prices->enabled & 4){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price3)?>:</td>
                        <td class="elements view">
                             <?php echo money::ru($item->price3) ?>
                        </td>
                    </tr>
                <? }?>

                <? if(isset($this->firm->prices->enabled) && $this->firm->prices->enabled & 8){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price4)?>:</td>
                        <td class="elements view">
                             <?php echo money::ru($item->price4) ?>
                        </td>
                    </tr>
                <? }?>

                <? if(isset($this->firm->prices->enabled) && $this->firm->prices->enabled & 16){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price5)?>:</td>
                        <td class="elements view">
                             <?php echo money::ru($item->price5) ?>
                        </td>
                    </tr>
                <? }?>

            <? }?>

            <? if(isset($relative) && $relative->product_id){ ?>

                <tr>
                    <td class="label">Источник описания:</td>
                    <td class="elements view">
                       <a href="/products/info/catid/<?=$relative->cat_id?>/catssubid/<?=$relative->catsub_id?>/id/<?=$relative->product_id?>/"><?=$relative->title?></a>
                    </td>
                </tr>

            <? } ?>

            <tr>
                <td class="label">Основные-характеристики:</td>
                <td class="elements view">
                    <?php echo  ($item->desc_mini) ?>
                </td>
            </tr>

            <tr>
                <td class="label">Описание:</td>
                <td class="elements view">
                    <?php echo  ($item->desc) ?>
                </td>
            </tr>
 
            <tr>
                <td class="label">Новый товар:</td>
                <td class="elements view">
                    <?= ($item->new == 1) ? "Да" : "-"; ?>
                </td>
            </tr>
            <tr>
                <td class="label">Товар недели:</td>
                <td class="elements view">
                    <?= ($item->week == 1) ? "Да" : "-"; ?>
                </td>
            </tr>
            <tr>
                <td class="label">Уникальное предложение:</td>
                <td class="elements view">
                    <?= ($item->unic == 1) ? "Да" : "-"; ?>
                </td>
            </tr>


            
            <tr>
                <td class="label">Скидка:</td>
                <td class="elements view">
                    <?php echo @html::specialchars($item->discount) ?>%
                </td>
            </tr>

            <tr>
                <td class="label">Вес в упаковке:</td>
                <td class="elements view">
                    <?php echo @html::specialchars($item->weight) ?> грамм
                </td>
            </tr>
 
            <? if ($this->fields && $this->fields->count()) { ?>

            <tr>
                <td class="label"></td>
                <td class="elements view">
                    <hr/>
                </td>
            </tr>

            <?php  foreach ($this->fields as $field) { ?>

                <tr>
                    <td class="label"><?php echo @html::specialchars($field->title) ?>:</td>
                    <td class="elements view">
                        <?php echo @html::specialchars($field->field_value) ?>
                        <? if($field->excel == 1) { ?>
                            <div class="smallInfo">Экспортируеться в Excel</div>
                        <? } ?>
                    </td>
                </tr>

                <?php } ?>

            <?php } ?>

 
            <tr>
                <td class="label"></td>
                <td class="elements">
                    <hr/>
                </td>
            </tr>

            <tr>
                <td class="label">Приклеплённые изображения:</td>
                <td class="elements view">

                    <? if($item->status != STATUS_DELETED) { ?>
                        <a title="Добавить изображения к товару"><input class="addImageBtnText" id="file_upload" name="file_upload" type="file" /></a>
                    <? } ?>
                    
                    <? if ($this->imgs && $this->imgs->count()) { ?>
                        
                        <?php  foreach ($this->imgs as $img) { ?>

                            <div id="imagestore">

                                <table>
                                    <tr>
                                        <td>
                                            <a href="<?php echo SuperPath::get($img->id, true) ?>.jpg" class="highslide"
                                                onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center'  })">
                                                <img <? if($img->favorite == 1) { ?>style="border: 2px #6495ed  solid  ;"<? } ?> src="<?php echo SuperPath::get($img->id, true) ?>m.jpg" alt="Номер <?=$img->id?>" title="Увеличить изображение" /></a>

                                        </td>

                                        <? if($item->status != STATUS_DELETED) { ?>
                                            <td valign="top">

                                               <!-- <a onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center'  }); return false;" class="largeBtn" href="#">Увеличить</a><br/> -->
                                                <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить данное изображение?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>products/info/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/deleteimage/<?=$img->id?>#imagestore');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>products/info/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/deleteimage/<?=$img->id?>">Удалить</a>

                                                <? if($img->favorite == 1) { ?>
                                                <? } else { ?>
                                                    <a title="Сделать основным изображением" class="favoriteBtn" href="<?php echo url::site(); ?>products/info/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/favoriteimage/<?=$img->id?>#imagestore">Сделать основным изображением</a>
                                                <? } ?>

                                            </td>
                                        <? } ?>
                                    </tr>

                                </table>
  
                             </div>
                        <?php } ?>

                    <?php }else { ?>
                        Изображения не загружены
                    <?php } ?>
                     
                </td>
            </tr>


<? if($this->costs->count()){ ?>

<tr >
    <td colspan="2"  >

    <table class="form"  >

        <tr>
            <td class="label bottomHandler" >Изменение цен:</td>
            <td class="view bottomHandler">

                <table id="bin" cellspacing="0" cellpadding="5" >

                    <tr>
                        <th width="170">Дата операции</th>
                        <th width="130">Цена</th>
                        <th>Администратор</th>
                    </tr>

                    <?php

                $count = 0;
                $current_first_item = 1;

                    foreach ($this->costs as $cost) {

                        $count ++;
                        $class = "";

                        if ($count % 2 == 0) {
                                $class="modTwo";
                        }

                    ?>

                        <tr class="hightLight <?php echo $class ?>" >

                            <td  class="catalog"><?=time::date($cost->date, DATE_FORMAT)?></td>
                            <td class="catalog"><?=money::ru($cost->coster)?></td>
                            <td class="catalog" >
                                <? if(!empty($cost->user_name)) { ?>
                                    <?=html::specialchars($cost->user_name)?>
                                <?php } ?>
                            </td>

                        </tr>

                    <?php } ?>

                </table>

            </td>
        </tr>

    </table> 

    </td>
</tr>

<?php } ?>




            
            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">

                    <a  class="backBtn" href="#" onclick="history.back(); return false;">Назад</a>

                    <? if($item->status != STATUS_DELETED) { ?>

                        <a  class="editBtnText" href="<?php echo url::site(); ?>products/edit/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Отредактировать</a>

                        <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить товар «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>products/delete/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>products/delete/catid/<?=$item->cat_id?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/">Удалить</a>
                        <a  target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/products/item/id/<?php echo ($item->product_id) ?>/">Посмотреть на сайте</a>

                    <? } ?>

                    
                </td>
            </tr>
 
        </table>
 
</center>

<?php } ?>
 