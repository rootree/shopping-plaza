
<? $proceed = (($_POST && isset($this->resulert) && $this->resulert === true) || $this->YMLprogress); ?>

<center>

    <form action="" method="post" <? if($proceed){ ?>onsubmit="return false;" <? } ?>>

        <table class="form">

            <tr>
                <td class="label <? if(in_array('Файл в формате YML', $this->errorFields)){ ?>errorField<? } ?>">Файл в формате YML:</td>
                <td class="elements">
                    <input <? if($proceed){ ?> disabled="disabled" <? } ?>title="Адрес должен начинаться с http://" class="text" id="yml" name="yml"
                    value="<?php echo (isset($_POST['yml'])) ? html::specialchars($_POST['yml']) : @$this->firm->YML ?>" />
 
                    <div class="smallInfo">
                        Укажите адрес страницы в Интернете, где расположен YML-файл.<br/><br/>
                    </div>

                </td>
            </tr>

            <tr>
                <td class="label">Импорт из YML:</td>
                <td class="elements">

                    <label><input <? if($proceed){ ?> disabled="disabled" <? } ?> type="checkbox" title="" name="YMLenabled" value="1" <?php echo ((isset($_POST['YMLenabled']) && $_POST['YMLenabled'] == 1) || (!isset($_POST['YMLenabled']) && $this->firm->YMLenabled)) ? 'checked="checked"' : "" ?>> Включён</label><br/>

                    <div class="smallInfo">
                        Включение/Выключение режима импортирования данных из YML-файла.<br/><br/>
                    </div>

                </td>
            </tr>

            <? if($proceed && !$this->YMLprogress) { ?>

                <tr>
                    <td class="label">Найдено категорий:</td>
                    <td class="label elements">

                        <strong><?=$this->countCats?></strong>
 
                    </td>
                </tr>
                <tr>
                    <td class="label">Найдено товаров:</td>
                    <td class="label elements">

                        <strong><?=$this->countItems?></strong>

<br/><br/>
                    </td>
                </tr>

            <? } ?>


            <tr id="buttons">
                <td class="label"></td>
                <td class="elements bottomHandler">
                    
                    <? if($proceed){ ?>
                        <input type="submit" onclick="SPAdmin.showConfirmMessage('Внимание!', 'Весь каталог Интернет-магазина будет обновляться раз в сутки из указанного YML-файла. <br/><br/>Все товары и категории, которые вы уже добавили или добавите, будут скрыты, после очередного обновления.<br/><br/>На время обновления магазин недоступен!', function(){proceedYML();}); return false;"   value="Начать обработку">
                    <? } else { ?>
                        <input type="submit" value="Отправить">
                    <? } ?>
                    
                    <a href="/products" class="cancelBtn">Отмена</a>
                </td>
            </tr>

            <tr id="progress" style="display:none;">
                <td class="label">Прогресс обработки:</td>
                <td class="elements bottomHandler">

                    <div id="progressbar"></div>

                    <div style="text-align:center; padding: 5px;"  ><span id="textProgress" >Загрузка...</span>

                    <div class="smallInfo">
                        Вне зависимости уйдёте вы со страницы или нет, <br/>процесс будет завершён.<br/><br/>

                        Если процесс обработки будет ещё не завершён, <br/>на этой странице вы сможете узнать, <br/>сколько осталось обрабатываться.
                    </div>
</div>
                </td>
            </tr>

        </table>

    </form>

</center>


<? if($proceed) {?>

    <h3>Дополнительне пояснение</h3>

    <p>
        При каждом обновлении каталога продукции из YML-файла, старые товары и их категории будут скрываться с сайта.
                Но в любом случае пропажи данных не будет.

    </p>
    

<? } else { ?>

    <h3>Пояснение</h3>

    <p>
    Файл обязательно должен соответсвовать стандарту YML (Yandex Market
    Language), который используется в системе "Яндекс.Маркет". <a href="http://partner.market.yandex.ru/legal/tt/" target="_blank">Ознакомиться с подробным описанием стандарта</a>.
    При загрузке файла будут импортированы категории, товары и параметы товаров.
    </p>
    <p>Обработка файла может занять несколько минут. Чем больше позиций в файле, тем больше времени потребуется на его обработку.
    Если у Вас возникли трудности при загрузке, пожалуйста, <a href="/response">напишите</a> об этом в Тех.поддержку, помогите нам улучшить сервис.
    </p>

<?}?>

<script type="text/javascript">

    function proceedYML(){

        $( "#progress" ).show();
        $( "#buttons" ).hide();

        $( "#progressbar" ).progressbar({
			value: 1
		});

        $.ajax( '/products/ymlstart/url/' + $( "#yml" ).val() )
            .done(function(data) {

            SPAdmin.timerMulti = window.setInterval("getResult();", 1000);

        })
            .fail(function() { SPAdmin.showAlertMessage("Произошла ошибка!", "Обратитесь к технической поддержке"); }
            // .always(function() { alert("complete"); }
        );
        

    }

    function getResult(){
        $.ajax( '/products/ymlupdate/')
            .done(function(value) {
                value = parseInt(value);

            if(value == 0 || value >= 100){
                clearInterval(SPAdmin.timerMulti);
                window.location.href = '/products?YMLupdated';
                return ;

            }

             $( "#textProgress" ).html( value + '%');
             $( "#progressbar" ).progressbar({
                value: value
            });

        })
            .fail(function() {
                SPAdmin.showAlertMessage("Произошла ошибка!", "Обратитесь к технической поддержке");
                clearInterval(SPAdmin.timerMulti);
        }

        );
    }

    <? if($this->YMLprogress) {?>


        $( "#progress" ).show();
        $( "#buttons" ).hide();

        $( "#progressbar" ).progressbar({
			value: 1
		});

        SPAdmin.timerMulti = window.setInterval("getResult();", 1000);
     
    <? } ?>

</script>