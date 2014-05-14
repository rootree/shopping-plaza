<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

Здравствуйте <?=$content->user->user_name ?>.<br/><br/>

С помощью сервиса Shopping-Plaza, вы создали магазин
«<?=html::specialchars($content->firm->title)?>».
В этом магазине вы являетесь главным администратором,
но регистрация вашего аккаунта завершена не полностью.<br/><br/>

Для завершения регистрации на сайте Shopping-Plaza,
перейдите по ссылке: <a style=" text-decoration:underline;" href="http://shopping-plaza.ru/confirm/index/code/<?=$content->hash ?>/">
    http://shopping-plaza.ru/confirm/code/<?=$content->hash ?>/</a> .


<? if($content->onwDomain) { ?>
<br/><br/>
        Внимание! Вы указали что у вас есть собственный домен для Интернет-магазина.
        Чтобы его активировать, вам нужно прописать следующую информацию о нём.<br/><br/>

    Необходимо добавить две записи вида А. Пример:<br/>

<b>magazin.ru A 109.234.155.18<br/>
 www.magazin.ru A 109.234.155.18</b><br/><br/>

    И необходимо добавить четыре NS записи. Пример:<br/>
 <b>magazin.ru NS ns1.selectel.org.   <br/>
www.magazin.ru NS ns1.selectel.org.</b><br/><br/>



 <b>magazin.ru NS ns2.selectel.org.  <br/>
 www.magazin.ru NS ns2.selectel.org.</b><br/><br/>
 
    Где взамен «magazin.ru» вам необходимо указать имя вашего домена.
Примерно через двое суток, информация будет обновлена в Интернете и ваш магазин будет полноценно работать.<br/>

    <br/>

    А пока вы этого не сделали, ваш магазин временно будет доступен по адресу <a style="text-decoration:underline;"
                                                                                 href="<?=$content->firm->domain ?>" title="Перейти к Интернет-магазину">
    <?=$content->firm->domain ?></a>
<? } ?>