<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>



<h2><?=html::specialchars($item->title)?></h2>
 <br/>
<p>
  <b><?=($item->annonce)?></b>
</p>
<br/>
 
<p class="text"><div id="news_content"  >
  <?=($item->content)?>
</div></p>

<br/><br/><em>
	Новость от <?=html::specialchars(time::date($item->date, DATE_FORMAT)) ?>
</em><br/>
<a href="/news/index/page/<?=$page ?>" title="">Вернуться к общему списку</a>

<? if($this->commentsEnabled){ ?>

    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comment/list', TRUE),
            array('items' => $comments)); ?>

    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comment/form', TRUE),
            array('type' => COMMENT_ON_NEWS, 'id' => $item->news_id)); ?>

<? } ?>