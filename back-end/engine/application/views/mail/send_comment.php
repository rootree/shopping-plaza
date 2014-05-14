<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<br/>Вы оставили коментарий на странице <a href="<?=$content['url']?>"><?=html::specialchars($content['fb_title'])?></a>:<br/>
<div style="font-style:italic;">
    <br/><?=str_replace("\n", "<br/>", html::specialchars($content['fb_questing'])) ?><br/><br/>
</div>

<br/>На ваш комментарий следующий ответ:<br/><br/>
<p> 
    <b><?=str_replace("\n", "<br/>", html::specialchars($content['fb_ansver'])) ?></b>
</p>

    <p>
Вы так же можете продолжить диалог или просто посмотреть все сообщение переписки на странице:<br/><br/>

<a href="<?=$content['url']?>"><?=$content['url']?></a>
</p>
<? if($firm->mail_inside){ ?>

    <div><br/>
         <?=$firm->mail_inside?>
    </div><br/>
    
<? } ?>