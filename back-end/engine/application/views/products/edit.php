<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">
        
        <? if(isset($catssub) && !$catssub->count()) { ?>
            <input name="product[catsub_id]" value="1" type="hidden"/>
        <? } ?>

        <table class="form">

            <? if($this->catidinedit && $this->catSubIdInEdit) { ?>

                <tr >
                    <td class="label"></td>
                    <td class="elements topHandler">
                        <input type="submit" value="Сохранить"> <a href="/products/info/catid/<?=$this->catid?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/" class="cancelBtn" >Отмена</a>
                    </td>
                </tr>

            <? } ?>
 
             <tr>
                <td class="label">Основная категория:</td>
                <td class="elements">
                 
                    <select name="product[cat_id]"
                            onchange="if(this.value != <?=$this->catidinedit?> && this.value != 0){
                            location.href='/products/edit/catid/' + <?=($this->catid) ? $this->catid : ' this.value '?> + '/catidinedit/'
                            + this.value + '/id/' + <?=$item->product_id?>
                            + '/catssubid/' + <?=$item->catsub_id?>;

                            }">

                        <option value="0" disabled="disabled">
                            Выберите категорию
                        </option>

                        <?php
                        $lastSort = 0; $counter = 0;
                        foreach ($this->cats as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

                            <option class='selectedElement' value="<?php echo $champEntry->cat_id ?>"
                                <? if($this->catidinedit == $champEntry->cat_id){ ?>
                                    selected="selected"><b><?php echo $counter . ". " .$champEntry->title ?></b>
                                <? }else{ ?>
                                    ><?php echo $counter . ". " .html::specialchars($champEntry->title) ?>
                                <? } ?>
                                
                            </option>

                        <?php } ?>

                    </select>
 
                </td>

            </tr>

            <? if(isset($this->catssub) && $this->catssub->count()) { ?>
                <tr>
                    <td class="label">Подкатегория:</td>
                    <td class="elements">

                        <select name="product[catsub_id]"
                            onchange="if(this.value != <?=$this->catSubIdInEdit?> && this.value != 0){
                                location.href =
                                '/products/edit/catid/' + <?=$this->catid?> + '/catssubid/<?=$item->catsub_id?>/'
                                + 'catidinedit/<?=$this->catidinedit?>/catSubIdInEdit/' + this.value +
                                '/id/' + <?=$item->product_id?>;
  
                            }">
 
                            <option value="0" >
                                Выберите категорию
                            </option>

                            <?php
                            $counter = 0;
                            foreach ($this->catssubForEdit as $champEntry) {    $counter ++ ?>

                                <option value="<?php echo $champEntry->catsub_id ?>"
                                    <?=($this->catSubIdInEdit == $champEntry->catsub_id ? 'selected="selected"' : '') ?>
                                        >
                                    <?php echo $counter . ". " .html::specialchars($champEntry->title)?>
                                </option>

                            <?php } ?>

                        </select>


                    </td>
                </tr>

                        <tr>
                            <td class="label"></td>
                            <td class="elements">
                                <hr/>
                            </td>
                        </tr>
            <? } ?>

            <? if($this->catidinedit && $this->catSubIdInEdit) { ?>

                <tr>
                    <td class="label">Название товара:</td>
                    <td class="elements">
                        <input  class="text" name="product[title]" value="<?php echo @(isset($_POST['product']['title'])) ? html::specialchars($_POST['product']['title']) : html::specialchars($item->title)  ?>" />
                 
                    </td>
                </tr>
                <tr>
                    <td class="label">Артикул:</td>
                    <td class="elements">
                        <input title="Уникальное поля для товара"  class="text" name="product[arcitule]" value="<?php echo @(isset($_POST['product']['arcitule'])) ? html::specialchars($_POST['product']['arcitule']) : html::specialchars($item->arcitule)  ?>" />

                    </td>
                </tr>
                <tr>
                    <td class="label">Цена:</td>
                    <td class="elements">
                        <input  class="text" name="product[price]" value="<?php echo @(isset($_POST['product']['price'])) ? html::specialchars($_POST['product']['price']) : html::specialchars($item->price)  ?>" />

                    </td>
                </tr>
 
                <? if($this->firm->prices->enabled & 1){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price1)?>:</td>
                        <td class="elements">
                            <input  class="text" name="product[price1]" value="<?php echo @(isset($_POST['product']['price1'])) ? html::specialchars($_POST['product']['price1']) : html::specialchars($item->price1)  ?>" />
                        </td>
                    </tr> 
                <? }?>

                <? if($this->firm->prices->enabled & 2){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price2)?>:</td>
                        <td class="elements">
                            <input  class="text" name="product[price2]" value="<?php echo @(isset($_POST['product']['price2'])) ? html::specialchars($_POST['product']['price2']) : html::specialchars($item->price2)  ?>" />
                        </td>
                    </tr>
                <? }?>

                <? if($this->firm->prices->enabled & 4){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price3)?>:</td>
                        <td class="elements">
                            <input  class="text" name="product[price3]" value="<?php echo @(isset($_POST['product']['price3'])) ? html::specialchars($_POST['product']['price3']) : html::specialchars($item->price3)  ?>" />
                        </td>
                    </tr>
                <? }?>

                <? if($this->firm->prices->enabled & 8){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price4)?>:</td>
                        <td class="elements">
                            <input  class="text" name="product[price4]" value="<?php echo @(isset($_POST['product']['price4'])) ? html::specialchars($_POST['product']['price4']) : html::specialchars($item->price4)  ?>" />
                        </td>
                    </tr>
                <? }?>

                <? if($this->firm->prices->enabled & 16){?>
                    <tr>
                        <td class="label"><?=html::specialchars($this->firm->prices->list->price5)?>:</td>
                        <td class="elements">
                            <input  class="text" name="product[price5]" value="<?php echo @(isset($_POST['product']['price5'])) ? html::specialchars($_POST['product']['price5']) : html::specialchars($item->price5)  ?>" />
                        </td>
                    </tr>
                <? }?>


                <tr>
                    <td class="label">Основные-характеристики:</td>
                    <td class="elements">
                        <input  class="text" name="product[desc_mini]" value="<?php echo @(isset($_POST['product']['desc_mini'])) ? html::specialchars($_POST['product']['desc_mini']) : html::specialchars($item->desc_mini)  ?>" />
                        <div class="smallInfo">
                            Укажите основные характеристики товара. К примеру: Обзор 120°, TFT-экран 2.5", SD до 32 ГБ, USB, пульт ДУ;
                        </div>
                    </td>
                </tr>



            <tr>
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="product[new]" <?php echo ($item->new == 1) ? 'checked="checked"' : "" ?>  value="1" > Новый товар</label>
                </td>
            </tr>

            <tr>
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="product[week]" <?php echo ($item->week == 1) ? 'checked="checked"' : "" ?>  value="1" > Товар недели</label>
                </td>
            </tr>

            <tr>
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="product[unic]" <?php echo ($item->unic == 1) ? 'checked="checked"' : "" ?>  value="1" > Уникальное предложение</label>
                </td>
            </tr>
     <!--
                <tr>
                    <td class="label">Скидка на товар:</td>
                    <td class="elements">
                        <input name="product[discount]" value="<?php echo @(isset($_POST['product']['discount'])) ? html::specialchars($_POST['product']['discount']) : html::specialchars($item->discount)   ?>" />
                        <div class="smallInfo">
                            Скидка указывается в процентах от основной цены.
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="label">Вес в упаковке:</td>
                    <td class="elements">
                        <input name="product[weight]" value="<?php echo @(isset($_POST['product']['weight'])) ? html::specialchars($_POST['product']['weight']) : html::specialchars($item->weight)   ?>" />
                        <div class="smallInfo">
                            Участвует в расчётах доставки товара транспортной компанией.
                        </div>
                    </td>
                </tr>
