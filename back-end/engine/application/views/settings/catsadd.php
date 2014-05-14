
<center>

    <form action="/settings/catsadd" method="post">

        <? if(!$cats->count()) { ?>
            <input name="cats[sort]" value="1" type="hidden"/>
        <? } ?>
        
        <table class="form">
  
            <tr>
                <td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?>">Название:</td>
                <td class="elements">
                    <input Title="Укажите название новой категории товара" name="cats[title]" class="text" value="<?php echo @html::specialchars($_POST['cats']['title']) ?>" />
                    <div class="smallInfo">
                        Ограничения по длине 55 символов.
                    </div>
                </td>
            </tr>

            <? if($cats->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Разместить перед', $this->errorFields)){ ?>errorField<? } ?>">Разместить перед:</td>
                    <td class="elements">
                        <select name="cats[sort]" Title="Выберите расположение среди других категорий" >

                            <?php
                            $lastSort = 0; $counter = 0;
                            foreach ($cats as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

                                <option value="<?php echo $champEntry->sort ?>">
                                    <?php echo $counter . ". " .$champEntry->title ?>
                                </option>

                            <?php } ?>

                            <option value="<?=($lastSort + 1)?>">В самый конец</option>

                        </select> 
                    </td>
                </tr>

                <tr>
                    <td class="label <? if(in_array('Развёрнутое описание', $this->errorFields)){ ?>errorField<? } ?>">Развёрнутое описание:</td>
                    <td class="elements">
                        <textarea rows="3" cols="4" id="cat_content" name="cats[desc]"><?php
                            echo @html::specialchars($_POST['cats']['desc'])
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
				<input type="submit" value="Добавить"> 
				<a href="/settings/cat" class="cancelBtn"  title="Перейти к списку категоий" >Отмена</a>
                </td>
            </tr>
			 
        </table>

    </form>

</center>
