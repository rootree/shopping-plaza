
<center>

    <form action="" method="post">

        <? if(isset($catssub) && !$catssub->count()) { ?>
            <input name="catssub[catsub_id]" value="0" type="hidden"/>
        <? } ?>
        
        <table class="form">


            <? if($this->catid && $this->catssubid) { ?>

                <tr >
                    <td class="label"></td>
                    <td class="elements topHandler">
                        <input type="submit" value="Добавить"> <a href="#" class="cancelBtn" onclick="history.back(); return false;">Отмена</a>
                    </td>
                </tr>

            <?php } ?>

            <tr>
                <td class="label">Основная категория:</td>
                <td class="elements">
                    <select name="product[cat_id]"
                            onchange="$('#product_cat').attr('disabled','disabled');if(this.value != <?=$this->catid?> && this.value != 0){location.href='/products/add/catid/' + this.value;}">

                        <option value="0" id="product_cat" >
                            Выберите категорию
                        </option>

                        <?php
                        $lastSort = 0; $counter = 0;
                        foreach ($this->cats as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>
 
                            <option value="<?php echo $champEntry->cat_id ?>"
                                <?=($this->catid == $champEntry->cat_id ? 'selected="selected"' : '') ?>
                                    >
                                <?php echo $counter . ". " .html::specialchars($champEntry->title) ?>
                            </option>

                        <?php } ?>
 
                    </select> 
                </td>

            </tr>

            <? if(isset($this->catssub) && $this->catssub->count()) { ?>

                <tr>
                    <td class="label">Разместить перед:</td>
                    <td class="elements">
                        <select name="product[catsub_id]"
                            onchange="$('#product_catsub').attr('disabled','disabled'); if(this.value != <?=$this->catssubid ?> && this.value != 0){
                            location.href='/products/add/catid/' + <?=$this->catid?> + '/catssubid/' + this.value;}">

                            <option value="0" id="product_catsub" >
                                Выберите категорию
                            </option>

                            <?php
                            $counter = 0;
                            foreach ($this->catssub as $champEntry) {    $counter ++ ?>
 
                                <option value="<?php echo $champEntry->catsub_id ?>"
                                    <?=($this->catssubid == $champEntry->catsub_id ? 'selected="selected"' : '') ?>
                                        >
                                    <?php echo $counter . ". " .html::specialchars($champEntry->title) ?>
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
            
            <? }elseif($this->catid != 0){ ?>

                <tr>
                    <td class="elements" colspan="2">
                        <?php echo messages::show('Внимание! Данная категория не содержит ни одной подкатегории. Для добавления товара сюда, необходимо <a href="/settings/catsaddsub/catid/'. $this->catid . '">создать</a> как минимум одну подкатигорию. ', TYPE_HELP) ?>
                    </td>
                </tr>

            <? }  ?>

            <? if($this->catid && $this->catssubid) { ?>
                
                <tr>
                    <td class="label">Название:</td>
                    <td class="elements">
                        <input  class="text" name="product[title]" value="<?php echo @html::specialchars($_POST['product']['title']) ?>" />
                         
                    </td>
                </tr>

                <tr>
                    <td class="label">Артикул:</td>
                    <td class="elements">
                        <input  class="text" name="product[arcitule]" value="<?php echo @html::specialchars($_POST['product']['arcitule']) ?>" />
                      
                    </td>
                </tr>

                <tr>
                    <td class="label">Цена:</td>
                    <td class="elements">
                        <input  class="text" name="product[price]" value="<?php echo @html::specialchars($_POST['product']['price']) ?>" />

                    </td>
                </tr>

                <tr>
                    <td class="label">Основные-характеристики:</td>
                    <td class="elements">
                        <input  class="text" name="product[desc_mini]" value="<?php echo @html::specialchars($_POST['product']['desc_mini']) ?>" /> 

                        <div class="smallInfo">
                            Укажите основные характеристики товара. К примеру: Обзор 120°, TFT-экран 2.5", SD до 32 ГБ, USB, пульт ДУ;
                        </div>
                     </td>
                </tr>


            <tr>
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="product[new]" value="1" > Новый товар</label>
                </td>
            </tr>

            <tr>
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="product[week]" value="1" > Товар недели</label>
                </td>
            </tr>

            <tr>
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="product[unic]" value="1" > Уникальное предложение</label>
                </td>
            </tr>
<!--
                <tr>
                    <td class="label">Скидка на товар:</td>
                    <td class="elements">
                        <input name="product[discount]" value="<?php echo @html::specialchars($_POST['product']['discount']) ?>" />
                        <div class="smallInfo">
                            Скидка указывается в процентах от основной цены.
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="label">Вес в упаковке:</td>
                    <td class="elements">
                        <input name="product[weight]" value="<?php echo @html::specialchars($_POST['product']['weight']) ?>" />
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



                       <label><input onchange="$('tr.newDesc').hide();$('tr.descFrom').show();" <? if((isset($_POST['product']['source']) && $_POST['product']['source'] == 1)  ){ ?>checked="checked" <?}?> type="radio" name="product[source]" id="sourceFrom" value="1"/>Взять описание из существующего товара</label><br/>
                       <div class="smallInfo">
                           Будут подставлены: основное описание, характеристики товара, сопутствующие рекомендованные товары.
                           <br/>
                           <br/>
                       </div>
                       <label><input onchange="$('tr.descFrom').hide();$('tr.newDesc').show();" <? if((isset($_POST['product']['source']) && $_POST['product']['source'] == 0) || !isset($_POST['product']['source'] )){ ?>checked="checked" <?}?> type="radio" name="product[source]" id="source" value="0"/>Новое описание для товара</label><br/>

<div class="smallInfo">
                           Описание для товара можно составить новое, или подставить уже существующее.<br/>
                       </div>
                       <br/>
                   </td>
               </tr>



                <tr class='descFrom'>
                   <td class="label">Взять из:</td>
                   <td class="elements">

                        <input  class="text" name="" value=" " id="searching" />
                        <input  class="text" name="product[searchingId]" value="0?>" id="searchingId" type="hidden" />
                        <div class="smallInfo">
                            Введите для поиска часть названия товара или артикул.
                        </div>
                    </td>
               </tr>

                <tr class='descFrom'>
                   <td class="label">Заменить:</td>
                   <td class="elements">

                       <input  class="text" name="product[replace]" value="<?php echo @(isset($_POST['product']['replace'])) ? html::specialchars($_POST['product']['replace']) : ''  ?>" />

                   </td>
               </tr>
                <tr class='descFrom'>
                   <td class="label">На:</td>
                   <td class="elements">

                       <input  class="text" name="product[replace_to]" value="<?php echo @(isset($_POST['product']['replace_to'])) ? html::specialchars($_POST['product']['replace_to']) : ''  ?>" />

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
                            echo @html::specialchars($_POST['product']['desc'])
                            ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    </td>
                </tr>
                
                <? if ($this->fields && $this->fields->count()) { ?>

                    <tr class="newDesc">
                        <td class="label"></td>
                        <td class="elements">
                            <hr/>
                        </td>
                    </tr>

                    <?php  foreach ($this->fields as $item) { ?>

                        <tr class="newDesc">
                            <td class="label"><?=$item->title?>:</td>
                            <td class="elements">
                                <input  class="text" name="product[fields][<?php echo $item->field_id ?>]" value="<?php echo @html::specialchars($_POST['product']['fields'][$item->field_id]) ?>" />

                            </td>
                        </tr>

                    <?php } ?>

                <?php } ?>
 
                <tr >
                    <td class="label"></td>
                    <td class="elements bottomHandler">
                        <input type="submit" value="Добавить"> <a href="#" class="cancelBtn" onclick="history.back(); return false;">Отмена</a>
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
        source: "/products/ajax/id/0",
        minLength: 3,
        select: function( event, ui ) {
            if(ui.item){
                $('#searchingId').val(ui.item.id);
                $('#searching').val(ui.item.value);
            }
        }
    });

</script>