<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Сохранить"> <a href="/pages/info/id/<?=$item->page_id?>/" class="cancelBtn" >Отмена</a>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Заголовок', $this->errorFields)){ ?>errorField<? } ?>">Заголовок:</td>
                <td class="elements">
                    <input class="text" name="pages[title]" value="<?php echo @html::specialchars($item->title) ?>" />
                </td>
            </tr>

            <? if($pages->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Позиция перед', $this->errorFields)){ ?>errorField<? } ?>">Позиция перед:</td>
                    <td class="elements">

                       <select name="pages[sort]">

                            <?php
                            $lastSort = 0; $counter = 0;

                            $len = count($pages);
                            $possDetected = false;

                            for ($i = 0; $i < $len; $i ++) {   $counter ++;

                                $champEntry = $pages[$i];
                                $lastSort = $champEntry->sort;

                                ?>

                                <option value="<?php echo $champEntry->sort ?>"
                                    <?=(($champEntry->page_id == $item->page_id) ? 'disabled="disabled"' : '') ?>
                                    <? if(isset($pages[$i - 1]) && (($pages[$i - 1]->sort) == $item->sort)) {
                                        echo 'selected="selected"';
                                        $possDetected = true;
                                    } ?>>
                                    <?php echo $counter . ". " .$champEntry->title  ?>
                                </option>

                            <?php   } ?>

                            <option value="<?=($lastSort + 1)?>" <?=(!$possDetected ? 'selected="selected"' : "")?>>В самый конец</option>

                        </select>

                    </td>
                </tr>

            <? } ?>


            <tr>
                <td class="label <? if(in_array('Содержимое', $this->errorFields)){ ?>errorField<? } ?>">Содержимое:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" id="pages_content" name="pages[content]"><?php
                        echo @html::specialchars($item->content)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                </td>
            </tr>

            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Сохранить"> <a href="/pages/info/id/<?=$item->page_id?>/" class="cancelBtn" >Отмена</a>
                </td>
            </tr>
  
        </table>

    </form>

</center>