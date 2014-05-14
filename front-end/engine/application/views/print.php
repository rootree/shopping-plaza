<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo html::specialchars($title) ?></title>

<link rel="stylesheet" href="/CSS/css-base.css" type="text/css"  media="screen">
<link rel="stylesheet" href="/CSS/css-print.css" type="text/css"  media="print">

</head>

<body>
	
	
<? if (!$empty_bin) : ?>

	<?  $sum_shop =  0?>
	
	<center>
	
	<div id="" class="for_site">
		<p>Ваша заявка сформирована и отправлена нам на выполнение. Выбранный вами товар будет отложен до вашего прихода.</p>
		<p>Для завершения покупки, распечатайте данную заявку на принтере и предъявите в нашем магазине (адрес указан ниже). Товар будет отпущен по указанным на сайте ценам.</p>
		<p>Если, по каким либо причинам, вы не можете распечатать заявку сейчас, её можно будет распечатать позже, на указанный вами электронный адрес выслана копия данной заявки.</p>
		<p> По истечению этого скора, выбранный вами товар будет возращён на витрины, и вы не сможете воспользоваться данной заявкой.</p>
		<p><a href="/" title="">Вернуться на сайт</a></p>
	</div>
	<h2>Интернет заявка № <?=$order_id?></h2>
	Заказчик: <b><?=$data['od_name']?></b> <br/>
	Номер контактного телефона: <?=$data['od_phone']?>
	</center><br/> 
	
	<p>
		Содержание заявки:
	</p>
	
	</br> 
	<center>
	<table width="97%" cellpadding="5" cellspacing="0" id="bin" border=1>
		<tr>
			<th>№.</th>
                        <th><small>#Уник. номер</small></th>
			<th>Тип</th> 
			<th>Фирма</th> 
			<th>Модель</th> 
			<th>Кол-во.</th> 
			<th>Цена за ед.</th> 
			<th>Цена за комплект</th>
		</tr>
	
	<? $counter = 1?>
	<?foreach ($items as $key ){ ?>
		
		<? if ($counter % 2 == 0) {$bg = '#f0f9fb';}else{$bg = '#FFFFFF';}; ?>
		<tr bgcolor="<?=$bg?>">
			<td align="center"><?=$counter?>.</td>
                        <td align="center"><small>#<?=$key->it_id?></small></td>
			<td><?=$key->gr_title?>&mdash;<b><?=$key->tp_title?></b></td>
			<td><?=$key->fr_title?></td> 
			<td><?=$key->it_model?></td> 
			<td align="center"><?=$items_ses[$key->it_id]?> шт.</td>
			<td align="center"><?=money::ru(formula($key))?></td>
			<td align="center"><?=money::ru(formula($key) * $items_ses[$key->it_id]);  $sum_shop += (formula($key) * $items_ses[$key->it_id])?></td>
		</tr>
		
		<? $counter ++;?>
		
	<?}?>
	
		<? if ($counter % 2 == 0) {$bg = '#f0f9fb';}else{$bg = '#FFFFFF';}; ?>
		
		<tr bgcolor="<?=$bg?>">
			<td colspan="6" style="text-align: right;"> </td>
			<td align="right">Итого:</td>  
			<td align="center"><?=money::ru($sum_shop)?></td>
		</tr>
		
	</table>
	</center>
	</br></br> 
	<p>
		<b>Данная заявка действительна с <?=$start?> по <?=$ender?>.</b>
	</p>
<p>Наш Адрес:
г. Краснодар, ул. Октябрьская 47<br/>
(между улицами Советская и Комсомольская )</p>

<p>Время работы:<br/> 
с 10.30 до 18.00<br/> 
Без перерыва и выходных</p>

<p>Телефоны (г. Краснодар):<br/> 
8 (861) 270-73-67<br/> 
8 (928) 660-55-55<br/> 
8 (918) 632-44-44</p>
	
	<p>	
		<b>В случае возникновения конфликтных ситуаций, при предъявлении данной заявки, следует обратиться по номеру: <nobr>8 (925) 83-23-913</nobr>.</b>
	</p>
	
<? else : ?>
	
	Заявка не может быть сформированна.
	
<? endif?>

</body>

</html>