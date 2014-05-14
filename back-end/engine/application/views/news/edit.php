<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Редактировать"> <a href="#" class="cancelBtn" onclick="history.back(); return false;">Отмена</a>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Заголовок', $this->errorFields)){ ?>errorField<? } ?>">Заголовок:</td>
                <td class="elements">
                    <input class="text" name="news[title]" value="<?php echo @(isset($_POST['news']['title'])) ? html::specialchars($_POST['news']['title']) : @html::specialchars($item->title) ?>" />
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Анонс', $this->errorFields)){ ?>errorField<? } ?>">Анонс:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="news[annonce]" style="height: 100px;"><?php
                        echo @(isset($_POST['news']['annonce'])) ? html::specialchars($_POST['news']['annonce']) : html::specialchars($item->annonce)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Содержание', $this->errorFields)){ ?>errorField<? } ?>">Содержание:</td>
                <td class="elements">
                    <textarea   id="news_content" rows="3" cols="4" name="news[content]"><?php
                        echo @(isset($_POST['news']['content'])) ? html::specialchars($_POST['news']['content']) : @html::specialchars($item->content)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                </td>
            </tr>
 
            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Редактировать"> <a href="#" class="cancelBtn" onclick="history.back(); return false;">Отмена</a>
                </td>
            </tr>

        </table>

    </form>

</center>