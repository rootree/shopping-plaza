
<center>

    <form action="" method="post" enctype="multipart/form-data" >
 
        <table class="form">

            <tr id="welcome_page">
                <td class="label view">Файл:</td>
                <td class="elements">
                    <input type="file" name="import_file">
                   <div class="smallInfo">
                        Выберите файл для обновления продукции.
                    </div>
                </td>
            </tr>


            <tr>
                <td class="label">Тип файла:</td>
                <td class="elements view">
                    <label><input type="radio" checked="checked" name="import[type]" value="<?=IMPORT_TYPE_EXCEL ?>" > Excel</label><br/>
                    <div class="smallInfo">
                        Файл в формате Microsoft Excel
                    </div>

                    <label><input type="radio" name="import[type]" value="<?=IMPORT_TYPE_CSV ?>" > CSV</label><br/>
                    <div class="smallInfo">
                        Файл в формате CSV. Разделители ";" - точка с запятой.
                    </div>

                    <br/><a target="_blank" href="http://shopping-plaza.ru/help/#import">Получить справку</a>

                </td>
            </tr>

            <tr >
                <td class="label"></td>
                <td class="elements bottomHandler">
                    <input type="submit" value="Загрузить и импортировать">
                </td>
            </tr>

        </table>

    </form>

</center>


    <h3 class="help">Пояснение</h3>
    <p>
    Если вы пользуетесь программой учёта товара (к примеру: 1С Склад, ТоварДеньгиТовар или любыми подобными), вам не удобно будет обновлять новые цены и количество товара, и в вашей программе и панели управления Интернет-магазином, а если у вас тысячи позиций, то это займет уйму времени и сил.
</p><p>
Поэтому мы предусмотрели импорт информации о товаре из вашей программы. На данный момент импорт может быть произведён из:
    <ul>
<li>Excel-файла, нашего формата</li>
<li>Storehouse Explorer</li>
        </ul>
</p><p>
При вашем желании, мы оперативно создадим импорт из любого формата.</p>