<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="/settings/content" method="post" enctype="multipart/form-data">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Сохранить"> <!--<a href="#" class="cancelBtn" onclick="SPAdmin.goToURL('/dashboard'); return false;">Отмена</a>-->
                    <a target="_blank" href="http://<?=$this->firm->domain?>?clear" class="viewOnSiteBtnText" title="Применение настроек и просмотр результата на сайте">Посмотреть результат</a>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Название Интернет-магазина', $this->errorFields)){ ?>errorField<? } ?> ">Название Интернет-магазина:</td>
                <td class="elements">
                    <input class="text"  title="Придумайте название для магазина, или укажите уже существующее" name="firms[title]" value="<?php echo @(isset($_POST['firms']['title'])) ? html::specialchars($_POST['firms']['title']) : html::specialchars($firm->title) ?>" />
                    <div class="smallInfo">
                        Указанное название будет отображаться в главном заголовке Интернет-магазина, а также в сопутствующих страницах. До 100 символов.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Деятельность', $this->errorFields)){ ?>errorField<? } ?> ">Деятельность:</td>
                <td class="elements">

                    <input class="text"  title="Например: 'Центр продаж сотовых телефонов' или 'Одежда для малышей и их мам'. Чтобы сразу отображалась суть деятельности магазина" name="firms[description]" value="<?php echo @(isset($_POST['firms']['description'])) ? html::specialchars($_POST['firms']['description']) : html::specialchars($firm->description)  ?>" />

                    <div class="smallInfo">
                        Это описание, так же как название сайта, будет отображаться на всех страницах. Опишите в нескольких словах, какую продукцию предоставляет ваш Интернет-магазин.
                        Поле ограничено до 100 символов.
                    </div>


                </td>
            </tr>

            <tr>
                <td class="label">Главный номер телефона:</td>
                <td class="elements">

                    <input class="text"  title="В произвольном формате. Пример: +7 (499) 123-45-67 или 9-54-40, но желательно с кодом города." name="firms[main_phone]" value="<?php echo @(isset($_POST['firms']['main_phone'])) ? html::specialchars($_POST['firms']['main_phone']) : html::specialchars($firm->main_phone)  ?>" />

                    <div class="smallInfo">
                        Укажите номер телефона, который будет отображаться на каждой странице сайта.
                    </div>


                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Логотип', $this->errorFields)){ ?>errorField<? } ?> ">Логотип:</td>
                <td class="elements topHandler">

                    <input type="file" class="text" name="logo"  title="Картинка в шапку магазина. Формат файла: JPG, PNG, GIF"/>

                    <div class="smallInfo">
                        Логотип будет отображаться на всех страницах вашего Интернет-магазина, а также в отправляемых вашим клиентам письмах.
                    </div>
 
                    <? if(file_exists(SuperPath::get($this->firmID, false, IMAGES_TYPE_LOGO).'.png')) { ?>
                        <img src="<?=SuperPath::get($this->firmID, true, IMAGES_TYPE_LOGO)?>.png?<?=rand(0,9999)?>" alt="Ваш логотип" />
                    <? }else{ ?>
                        <i>На данный момент логотип не загружен.</i>
                    <? } ?>

                    <br/>
                </td>
            </tr>



            <tr>
                <td class="label <? if(in_array('Водяной знак', $this->errorFields)){ ?>errorField<? } ?> ">Водяной знак:</td>
                <td class="elements topHandler">

                    <input type="file" class="text" name="watermark"  title="Можете сюда же загрузить логотип, или отдельно подготовленный водяной знак"/>

                    <div class="smallInfo">
                        Вы можете загрузить ваш фирменный водяной знак. Он будет размещаться на загружаемых изображениях товара и нужен для защиты от копирования изображений.
                        Если кто-то захочет использовать изображения с вашего сайта, то будет виден ваш водяной на нём.
                    </div>

                    <? if(file_exists(SuperPath::get($this->firmID, false, IMAGES_TYPE_WATERMARK).'.png')) { ?>
                        <img src="<?=SuperPath::get($this->firmID, true, IMAGES_TYPE_WATERMARK)?>.png?<?=rand(0,9999)?>" alt="Ваш водяной знак" />
                    <? }else{ ?>
                        <i>На данный момент водяной знак не загружен.</i>
                    <? } ?>

                    <br/>
                </td>
            </tr>




