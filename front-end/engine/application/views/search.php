<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="new">

<h2>Результаты поиска</h2>

<? if($input_error) : ?>

    <div class="errordesc" >
        <h4>Произошла ошибка при проверке указанных вами данных.</h4>
        <p class="last-child">Проверьте корректность заполненых полей.</p>
    </div>

<? endif ?>

<? if(isset($found_all) && $found_all) { ?>


Найдено <?=texter::ru(array('%s позиций', '%s позиция', '%s позиции'), $found_all); ?><br/><br/>

<div id="news-blog" style="border: 0px; padding:0;">
    <? foreach($result as $item) { ?>

        <div  >
            <p>

                <a href="<?=$item['url'] ?>" title=""><b><?=($item['title']) ?></b></a><br/><br />
                <span><?=($item['passed'][0]) ?></span>
 
            </p>



        </div>

    <?}?>
 </div>
  
<? }else {?>
    По вашему запросу ничего не найлено.
<? }?>

</div>