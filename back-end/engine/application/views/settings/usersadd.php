
<center>

    <form action="" method="post">

        <table class="form">
  
  		<tr >
                <td class="label"></td>
                <td class="elements topHandler">
				<input type="submit" value="Добавить"> 
				<a href="/settings/users" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			
            <tr>
                <td class="label <? if(in_array('Имя администратора', $this->errorFields)){ ?>errorField<? } ?> ">Имя администратора:</td>
                <td class="elements">
                    <input   title="Указанное имя будет показываться в панели управления и в переписке с пользователями" class="text" name="firms[userName]" value="<?php echo @html::specialchars($_POST['firms']['userName']) ?>" />
                </td>
            </tr>
   
            <tr>
                <td class="label <? if(in_array('Электронный адрес', $this->errorFields)){ ?>errorField<? } ?> ">Электронный адрес:</td>
                <td class="elements">
                    <input class="text" name="firms[userMail]" value="<?php echo @html::specialchars($_POST['firms']['userMail']) ?>" />
                    <div class="smallInfo"> 

​Электронный адрес используется при авторизации пользователя в панели управления Интернет-магазином.<br/><br/>
Внимание! Новому администратору будет выслано письмо с приглашением присоединиться к вашему Интернет-магазину.
                        
                    </div>
                </td>
            </tr>

<!--           <tr>
                <td class="label">Возможности администратора:</td>
                <td class="elements">
                    
                    <label><input type="checkbox" name="firms[access][]" value="<?=ACCESS_ADMIN?>"  <?php echo (isset($_POST['firms']['access']) && in_array(ACCESS_ADMIN, $_POST['firms']['access'])) ? 'checked="checked"' : "" ?>> Главей админ</label><br/>
                    <label><input type="checkbox" name="firms[access][]" value="<?=ACCESS_MODER?>"  <?php echo (isset($_POST['firms']['access']) && in_array(ACCESS_MODER, $_POST['firms']['access'])) ? 'checked="checked"' : "" ?>> Модератор</label><br/>

                    <div class="smallInfo">
                        Отметьте галочками, какой доступ вы хотите присвоить новому администратору.
                    </div>
                </td>
            </tr>
-->
		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Добавить"> 
				<a href="/settings/users" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
		 

        </table>

    </form>

</center>