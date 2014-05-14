
<center>

    <form action="" method="post">

        <? if(!$payway->count()) { ?>
            <input name="pay[sort]" value="1" type="hidden"/>
        <? } ?>
        
        <table class="form">
 
 		<tr >
                <td class="label"></td>
                <td class="elements topHandler">
				<input type="submit" value="Добавить"> 
				<a href="/settings/pay" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			 
            <tr>
                <td class="label <? if(in_array('Название', $this->errorFields)){ ?>errorField<? } ?> ">Название:</td>
                <td class="elements">
                    <input name="pay[title]"  class="text" value="<?php echo @html::specialchars($_POST['pay']['title']) ?>" />
                    <div class="smallInfo">
                        Пример: Оплата банковским переводом
                    </div>
                </td>
            </tr>


            <? if($delivery->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('При доставке', $this->errorFields)){ ?>errorField<? } ?> ">При доставке:</td>
                    <td class="elements">
                        
                        <select name="pay[delivery]" id="deliveryType">

                            <?php
                            $lastSort = 0; $counter = 0;
                            foreach ($delivery as $dev) { ?>

                                <option value="<?php echo $dev->del_id ?>"
                                    <?=((isset($_POST['pay']['delivery']) && $_POST['pay']['delivery'] == $dev->del_id) ? 'selected="selected"' : '') ?>
                                        ><?php echo html::specialchars($dev->title) ?>
                                </option>

                            <?php } ?>

                        </select>

                        <div class="smallInfo">Выберите способ доставки, при котором будет появляться данный выбор оплаты.</div>
                        
                    </td>
                </tr> 
            <? } ?>


            <tr>
                <td class="label <? if(in_array('Тип клиента', $this->errorFields)){ ?>errorField<? } ?> ">Тип клиента:</td>
                <td class="elements">
                    <select name="pay[type]">

                        <option value="" disabled="disabled">-</option>

                        <?php foreach ($GLOBALS['CLIENT_TYPE'] as $cat_key => $cat_val) {  ?>

                            <option  <?php if(isset($_POST['pay']['type']) && $cat_key == $_POST['pay']['type']) {
                                ?>selected="selected" <?php } ?> value="<?php echo $cat_key ?>"><?php echo $cat_val ?></option>

                        <?php } ?>

                    </select>
                    <div class="smallInfo">Укажите тип клиента, на которого рассчитан данные тип оплаты.</div>
					
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Требуемые поля', $this->errorFields)){ ?>errorField<? } ?> ">Требуемые поля:</td>
                <td class="elements">

                    <select name="pay[field_type]">

                        <option value="" disabled="disabled">-</option>

                        <?php foreach ($GLOBALS['FIELD_TYPE'] as $cat_key => $cat_val) {  ?>

                            <option  <?php if(isset($_POST['pay']['field_type']) && $cat_key == $_POST['pay']['field_type']) {
                                ?>selected="selected" <?php } ?> value="<?php echo $cat_key ?>"><?php echo $cat_val ?></option>

                        <?php } ?>

                    </select>
                
                    <div class="smallInfo">
                        В зависимости то выбранного варианта, от покупателя будут требоваться ввести соответствующие поля, для оформления заказа.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Особые условия', $this->errorFields)){ ?>errorField<? } ?> ">Особые условия:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="pay[conditions]" id="pay_conditions"><?php
                        echo @html::specialchars($_POST['pay']['conditions'])
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    <div class="smallInfo">
                        Здесь вы можете указать специфические условия, которые будут отображаться при выборе этого способы оплаты.
                        К примеру: при оплате заказа банковским переводом, заказ будет обработан сразу же после поступление денежных
                        средств на счёт Интернет-магазина.
                    </div>
                </td>
            </tr>

            <? if($payway->count()) { ?>
                <tr>
                    <td class="label <? if(in_array('Разместить перед', $this->errorFields)){ ?>errorField<? } ?>">Разместить перед:</td>
                    <td class="elements">
                        <select name="pay[sort]"  id="payType" >

                            <option delivery="0" value="0">...</option>

                            <?php
                            $lastSort = 0; $counter = 0;
                            foreach ($payway as $champEntry) {  $lastSort = $champEntry->sort ; $counter ++ ?>

                                <option delivery="<?=$champEntry->delivery?>" value="<?php echo $champEntry->sort ?>">
                                    <?php echo $champEntry->title ?>
                                </option>

                            <?php } ?>

                            <option delivery="0" id="end" value="<?=($lastSort + 1)?>">В самый конец</option>

                        </select>
                         
                    </td>
                </tr>
        
            <? } ?>
			  
		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Добавить"> 
				<a href="/settings/pay" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			  
        </table>

    </form>

</center>


<script type="text/javascript">
 
    function updateAgreement(e, fromSelf)
	{
		// защита от рекурсии
		fromSelf = fromSelf || false;
		if (fromSelf) return;

		var shopID	= $('#deliveryType option:selected').val();
		var agreements	= $('#payType option');
        var selectedAgree = 0;

        agreements.each(function(){
            $(this).show();
			if($(this).attr('delivery') != shopID && parseInt(shopID) > 0 && selectedAgree != 0)
            {
                $(this).hide();
            }
            if(selectedAgree == 0)
            {
                $(this).show();
                $(this).attr('selected', 'selected');
            }
            selectedAgree ++;
        });

        $("#end").show();
	}


		$("#deliveryType").change(updateAgreement).keypress(updateAgreement);

        updateAgreement(null, null);


</script>