</table><h3  style="text-align:left;">Уведомления</h3> <table class="form">


            <tr>
                <td class="label <? if(in_array('Обратная связь', $this->errorFields)){ ?>errorField<? } ?> ">Обратная связь:</td>
                <td class="elements">
                    <input class="text"  name="firms[mailo]" value="<?php echo @(isset($_POST['firms']['mailo'])) ? html::specialchars($_POST['firms']['mailo']) : html::specialchars($firm->mailo)  ?>" />
                    <div class="smallInfo">
                       Укажите электронный адрес для вопросов пользователей. На указанный электронный адрес будут высылаться письма от пользователей, созданные с помощью формы обратной связи расположенной в Интернет-магазине.

                        <br/><br/>Этот адрес НЕ будет виден на сайте. Он служит только для уведомлений.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('SMS отправитель', $this->errorFields)){ ?>errorField<? } ?> ">SMS отправитель:</td>
                <td class="elements">
                    <input class="text"  title="Не указывайте отправителя типа: МТС или Билайн, и в таком духе. Указать надо сокращённое название вашего магазина." name="firms[sms_title]" value="<?php echo @(isset($_POST['firms']['sms_title'])) ? html::specialchars($_POST['firms']['sms_title']) : html::specialchars($firm->sms_title)  ?>" />
                    <div class="smallInfo">
                        Укажите заголовок отправителя латинскими буквами, 11 символов.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('SMS оповещения для', $this->errorFields)){ ?>errorField<? } ?> ">SMS оповещения для:</td>
                <td class="elements">
                    <input class="text" name="firms[sms_number]" value="<?php echo @(isset($_POST['firms']['sms_number'])) ? html::specialchars($_POST['firms']['sms_number']) : html::specialchars($firm->sms_number)  ?>" />
                    <div class="smallInfo">
                        Нужно указать номер, на который будут присылаться SMS оповещения, к примеру: 79258822456. 10-ть символов, номер должен начинаться на 7.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('SMS оповещения', $this->errorFields)){ ?>errorField<? } ?> ">SMS оповещения:</td>
                <td class="elements">

                    <label><input type="checkbox" name="firms[sms_settings][]" value="<?=SMS_ON_AMDIN_NEW_ORDER?>" <?php echo ($firm->sms_settings & SMS_ON_AMDIN_NEW_ORDER) ? 'checked="checked"' : "" ?>> Поступил новый заказ</label><br/>
                    <label><input type="checkbox" name="firms[sms_settings][]" value="<?=SMS_ON_AMDIN_NEW_FEEDBACK?>" <?php echo ($firm->sms_settings & SMS_ON_AMDIN_NEW_FEEDBACK) ? 'checked="checked"' : "" ?>> Сообщение от пользователя</label><br/>
                    <label><input type="checkbox" name="firms[sms_settings][]" value="<?=SMS_ON_AMDIN_NEW_CALLBACK?>" <?php echo ($firm->sms_settings & SMS_ON_AMDIN_NEW_CALLBACK) ? 'checked="checked"' : "" ?>> Оставлен номер для обратного звонка</label><br/>
                    <label><input type="checkbox" name="firms[sms_settings][]" value="<?=SMS_ON_AMDIN_COMMENT?>" <?php echo ($firm->sms_settings & SMS_ON_AMDIN_COMMENT) ? 'checked="checked"' : "" ?>> Оставлен коментарии</label><br/>

                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Коментарии', $this->errorFields)){ ?>errorField<? } ?> ">Коментарии:</td>
                <td class="elements">

                    <label><input  title="Разрешить пользователям комментировать ваши товары" type="checkbox" name="firms[comment_settings][]" value="<?=COMMENT_ON_ITEMS?>" <?php echo ($firm->comment_settings & COMMENT_ON_ITEMS) ? 'checked="checked"' : "" ?>> для продукции</label><br/>
                    <label><input   title="Разрешить пользователям комментировать ваши новости" type="checkbox" name="firms[comment_settings][]" value="<?=COMMENT_ON_NEWS?>" <?php echo ($firm->comment_settings & COMMENT_ON_NEWS) ? 'checked="checked"' : "" ?>> для новостей</label><br/>
                    <label><input   title="Разрешить пользователям комментировать ваши статьи" type="checkbox" name="firms[comment_settings][]" value="<?=COMMENT_ON_ARTICLE?>" <?php echo ($firm->comment_settings & COMMENT_ON_ARTICLE) ? 'checked="checked"' : "" ?>> для статей</label><br/>

                    <div class="smallInfo">
                        Комментарии позволяют узнавать мнения пользователей, поэтому рекомендуем их включить.
                    </div>

                </td>
            </tr>

    <tr >
        <td class="label"></td>
        <td class="elements bottomHandler">
            <input type="submit" value="Сохранить"> <!--<a href="#" class="cancelBtn" onclick="SPAdmin.goToURL('/dashboard'); return false;">Отмена</a>-->
            <a target="_blank" href="http://<?=$this->firm->domain?>?clear"  title="Применение настроек и просмотр результата на сайте" class="viewOnSiteBtnText">Посмотреть результат</a>
        </td>
    </tr>

            </table><h3 id="mainTitle" style="text-align:left;">Детальные настройки</h3> <table class="form">

            <tr>
                <td class="label <? if(in_array('Мета-теги', $this->errorFields)){ ?>errorField<? } ?> ">Мета-теги:</td>
                <td class="elements">
                    <textarea class="text" name="firms[meta]" style="height: 100px;"><?php echo @(isset($_POST['firms']['meta'])) ? html::specialchars($_POST['firms']['meta']) : html::specialchars($firm->meta) ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    <div class="smallInfo">
                        Очень важный аспект для поисковых роботов, более подробно о том что такое мета-теги и как их правильно можно прочитать на <a href="http://ru.wikipedia.org/wiki/%D0%9C%D0%B5%D1%82%D0%B0-%D1%82%D0%B5%D0%B3%D0%B8#.D0.9C.D0.B5.D1.82.D0.B0-.D1.82.D0.B5.D0.B3_Keywords" target="_blank">странице помощи</a>.

                        <br/> 
                        Пример: коски, чулки, калготки.
                    </div>
                </td>
            </tr>


            <tr>
                <td class="label <? if(in_array('Название мета-тега', $this->errorFields)){ ?>errorField<? } ?> ">Название мета-тега:</td>
                <td class="elements">

                    <input class="text" name="firms[meta_name]" value="<?php echo @(isset($_POST['firms']['meta_name'])) ? html::specialchars($_POST['firms']['meta_name']) : html::specialchars($firm->meta_name)  ?>" />

                </td>
            </tr>
            
            <tr>
                <td class="label <? if(in_array('Значение мета-тега', $this->errorFields)){ ?>errorField<? } ?> ">Значение мета-тега:</td>
                <td class="elements">

                    <input class="text" name="firms[meta_text]" value="<?php echo @(isset($_POST['firms']['meta_text'])) ? html::specialchars($_POST['firms']['meta_text']) : html::specialchars($firm->meta_text)  ?>" />

                    <div class="smallInfo">
                        Вы можете указать произвольный мета-тег и его значение. Это возможность может понадобиться чтобы подтвердить
                        что вы являетесь владельцем сайта для каких либо сервисов. Например сервис статистики сайта <a href="http://metrika.yandex.ru/" target="_b">Яндекс.Метрика</a>.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Вставка в почтовые сообщения', $this->errorFields)){ ?>errorField<? } ?> ">Вставка в почтовые сообщения:</td>
                <td class="elements">
                    <textarea class="text" name="firms[mail_inside]" style="height: 100px;"><?php echo @(isset($_POST['firms']['mail_inside'])) ? html::specialchars($_POST['firms']['mail_inside']) : html::specialchars($firm->mail_inside) ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    <div class="smallInfo">
                        Вы можете указать произвольный текст, который будет показан во всех отправляемых почтовых сообщениях.
                        Например: "Спасибо что выбрали наш магазин", этот текст будет вставлен во все отправляемые сообщения для пользователей.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label <? if(in_array('Код статистики', $this->errorFields)){ ?>errorField<? } ?> ">Код статистики:</td>
                <td class="elements">
                    <textarea class="text" name="firms[code_inside]"><?php echo @(isset($_POST['firms']['code_inside'])) ? html::specialchars($_POST['firms']['code_inside']) : html::specialchars($firm->code_inside) ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                    <div class="smallInfo">
                        В это поле вы можете вставить HTML-код, полученых от сервисов статистики. Блок скрыт на странице.
                    </div>
                </td>
            </tr>

 
            <tr>
                <td class="label">Дизайн сайта:</td>
                <td class="elements topHandler">

                    <label><input type="radio" name="firms[template]"  <?php echo ($firm->template == TEMPLATE_1) ? 'checked="checked"' : "" ?>  value="<?=TEMPLATE_1?>" > Номер 1</label><br/>

