<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">
        
        <? if(isset($catssub) && !$catssub->count()) { ?>
            <input name="catssub[sort]" value="1" type="hidden"/>
        <? } ?>

        <table class="form">


            <tr>
                <td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?> ">Название:</td>
                <td class="elements">
                    <input  class="text" name="catssub[title]" value="<?php echo @(isset($_POST['catssub']['title'])) ? html::specialchars($_POST['catssub']['title']) : html::specialchars($user->title)  ?>" /> 
                </td>
            </tr>
 
             <tr>
                <td class="label <? if(in_array('Основная категория', $this->errorFields)){ ?>errorField<? } ?> ">Основная категория:</td>
                <td class="elements">
                    <select name="catssub[cat_id]"
                            onchange="if(this.value != <?=$catid?> && this.value != 0){
                            location.href='/settings/catseditsub/catid/' + this.value + '/id/' + <?= $user->catsub_id ; ?>;}">

                        <option value="0" disabled="disabled">
                            Выберите категорию
                        </option>

                        <?php
                        $lastSort = 0; $counter = 0;
                        foreach ($cats as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

                            <option value="<?php echo $champEntry->cat_id ?>"
                                <?=($catid == $champEntry->cat_id ? 'selected="selected"' : '') ?>
                                    >
                                <?php echo $counter . ". " .$champEntry->title ?>
                            </option>

                        <?php } ?>

                    </select> 
					
					<div class="smallInfo">Привязка будет осуществлена к выбранной основной категории.</div>
					
                </td>

            </tr>

            <? if(isset($catssub) && $catssub->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Разместить перед', $this->errorFields)){ ?>errorField<? } ?>">Разместить перед:</td>
                    <td class="elements">


                       <select name="catssub[sort]">

                            <?php
                            $lastSort = 0; $counter = 0;

                            $len = count($catssub);
                            $possDetected = false;

                            for ($i = 0; $i < $len; $i ++) {   $counter ++;

                                $champEntry = $catssub[$i];
                                $lastSort = $champEntry->sort;

                                ?>

                                <option value="<?php echo $champEntry->sort ?>"
                                    <?=(($champEntry->catsub_id == $user->catsub_id) ? 'disabled="disabled"' : '') ?>
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
                        <textarea rows="3" cols="4" id="cat_content" name="catssub[desc]"><?php
                            echo @html::specialchars($user->desc)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                         <div class="smallInfo">
                                Когда пользователь попадает в подкатегорию, первым делом он увидит это описание.
                                <br/><br/>
                                Полезно для описания товаров, которые будут перечислены в этой категории.

                            </div>

                    </td>
                </tr>

            <? } ?>

            <? if($catid) { ?>

			<tr >
					<td class="label"></td>
					<td class="elements bottomHandler">
					<input type="submit" value="Сохранить">
					<a href="/settings/catssub" class="cancelBtn"  >Отмена</a>
					</td>
				</tr>
		   
            <? } ?>

        </table>

    </form>

</center>