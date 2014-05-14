<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="/settings/firm" method="post">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
				<input type="submit" value="Изменить"> <!--<a href="#" class="cancelBtn" onclick="SPAdmin.goToURL('/dashboard'); return false;">Отмена</a>-->
				<a  title="Применение настроек и просмотр результата на сайте" target="_blank" href="http://<?=$this->firm->domain?>/feedback?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Название организации', $this->errorFields)){ ?>errorField<? } ?> ">Название организации:</td>
                <td class="elements">
                    <input class="text" name="firms[title]" value="<?php echo
                    @(isset($_POST['firms']['title'])) ? html::specialchars($_POST['firms']['title']) :
                            (!empty($firm->title_firm) ? html::specialchars($firm->title_firm) : html::specialchars($firm->title))
                     ?>" />
                    
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Описание компании', $this->errorFields)){ ?>errorField<? } ?> ">Описание компании:</td>
                <td class="elements">
                    
                    <textarea rows="3" cols="4" name="firms[descFirm]" id="firm_desc"><?php
                        echo @(isset($_POST['firms']['descFirm'])) ? html::specialchars($_POST['firms']['descFirm']) : html::specialchars($firm->descFirm)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    <div class="smallInfo">
                        Описание вашей фирмы. Можно указать преимущества над конкурентами, особенности работы. Приемущества работы с вами.
                        <br/><br/>
                        Пример: Мы - команда профессионалов в области продаж работающих в Интернет-магазине <?=(!empty($firm->title) ? '«'.html::specialchars($firm->title).'»' : '')?>,
                        съевших не одну "собаку" в процессе разных, по своей сложности, торговых переговоров.
                        Мы достигли высоких результатов, но при этом не собираемся стоять на месте.
                        Мы постоянно ищем новых поставщиков, ищем новые способы доставки, цель которых снизить стоимость предлагаемых нами товаров.
                        Развиваем торговую площадку. Повышаем качество обслуживания наших клиентов.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Юридические данные', $this->errorFields)){ ?>errorField<? } ?> ">Юридические данные:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="firms[urik]" id="firm_urik"><?php
                        echo @(isset($_POST['firms']['urik'])) ? html::specialchars($_POST['firms']['urik']) : html::specialchars($firm->urik)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    <div class="smallInfo">
                        Укажите ваши юридические реквизиты. Обязательно,  если вы хотите размещать ваши товары на торговых площадках (Яндекс.Маркет).
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Время работы', $this->errorFields)){ ?>errorField<? } ?> ">Время работы:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="firms[worktime]" id="firm_worktime"><?php
                        echo @(isset($_POST['firms']['worktime'])) ? html::specialchars($_POST['firms']['worktime']) : html::specialchars($firm->worktime)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    <div class="smallInfo">
                        Укажите график вашей работы.
                    </div>
                </td>
            </tr>


            <tr>
                <td class="label <? if(in_array('Телефон', $this->errorFields)){ ?>errorField<? } ?> ">Телефон:</td>
                <td class="elements">

                    <textarea rows="3" cols="4" name="firms[tele]" id="firms_tele"><?php
                        echo @(isset($_POST['firms']['tele'])) ? html::specialchars($_POST['firms']['tele']) : html::specialchars($firm->tele)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    <div class="smallInfo">
                        Здесь вы можете указать один или несколько телефонов для связи с вами, или отдельными отделами. Не забудте, что вам могут звонить с разных регионов, поэтому желательно указывать номера телефонов в международном формате.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Факс', $this->errorFields)){ ?>errorField<? } ?> ">Факс:</td>
                <td class="elements">
                    <input class="text" name="firms[fax]" value="<?php echo @(isset($_POST['firms']['fax'])) ? html::specialchars($_POST['firms']['fax']) : html::specialchars($firm->fax)  ?>" />
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Ваш город', $this->errorFields)){ ?>errorField<? } ?> ">Ваш город:</td>
                <td class="elements">
                    <input class="text"  title="Начните вводить ваш город, он появиться в выпадающем списке" name="firms[city]" value="<?php echo @(isset($_POST['firms']['city'])) ? html::specialchars($_POST['firms']['city']) : html::specialchars($firm->city)  ?>" />
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Адрес', $this->errorFields)){ ?>errorField<? } ?>">Адрес:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="firms[address]" id="firms_address"><?php
                        echo @(isset($_POST['firms']['address'])) ? html::specialchars($_POST['firms']['address']) : html::specialchars($firm->address)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    <div class="smallInfo">
                        Вы можете указать адрес вашего расположения, как фактический, так и юридический.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Электронный адрес', $this->errorFields)){ ?>errorField<? } ?> ">Электронный адрес:</td>
                <td class="elements">

                    <textarea rows="3" cols="4" name="firms[mail]" id="firms_mail"><?php
                        echo @(isset($_POST['firms']['mail'])) ? html::specialchars($_POST['firms']['mail']) : html::specialchars($firm->mail)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>

                    <div class="smallInfo">
                        ​Укажите электронный адрес, который будет указан как контактный. Вы можете указать несколько адресов, но тогда стоит расшифровать, на какой адрес по каким вопросам обращаться.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">ICQ:</td>
                <td class="elements">
                    <input class="text" name="firms[icq]" value="<?php echo @(isset($_POST['firms']['icq'])) ? html::specialchars($_POST['firms']['icq']) : html::specialchars($firm->icq) ?>" />

                </td>
            </tr>

            <tr>
                <td class="label">Skype:</td>
                <td class="elements">
                    <input class="text" name="firms[skype]" value="<?php echo @(isset($_POST['firms']['skype'])) ? html::specialchars($_POST['firms']['skype']) : html::specialchars($firm->skype)  ?>" />
                    <div class="smallInfo">
                        Чем больше у вашей организации каналов для связи с покупателем, тем он ближе покупатель.
                    </div>
                </td>
            </tr>

<!--
            <tr>
                <td class="label">Род деятельности:</td>
                <td class="elements">

                    <? $lastChampName = null; ?>
                    <?php foreach ($cats as $cat_key => $cat_val) {  ?>

                         <?php if($cat_key == $firm->cat) { ?><?php echo $cat_val ?> <?php } ?>

                    <?php } ?>

                    <div class="smallInfo"><br/></div>
                </td>
            </tr>
-->

            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Изменить"> <!--<a href="#" class="cancelBtn" onclick="SPAdmin.goToURL('/dashboard'); return false;">Отмена</a>-->
					
				<a  title="Применение настроек и просмотр результата на сайте" target="_blank" href="http://<?=$this->firm->domain?>/feedback?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>
  

        </table>

    </form>

</center>