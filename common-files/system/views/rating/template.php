<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>IOGames - <?php echo html::specialchars($title) ?></title>

    <link rel="stylesheet" href="<?php echo url::site(); ?>CSS/jquery.Jcrop.css" type="text/css" />
    <script src="<?php echo url::site(); ?>JS/jquery.min.js"></script>
    <script src="<?php echo url::site(); ?>JS/jquery.Jcrop.js"></script>
    <script src="<?php echo url::site(); ?>JS/init.js"></script>
    <link rel="stylesheet" href="<?php echo url::site(); ?>CSS/demos.css" type="text/css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>


    <link href="<?php echo url::site(); ?>CSS/css-base.css" rel="stylesheet" type="text/css" />


    <!--[if IE 7]><link rel="stylesheet" href="<?php echo url::site(); ?>CSS/css-ie7.css" type="text/css" /><![endif]-->
    <!--[if IE 8]><link rel="stylesheet" href="<?php echo url::site(); ?>CSS/css-ie8.css" type="text/css" /><![endif]-->

    <meta content="general" name="Ivan Chura" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />

</head>
<body>

<div id="logo">

    <div id="" class="" style="float: right;">
  
    
        <?PHP if($GLOBALS['ACCESS'][PAGE_MAIN] & $this->access){ ?>
            <a href="<?php echo url::site() ; ?>/" <?php if($this->selected_page == PAGE_MAIN) { ?>id="selected"<?php } ?>>Страница приветствия</a>
            |
        <?PHP } ?>

        <?PHP if($GLOBALS['ACCESS'][PAGE_TOUR] & $this->access){ ?>
            <a href="<?php echo url::site() . PAGE_TOUR; ?>/" <?php if($this->selected_page == PAGE_TOUR) { ?>id="selected"<?php } ?>>Тур</a>
            |
        <?PHP } ?>

        <?PHP if($GLOBALS['ACCESS'][PAGE_HELP] & $this->access){ ?>
            <a href="<?php echo url::site() . PAGE_HELP; ?>/" <?php if($this->selected_page == PAGE_HELP) { ?>id="selected"<?php } ?>>Справка</a>
            |
        <?PHP } ?>
        <?PHP if($GLOBALS['ACCESS'][PAGE_PRICE] & $this->access){ ?>
            <a href="<?php echo url::site() . PAGE_PRICE; ?>/" <?php if($this->selected_page == PAGE_PRICE) { ?>id="selected"<?php } ?>>Цены и тарифы</a>
            |
        <?PHP } ?>
 
        <?PHP if($GLOBALS['ACCESS'][PAGE_LOGIN] & $this->access){ ?>
            <a href="<?php echo url::site() . PAGE_LOGIN; ?>/" <?php if($this->selected_page == PAGE_LOGIN) { ?>id="selected"<?php } ?>>Для клиентов</a>
        <?PHP } ?>
  
    </div>

     Публичный шаблон

    <!--<div id="select_project" class=" shadow " style="width: 200px;">

        <ol id="nav" class="select_project">
            <li><a title="Opened"  href="/office/inspector/opened/lists/my">«Город грешников»</a></li>
            <li><a title="On-duty"  href="/office/inspector/onduty/lists/my">«Что-нибуть ещё»</a></li>
        </ol>
    </div>-->

</div>

<p></p>

<table width="100%">
    <tr>
        <td align="left" valign="top">

            <NOSCRIPT>

                <div class="input_error">
                    <p>В вашем браузере отключена поддержка JavaScript. Советуем включить, так как часть функционала будет недоступно.</p>
                </div>

            </NOSCRIPT>

            <!--
                        <div class="input_error shadow"></div>
                        <div class="info shadow"></div>
            -->
            <h3><?php echo html::specialchars($title) ?></h3>

        <?php echo messages::show($this->error, TYPE_ERROR) ?>

        <?php echo messages::show($this->info, TYPE_INFO) ?>

            <table width="100%">
                <tr>
                    <td><?php echo $content ?></td>
                </tr>
            </table>

        </td>
 
    </tr>
</table>

<hr/>

<div id="end">2010. Все прова защищены.<br />
    <small>Rendered in {execution_time} seconds, using {memory_usage} of memory</small>
</div>

<br/>

</body>
</html>





