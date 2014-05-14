<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

Здравствуйте <?=html::specialchars($content->user) ?>.<br/><br/>

<?=($content->himSelf) ? 'Вы указали' : 'Администратор Интернет-магазина «'. html::specialchars($content->firm->title).'», ' . $content->currentAdmin->user_name . ' указал для вас ' ?>  новый адрес электронной
почты для входа в панель управления магазином.<br/><br/>

Если всё правильно, для активации нового адреса электронной почты
перейдите по ссылке: <a style=" text-decoration:underline;" href="http://shopping-plaza.ru/confirm/index/code/<?=$content->hash ?>/">http://shopping-plaza.ru/confirm/code/<?=$content->hash ?>/</a> .