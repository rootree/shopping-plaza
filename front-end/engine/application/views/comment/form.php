<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<? if(cookie::get('userBlocked') != '1') { ?>
    
    <div class="adress">

        <h3  id="commentForm">Вы можете оставить комментарий</h3>

        <? if(array_key_exists('errorOnComment', $_GET)) {?>
            <div class="errordesc" >
                <h4>Произошла ошибка при проверке указанных вами данных.</h4> 
                <p class="last-child">Пожалуйста, заполните обязательные поля «Комментарий» и «Ваше имя». И если вы указали электронный адрес, проверте что он правильно заполнен.</p>
            </div>
        <? } ?>

        <form action="/comment" onsubmit="return SPHandler.checkComment();" method="POST">

            <input type="hidden" value="<?=$type?>" name="type">
            <input type="hidden" value="<?=$id?>" name="id">

        <div class="svyaz" id="svyaz" style="height: 195px;">

            <div class="svyazList">
                <p><?=form::label('name', Kohana::lang('feedback.form_name'));?>:</p>
                <p><?=form::label('mail', 'Электронный адрес');?>:</p>
                <p><?=form::label('msg', 'Комментарий');?>:</p>
            </div>

            <div class="svyazForm">

                <p>
                    <?=form::input('name', (cookie::get('name')) ? cookie::get('name') : (@$_REQUEST['name']), '  ');?>
                </p>
                <p>
                    <?=form::input('mail', (cookie::get('mail')) ? cookie::get('mail') : (@$_REQUEST['mail']), ' ');?>
                </p>
                <p>
                    <?=form::textarea('msg', @($_REQUEST['msg']), ' class="text" rows="3"');?>
                </p>
                <p>
                    <input id="submiter" type="submit" class="sub" value="<?=(isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '')?>"/>
                </p>

            </div>

        </div>

        </form>

    </div>

<? }else {?>
      
    <div class="errordesc" id="commentForm" >
        <h4>Вы не можете оставлять коментарии.</h4><br/>
        <p class="last-child">
             Обратитесь к администрации Интернет-магазина за деталями причины.
        </p>
    </div>

<? } ?>