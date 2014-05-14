<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">
 
			
            <tr>
                <td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?> ">Название:</td>
                <td class="elements">
                    <input name="cats[title]" class="text"  value="<?php echo @(isset($_POST['cats']['title'])) ? html::specialchars($_POST['cats']['title']) : html::specialchars($user->title)  ?>" />
                    <div class="smallInfo">
                        Ограничения по длине 55 символов.
                    </div>
                </td>
            </tr>
 
            <? if($cats->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Позиция перед', $this->errorFields)){ ?>errorField<? } ?> ">Позиция перед:</td>
                    <td class="elements">
                    
                       <select name="cats[sort]">

                            <?php
                            $lastSort = 0; $counter = 0;

                            $len = count($cats);
                            $possDetected = false;

                            for ($i = 0; $i < $len; $i ++) {   $counter ++;

                                $champEntry = $cats[$i];
                                $lastSort = $champEntry->sort;

                                ?>

                                <option value="<?php echo $champEntry->sort ?>"
                                    <?=(($champEntry->cat_id == $user->cat_id) ? 'disabled="disabled"' : '') ?>
                                    <? if(isset($cats[$i - 1]) && (($cats[$i - 1]->sort) == $user->sort)) {
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
                <tr>
                    <td class="label <? if(in_array('Развёрнутое описание', $this->errorFields)){ ?>errorField<? } ?> ">Развёрнутое описание:</td>
                    <td class="elements">
                        <textarea rows="3" cols="4" id="cat_content" name="cats[desc]"><?php
                            echo @html::specialchars($user->desc)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                         <div class="smallInfo">
                                Когда пользователь попадает в категорию, первым делом он увидит это описание.
                                <br/><br/>
                                Полезно для описания товаров, которые будут перечислены в этой категории.

                            </div>
                    </td>
                </tr>

            <? } ?>
   
   
		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Изменить"> 
				<a href="/settings/cats" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
		 

        </table>

    </form>

</center>