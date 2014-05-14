<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<div class="pageband">

    <div class="container">

      <div class="pagetitle">
        <h1>Регистрация Интернет-магазина</h1>
      </div>

    </div>

</div>
 
<form action="/reg/index/plan/<?=$plan?>" method="post">

<div class="container" style="text-align:center;">
 

    <div class="leftcolumn" style="margin-left: 150px;">

          <div class="banner">
 
          </div>

        <div class="contents" id="formStart">

            <div class="account section">

                <? if(!is_null($this->error)) { ?><span id="serverError">

                    <h3>По следующим причинам регистрация не может быть завершина, исправте ошибки и повторите попытку:</h3>
 
                    <p class="error">
                        <?php echo $this->error ?>
                    </p>
                    
                </span><? } ?>

                <table>

                    <tbody><tr>
                        <td class="regFormTable"><label for="signup_title">Название:</label></td>
                        <td><input autocomplete="off" id="signup_title" size="24" name="firms[title]" value="<?php echo @html::specialchars($_POST['firms']['title']) ?>" />
                        <br/>
                        Укажите название вашего будущего Интернет-магазина.

                            <br/><br/><p class="error" id="error_title" style="display: none;">Укажите пожалуйста название вашего будущего Интернет-магазина</p>

                        </td>
                    </tr>
                    <tr>
                        <td class="regFormTable"><label for="signup_domain">Домен:</label></td>
                        <td><input onfocus="$('#signup_own_domain').val('');" autocomplete="off" size="14" id="signup_domain" name="firms[domain]" value="<?php echo @html::specialchars($_POST['firms']['domain']) ?>" /><strong>.shopping-plaza.ru</strong>
                        <br>
                            Название домена может содержать только латинские буквы в нижнем регистре, цифры и тире, пример: <big><u>n-23</u></big><small>.shopping-plaza.ru</small> .

                            <br/><br/><label for="signup_own_domain">Или, вы можете указать свой домен, если он есть:</label>

                            <br/>

                            <input autocomplete="off" onfocus="$('#signup_domain').val('');" id="signup_own_domain" size="24" name="firms[domain_own]" value="<?php echo @html::specialchars((!empty($_POST['firms']['domain']) ? '' : $_POST['firms']['domain_own'])) ?>" />
                            <br/>О там как настроить управление магазином на вашем домене будет описано позже.


                            <p class="error" id="error_domain" style="display: none; margin-top: 15px;">Домен для Интернет-магазина не выбран, сделайте это пожалуйста</p>

                        </td>
                    </tr>

                    </tbody></table>


                <fieldset class="credentials">
                    <legend>Добавление администратора магазина</legend>

                    <!--
                      <div class="offer_to_sign_in">
                        Already use a 37signals product? <a href="#z/sign_in">Sign in</a> with the username you already have.
                      </div>
                    -->

                    <div id="username_entry">
                        <p class="field">
                            <label for="signup_username">Ваше имя</label><br>

                            <input autocomplete="off" id="signup_username" size="30" name="firms[userName]" value="<?php echo @html::specialchars($_POST['firms']['userName']) ?>" />

                            <p class="error" id="error_username" style="display: none;">Вы не указали как вас зовут</p>
                        
                        </p>

                        <p class="field">
                            <label for="signup_mail">Электронный адрес</label><br>

                            <input autocomplete="off" id="signup_mail" size="30" name="firms[userMail]" value="<?php echo @html::specialchars($_POST['firms']['userMail']) ?>" />
                            <br>
                            <span id="username_hint">По указанному электронному адресу вы будете авторизовываться в панели управления магазином.</span>

                            <p class="error" id="error_mai" style="display: none;">Укажите ваш адрес электронной почты</p>
                        </p>

                        <p class="field">
                            <label for="signup_password">Пароль</label><br>

                            <input autocomplete="off" id="signup_password" size="30"  type="password" name="firms[userPass]"  />

                            <br>
                            От 6-ти символом или больше, для лучшей надёжности.

                            <p class="error" id="error_password" style="display: none;">Пароль не был указан</p>

                        </p>

                        <p class="field">
                            <label for="signup_password_confirmation">Повторите ваш пароль для уверенности, что нет ошибки</label><br>
                            <input autocomplete="off" id="signup_password_confirmation" name="firms[password_confirmation]" size="30" type="password">

                            <p class="error" id="error_confirmation_empty" style="display: none;">Введите пароль ещё раз</p>
                            <p class="error" id="error_confirmation" style="display: none;">Указанный пароль и его подтверждение не совпадают, убедитесь что вы правильно ввели пароль и подтвердите его в поле подтверждения</p>

                        </p>
                    </div>
                </fieldset>


            </div>

 
            <div class="clear"></div>

   <!--         <div class="amount">

                <p class="instruction">

                    <? $nextmonth = mktime (0,0,0,date("m") + 1 ,date("d"), date("Y"));   ?>
                    <strong>Вы сможете бесплатно пользоваться вашим Интернет-магазином до <?=date(DATE_FORMAT_LITE, $nextmonth)?>.</strong>
                    Если вы захотите и дальше пользоваться магазином, вам потребуется оплатить <?=getPriceByPlan($plan)?> руб. за каждый последующий месяц,
                    согласно выбранному тарифному плану.
                    В противном случае ваш Интернет-магазин будет заблокирован.
                    <strong>Вы всегда сможете поменять тарифный план или отказаться от продления аккаунта.</strong>
                </p>

            </div>

            <div class="rule last"></div>
  -->
            <p class="instruction">
                Кликнув на <strong>Создать магазин</strong> вы соглашаетесь с
                <a href="/terms" target="_blank">Условиями использования</a> и
                <a href="/privacy" target="_blank">Политика конфиденциальности</a><!--,
                <a href="/refund" target="_blank">Условиями возврата</a>.  -->
            .</p>

            <input onclick="return checkRegForm();" alt="Create my account" src="/publicIMG/btn-createaccount.png" type="image"   >

        </div>
        <div class="bottom">
            <img alt="Shadow-bottom" height="20" src="/publicIMG/shadow-bottom.png" width="645">
        </div>
    </div>
</div>


 </form>
 