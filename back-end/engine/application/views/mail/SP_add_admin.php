<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

Здравствуйте <?=html::specialchars($content->user) ?>.<br/><br/>

Администратор Интернет-магазина «<?=html::specialchars($content->firm->title)?>» <?=html::specialchars($content->currentAdmin->user_name) ?> добавил вас
        как нового администратора магазина.<br/><br/>


Если всё правильно, и вы хотите стать администратором Интернет-магазина «<?=html::specialchars($content->firm->title)?>»,
перейдите по ссылке: <a style=" text-decoration:underline;" href="http://shopping-plaza.ru/confirm/index/code/<?=$content->hash ?>/">http://shopping-plaza.ru/confirm/code/<?=$content->hash ?>/</a> .





