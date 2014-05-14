<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

 
<div style=" " id="sign_in" class="login_overlay">
  <div class="new_claim">
    <h2>Вход для клиентов</h2>

    <div class="products">
      <div><img alt="Shopping-Plaza.ru" src="/publicIMG/LOGO.white.png"> </div>
    </div>

    <div class="form">

      <p>Для входа в панель управления укажите свой электронный адрес и пароль, или пройдите регистрацию.</p>


        <? if(!is_null($this->error)) { ?>

            <p class="error">
                <?php echo $this->error ?>
            </p>
        
        <? } ?>

      <form action="/login" method="post"><div style="margin:0;padding:0;display:inline"><input name="authenticity_token" type="hidden" value="DmzLGUDtpmEIXgK+NLRonJQ+vIEnIVEot9mVGl7pJB8="></div>
        <table>
          <tbody class="signal_id_credentials">
            <tr class="field">
              <th>E-mail</th>
              <td><input class="autofocus" id="singin[mail]" name="singin[mail]" type="text" value="<?php echo @html::specialchars($_POST['singin']['mail']) ?>"></td>
            </tr>
            <tr class="field">
              <th>Пароль</th>
              <td><input id="password" name="singin[word]" type="password">
              <!--  <div class="options">
                  <a href="/forgot_password" target="_blank">Забыли свой пароль?</a>
                </div> -->
              </td>
            </tr>
          </tbody>
          <tbody><tr class="submit">
            <th></th>
            <td>
              <div class="submit_or_cancel">
                <input src="/publicIMG/sign_in.png" type="image"> или <a href="/">Отмена</a>
              </div>
            </td>
          </tr>
        </tbody></table>
    </form>
    </div>
  </div>
</div>
 