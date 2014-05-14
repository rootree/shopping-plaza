<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?='<?xml version="1.0" encoding="utf-8"?>'?>
<torg_price date="<?=(date("Y-m-d H:i"))?>">
    <shop>
        <update_type>0</update_type>
        <shopname><?=html::specialchars($this->firm->title)?></shopname>
        <company><?=html::specialchars($this->firm->title_firm)?></company>
        <url><?=SERVER_SITE?></url>
        <currencies>
            <currency id="RUR" rate="1"/>
        </currencies>
        <categories>

            <? foreach ($groups as $group ){  ?>
                <category  parentId="0" id="<?=$group->cat_id?>"><?=html::specialchars($group->title)?></category>
            <? } ?>

            <? foreach ($groupsSub as $group ){  ?>
                <category parentId="<?=$group->cat_id?>" id="<?=$group->catsub_id?>"><?=html::specialchars($group->title)?></category>
            <? } ?>

        </categories>

        <offers>

            <? foreach ($items as $key ){  ?>

                <offer id="<?=$key->product_id?>" type="good" mpc="5.50">
                    <url>http://<?=SERVER_SITE?>products/item/id/<?=$key->product_id?></url>
                    <price><?=$key->price?></price>
                    <currencyId>RUR</currencyId>
                    <categoryId><?=html::specialchars($key->catsub_id)?></categoryId>
                    <picture><?=SuperPath::get($key->img, true)?>b.jpg</picture>
                    <vendor></vendor>
                    <name><?=html::specialchars($key->title)?></name>
                    <description><?=html::specialchars($key->desc_mini)?></description>
                    <descmore>http://<?=SERVER_SITE?>products/item/id/<?=$key->product_id?></descmore>

                    <? if(!empty($delivery)) { ?>
                        <delivery_price><?=$delivery->cost?></delivery_price>
                        <delivery_type>+</delivery_type>
                    <? } ?>

                </offer>

            <? }?>

        </offers> 
    </shop>
</torg_price>

