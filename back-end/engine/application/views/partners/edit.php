<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Сохранить"> <a href="/partners/info/id/<?=$item->partner_id?>/" class="cancelBtn" >Отмена</a>
                </td>
            </tr>

            <tr>
                <td class="label">Название:</td>
                <td class="elements">
                    <input class="text" name="partners[title]" value="<?php echo @html::specialchars($item->title) ?>" />
                </td>
            </tr>

            <tr>
                <td class="label">Описание:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="partners[annonce]" id="partners_annonce"><?php
                        echo @html::specialchars($item->annonce)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                </td>
            </tr>


            <tr>
                <td class="label">Телефон(ы):</td>
                <td class="elements">
                    <input class="text" name="partners[tel]" value="<?php echo @html::specialchars($item->tel) ?>" />
                </td>
            </tr>

            <tr>
                <td class="label">Адрес:</td>
                <td class="elements">
                    <input class="text" name="partners[address]" value="<?php echo @html::specialchars($item->address) ?>" />
                </td>
            </tr>

            <tr>
                <td class="label">Факс:</td>
                <td class="elements">
                    <input class="text" name="partners[fax]" value="<?php echo @html::specialchars($item->fax) ?>" />
                </td>
            </tr>

            <tr>
                <td class="label">Электронный адрес:</td>
                <td class="elements">
                    <input class="text" name="partners[mail]" value="<?php echo @html::specialchars($item->mail) ?>" />
                </td>
            </tr>

            <tr>
                <td class="label">Адрес в Интернете:</td>
                <td class="elements">
                    <input class="text" name="partners[www]" value="<?php echo @html::specialchars($item->www) ?>" />
                </td>
            </tr>


            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Сохранить"> <a href="/partners/info/id/<?=$item->partner_id?>/" class="cancelBtn" >Отмена</a>
                </td>
            </tr>

        </table>

    </form>

</center>