<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<? if(empty($phone)) { ?>

<div id="callbackMessage" class="kolvo" style="display: none ; ">
 
    <span id="callbackComplete" style="display: none;">

        <p><br/>Спасибо что оставили заявку, мы перезвоним вам в ближайшее время.<br/><br/>

        </p>
 
    </span>

    <span id="callbackLoading" style="display: none;">

        <p><img src="/highslide/graphics/loader.white.gif" alt="..." /> Отправка данных ...</p>
     
    </span>

    <span id="callbackForm" style="text-align:left;" >

        <p>Если вы не дозвонились до нас, или хотите чтобы мы перезвонили вам, вы можете заказать обратный звонок. <br/><br/>Оставив свой номер телефона, наш оператор перезвонит вам в ближайщее время.</p>

        <form id="kolvo" action="#">
            <div class="field-text" style="text-align:center; width: 100%;">

                <span style="padding-top: 20px;">Телефон с кодом:</span>&nbsp;&nbsp; <input style="width: 180px; text-align:left;" name="numberCallback" value="" type="text" id="numberCallback" />

            </div>
        </form>

    </span>

    <div class="panel" id="callbackButtons" style="  ;margin-bottom: 2px;">
        <a class="news-link" href="#" onClick="SPHandler.hideCallback(); return false;">Отмена</a>

        <img class="line" src="/img.<?=$this->firm->template?>/icons/line2.png" alt="" />

        <a class="news-link" href="#" onClick="SPHandler.sendCallback(); return false;">Оставить номер</a>
    </div>
     
</div>

<? } ?>