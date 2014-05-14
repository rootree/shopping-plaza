<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="counterMessage" class="kolvo" style="display:none;">

    <div class="ygol2"></div>

    <span id="takeOrderComplete" style="display:none;">

        <p><br/>Можно тут же <br/><a href="/bin"><strong>Оформить заказ</strong></a><br/><br/>
 
        <? if(isset($this->satellites) && count($this->satellites)){ ?>

             или посмотреть<br/>

            <a onclick="location.href=location.href + '#satellites'; return false;" href="#"><strong>Сопутствующие товары</strong></a><br/><br/>
        <? } ?>
            
        </p>
 
    </span>

    <span id="takeOrderLoading" style="display:none;">

        <p><img src="/highslide/graphics/loader.white.gif" alt="..." /></p>
     
    </span>

    <span id="takeOrderQuentaty" >

        <p>Укажите количество:</p>

        <form id="kolvo" action="#">
            <div class="field-text">
                <a href="" onClick="SPHandler.changeCounter(false); return false;"><img class="left" src="/img.<?=$this->firm->template?>/icons/minus.png" alt="-" /></a>
                <input name="items" value="1" type="text" id="itemCount" />
                <a href="" onClick="SPHandler.changeCounter(true); return false;"><img class="right" src="/img.<?=$this->firm->template?>/icons/plus.png" alt="+" /></a>
            </div>
        </form>

    </span>

    <div class="panel" id="counterMessageButtons">
        <a class="news-link" href="#" onClick="SPHandler.isCounterMessageOpened = false;SPHandler.hideCounterMessage(); return false;">Отмена</a>

        <img class="line" src="/img.<?=$this->firm->template?>/icons/line2.png" alt="" />

        <a class="news-link" href="#" onClick="SPHandler.sendOrder(); return false;">ОК</a>
    </div>
    
    <div class="panel" id="counterMessageProgress"></div>
</div>