-->
                  <tr  >
                        <td class="label"></td>
                        <td class="elements">
                            <hr/>

                        </td>
                    </tr>

                <tr>
                    <td class="label"></td>
                    <td class="elements">


                        
                        <label><input onchange="$('tr.newDesc').hide();$('tr.descFrom').show();" <? if((isset($_POST['product']['source']) && $_POST['product']['source'] == 1) || (!isset($_POST['product']['source']) && $item->source == 1) ){ ?>checked="checked" <?}?> type="radio" name="product[source]" id="sourceFrom" value="1"/>Взять описание из существующего товара</label><br/>
                        <div class="smallInfo">
                            Будут подставлены: основное описание, характеристики товара, сопутствующие рекомендованные товары.
                            <br/>
                            <br/>
                        </div>
                        <label><input onchange="$('tr.descFrom').hide();$('tr.newDesc').show();" <? if((isset($_POST['product']['source']) && $_POST['product']['source'] == 0) || (!isset($_POST['product']['source']) && $item->source == 0) ){ ?>checked="checked" <?}?> type="radio" name="product[source]" id="source" value="0"/>Новое описание для товара</label><br/>

 <div class="smallInfo">
                            Описание для товара можно составить новое, или подставить уже существующее.<br/>
                        </div>
                        <br/>
                    </td>
                </tr>


                <tr class='descFrom'>
                   <td class="label">Взять из:</td>
                   <td class="elements">  

                        <input  class="text" name="" value="<?=isset($relative) ? html::specialchars($relative->title) : ''?> <?=isset($relative) ? '(артикул '.html::specialchars($relative->arcitule) .')' : ''?>" id="searching" />
                        <input  class="text" name="product[searchingId]" value="<?=isset($relative) ? $relative->product_id : 0?>" id="searchingId" type="hidden" />
                       <? if(isset($relative) && $relative->product_id){ ?>
                        <div class="smallInfo">
                            
                            <a href="/products/edit/catid/<?=$relative->cat_id?>/catssubid/<?=$relative->catsub_id?>/id/<?=$relative->product_id?>/">Перейти к оригиналу</a>
                                 
                        </div>
                       <? }?>
                        <div class="smallInfo">
                            Введите для поиска часть названия товара или артикул.
                        </div>
                    </td>
               </tr>

                <tr class='descFrom'>
                   <td class="label">Заменить:</td>
                   <td class="elements">

                       <input  class="text" name="product[replace]" value="<?php echo @(isset($_POST['product']['replace'])) ? html::specialchars($_POST['product']['replace']) : html::specialchars($item->replace)  ?>" />

                   </td>
               </tr>
                <tr class='descFrom'>
                   <td class="label">На:</td>
                   <td class="elements">

                       <input  class="text" name="product[replace_to]" value="<?php echo @(isset($_POST['product']['replace_to'])) ? html::specialchars($_POST['product']['replace_to']) : html::specialchars($item->replace_to)  ?>" />

                       <div class="smallInfo">
                           Вы можете указать какую фразу вы хотели бы заменить при подстановке описания выбранного товара.<br/><br/>
                           К примеру, если в подставляемом описание есть слово Panasonic, а вы хотите, чтобы вместо него
                           было написано Sony, то в поле «Заменить» укажите «Panasonic», а в поле «На» соответственно «Sony».
                       </div>
                   
                   </td>
               </tr>

                <tr class="newDesc">
                    <td class="label">Описание:</td>
                    <td class="elements">
                        <textarea rows="3" cols="4" name="product[desc]" id="product_desc"><?php
                            echo @(isset($_POST['product']['desc'])) ? html::specialchars($_POST['product']['desc']) : html::specialchars($item->desc)
                            ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    </td>
                </tr>

                <? if($item->catsub_id != $this->catSubIdInEdit && $this->prevCountOfFields > 0){ ?>
                    <tr class="newDesc">
                        <td colspan="2">
                            <?php echo messages::show('Внимание! Вы выбрали новую категорию, поля предыдущей категории будут частично или полностью удалены', TYPE_HELP) ?>
                        </td>
                    </tr>
                <? } ?>
                
                <? if ($this->fields && $this->fields->count()) { ?>

                    <tr class="newDesc">
                        <td class="label"></td>
                        <td class="elements">
                            <hr/>

                        </td>
                    </tr>

                    <?php  foreach ($this->fields as $field) { ?>

                        <tr class="newDesc">
                            <td class="label"><?=html::specialchars($field->title)?>:</td>
                            <td class="elements">
                                <input  class="text" name="product[fields][<?php echo $field->field_id ?>]"
                                       value="<?php

                               if(isset($_POST['product']['fields'][$field->field_id])) {
                                   echo html::specialchars($_POST['product']['fields'][$field->field_id]);
                               } else {

                                   if($item->catsub_id != $this->catSubIdInEdit && $item->catsub_id){

                                       foreach ($this->oldFields as $fieldOLD) {
                                            if($fieldOLD->title == $field->title){
                                                echo html::specialchars($fieldOLD->field_value);
                                            }
                                       }

                                   }else{
                                        echo html::specialchars($field->field_value);
                                   }

                               }

                               ?>" />
                            </td>
                        </tr>

                    <?php } ?>

                <?php } ?>

                <tr >
                    <td class="label"></td>
                    <td class="elements bottomHandler">
                        <input type="submit" value="Сохранить"> <a href="/products/info/catid/<?=$this->catid?>/catssubid/<?=$item->catsub_id?>/id/<?=$item->product_id?>/" class="cancelBtn" >Отмена</a>
                    </td>
                </tr>

            <? } ?>

        </table>

    </form>

</center>

<script type="text/javascript">


    if (!($('#sourceFrom').attr("checked") != "undefined" && $('#sourceFrom').attr("checked") == "checked")) {
        $('tr.descFrom').hide();
        $('tr.newDesc').show();
    }else{
        $('tr.newDesc').hide();
        $('tr.descFrom').show();
    }

    $( "#searching" ).autocomplete({
        source: "/products/ajax/id/<?=$item->product_id?>",
        minLength: 3,
        select: function( event, ui ) {
            if(ui.item){
                $('#searchingId').val(ui.item.id);
                $('#searching').val(ui.item.value);
            }
        }
    });

</script>