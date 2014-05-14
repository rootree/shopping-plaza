
<center>

    <form action="" method="post">

        <input name="fieldsadd[proceed]" value="0" id="proceed" type="hidden"/>

        <? if(!$cats->count()) { ?>
            <input name="fieldsadd[sort]" value="1" type="hidden"/>
        <? } ?>
        
        <table class="form">
  
            <tr>
                <td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?> ">Название:</td>
                <td class="elements">
                    <input name="fieldsadd[title]" class="text" value="<?php echo @html::specialchars($_POST['fieldsadd']['title']) ?>" />
 				    <div class="smallInfo">
					    Пример: Габариты, Производитель или Цвет.
                    </div>
                </td>
            </tr>

            <? if($cats->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Разместить перед', $this->errorFields)){ ?>errorField<? } ?> ">Разместить перед:</td>
                    <td class="elements">
                        <select name="fieldsadd[sort]">

                            <?php
                            $lastSort = 0; $counter = 0;
                            foreach ($cats as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

                                <option value="<?php echo $champEntry->sort ?>">
                                    <?php echo $counter . ". " .$champEntry->title ?>
                                </option>

                            <?php } ?>

                            <option value="<?=($lastSort + 1)?>">В самый конец</option>

                        </select>

                        <div class="smallInfo">Выберите расположение среди уже созданных характеристик</div>
                    </td>
                </tr>
        
            <? } ?>

            <tr style="display:none">
                <td class="label"></td>
                <td class="elements">
                    <label><input type="checkbox" name="fieldsadd[excel]" value="1" > Поместить характеристику в Excel-прайса </label>
					
				<div class="smallInfo">
					При автоматическом составлении Excel-прайса вашего Интернет-магазина, данное характеристика будет включена в него.
                    </div>
                </td>
            </tr>

		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Добавить"> 
				<input onclick="$('#proceed').val('1')" type="submit" value="Добавить и продолжить добавлять">
				<a href="/settings/fields/catsubid/<?=$catsubid?>" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
 

        </table>

    </form>

</center>