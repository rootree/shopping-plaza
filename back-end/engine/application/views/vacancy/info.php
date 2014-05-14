<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

<form action="" method="post">
<input type="hidden" name="action" value="update"/>
    
<table class="form">

	<tr >
		<td class="label"></td>
		<td class="elements topHandler"> 
			<a href="<?php echo url::site(); ?>vacancy/edit/id/<?php echo ($item->vacancy_id) ?>" class="editBtnText"  >Изменить</a>
			<a href="/vacancy" class="backBtn"  onclick="history.back(); return false;">Назад</a>
			<a  target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/vanancy#<?php echo ($item->vacancy_id) ?>">Посмотреть на сайте</a>		 
			<a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить вакансию «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>vacancy/delete/id/<?=$item->vacancy_id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>vacancy/delete/id/<?=$item->vacancy_id?>">Удалить</a>
		</td>
	</tr>
	
    <tr>
        <td class="label">Обязанности:</td>
        <td class="elements view">
            <?php echo ($item->responsibilities) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Требования:</td>
        <td class="elements view">
            <?php echo ($item->requirements) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Условия:</td>
        <td class="elements view">
            <?php echo ($item->conditions) ?>
        </td>
    </tr>
 

    <tr>
        <td class="label">Тип занятости:</td>
        <td class="elements view">
            <?php echo $GLOBALS['VACANCY_EMPL_TYPE'][($item->employment_type)] ?>
        </td>
    </tr>

    
    <tr>
        <td class="label">Уровень зарплаты:</td>
        <td class="elements view">
            <?php echo (intval($item->wage_level)) ? money::ru($item->wage_level) : $item->wage_level ; ?>
        </td>
    </tr>
	
    <tr>
        <td class="label">Требуемый опыт работы:</td>
        <td class="elements view">
            <?php echo $GLOBALS['VACANCY_XP'][($item->experience_required)] ?>
        </td>
    </tr>
 
    <tr>
        <td class="label">Телефон для справок:</td>
        <td class="elements view">
            <?php echo (!empty($item->tel) ? html::specialchars($item->tel) : '-') ?>
        </td>
    </tr>

    <tr>
        <td class="label">E-mail для справок:</td>
        <td class="elements view"> 
			 <?php echo (!empty($item->mail) ? html::specialchars($item->mail) : '-') ?>
        </td>
    </tr>
 
	<tr >
		<td class="label"></td>
		<td class="elements bottomHandler"> 
			<a href="<?php echo url::site(); ?>vacancy/edit/id/<?php echo ($item->vacancy_id) ?>" class="editBtnText"  >Изменить</a>
			<a href="/vacancy" class="backBtn"  onclick="history.back(); return false;">Назад</a>
			 <a  target="_blank" class="viewOnSiteBtnText" href="http://<?=$this->firm->domain?>/vanancy#<?php echo ($item->vacancy_id) ?>">Посмотреть на сайте</a>
			 <a onclick="SPAdmin.showConfirmMessage('Подтвердите удаление', 'Вы действительно хотите удалить вакансию «<?php echo html::specialchars($item->title) ?>»?', function(){SPAdmin.goToURL('<?php echo url::site(); ?>vacancy/delete/id/<?=$item->vacancy_id?>');}); return false;" class="deleteTextBtn" href="<?php echo url::site(); ?>vacancy/delete/id/<?=$item->vacancy_id?>">Удалить</a>
		</td>
	</tr>
 

</table>

</form>

</center>

<?php } ?>
 