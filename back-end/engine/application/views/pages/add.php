<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<center>

    <form action="./" method="post">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Добавить"> <a href="#" class="cancelBtn" onclick="history.back(); return false;">Отмена</a>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Заголовок', $this->errorFields)){ ?>errorField<? } ?>">Заголовок:</td>
                <td class="elements">
                    <input class="text" name="pages[title]" value="<?php echo @html::specialchars($_POST['pages']['title']) ?>" />
                </td>
            </tr>

            <? if($pages->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Разместить перед', $this->errorFields)){ ?>errorField<? } ?>">Разместить перед:</td>
                    <td class="elements">
                        <select name="pages[sort]">

                            <?php
                            $lastSort = 0; $counter = 0;
                            foreach ($pages as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

                                <option value="<?php echo $champEntry->sort ?>">
                                    <?php echo $counter . ". " .$champEntry->title ?>
                                </option>

                            <?php } ?>

                            <option value="<?=($lastSort + 1)?>">В самый конец</option>

                        </select>
                        <div class="smallInfo"><br/></div>
                    </td>
                </tr>

            <? } ?>

            <tr>
                <td class="label <? if(in_array('Содержание', $this->errorFields)){ ?>errorField<? } ?>">Содержание:</td>
                <td class="elements">

                    <textarea id="pages_content" rows="3" cols="2" name="pages[content]"><?php
                        echo @html::specialchars($_POST['pages']['content'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
 
                </td>
            </tr>

             <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Добавить"> <a href="#" class="cancelBtn" onclick="history.back(); return false;">Отмена</a>
                </td>
            </tr>

        </table>

    </form>

</center>
 