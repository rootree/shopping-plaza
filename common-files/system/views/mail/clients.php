<?php defined('SYSPATH') OR die('No direct access allowed.'); ?><HTML>
<HEAD>
<TITLE><?=html::specialchars($title)?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {padding : 1px; margin : 0; font-size : 11px; color : #000000; font-style : normal;
    font-family : Tahoma, Verdana, Arial, Helvetica; background-color: #ffffff;}
form, address { padding: 0 0 0 0; margin: 0 0 0 0;}
td, font, address {font-family : Tahoma, Verdana, Arial, Helvetica; font-size : 11px !important; font-style : normal !important;}
DIV { font-size : 11px;  } 
A:hover {text-decoration : underline;  }
TEXTAREA {border: 1px solid #7F9DB9;  font-size : 11px; color : #000000; font-family : Tahoma, Verdana, Arial, Helvetica; }
SELECT {font-size : 11px; color : #000000; font-family : Tahoma, Verdana, Arial, Helvetica; }
A IMG {border: none; }
p {font-family : Tahoma, Verdana, Arial, Helvetica; font-size : 11px; margin: 0px; padding: 0px;}
 
-->
</style>
</HEAD>

<BODY bgColor=#ffffff>

<div style="background-color: #f0f8ff; padding: 4px; text-align:right; border-bottom: 1px solid #5f9ea0;">
    
    <h1 style="padding: 0px; margin: 0px;"><?= html::specialchars($firm->title) ?></h1>
    <?=html::specialchars($this->firm->description)?>
 
</div>

<div <? if (!isset($user)) { ?>style="padding: 10px 4px; border-bottom: 1px solid #dcdcdc; border-top: 1px solid #dcdcdc;"<? } ?>>
    <?=$content?>
</div>

<? if (isset($user)) { ?>

    <div style="padding: 10px 4px; border-bottom: 1px solid #dcdcdc; border-top: 1px solid #dcdcdc;"> 
        С уважением, <?=$user->user_name?>.
    </div>

<? } ?>

<div  style="background-color: #f0f8ff; padding: 4px; border-top: 1px solid #5f9ea0;">
 
    <table class="list" border="0" cellspacing="0" cellpadding="0" width="100%">

        <tr>

            <td valign="top">

                <strong><a href="http://<?=$firm->domain?>"><?= html::specialchars($firm->title) ?></a></strong><br/>

                Адрес в Интернете: http://<?= ($firm->domain) ?>/<br/>

                <? if (!empty($this->firm->mail)){?>
                    Наш электронный адрес: <?=strip_tags($this->firm->mail)?>
                <? } ?>

            </td>
            
            <td valign="top" align="right">
                Время работы: <?=$this->firm->worktime?><br/>
                <? if (0 && !empty($this->firm->address)){?>
                    Адрес: <?=strip_tags ($this->firm->address)?><br/>
                <? } ?>
                <? if (!empty($this->firm->tele)){?>
                    Телефон(-ы): <?=strip_tags ($this->firm->tele)?>
                <? } ?>

            </td>

        </tr>

    </table>

</div>

</BODY></HTML>