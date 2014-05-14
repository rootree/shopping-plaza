<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<? if(count($items)) { ?>


<div class="new"  >

<h2 name="commentsList" id="commentsList">Комментарии посетителей</h2>
    
<? foreach ($items as $key ){   ?>

    <div id="comment<?=$key->coment_id?>" style="padding-left: 15px; " <? if($key->status == COMMENT_STATUS_ANSWER) { echo 'class="answerComment"'; } ?>>
	  
        <p style="">
            <? if($key->status == COMMENT_STATUS_ANSWER) { echo 'Ответ оставил'; }else{echo 'Комментарий оставил';} ?>: <strong><?=html::specialchars($key->name)?></strong> от <?=time::date($key->createDate, DATE_FORMAT) ?>

            <div style="color:black; border: 0px; padding: 10px 0px 0px;">
                <?=str_replace("\n", "<br/>", html::specialchars($key->content))?>
            </div>
        </p>
  
    </div>

<?  } ?>

 </div>

<?  } ?>