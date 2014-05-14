<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div  class="body_content">
 
			<h3>Импорт базы данных</h3>

<form method="post" action="/import" enctype="multipart/form-data">
 
	<input type="file" name="csv" size="54" value=""></input> 
		

<div id="" class="body_line">  </div>

<div id="" class="" style="text-align: right;">
	<input type="submit" class="sub" name="" value="Загрузить"></input>
</div>

</form>

<? if($_FILES) : ?>

	<h3>Обновлено</h3>
	 
	<table width="100%" cellpadding="0" cellspacing="3" border="0">
		<tr>
			<td width="150">
				Групп товаров:
			</td>
			<td>
				 <?=$this->statistic['groups']?>
			</td>
		</tr>
		<tr>
			<td>
				Типов товаров: 
			</td>
			<td>
				<?=$this->statistic['type']?>
			</td>
		</tr>
		<tr>
			<td>
				Производителей: 
			</td>
			<td>
				<?=$this->statistic['vendors']?>
			</td>
		</tr>
		<tr>
			<td>
				Продуктов: 
			</td>
			<td>
				<?=$this->statistic['items']?>
			</td>
		</tr>
	</table>
	
 
	
<? endif ?>

<h3>Дополнительные операции</h3>

<?=(@intval($counter) > 0) ? '<p>Обработано элементов: '.$counter.'</p>' : '' ?>

<a href="/import/img" title="">Обновить Аватары</a> | <a href="/import/html" title="">Обновить Описания</a>

<br/><br/>

</div>
		</td>
		<td valign="top" style="width: 200px;">
<div id="first_rigth_block" class="body_right_panel" >
<h3 class="bin">Обновление каталога</h3>

<ol class="help">
<li>Сформировать предварительную распечатку Интернет-отчёта в программе "Товар-Деньги-Товар", если его нет, он находиться в корне FTP под названием: BAZA_to_Internet.frf</li>
<li>Сохранить в формате MS Excel (*.xls)</li>
<li>Открыть сохранённый файл в MS Excel или Openoffice Excel</li>
<li>Сохранить как CSV-фаил. Для MS Excel разделители являются: "," - запятая, для Openoffice Excel : ";" - точка с запятой</li>
<li>Полученный фаил импортировать на текущей странице.</li>
</ol>

<p style="text-align: justify">Если всё сделано правильно, все данные на сайте должны соответствовать базе программы "Товар-Деньги-Товар".</p>

<h3 class="bin">Обновление изображений</h3>
<ol class="help"><li>Загрузить изображения на предоставленный FTP в папку /img</li>
<li>Нажать на ссылку "Обновить Аватары".</li>
</ol>
<p style="text-align: justify">Название файлов должно соответствовать значениям полей "Комментарий 1" в программе "Товар-Деньги-Товар".</p>

<p style="text-align: justify">Если всё прошло правильно, будет видно общее количество обработанных записей.</p>

<h3 class="bin">Обновление описаний</h3>
<ol class="help"><li>Загрузить описания продукции на предоставленный FTP в папку /html</li>
<li>Если в файле-описания присутствуют изображения, их следует загрузить в папку /html_img и конечно правильно указать путь до изображения в файле-описания</li>
<li>Нажать на ссылку "Обновить Описания".</li>
</ol>
<p style="text-align: justify">Название файлов должно соответствовать значениям полей "Комментарий 2" в программе "Товар-Деньги-Товар".</p>

<p style="text-align: justify">Если всё прошло правильно, будет видно общее количество обработанных записей.</p>


</div>
	