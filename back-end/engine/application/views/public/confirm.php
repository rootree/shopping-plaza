<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<div class="pageband">

    <div class="container">

      <div class="pagetitle">
        <h1>Активация аккаунта</h1>
      </div>

    </div>

</div>
 
<form action="/confirm" method="post">

<div class="container" style="text-align:center;">
 

    <div class="leftcolumn">

          <div class="banner">
 
          </div>

        <div class="contents" id="formStart">

            <div class="account section">

                <? if(!is_null($this->error)) { ?>

                    <span id="serverError">

                        <h3>По следующим причинам активация аккаунта не может быть заверещена:</h3>

                    <p class="error">
                        <?php echo $this->error ?>
                    </p>
                    
                </span>

                <? } ?>

                    <div  >
                        
                        <p class="field">

                            <label >Код активации: </label>

                            <input autocomplete="off"  size="34" name="code" value="<?php echo @html::specialchars($code) ?>" />

                            <p class="error" id="error_username" style="display: none;">Вы не указали как вас зовут</p>
                        
                        </p>
                        
                    </div> 

            </div>

 
             
            <div class="rule last"></div>

            <p class="instruction">
                Вы попали на страницу активации электронного адреса пользователей, зарегистрированных в сервисе Shopping-Plaza.
                Для активации аккаунта, у вас должен быть <strong>Код активации</strong>, вставьте его в соответствующее поле и нажмите кнопку
                <strong>Активировать</strong>. Это точно даст нам понять, что указанный при регистрации электронный адрес, принадлежит именно вам,
                и ошибки никакой не произошло.
            </p>
 
            <input onclick="return checkRegForm();" alt="Активировать" src="/publicIMG/btn-activate.png" type="image"   >

        </div>
        <div class="bottom">
            <img alt="Shadow-bottom" height="20" src="/publicIMG/shadow-bottom.png" width="645">
        </div>
    </div>
</div>


 </form>
 