<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <input type="hidden" value="1" name="ped"/> 

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Сохранить">
                    <a href="/dashboard" class="cancelBtn"  >Отмена</a>
                    <a target="_blank" href="http://<?=$this->firm->domain?>?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>

        <tr >
            <td class="label">Состояние магазина:</td>
            <td class="elements view">

                <label><input type="checkbox" name="firms[enabled]" value="1" <?php echo ($this->firm->enabled == 1) ? ' title="Выключить?" checked="checked"' : ' title="Включить?"'  ?>> Работает</label><br/>

                <?php if ($this->firm->enabled != 1){ ?>
                    <br/><strong>В данный момент магазин не принимает заказы</strong><br/><br/>
                <? } ?>

                <div class="smallInfo">
                    Если галочка включена, это означает что магазин может принимать заказы. Если галочку убрать, то клиенты не смогут заказывать продукцию.
                </div>
            </td>
        </tr>

		<tr >
            <td class="label"></td>
            <td class="elements bottomHandler">
                <input type="submit" value="Сохранить">
                <a href="/dashboard" class="cancelBtn"  >Отмена</a>
                <a target="_blank" href="http://<?=$this->firm->domain?>?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
            </td>
        </tr>
			 
        </table>

    </form>

</center>