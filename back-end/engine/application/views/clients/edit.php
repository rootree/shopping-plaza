<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">
 
            <tr>
                <td class="label">Опыт до следущего уровня:</td>
                <td class="elements">
                    <input name="level[nextExperiance]" value="<?php echo @html::specialchars($item->nextExperiance) ?>" /> 
                </td>
            </tr>
 
            <tr>
                <td class="label"></td>
                <td class="elements">
                    <input type="submit" value="Редактировать"> | <a href="#" onclick="history.back(); return false;">Назад</a>
                </td>
            </tr>

        </table>

    </form>

</center>