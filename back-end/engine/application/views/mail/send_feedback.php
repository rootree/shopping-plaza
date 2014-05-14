<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<p> 
    <br/><?=str_replace("\n", "<br/>", html::specialchars($content['fb_ansver'])) ?>
</p>

<br/>Вы писали:<br/>
<div style="font-style:italic;">
    <br/><?=str_replace("\n", "<br/>", html::specialchars($content['fb_questing'])) ?><br/><br/>
</div>

<? if($firm->mail_inside){ ?>

    <div><br/>
         <?=$firm->mail_inside?>
    </div><br/>
    
<? } ?>