<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

        <? if ($this->imgs && $this->imgs->count()) { ?>
            <?php  foreach ($this->imgs as $img) { ?>
                <? if($img->favorite == 1) { ?>

                    <div style=" position:absolute;right:10px;"><br/><br/><br/>
                        <a href="<?php echo SuperPath::get($img->id, true) ?>.jpg" class="highslide"
                            onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center'  })">
                            <img style="border: 2px #6495ed  solid  ;" src="<?php echo SuperPath::get($img->id, true) ?>m.jpg" alt="Номер <?=$img->id?>" title="Увеличить изображение" /></a>
                    </div>
                <? } ?>
            <?php } ?>
        <?php } ?>


<center>

        <table class="form">
     
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
                <td class="label">Цена:</td>
                <td class="elements view">
                    <?php echo money::ru($item->price) ?>
                </td>
            </tr>

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

            <?php  foreach ($this->fields as $field) { if(empty($field->field_value)){ continue;}  ?>

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
  
        </table>
 
</center>

<?php } ?>
 