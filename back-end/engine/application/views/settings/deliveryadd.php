
<center>

    <form action="" method="post">

        <? if(!$delivery->count()) { ?>
            <input name="delivery[sort]" value="1" type="hidden"/>
        <? } ?>
        
        <table class="form">
  
  		<tr >
                <td class="label"></td>
                <td class="elements topHandler">
				<input type="submit" value="Добавить"> 
				<a href="/settings/delivery" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			
            <tr>
                <td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?> ">Название:</td>
                <td class="elements">
                    <input name="delivery[title]" class="text" value="<?php echo @html::specialchars($_POST['delivery']['title']) ?>" />
                    <div class="smallInfo">
                        Пример: Курьером по Москве, экспресс-доставка
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Шаблон доставки', $this->errorFields)){ ?>errorField<? } ?> ">Шаблон доставки:</td>
                <td class="elements">
                    <select name="delivery[type]">

                        <option value="" disabled="disabled">-</option>

                        <?php foreach ($GLOBALS['DELIVERY'] as $cat_key => $cat_val) {  ?>

                            <option  <?php if(isset($_POST['delivery']['type']) && $cat_key == $_POST['delivery']['type']) {
                                ?>selected="selected" <?php } ?> value="<?php echo $cat_key ?>"><?php echo $cat_val ?></option>

                        <?php } ?>

                    </select>
                    <div class="smallInfo">В зависимости от выбранного шаблона, для оформления заказа, от покупателя будут требоваться ввести
                        соответствующие поля.</div>
                </td>
            </tr>
			
            <tr>
                <td class="label <? if(in_array('Фиксированная стоимость', $this->errorFields)){ ?>errorField<? } ?> ">Фиксированная стоимость:</td>
                <td class="elements">
                    <input name="delivery[cost]"  class="text"value="<?php echo @html::specialchars($_POST['delivery']['cost']) ?>" />
                    <div class="smallInfo">
                        Если доставка подразумевает фиксированную стоимость, заполните это поле. К примеру 300 р. 
	                    Если стоимость
	                    доставки не известна, оставьте это поле пустым.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Особые условия', $this->errorFields)){ ?>errorField<? } ?>">Особые условия:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="delivery[conditions]" id="delivery_conditions"><?php
                        echo @html::specialchars($_POST['delivery']['conditions'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    <div class="smallInfo">
                        Здесь вы можете указать специфические условия, которые будут отображаться при выборе этого способа доставки.
                        К примеру: при доставке за МКАД - стоимость доставки будет дороже на 200 руб. (до 10км).
                    </div>
                </td>
            </tr>

            <? if($delivery->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Разместить перед', $this->errorFields)){ ?>errorField<? } ?> ">Разместить перед:</td>
                    <td class="elements">
                        <select name="delivery[sort]">

                            <?php
                            $lastSort = 0; $counter = 0;
                            foreach ($delivery as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

                                <option value="<?php echo $champEntry->sort ?>">
                                    <?php echo $counter . ". " .$champEntry->title ?>
                                </option>

                            <?php } ?>

                            <option value="<?=($lastSort + 1)?>">В самый конец</option>

                        </select>
                        <div class="smallInfo">Выберите расположение среди уже созданных способов доставки</div>
                    </td>
                </tr>
         
            <? } ?>
			
		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Добавить"> 
				<a href="/settings/delivery" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
 

        </table>

    </form>

</center>
	