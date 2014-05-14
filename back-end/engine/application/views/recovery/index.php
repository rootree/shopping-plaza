<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<center>

    <form action="/recovery" method="post">

        <table class="form">

            <tr>
                <td class="label">Электронный адрес:</td>
                <td class="elements">
                    <input name="firms[title]" value="<?php echo @html::specialchars($_POST['firms']['title']) ?>" /> 
                </td>
            </tr>

            <tr>
                <td class="label">Домен:</td>
                <td class="elements">
                    <input name="firms[domain]" value="<?php echo @html::specialchars($_POST['firms']['domain']) ?>" />
                    <div class="smallInfo">
                        Опыт очень важен
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label"></td>
                <td class="elements">
                    <input type="submit" value="Добавить">
                </td>
            </tr>

        </table>

    </form>

</center>
 