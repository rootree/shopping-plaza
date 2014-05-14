<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

Уважаемый(-ая) <?=html::specialchars($content->user) ?>, рады видеть вас среди наших пользователей, так же надеемся и клиентов нашего Интернет-магазина.
<br/><br/>
Благодаря регистрации, вы всегда сможете просмотреть ваши предыдущие заказы, и гораздо проще оформить новые.
<br/><br/>
Страница для авторизации в нашем магазине: <strong><a href="http://<?=SERVER_SITE?>/login">http://<?=SERVER_SITE?>login</a></strong><br/>
Ваш пароль: <strong><?=html::specialchars($content->userPass) ?></strong>

<br/><br/>
По всем вопросам смело пишите нам.