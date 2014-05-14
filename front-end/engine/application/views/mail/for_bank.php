<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<HTML>

<HEAD>
<TITLE>Квитанция на оплату</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
body {padding : 1px; margin : 0; font-size : 11px; color : #000000; font-style : normal; font-family : Tahoma, Verdana, Arial, Helvetica; background-color: #ffffff; text-align:center; }
form { padding: 0 0 0 0; margin: 0 0 0 0;}
td, font {font-family : Tahoma, Verdana, Arial, Helvetica; font-size : 11px;}
DIV { font-size : 11px;  }
A { color : #000000;  text-decoration : none; }
A:hover {text-decoration : underline;  }
TEXTAREA {border: 1px solid #7F9DB9;  font-size : 11px; color : #000000; font-family : Tahoma, Verdana, Arial, Helvetica; }
SELECT {font-size : 11px; color : #000000; font-family : Tahoma, Verdana, Arial, Helvetica; }
A IMG {border: none; }
p {font-family : Tahoma, Verdana, Arial, Helvetica; font-size : 11px; margin: 0px; padding: 0px;}
-->
</style>
</HEAD>

<BODY bgColor=#ffffff>
<DIV align=center><BR>
<TABLE cellSpacing=0 cellPadding=4 width=600 border=1>
  <TBODY>
  <TR>
    <TD vAlign=bottom width="25%">
      <P align=right>Извещение</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>Кассир</P></TD>
    <TD width="75%">
      <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
        <TBODY>
        <TR>
          <TD colSpan=3><STRONG>Получатель платежа</STRONG></TD></TR>
        <TR>
          <TD colSpan=3>Наименование: ____________ (имя юр. лица)</TD></TR>
        <TR>
          <TD>Счет: ____________________</TD>
          <TD>ИНН: __________</TD>
          <TD>КПП: </TD></TR>
        <TR>
          <TD colSpan=3>Наименование банка: ____________</TD></TR>
        <TR>
          <TD>Кор. счет: ____________________</TD>
          <TD colSpan=2>БИК: ________</TD></TR></TBODY></TABLE><BR>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
        <TBODY>
        <TR>
          <TD><STRONG>Плательщик</STRONG></TD></TR>
        <TR>
          <TD><?=html::specialchars($content->deliveryInfo->name)?> <?=html::specialchars($content->deliveryInfo->soname)?>,</TD></TR>
        <TR>
          <TD>
               <? if(!empty($content->deliveryInfo->region)){?>
                    <?=html::specialchars($content->deliveryInfo->region)?>,
                <? } ?>
                <? if(!empty($content->deliveryInfo->city)){?>
                    г.<?=html::specialchars($content->deliveryInfo->city)?>,
                <? } ?>
                <? if(!empty($content->deliveryInfo->street)){?>
                    ул.<?=html::specialchars($content->deliveryInfo->street)?>,
                <? } ?>
                <? if(!empty($content->deliveryInfo->house)){?>
                    д.<?=html::specialchars($content->deliveryInfo->house)?>,
                <? } ?>
                <? if(!empty($content->deliveryInfo->apr)){?>
                    кв.<?=html::specialchars($content->deliveryInfo->apr)?>
                <? } ?>

          </TD></TR>
        </TBODY></TABLE><BR>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" border=1>
        <TBODY>
        <TR>
          <TD>
            <DIV align=center>Назначение платежа</DIV></TD>
          <TD>
            <DIV align=center>Дата</DIV></TD>
          <TD>
            <DIV align=center>Сумма</DIV></TD></TR>
        <TR>
          <TD>
            <DIV align=center>Оплата заказа №<?=$content->orderNumber?></DIV></TD>
          <TD>
            <DIV align=center>&nbsp;</DIV></TD>
          <TD>
            <DIV align=center><?=money::ru($content->cost);?></DIV></TD></TR></TBODY></TABLE>
      <P>Подпись плательщика:</P></TD></TR>
  <TR>
    <TD vAlign=bottom>
      <P align=right>Извещение</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>&nbsp;</P>
      <P align=right>Кассир</P></TD>
    <TD>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
        <TBODY>
        <TR>
          <TD colSpan=3><STRONG>Получатель платежа</STRONG></TD></TR>
        <TR>
                <TD colSpan=3>Наименование:
                  __________
                </TD>
              </TR>
        <TR>
                <TD>Счет:
                  ____________________
                </TD>
                <TD>ИНН:
                  __________
                </TD>
                <TD>КПП:
                  ____________
                </TD>
              </TR>
        <TR>
                <TD colSpan=3>Наименование банка:
                  ____________________
                </TD>
              </TR>
        <TR>
                <TD>Кор. счет:
                  _____________________
                </TD>
                <TD colSpan=2>БИК:
                  __________
                </TD>
              </TR></TBODY></TABLE><BR>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><STRONG>Плательщик</STRONG></TD>
              </TR>
              <TR>
                <TD>
                    <?=html::specialchars($content->deliveryInfo->name)?> <?=html::specialchars($content->deliveryInfo->soname)?>,
                </TD>
              </TR>
              <TR>
                <TD>
                    <? if(!empty($content->deliveryInfo->region)){?>
                        <?=html::specialchars($content->deliveryInfo->region)?>,
                    <? } ?>
                    <? if(!empty($content->deliveryInfo->city)){?>
                        г.<?=html::specialchars($content->deliveryInfo->city)?>,
                    <? } ?>
                    <? if(!empty($content->deliveryInfo->street)){?>
                        ул.<?=html::specialchars($content->deliveryInfo->street)?>,
                    <? } ?>
                    <? if(!empty($content->deliveryInfo->house)){?>
                        д.<?=html::specialchars($content->deliveryInfo->house)?>,
                    <? } ?>
                    <? if(!empty($content->deliveryInfo->apr)){?>
                        кв.<?=html::specialchars($content->deliveryInfo->apr)?>
                    <? } ?>
                </TD>
              </TR>
            </TBODY>
          </TABLE>
          <BR>
      <TABLE cellSpacing=0 cellPadding=2 width="100%" border=1>
        <TBODY>
        <TR>
          <TD>
            <DIV align=center>Назначение платежа</DIV></TD>
          <TD>
            <DIV align=center>Дата</DIV></TD>
          <TD>
            <DIV align=center>Сумма</DIV></TD></TR>
        <TR>
          <TD>
            <DIV align=center>
                    Оплата заказа №<?=$content->orderNumber?>
                  </DIV></TD>
          <TD>&nbsp;</TD>
          <TD>
            <DIV align=center>
                    <?=money::ru($content->cost);?>
                  </DIV></TD></TR></TBODY></TABLE>
      <P>Подпись плательщика:</P></TD></TR></TBODY></TABLE></DIV></BODY></HTML>
