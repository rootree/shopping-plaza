<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

У пользователя вашего магазина по имени <?=html::specialchars($content->user) ?>
 (электронный адрес: <?=html::specialchars($content->mail) ?>) возник вопрос: <br/><br/>


<strong><?=str_replace("\n", "<br/>", html::specialchars($content->questing)) ?></strong>
