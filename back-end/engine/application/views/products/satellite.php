<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<div id="addOnMenu">

    <a class="addImageBtnText" onclick="$('#addSatellite').toggle();" href="#">Добавить сопутствуюший товар</a>

    <a class="recommendBtnText" href="<?php echo url::site(); ?>/products/recommend/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>/id/<?=@$item->product_id?>/">Рекомендованные товары</a>

    <a class="largeBtnText" href="<?php echo url::site(); ?>/products/info/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>/id/<?=@$item->product_id?>/">Карточка товара</a>

</div>

<div id="addSatellite" style="<?=!isset($satelliteResult) ? "display:none; " : '' ?>  ">

    <center>

        <form action="<?php echo url::site(); ?>products/satellite/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>/id/<?=@$item->product_id?>/" method="post">

            <table class="form">

                <tr>
                    <td class="label">Поиск:</td>
                    <td class="elements">
                        <input  class="text" name="product[satellite]" value="<?php echo @html::specialchars($_POST['product']['satellite']) ?>" />

                    <div class="smallInfo">
                        Найдите подходящие товары и отметте их как сопутствующие. <br/><br/>

                        Внимание! Поиск проводиться только по названиею товара, описанию и его уникальному номерупервым, и выводиться только 20 позиций.
                    </div>
                    </td>
                </tr>

                <tr>
                    <td class="label"></td>
                    <td class="elements">
                        <input type="submit" value="Произвести поиск"><br/><br/>
                    </td>
                </tr>

            </table>

        </form>

    </center>

</div>

<? if(isset($satelliteResult) && count($satelliteResult)) { $current_first_item = 1;  ?>
 
    <table id="bin" cellspacing="0" cellpadding="5" >

        <tr>
            <th width="20">№</th>
            <th>Наименовение товара</th>
            <th>Цена</th>
            <th width="70"></th>
        </tr>

    <?php

    $count = 0;

    foreach ($satelliteResult as $satelliteItem) {

        $count ++;

        $class = "";

        if ($count % 2 == 0) {
                $class="modTwo";
        }

    ?>

        <tr class="hightLight <?php echo $class ?>" >

            <td class="catalog" width="20"><?php echo $current_first_item ?></td>
            <td ><?php echo html::specialchars($satelliteItem->title) ?></td>
            <td class="catalog"><?php echo money::ru($satelliteItem->price) ?></td>
                <td class="catalog" >

                    <a class="viewBtn" target="_blank" href="<?php echo url::site(); ?>/products/info/catid/<?=$satelliteItem->cat_id?>/catssubid/<?=$satelliteItem->catsub_id?>/id/<?=$satelliteItem->product_id?>/">Посмотреть</a>
                    <a class="addImageBtn" href="<?php
                        echo url::site(); ?>/products/satellite/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>/id/<?=@$item->product_id?>/addsatellite/<?=$satelliteItem->product_id?>/">Добавить в сопутствующие товары</a>

                </td>

        </tr>

    <?php
        $current_first_item ++;
    }
    ?>

    </table>





<? } else { ?>


    <?php if($this->satellites->count()) { $current_first_item = 1; ?>

    <table id="bin" cellspacing="0" cellpadding="5" >

        <tr>
            <th width="20">№</th>
            <th>Наименовение товара</th>
            <th>Цена</th>
            <th width="70"></th>
        </tr>

    <?php

    $count = 0;

    foreach ($this->satellites as $satelliteItem) {

        $count ++;

        $class = "";

        if ($count % 2 == 0) {
                $class="modTwo";
        }

    ?>

        <tr class="hightLight <?php echo $class ?>" >

            <td class="catalog" width="20"><?php echo $current_first_item ?></td>
            <td ><?php echo html::specialchars($satelliteItem->title) ?></td>
            <td class="catalog"><?php echo money::ru($satelliteItem->price) ?></td>
                <td class="catalog" >

                    <a class="viewBtn" target="_blank" href="<?php echo url::site(); ?>/products/info/catid/<?=$satelliteItem->cat_id?>/catssubid/<?=$satelliteItem->catsub_id?>/id/<?=$satelliteItem->product_id?>/">Посмотреть</a>

                    <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить связь между товароми «<?php echo html::specialchars($satelliteItem->title) ?>» и «<?php echo html::specialchars($item->title)
                        ?>»?', function(){SPAdmin.goToURL('<? echo url::site(); ?>/products/satellite/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>/id/<?=@$item->product_id?>/deletesatellite/<?=$satelliteItem->product_id?>/');}); return false;" class="deleteBtn" href="<?php echo url::site(); ?>/products/satellite/catid/<?=@$this->catid?>/catssubid/<?=@$this->catssubid?>/id/<?=@$item->product_id?>/deletesatellite/<?=$satelliteItem->product_id?>/">Удалить</a>

                </td>

        </tr>

    <?php
        $current_first_item ++;
    }
    ?>

    </table>

    <?php }else{ ?>

        <p>
            На данный момент для продукта «<?=html::specialchars($item->title)?>» нет сопутствующих товаров.
        </p>

    <? } ?>


<? } ?>

<h3 id="mainTitle">Пояснение</h3>

<p>Сопутствующие товары - это товары, дополняющие основной товар, образующие вместе с ним единый комплект.</p>

<p>Сопутствующие товары будут показаны в карточке товара. А если клиент выберет товар для покупки, и добавит его в корзину
, ему автоматически будут показаны именно сопутствующие товары. Таким образом можно увеличить общий чек заказа.</p>