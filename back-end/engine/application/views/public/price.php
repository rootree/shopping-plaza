<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>



<div class="top">

      <div class="masthead" style="padding-top:0px;">
        <h1>АКЦИЯ</h1>
        <h2>Зарегистрировавшись сейчас вы получите Интернет-магазин <br/>без каких либо ограничений и абсолютно  <b>бесплатно</b>.</h2>
      </div>

        <br/>
    
</div>

 
<div class="container" style="text-align:center;">

    <div class="statement">
        <h2>Конструктор Интернет-магазина</h2><br/>
    </div>
 
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
 
                <fieldset class="credentials">
                    
                    <legend>Выбор оплаты</legend>

                    <table>
                        <tbody>

                        <tr>
                             
                            <td>

                                <label><input checked="checked"  type="radio" size="24" name="collect[pay]" value="1" onclick="constrationAboniment();"/> Абонентская плата</label> <br/>

                                Если вам удобней платить фиксированную стоимость за услуги, эта опция для вас.<br/><br/>

                                <label><input   type="radio" size="24" name="collect[pay]" value="1" onclick="constrationPercent();" /> Процент с заказов</label><br/>
 
                                Так как у новых магазинов заказов может быть не много, и может так оказаться, что выгодней будет
                                оплачивать услуги именно как процент с заказов. А как количество заказов вырастит, перейти на фиксированную стоимость не составит труда.

                            </td>
                        </tr>
 
                    </tbody></table>

                </fieldset>




                <fieldset class="credentials">
                    <legend>Общие параметры</legend>

                    <!--
                      <div class="offer_to_sign_in">
                        Already use a 37signals product? <a href="#z/sign_in">Sign in</a> with the username you already have.
                      </div>
                    -->

                    <table> 
                        <tbody>

                        <tr>
                            <td class="regFormTable"><label>Количество товаров:</label></td>
                            <td>

                                <label><input type="radio" size="24" name="collect[items]" value="1" /> 100 позиций</label> <span class="pricer aboniment">(0 руб.)</span><span class="pricer percent">(0%)</span><br/>
                                <label><input checked="checked" type="radio" size="24" name="collect[items]" value="1" /> 500 позиций</label> <span class="pricer aboniment">(30 руб.)</span><span class="pricer percent">(0.02%)</span><br/>
                                <label><input type="radio" size="24" name="collect[items]" value="1" /> 1000 позиций</label> <span class="pricer aboniment">(50 руб.)</span><span class="pricer percent">(0.03%)</span><br/>
                                <label><input type="radio" size="24" name="collect[items]" value="1" /> 5000 позиций</label> <span class="pricer aboniment">(200 руб.)</span><span class="pricer percent">(0.1%)</span><br/>
                                <label><input type="radio" size="24" name="collect[items]" value="1" /> Без лимит</label> <span class="pricer aboniment">(1000 руб.)</span><span class="pricer percent">(1%)</span><br/>
 
                            </td>
                        </tr>

                        <tr>
                            <td class="regFormTable"><label>Количество управляющих магазина:</label></td>
                            <td>

                                <label><input type="radio" size="24" name="collect[admin]" value="1" /> 2 человека</label> <span class="pricer aboniment">(0 руб.)</span><span class="pricer percent">(0%)</span><br/>
                                <label><input checked="checked" type="radio" size="24" name="collect[admin]" value="1" /> 5 человек</label> <span class="pricer aboniment">(10 руб.)</span><span class="pricer percent">(0.01%)</span><br/>
                                <label><input type="radio" size="24" name="collect[admin]" value="1" /> 10 человек</label> <span class="pricer aboniment">(15 руб.)</span><span class="pricer percent">(0.02%)</span><br/>
                                <label><input type="radio" size="24" name="collect[admin]" value="1" /> 25 человек</label> <span class="pricer aboniment">(30 руб.)</span><span class="pricer percent">(0.05%)</span><br/>
                                <label><input type="radio" size="24" name="collect[admin]" value="1" /> Без лимит</label> <span class="pricer aboniment">(100 руб.)</span><span class="pricer percent">(0.5%)</span><br/>

                            </td>
                        </tr>

                        <tr>
                            <td class="regFormTable"><label>Дополнительные страницы:</label></td>
                            <td>

                                <label><input type="radio" size="24" name="collect[page]" value="1" /> 3 страницы</label> <span class="pricer aboniment">(0 руб.)</span><span class="pricer percent">(0%)</span><br/>
                                <label><input checked="checked" type="radio" size="24" name="collect[page]" value="1" /> 10 страниц</label> <span class="pricer aboniment">(20 руб.)</span><span class="pricer percent">(0.05%)</span><br/>
                                <label><input type="radio" size="24" name="collect[page]" value="1" /> 50 страниц</label> <span class="pricer aboniment">(30 руб.)</span><span class="pricer percent">(0.1%)</span><br/>
                                <label><input type="radio" size="24" name="collect[page]" value="1" /> Без лимит</label> <span class="pricer aboniment">(100 руб.)</span><span class="pricer percent">(0.5%)</span><br/>

                            </td>
                        </tr>

                        <tr>
                            <td class="regFormTable"><label>Пакет SMS:</label></td>
                            <td>

                                <label><input checked="checked" type="radio" size="24" name="collect[sms]" value="1" /> 0 шт.</label> <span class="pricer aboniment">(0 руб.)</span><span class="pricer percent">(0%)</span><br/>
                                <label><input type="radio" size="24" name="collect[sms]" value="1" /> 100 шт.</label> <span class="pricer aboniment">(50 руб.)</span><span class="pricer percent">(1%)</span><br/>
                                <label><input type="radio" size="24" name="collect[sms]" value="1" /> 500 шт.</label> <span class="pricer aboniment">(200 руб.)</span><span class="pricer percent">(1%)</span><br/>
                                <label><input type="radio" size="24" name="collect[sms]" value="1" /> 1000 шт.</label> <span class="pricer aboniment">(500 руб.)</span><span class="pricer percent">(1%)</span><br/>
                                <label><input type="radio" size="24" name="collect[sms]" value="1" /> 5000 шт.</label> <span class="pricer aboniment">(1700 руб.)</span><span class="pricer percent">(1%)</span><br/>

                            </td>
                        </tr>
                        
                    </tbody></table>

                </fieldset>



                

                <fieldset class="credentials">
                    <legend>Дополнительные опции</legend>

                    <!--
                      <div class="offer_to_sign_in">
                        Already use a 37signals product? <a href="#z/sign_in">Sign in</a> with the username you already have.
                      </div>
                    -->

                    <table>
                        <tbody>

                        <tr>
                            <td class="regFormTable"><label>Модули:</label></td>
                            <td>

                                <label><input type="checkbox" name="collect[news]" value="1" /> Новости</label>
                                <span class="pricer aboniment">(50 руб.)</span><span class="pricer percent">(0.15%)</span><br/>

                                <label><input type="checkbox" name="collect[part]" value="1" /> Партнёры</label>
                                <span class="pricer aboniment">(50 руб.)</span><span class="pricer percent">(0.15%)</span><br/>

                                <label><input type="checkbox" name="collect[vac]" value="1" /> Вакансии</label>
                                <span class="pricer aboniment">(50 руб.)</span><span class="pricer percent">(0.15%)</span><br/>

                                Дополнительные опции на ваше усмотрение.

                            </td>
                        </tr>


                    </tbody></table>

                </fieldset>

                

            </div>


            <div class="clear"></div>

            <div class="amount">
 
                <div style="padding-top: 10px; text-align: right; font-style:italic; font-size: 20px; float:right;"><span class="aboniment">0 руб.</span><span class="percent">0%</span></div>

                <p class="instruction">
                    <strong>Стоимость выбранных опций в месяц:</strong><br/>
                </p>

            </div>

            <div class="rule last"></div>

            <br/>

            <input onclick="document.location.href = '/reg/index/plan/free'; return false;" alt="Create my account" src="/publicIMG/btn_signupchart_large.png" type="image"   >
 
        </div>
        <div class="bottom">
            <img alt="Shadow-bottom" height="20" src="/publicIMG/shadow-bottom.png" width="645">
        </div>
    </div>
</div>

<script type="text/javascript">
    constrationAboniment();
</script>
