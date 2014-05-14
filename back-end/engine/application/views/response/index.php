<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<? if(empty($this->info)) { ?>

<p>
	В этой форме вы можете написать нам отзывы, предложения, ошибки сервиса, а так же любую другую полезную информацию касающуюся нашего сервиса. Если у вас возникли
     сложности или проблемы мы постараемся помочь в ближайшем будущем.
</p>

<center>
 
    <form action="/response" method="post">

        <table class="form">
 
            <tr>
                <td class="label <? if(in_array('Тема', $this->errorFields)){ ?>errorField<? } ?>">Тема:</td>
                <td class="elements">
                    <label><input type="radio" name="response[typer]" <?=(@$_REQUEST['type'] == RESPONSE_TYPE_QUESTION) ? "checked=checked" : "" ?>  value="<?=RESPONSE_TYPE_QUESTION?>" > Вопрос по работе сервиса</label><br/>
                    <label><input type="radio" name="response[typer]" <?=(@$_REQUEST['type'] == RESPONSE_TYPE_PREDLO) ? "checked=checked" : "" ?>   value="<?=RESPONSE_TYPE_PREDLO?>" > Предложение</label><br/>
                    <label><input type="radio" name="response[typer]" <?=(@$_REQUEST['type'] == RESPONSE_TYPE_ERROR) ? "checked=checked" : "" ?>    value="<?=RESPONSE_TYPE_ERROR?>" > Найдена ошибка</label><br/>
                    <label><input type="radio" name="response[typer]" <?=(@$_REQUEST['type'] == RESPONSE_TYPE_SERVICE) ? "checked=checked" : "" ?>    value="<?=RESPONSE_TYPE_SERVICE?>" > Заказ дополнительных услуг</label><br/>
                    <label><input type="radio" name="response[typer]" <?=(@$_REQUEST['type'] == RESPONSE_TYPE_OTHER) ? "checked=checked" : "" ?>    value="<?=RESPONSE_TYPE_OTHER?>" > Другое</label>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Текст сообщение', $this->errorFields)){ ?>errorField<? } ?>">Текст сообщение:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="response[annonce]"><?php
                        echo @html::specialchars($_POST['response']['annonce'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                </td>
            </tr>


            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Отправить">
                </td>
            </tr>


        </table>

    </form>

</center>

<? } ?>