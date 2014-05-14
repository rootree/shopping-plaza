<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Сохранить">
                    <a href="/settings/users" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			
            <tr>
                <td class="label <? if(in_array('Ваше имя', $this->errorFields) || in_array('Имя администратора', $this->errorFields)){ ?>errorField<? } ?> "><?=($this->editUserSelf ? 'Ваше имя:' : 'Имя администратора:')  ?></td>
                <td class="elements">
                    <input   title="Указанное имя будет показываться в панели управления и в переписке с пользователями" class="text" name="user[user_name]" value="<?php echo @(isset($_POST['user']['user_name'])) ? html::specialchars($_POST['user']['user_name']) : html::specialchars($user->user_name)  ?>" />
                </td>
            </tr>
            <tr>
                <td class="label <? if(in_array('Электронный адрес', $this->errorFields)){ ?>errorField<? } ?> ">Электронный адрес:</td>
                <td class="elements">
                    <input  class="text" name="user[user_mail]" value="<?php echo @(isset($_POST['user']['user_mail'])) ? html::specialchars($_POST['user']['user_mail']) : html::specialchars($user->user_mail)  ?>" />
                    <div class="smallInfo">

                        Электронный адрес используется при авторизации пользователя в панели управления Интернет-магазином.<br/><br/>

                        <? if(!empty($user->user_mail_new)) { ?>

                            <b>Указан новый адрес электронной почты (<?=$user->user_mail_new?>), <?=($this->editUserSelf ? 'вы ещё не подтвердили его' : 'администратор ещё не подтвердил его')  ?> .</b><br/><br/>

                            Внимание! Чтобы подтвердить принадлежность нового адреса электронной почты к <?=($this->editUserSelf ? 'вам' : 'администратору магазина')  ?>, на указанный адрес будет выслано письмо с инструкций по его подтверждению. Только после проходжения инструкции в письме, к <?=($this->editUserSelf ? 'вам' : 'администратору магазина')  ?> будет привязан новый адрес электронной почты.

                        <? } ?>

                    </div>
                </td>
            </tr>

            <? if($this->editUserSelf) { ?>

                <? if(!$emptyPass) { ?>
                    <tr>
                        <td class="label <? if(in_array('Текущий пароль', $this->errorFields)){ ?>errorField<? } ?> ">Текущий пароль:</td>
                        <td class="elements">
                            <input autocomplete="off"  type="password" class="text" name="user[user_word_current]" value="" />
                            <div class="smallInfo">
                                Для смены пароля укажите текущий пароль, придумайте и укажите новый, и подтвердите новый пароль. Если вы не хотите менять пароль для входа в панель управления Интернет-магазином, оставьте эти поля пустыми.
                            </div>
                        </td>
                    </tr>
                <? } ?>
				
                <tr>
                    <td class="label <? if(in_array('Новый пароль', $this->errorFields)){ ?>errorField<? } ?> ">Новый пароль:</td>
                    <td class="elements">
                        <input autocomplete="off" type="password" class="text" name="user[user_word]" value="" />
                    </td>
                </tr>

                <tr>
                    <td class="label <? if(in_array('Повторите новый пароль', $this->errorFields)){ ?>errorField<? } ?> ">Повторите новый пароль:</td>
                    <td class="elements">
                        <input autocomplete="off"  type="password" class="text" name="user[user_word_re]" value="" />
                    </td>
                </tr>

            <? } ?>

     <!--       <tr>
                <td class="label">Возможности администратора:</td>
                <td class="elements">

                    <label><input type="checkbox" name="firms[access][]" value="<?=ACCESS_ADMIN?>" <?php echo ($user->user_right & ACCESS_ADMIN) ? 'checked="checked"' : "" ?>> Главей админ</label><br/>
                    <label><input type="checkbox" name="firms[access][]" value="<?=ACCESS_MODER?>" <?php echo ($user->user_right & ACCESS_MODER) ? 'checked="checked"' : "" ?>> Модератор</label><br/>

                    <div class="smallInfo">
                        Отметьте галочками, какой доступ <?=($this->editUserSelf ? 'вы хотите получить' : 'требуеться для администратора')  ?>.
                    </div>
                </td>
            </tr>
   -->
		<tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
				<input type="submit" value="Сохранить">
				<a href="/settings/users" class="cancelBtn"  >Отмена</a>
                </td>
            </tr>
			 
        </table>

    </form>

</center>