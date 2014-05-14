<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
 
<? if(array_key_exists('thanx', $_REQUEST) && intval($_REQUEST['thanx'])){ ?>
        
    <div class="errordesc infodesc" >
        <h4>Спасибо за заказ!</h4><br/>
        <p class="last-child">Ваш заказ №<?=$_REQUEST['thanx'] ?>. Спасибо что указали дополнительную информацию к вашему заказу.</p>
    </div>
 
<? }?>


<? if($this->firm->welcomepage){ ?>

    <br/>
    
    <div id="news_content"  >
        <?=$mainpage?>
    </div>
 
<? } ?>
 
    <? if($this->firm->showcatalog){ ?>

    <table style="width: 100%;">
        <tr>
            <td>

    <h2>Наш каталог</h2>

    <div style="float:none; ">

    <div class="left-catalog">
    <?
        $counterRE = 0;

        foreach ($this->groups as  $key ){  $counterRE++; ?>

        <? if($counterRE % 2 == 1) { ?>

        <? }else {continue;}?>

            <h3><?=html::specialchars($key->title)?></h3>

            <? if(count($this->groupssub)) { ?>

                <? $counter = 0;

                $sub = '<p>';

                foreach ($this->groupssub as $key_SUB ){

                    if($key_SUB->cat_id == $key->cat_id) {
                        $counter ++ ;

                        $sub .= '<a href="/products/index/topic/' . $key_SUB->url_link_cat .'/catsub/'.$key_SUB->url_link.'">' .
                                html::specialchars($key_SUB->title) . '</a>';

                         } ?>

                <? } $sub .= '</p>'; ?>

            <? if($counter > 0) { echo $sub; }} ?>


        <? }?>

    </div>
    </div>

    <div class="right-catalog">
    <?
        $counterRE = 0;
        foreach ($this->groups as  $key ){  $counterRE++; ?>

            <? if($counterRE % 2 != 1) { ?>

            <? }else {continue;}?>

            <h3><?=html::specialchars($key->title)?></h3>

            <? if(count($this->groupssub)) { ?>

               <? $counter = 0;

                $sub = '<p>';

                foreach ($this->groupssub as $key_SUB ){

                    if($key_SUB->cat_id == $key->cat_id) {

                        $counter ++ ;

                        $sub .= '<a href="/products/index/topic/' . $key_SUB->url_link_cat .'/catsub/'.$key_SUB->url_link.'">' .
                                html::specialchars($key_SUB->title) . '</a>';

                        } ?>

                <? } $sub .= '</p>'; ?>

            <? if($counter > 0) { echo $sub; }} ;?>

        <? }?>
        <div class="clear"></div>


    </div>

        </td>
        </tr>

    </table>

    <? } ?>


<? if(count($this->groups)) { ?>

    <? if($this->firm->showfirstpro){ ?>

    <div class="new"  >

        <h2>
        <? switch($this->firm->showfirstpro){
            case MAINPAGE_PRICE_NEW: echo 'Новый товар' ; break;
            case MAINPAGE_PRICE_WEEK: echo 'Товар недели' ; break;
            case MAINPAGE_PRICE_SPEC: echo 'Специальное предложение' ; break;
            case MAINPAGE_PRICE_BUY: echo 'Самый покупаемый товар' ; break;
            case MAINPAGE_PRICE_POPULAR: echo 'Самый популярный товар' ; break;
        } ?>
        </h2>

        <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'product_list/list', TRUE),
            array('items' => $items, 'items_ses' => isset($items_ses) ? $items_ses : array())); ?>


    </div>

    <? } ?>

<? }elseif(empty($this->firm->welcomepage)){ ?>

    <div class="errordesc infodesc">
        <p class="last-child">Сайт находиться в процессе наполнения.</p>
    </div>
    

<? } ?>