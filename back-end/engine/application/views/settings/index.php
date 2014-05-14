<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr >
                <td class="label"></td>
                <td class="elements topHandler">
                    <input type="submit" value="Сохранить">
                    <a title="Применение настроек и просмотр результата на сайте" target="_blank" href="http://<?=$this->firm->domain?>?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>
            
            <tr>
                <td class="label">Показывать:</td>
                <td class="elements view">
                    <label><input  title="На главной странице будут размещены все категории и подкатегории в два столбика" type="checkbox" name="firm[showcatalog]" <?php echo ($firm->showcatalog == 1) ? 'checked="checked"' : "" ?>  value="1" > Полный список категорий</label><br/>

                    <? if($firm->show & SHOW_ON_SITE_NEWS) { ?>
                        <label><input  title="Показывать последнии новости на главной странице" type="checkbox" name="firm[shownews]" <?php echo ($firm->shownews == 1) ? 'checked="checked"' : "" ?>  value="1" > Блок новостей </label><br/>
                    <? } ?>

                    <label><input onchange="if(this.checked){$('#welcome_page').show();}else{$('#welcome_page').hide();}"
                         title="При выборе этого пункта появиться возможность редактировать содержание главной страницы" type="checkbox" name="firm[welcomepage]" <?php echo ($firm->welcomepage == 1) ? 'checked="checked"' : "" ?>  value="1" > Блок приветствия</label>

                    <div class="smallInfo">
                        Отметьте блоки, которые вы бы хотели бы увидеть на главной странице.
                    </div>
                </td>
            </tr>

  <!--          <tr id="news_page">
                <td class="label">Ограничения новостей:</td>
                <td class="elements">
                    <input name="firm[shownews]" value="<?php echo $firm->shownews ?>" />
                    <div class="smallInfo">
                        Укажите количество, отображаемых на главной странице, новостей. От 2 до 10;
                    </div>
                </td>
            </tr> -->

            <tr id="welcome_page">
                <td class="label view  <? if(in_array('Приветствие', $this->errorFields)){ ?>errorField<? } ?> ">Приветствие:</td>
                <td class="elements">
                    <textarea rows="3" cols="4" name="firm[mainpage]" id="firm_mainpage"><?php
                        echo @html::specialchars($firm->mainpage)
                        ?></textarea><div class="systemHelp"><b>Подсказка</b>: Чтобы вставить текст без форматирования (если вы копируете содержание из стороннего источника), используйте не <b>Cntr</b>+<b>V</b>, а <b>Cntr</b>+<b>Shift</b>+<b>V</b>.</div>
                   <div class="smallInfo">
                        Содержимое блока приветствия. Этот текст будет показан на главной странице вашего Интернет-магазина.
                    </div>
                </td>
            </tr>

            
            <tr>
                <td class="label">Тип товаров:</td>
                <td class="elements view">
                    <label><input type="radio" name="firm[showfirstpro]" <?php echo ($firm->showfirstpro == MAINPAGE_PRICE_NEW) ? 'checked="checked"' : "" ?>  value="<?=MAINPAGE_PRICE_NEW?>" > Новые</label><br/>
                    <label><input type="radio" name="firm[showfirstpro]" <?php echo ($firm->showfirstpro == MAINPAGE_PRICE_SPEC) ? 'checked="checked"' : "" ?>  value="<?=MAINPAGE_PRICE_SPEC?>" > Спец.предложения</label><br/>
                    <label><input type="radio" name="firm[showfirstpro]" <?php echo ($firm->showfirstpro == MAINPAGE_PRICE_WEEK) ? 'checked="checked"' : "" ?>  value="<?=MAINPAGE_PRICE_WEEK?>" > Предложения недели</label><br/>
                    <label><input type="radio" name="firm[showfirstpro]" <?php echo ($firm->showfirstpro == MAINPAGE_PRICE_BUY) ? 'checked="checked"' : "" ?>  value="<?=MAINPAGE_PRICE_BUY?>" > Самые продаваемые</label><br/>
                    <label><input type="radio" name="firm[showfirstpro]" <?php echo ($firm->showfirstpro == MAINPAGE_PRICE_POPULAR) ? 'checked="checked"' : "" ?>  value="<?=MAINPAGE_PRICE_POPULAR?>" > Самые посещаемые</label>
                    <div class="smallInfo">
                        Чтобы привлечь покупателей к определённым товаром сразу же при входе на главную страницу Интернет-магазина,
                        можно при добавлении или редактировании товара помечать их галочками: "Новые", "Спец.предложения", "Предложения недели".
                        Затем выбрать галочку тут, и помеченные товары будут показаны на главной странице. <br/>
                        <br/>
                        Можно выбрать "Самые продаваемые" или "Самые посещаемые", и тогда система сама будет размещать на главной странице актуальные данные.
                    </div>
                </td>
            </tr>

            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Сохранить">
                    <a title="Применение настроек и просмотр результата на сайте" target="_blank" href="http://<?=$this->firm->domain?>?clear" class="viewOnSiteBtnText">Посмотреть результат</a>
                </td>
            </tr>

        </table>

    </form>

</center>

<? if($firm->welcomepage == 0) {?>
<script language="JavaScript">
    $('#welcome_page').hide();
</script>
<? } ?>
 