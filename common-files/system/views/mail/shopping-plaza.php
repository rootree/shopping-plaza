<?php defined('SYSPATH') OR die('No direct access allowed.'); ?><HTML>
<HEAD>
<TITLE><?=html::specialchars($title)?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {margin : 0px;; padding: 0px; font-size : 11px; color : #000000; font-style : normal;
    font-family : Tahoma, Verdana, Arial, Helvetica;
    background-color: #ffffff;   }
form { padding: 0 0 0 0; margin: 0 0 0 0;}
td, font, address {font-family : Tahoma, Verdana, Arial, Helvetica; font-size : 11px;}
DIV { font-size : 11px;  }
A { color : #000000;  text-decoration : none; }
A:hover {text-decoration : underline;  }
TEXTAREA {border: 1px solid #7F9DB9;  font-size : 11px; color : #000000; font-family : Tahoma, Verdana, Arial, Helvetica; }
 
A IMG {border: none; }
p {font-family : Tahoma, Verdana, Arial, Helvetica; font-size : 11px; margin: 0px; padding: 0px;}
 
-->
</style>
</HEAD>

<BODY bgColor="#ffffff" >

<table style="width: 100%;">

    <tr>
        <td style=" width: 100%; background:#222; vertical-align:middle; padding:10px 38px 8px 20px;">

            <table style="width: 100%;">
                <tr>
                    <td style="color:#FFFFFF; font-size:16px;font-family:'lucida grande',tahoma,verdana,arial,sans-serif; font-weight:bold;vertical-align:middle;letter-spacing:-0.03em;text-align:left; "><?=html::specialchars($title)?></td>
                    <td style="text-align:right;">

                        <img src="http://shopping-plaza.ru/publicIMG/LOGO.top.png" alt="shopping-plaza.ru">

                    </td>
                </tr>
            </table>
             
        </td>
    </tr>
    
    <tr>
        <td style="border-bottom: 1px solid #cccccc; padding: 20px 10px;">

            <?=$content?>
  
        </td>
    </tr>
 
    <tr >
        <td style="text-align:center; padding:10px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none;font-size:11px;font-family:'lucida grande', tahoma, verdana, arial, sans-serif;color:#999999;border:none">
            Вы получили это письмо, так как являетесь администратором в Интернет-магазине «<?=html::specialchars($firm->title)?>»
            (<a style="color : #999999; text-decoration:underline;" href="http://<?=$firm->domain ?>/" title="Перейти к Интернет-магазину"><?=$firm->domain ?></a>).
            Если вы получили это письмо по ошибке, сообщите об этом администрации магазина по следующей ссылке:
            <a style="color : #999999; text-decoration:underline;" href="http://<?=$firm->domain ?>/feedback" title="Перейти к Интернет-магазину">http://<?=$firm->domain ?>/feedback</a>.

            <br/><br/>

            © 2011. «<a style="color : #999999; text-decoration:underline;" href="<?=$firm->domain ?>" title="Перейти к Интернет-магазину">Shopping-Plaza.ru</a>»  - аренда Интернет-магазинов.<Br/>

        </td>
    </tr>

</table>
 
</BODY></HTML>