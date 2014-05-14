<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="podtv">

<? if(array_key_exists('new', $_REQUEST)){ ?>

    <div class="errordesc infodesc" >
        <h4>Спасибо за регистрацию!</h4><br/>
        <p class="last-child">Теперь мы знаем о вас немного больше, и это поможет сэкономить время как вам там и нам.</p>
        <p class="last-child">Вам больше не придется вводить одни и те же данные при оформлении заказа, т.к. они уже будут сохранены.</p>
    </div>

<? }?>

<h2>История заказов</h2>
 
<?php if($items->count()) { ?>

    <?php echo $pagination ?>
<br/>
<br/>
<br/> 
        <table class="cartList" cellspacing="0" cellpadding="0">
            <tr class="top">
                <td class="num"><p>№</p></td>
                <td style="width:50px;"><p>Заказ</p></td>
                <td style="width:130px;"><p>Время заказа</p></td>
                <td  nowrap="nowrap"><p>Оплата</p></td>
                <td nowrap="nowrap"  ><p>Доставка</p></td>
                <td nowrap="nowrap" style="width:110px;"><p>Стоимость</p></td>
                <td nowrap="nowrap" style="width:100px;"><p>Статус</p></td>
                <td class="back0"><p>&nbsp;</p></td>
            </tr>
  
    <?php

    $count = 0;

    foreach ($items as $item) {

        $count ++; ?>
 
            <tr >
                <td><p class="11"><?=$current_first_item?>.</p></td>
                <td><p class="11"><?php echo html::specialchars($item->id) ?></p></td>
                <td class="itemTitle"><p>
                    <?php echo time::date($item->date, DATE_FORMAT)  ?>
                </p></td>
                <td class="itemTitle"><p>
                   <?php echo html::specialchars($item->devivery) ?>
                </p></td>
                <td class="itemTitle"><p>
                    <?php echo html::specialchars($item->payment) ?>
                </p></td>
                <td><p class="price1"><b><?=money::ru($item->total);  ?></b></p></td>
                <td class="itemTitle"><p>
                    <?php echo $GLOBALS['ORDER_STATUS'][$item->status] ?>
                </p></td>
                <td>
                    <a href="/dashboard/order/id/<?=$item->id?>"><img  alt="Подробности" title="Подробности"   src="/img.<?=$this->firm->template?>/icons/plus.png" /></a>
                </td>
             </tr>
 

    <?php
        $current_first_item ++;
    }
    ?>

    </table>
 
     <?php echo $pagination ?>

<?php }else{ ?>

   Вы не выбрали ни одного товара.

<? } ?>

</div> 