<a href="/IMG/templates/mainPage.t1.jpg" class="highslide"
        onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center', captionText: '<b>Главная страница<b/>' })">
    <img src="/IMG/templates/mainPage.t1.mini.jpg" alt="Номер"
        title="Click to enlarge" height="74" width="100" />
</a>
&nbsp;
<a href="/IMG/templates/catalog.t1.jpg" class="highslide"
        onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center', captionText: '<b>Список товаров<b/>' })">
    <img src="/IMG/templates/catalog.t1.mini.jpg" alt="Номер"
        title="Click to enlarge" height="70" width="100" />
</a>
&nbsp;
<a href="/IMG/templates/item.t1.jpg" class="highslide"
        onclick="return hs.expand(this, { wrapperClassName: 'highslide-white', outlineType: 'rounded-white', dimmingOpacity: 0.75, align: 'center', captionText: '<b>Карточка товара<b/>' })">
    <img src="/IMG/templates/item.t1.mini.jpg" alt="Номер"
        title="Click to enlarge" height="74" width="100" />
</a>
<br/>
 

<? if($firm->template != TEMPLATE_1) { ?>

    <b>В вашем Интернет-магазине установлен уникальный дизайн.</b><br/><Br/>

<? } ?>

<a href="/design" target="_blank">Другие варианты дизайна</a><br/><br/>

                </td>
            </tr>

            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Сохранить"> <!--<a href="#" class="cancelBtn" onclick="SPAdmin.goToURL('/dashboard'); return false;">Отмена</a>-->
                    <a target="_blank" href="http://<?=$this->firm->domain?>?clear"  title="Применение настроек и просмотр результата на сайте" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>


            </table><h3  style="text-align:left;">Дополнительно</h3> <table class="form">

            <tr>
                <td class="label">Дополнительные модули:</td>
                <td class="elements">

                    <label><input type="checkbox"  title="Подключить модуль Новостей. После подключения вы сможите опубликовывать свои новости" name="firms[show][]" value="<?=SHOW_ON_SITE_NEWS?>" <?php echo ($firm->show & SHOW_ON_SITE_NEWS) ? 'checked="checked"' : "" ?>> Новости</label><br/>
                    <label><input type="checkbox"  title="Подключить модуль Вакансии. После подключения вы сможите опубликовывать вакансии вашего бизнеса" name="firms[show][]" value="<?=SHOW_ON_SITE_VACANCY?>" <?php echo ($firm->show & SHOW_ON_SITE_VACANCY) ? 'checked="checked"' : "" ?>> Вакансии</label><br/>
                    <label><input type="checkbox"  title="Подключить модуль Партнёры. После подключения вы сможите опубликовывать информацию о ваших партнёрах в красивом и структурированном виде" name="firms[show][]" value="<?=SHOW_ON_SITE_PARTNERS?>" <?php echo ($firm->show & SHOW_ON_SITE_PARTNERS) ? 'checked="checked"' : "" ?>> Партнёров</label><br/>
                    <label><input type="checkbox"  title="Подключить модуль Страницы. После подключения вы сможите опубликовывать страницы и статьи" name="firms[show][]" value="<?=SHOW_ON_SITE_PAGES?>" <?php echo ($firm->show & SHOW_ON_SITE_PAGES) ? 'checked="checked"' : "" ?>> Дополнительные страницы</label><br/>

                </td>
            </tr>

            
            
            <tr>
                <td class="label">Дополнительные цены:</td>
                <td class="elements">
 
                    <label ><input onchange="if(this.checked){$('#priceTitle1').css('display', 'block');}else{$('#priceTitle1').hide();}"  type="checkbox" name="firms[price][]" value="1" <?php echo ($this->firm->prices->enabled & 1) ? 'checked="checked"' : "" ?>> Цена 1</label><br/>
                    <div id="priceTitle1" style='display:<?php echo ($this->firm->prices->enabled & 1) ? 'block' : "none" ?>'>
                        <input  class="text" name="firms[priceTitle][1]" value="<?php echo @(isset($_POST['priceTitle']['1'])) ? html::specialchars($_POST['priceTitle']['1']) : html::specialchars(empty($this->firm->prices->list->price1) ? 'Укажите название для цены' : $this->firm->prices->list->price1)  ?>" />
                        <div class="smallInfo">
                           Для каждой из цен, укажите назвение, которое будет с ней ассоциироваться. Например: Цена закупки, Оптовая цена и так далее.
                        </div> 
                        <input type="checkbox" name="firms[priceVisible][]" value="1" <?php echo ($this->firm->prices->visible & 1) ? 'checked="checked"' : "" ?>> Цена видна на сайте</label>
                        <div class="smallInfo">
                           Вы можете снять или установить этот флаг если хотите чтобы цены были или не были видны на сайте. Полезноскрыть к примеру закупочную цену, и показать оптовую.
                        </div>
                        <br/>
                    </div>

                    <label  ><input onchange="if(this.checked){$('#priceTitle2').css('display', 'block');}else{$('#priceTitle2').hide();}"  type="checkbox" name="firms[price][]" value="2" <?php echo ($this->firm->prices->enabled & 2) ? 'checked="checked"' : "" ?>> Цена 2</label><br/>
                    <div id="priceTitle2" style='display:<?php echo ($this->firm->prices->enabled & 2) ? 'block' : "none" ?>'>
                        <input  class="text" name="firms[priceTitle][2]" value="<?php echo @(isset($_POST['priceTitle']['2'])) ? html::specialchars($_POST['priceTitle']['2']) : html::specialchars(empty($this->firm->prices->list->price2) ? 'Укажите название для цены' : $this->firm->prices->list->price2)  ?>" />
                        <input type="checkbox" name="firms[priceVisible][]" value="2" <?php echo ($this->firm->prices->visible & 2) ? 'checked="checked"' : "" ?>> Цена видна на сайте</label>
                        <br/><br/>
                    </div>

                    <label  ><input onchange="if(this.checked){$('#priceTitle3').css('display', 'block');}else{$('#priceTitle3').hide();}"  type="checkbox" name="firms[price][]" value="4" <?php echo ($this->firm->prices->enabled & 4) ? 'checked="checked"' : "" ?>> Цена 3</label><br/>
                    <div id="priceTitle3" style='display:<?php echo ($this->firm->prices->enabled & 4) ? 'block' : "none" ?>'>
                        <input  class="text" name="firms[priceTitle][3]" value="<?php echo @(isset($_POST['priceTitle']['4'])) ? html::specialchars($_POST['priceTitle']['3']) : html::specialchars(empty($this->firm->prices->list->price3) ? 'Укажите название для цены' : $this->firm->prices->list->price3)  ?>" />
                        <input type="checkbox" name="firms[priceVisible][]" value="4" <?php echo ($this->firm->prices->visible & 4) ? 'checked="checked"' : "" ?>> Цена видна на сайте</label>
                        <br/><br/>
                    </div>

                    <label  ><input onchange="if(this.checked){$('#priceTitle4').css('display', 'block');}else{$('#priceTitle4').hide();}"  type="checkbox" name="firms[price][]" value="8" <?php echo ($this->firm->prices->enabled & 8) ? 'checked="checked"' : "" ?>> Цена 4</label><br/>
                    <div id="priceTitle4" style='display:<?php echo ($this->firm->prices->enabled & 8) ? 'block' : "none" ?>' >
                        <input class="text" name="firms[priceTitle][4]" value="<?php echo @(isset($_POST['priceTitle']['8'])) ? html::specialchars($_POST['priceTitle']['4']) : html::specialchars(empty($this->firm->prices->list->price4) ? 'Укажите название для цены' : $this->firm->prices->list->price4)  ?>" />
                        <input type="checkbox" name="firms[priceVisible][]" value="8" <?php echo ($this->firm->prices->visible & 8) ? 'checked="checked"' : "" ?>> Цена видна на сайте</label>
                        <br/><br/>
                    </div>

                    <label ><input onchange="if(this.checked){$('#priceTitle5').css('display', 'block');}else{$('#priceTitle5').hide();}" type="checkbox" name="firms[price][]" value="16" <?php echo ($this->firm->prices->enabled & 16) ? 'checked="checked"' : "" ?>> Цена 5</label><br/>
                    <div id="priceTitle5" style='display:<?php echo ($this->firm->prices->enabled & 16) ? 'block' : "none" ?>'>
                        <input  class="text" name="firms[priceTitle][5]" value="<?php echo @(isset($_POST['priceTitle']['16'])) ? html::specialchars($_POST['priceTitle']['5']) : html::specialchars(empty($this->firm->prices->list->price5) ? 'Укажите название для цены' : $this->firm->prices->list->price5)  ?>" />
                        <input type="checkbox" name="firms[priceVisible][]" value="16" <?php echo ($this->firm->prices->visible & 16) ? 'checked="checked"' : "" ?>> Цена видна на сайте</label>
                        <br/><br/>
                    </div>

                </td>
            </tr>



            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Сохранить"> <!--<a href="#" class="cancelBtn" onclick="SPAdmin.goToURL('/dashboard'); return false;">Отмена</a>-->
                    <a target="_blank" href="http://<?=$this->firm->domain?>?clear"  title="Применение настроек и просмотр результата на сайте" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>

        </table>

    </form>

</center>