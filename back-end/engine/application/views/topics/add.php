<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<center>

    <form action="./" method="post">

        <table class="form">

            <tr>
                <td class="label">Номер уровня:</td>
                <td class="elements">
                    <input name="level[level]" value="<?php echo @html::specialchars($_POST['level']['level']) ?>" />
                    <div class="smallInfo">
                        Уровни не должны повторяться
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">Опыт до следущего уровня:</td>
                <td class="elements">
                    <input name="level[nextExperiance]" value="<?php echo @html::specialchars($_POST['level']['nextExperiance']) ?>" />
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
 