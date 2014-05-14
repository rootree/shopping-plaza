<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<div class="podtv">


<?php if(count($item)) { ?>

	<h2><?=html::specialchars($item->title)?></h2>
    <br/>
    <div id="news_content"  ><?php echo ($item->content) ?></div>

    <? if($this->commentsEnabled){ ?>

        <? if (count($comments)) { ?>

            <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comment/list', TRUE),
                    array('items' => $comments)); ?>

        <? } else { ?>
            <hr/>        
        <? } ?>

        <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comment/form', TRUE),
                array('type' => COMMENT_ON_ARTICLE, 'id' => $item->page_id)); ?>

    <? } ?>

        
<?php }else{ ?>

    <h2>������</h2>
    
<? } ?>

</div>

