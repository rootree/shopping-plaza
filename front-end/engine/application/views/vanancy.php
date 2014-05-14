<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<h3>Нам нужны</h3>

<ul style="margin:0px;">
	<? foreach($items as $item) { ?>
	<li><a href="/vanancy#<?=($item->vacancy_id) ?>"><?=html::specialchars($item->title) ?></a></li>
	<?}?>
</ul>

<? foreach($items as $item) { ?>



<div class="ndd"><p>Дата размещения: <?=html::specialchars(time::date($item->date, DATE_FORMAT)) ?></p>
	<h2 id="<?=($item->vacancy_id) ?>"><?=html::specialchars($item->title) ?></h2></div>
<div class="web">
	<p><b>Обязанности</b><br />
		<?=($item->responsibilities) ?></p>

	<p><b>Требования</b><br />
		<?=($item->requirements) ?></p>

	<p><b>Условия</b><br />
		<?=($item->conditions) ?></p>

	<table class="table" width="395" border="0" cellspacing="0" cellpadding="10">
		<tr>
			<td><b>Тип занятости:</b>   </td>
			<td><?=$GLOBALS['VACANCY_EMPL_TYPE'][($item->employment_type)] ?></td>
		</tr>
		<tr>
			<td><b>Уровень ЗП: </b></td>
			<td><?php echo (intval($item->wage_level)) ? money::ru($item->wage_level) : $item->wage_level ; ?></td>
		</tr>
		<tr>
			<td><b>Опыт:</b></td>
			<td><?=$GLOBALS['VACANCY_XP'][($item->experience_required)] ?></td>
		</tr>
		<? if(!empty($item->tel)) { ?>
		<tr>
			<td><b>Телеофн для связи:</b></td>
			<td><b><?=html::specialchars($item->tel) ?></b></td>
		</tr>
		<? } ?>
		<? if(!empty($item->mail)) { ?>
		<tr>
			<td><b>E-mail для связи:  </b> </td>
			<td><?=html::specialchars($item->mail) ?></td>
		</tr>
		<? } ?>
	</table>



</div>

<?}?>
 