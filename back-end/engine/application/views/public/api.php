<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<style type="text/css>">



</style>


<div class="pageband">

    <div class="container">

        <div class="pagetitle">
            <h1>API - средство интеграции приложений</h1>
        </div>

    </div>

</div>


<div class="statement">
    <h2>Вы можете интегрировать ваше приложение <Br/>с Интернет-магазином через API методы</h2>
</div>

<div class="container">

    <div class="extra">

        <div class="fullcolumn">


            <p>
                Используя данное API вы сможете получать и изменять данные своего магазина из других программ.
                Получать информацию о заказах, клиентах и прочей информации в магазине.
            </p>

            <p>
                Мы предлагаем следующие методы для работы с API (Application programming interface)
            </p>




            <div class="rightcolumneven">

                <p>
                    Категории:
                </p>
                <ul>
                    <li><a href="/help#link101">cats</a> - список всех категорий</li>
                    <li><a href="/help#link101">catsadd</a> - добавление категории</li>
                    <li><a href="/help#link101">catsedit</a> - изменение категории</li>
                    <li><a href="/help#link101">catsdelete</a> - удаление категории</li>
                    <li><a href="/help#link101">catssubdelete</a> - удаление подкатегории</li>
                    <li><a href="/help#link101">catssubedit</a> - изменение подкатегории</li>
                    <li><a href="/help#link101">catssubadd</a> - добавление подкатегории</li>
                </ul>

            </div>


            <p>
                Заказы:</p>
            <ul>
                <li><a href="/help#link101">orderinfo</a> - получение детальной информации о конкретном заказе</li>
                <li><a href="/help#link101">orders</a> - получение заказав</li>
            </ul>


            <p>Товары:</p>
            <ul>
                <li><a href="/help#link101">productinfo</a> - получение детальной информации о конкретном продукте</li>
                <li><a href="/help#link101">products</a> - получение списки товаров</li>
                <li><a href="/help#link101">productadd</a> - добавление товара</li>
                <li><a href="/help#link101">productdelete</a> - удаление товара</li>
                <li><a href="/help#link101">productedit</a> - изменение товара</li>
            </ul>
 

        </div>
    </div>

</div>










<div class="statement">
    <h2>Общий принцип</h2>
</div>

<div class="container">

    <div class="extra">

        <div class="fullcolumn">

            <p>
                Вы делаете запрос по адресу: http://shopping-plaza.ru/api/ с определённым методом, и его параметрами.
                В ответ получаете результат запроса. Ответ может содержать положительный результат в формате <a href="http://ru.wikipedia.org/wiki/JSON" target="_blank">JSON</a>, если всё сделано правильно, или ошибку,
                в которой будет описано что не так.
            </p>

            <p>
                Так же в запросе нужно будет указать уникальный API-ключ Интернет-магазина, который находиться в Панели управления, в <a href="http://shopping-plaza.ru/settings/api" target="_blank">настройках</a>.
            </p>

            <p>
                Вот как должен выглядеть правильный адрес запроса:
            </p>
            <div class="codeS">
                http://shopping-plaza.ru/api/<b>cats</b>/?key=<b>9d0sd9bbb9f0d9</b>&checksum=7ADEABFF8084C665E89702B14BDF118A
            </div>
            <p>
                Для этого примера мы используем метод «<a href="/api#link401">cats</a>» и получаем все категории магазина, API-ключ которого: 9d0sd9bbb9f0d9.
            </p>
            <p>
                Параметр <b>checksum</b> - это md5-хеш от всех параметров переданных после знака «?». Для этого примера расчёт checksum такой:
            </p>

            <div class="codeS">
                <?=('md5("9d0sd9bbb9f0d9");')?>
            </div>

            <p>
                Если параметр не один, то для функции md5 параметры конкатенируются в алфавитном порядке их ключей.
            </p>

            <div class="codeS" style="text-align: left;">
                <?=str_replace(' ', '&nbsp;', str_replace("\n", '<br/>','
$parameters = array(
    "title" => "TEST",
    "level" => 1,
    "key"   => "9d0sd9bbb9f0d9"
);
ksort($parameters);
$checkSum = md5(implode($parameters,""));
    '))?>
            </div>

        </div>
    </div>

</div>




<div class="statement">
    <h2>Категории</h2>
</div>

<div class="container">

    <div class="extra">

        <div class="fullcolumn">

            <h3 id="link401">cats</h3>
            <p>
                Получение всех категории Интернет-магазина (включая подкатегории).
            </p>

            <p>
                Пример запроса:
            </p>

            <div class="codeS">
                http://shopping-plaza.ru/api/<b>cats</b>/?<b>key</b>=9d0sd9bbb9f0d9&<b>desc</b>=1&<b>checksum</b>=7ADEABFF8084C665E89702B14BDF118A
            </div>

            <p>
                Параметры:
            </p>

            <table class="codeDesc">
                <tR>
                    <th>Параметр</th>
                    <th>Описание</th>
                    <th>Обязательный</th>
                    <th>Формат</th>
                    <th>Дополнительно</th>
                </tr>
                <tr>
                    <td class="code"><b>key</b></td>
                    <td class="desc">API-ключ Интернет-магазина</td>
                    <td>Да</td>
                    <td>Строка</td>
                    <td class="descAddon"></td>
                </tr>
                <tr>
                    <td class="code"><b>desc</b></td>
                    <td class="desc">Флаг получения описаний для категорий, если описания есть</td>
                    <td>Нет</td>
                    <td>Число</td>
                    <td class="descAddon">1 или 0</td>
                </tr>
                <tr>
                    <td class="code"><b>checksum</b></td>
                    <td class="desc">Хэш от всех параметров</td>
                    <td>Да</td>
                    <td>Строка</td>
                    <td class="descAddon"></td>
                </tr>
            </table>

            <p>
                Возвращаемы результат в формате JSON, список категорий:
            </p>
            <div class="codeS" style="text-align: left;">
                <?=str_replace(' ', '&nbsp;', str_replace("\n", '<br/>','
    {
        "subgroups":{
            "22":{
                "catsub_id":"22",
                "cat_id":"28","title":"TEST"
            },
            "136":{
                "catsub_id":"136",
                "cat_id":"28",
                "title":"TEST 2"
            }
        },
        "groups":{
            "28":{
                "cat_id":"28",
                "title":"TEST 3"
            },
            "29":{
                "cat_id":"29",
                "title":"TEST 4"
            }
        }
    }
    '))?>
            </div>



            <p>
                <a href="/api/#top">Подняться к содержанию</a></p>

        </div>
    </div>

</div>