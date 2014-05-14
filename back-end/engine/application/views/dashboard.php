<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<? if(count($items)) { ?>
 
    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'orders/index', TRUE),
             array('items' => $items)); ?>
        
<? }else{ ?>
    <p style="margin-top: 0px;">
        На данный момент новых заказов не поступало.
    </p>
<? } ?>

<h3>Новые сообщения</h3>

<? if(count($feedbacks)) { ?> 
    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'feedback/index', TRUE),
             array('items' => $feedbacks)); ?>
<? }else{ ?>
    <p>
        Новых сообщений от пользователей не поступало.
    </p>
<? } ?>

<h3>Новые комментарии</h3>

<? if(count($comments)) { ?>



    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'comments/list_items', TRUE),
             array('items' => $comments)); ?>
<? }else{ ?>
    <p>
        Новых комментариев не поступало.
    </p>
<? } ?>

<h3>Номера для перезвона</h3>

<? if(count($phones)) { ?>
    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'callback/index', TRUE),
             array('items' => $phones)); ?>
<? }else{ ?>
    <p>
        Новых номеров не поступало.
    </p>
<? } ?>


<h3>Развитие сервиса</h3>

<p>
    Планируемые нововведения, в следующем обновлении:
</p>
<ol>
    <li>Разграничения пользователей по правам</li>
    <li>Автоматическая разборка категорий, и подстановка параметров</li>
    <li>Добавления функционала для работы с клиентами</li>
</ol>
    


