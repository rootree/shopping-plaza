<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?='<?xml version="1.0" encoding="utf-8"?>'?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?=(date("Y-m-d H:i"))?>">
    <shop>
      
        <name><?=html::specialchars($this->firm->title)?></name>
        <company><?=html::specialchars($this->firm->title_firm)?></company>
        <url>http://<?=SERVER_SITE?></url>
        <agency>Shopping-Plaza.ru</agency>

        <currencies>
            <currency id="RUR" rate="1" plus="0"/>
        </currencies>


     <categories>

            <? foreach ($groups as $group ){  ?>
                <category id="<?=$group->cat_id?>"><?=html::specialchars($group->title)?></category>
            <? } ?>

            <? foreach ($groupsSub as $group ){  ?>
                <category parentId="<?=$group->cat_id?>" id="<?=$group->catsub_id?>"><?=html::specialchars($group->title)?></category>
            <? } ?>

        </categories> 

        <? if(!empty($delivery)) { ?>
            <local_delivery_cost><?=$delivery->cost?></local_delivery_cost>
        <? } ?>

        <offers>

                
                <? foreach ($items as $key ){   ?>

                    <? if($this->firm->sales == 1 && $key->counter < 1 ) { continue; }  ?>

                    <offer id="<?=$key->product_id?>" available="<?=(($key->counter > 0 && $this->firm->enabled == 1 ) ? 'true' : 'false'); ?>" type="vendor.model" bid="13">

                        <url>http://<?=SERVER_SITE?>products/item/id/<?=$key->product_id?></url>
                        <price><?=$key->price?></price>
                        <currencyId>RUR</currencyId>
                       <categoryId><?=html::specialchars($key->catsub_id)?></categoryId>
                        <picture><?=SuperPath::get($key->source == 0 ? $key->img : $key->imgSearch , true)?>b.jpg</picture>

                        <store>false</store>
                        <pickup>false</pickup>
                        <delivery>true</delivery>

                        <vendor></vendor>
                        <model><?=html::specialchars($key->title)?></model>

                        <description><?=html::specialchars($key->desc_mini)?></description>

                        <? if ($fields && $fields->count()) {  ?>

                            <?php  foreach ($fields as $field) {

                                if((($key->source == 0 && $key->product_id != $field->product_id) ||
                                    ($key->source == 1 && $key->searchingId != $field->product_id)) || empty($field->field_value)){
                                    continue;
                                } ?>
                                
                                <param name="<?php echo @html::specialchars($field->title) ?>"><?php echo @html::specialchars($field->field_value) ?></param>
                            <?php } ?>

                        <?php } ?>

                    </offer>

                <? }?>

        </offers>

    </shop>
</yml_catalog>
