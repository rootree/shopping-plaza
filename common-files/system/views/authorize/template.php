<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title><?=html::specialchars($this->firm->title)?> - <?php echo html::specialchars($title) ?></title>

    <link href="<?php echo url::site(); ?>CSS/jquery-ui-1.8.18.custom.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="<?php echo url::site(); ?>CSS/uploadify.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="<?php echo url::site(); ?>CSS/highslide.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="<?php echo url::site(); ?>CSS/highslide-ie6.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="<?php echo url::site(); ?>CSS/jquery.tooltip.css" type="text/css" rel="stylesheet" media="screen" />



    <link href="<?php echo url::site(); ?>CSS/print.css" type="text/css" rel="stylesheet" media="print"/>

    <script src="<?php echo url::site(); ?>JS/jquery-1.7.1.min.js"></script>
    <script src="<?php echo url::site(); ?>JS/jquery-ui-1.8.18.custom.min.js"></script>
    <script src="<?php echo url::site(); ?>JS/highslide.js"></script>
    <script src="<?php echo url::site(); ?>JS/nicEdit.js"></script> 
    <script src="<?php echo url::site(); ?>JS/jquery.tooltip.js" type="text/javascript"></script>
    <script src="<?php echo url::site(); ?>JS/SPAdmin.js"></script>
    <script src="<?php echo url::site(); ?>JS/portamento.js"></script> 
    <script src="<?php echo url::site(); ?>JS/init.js"></script>

     
    <script type="text/javascript" src="<?php echo url::site(); ?>JS/swfobject.js"></script>
    <script type="text/javascript" src="<?php echo url::site(); ?>JS/jquery.uploadify.v2.1.4.min.js"></script>
 
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>


    <link href="<?php echo url::site(); ?>CSS/css-base.css" rel="stylesheet" type="text/css"  media="screen"/>
 
    <!--[if IE 7]><link rel="stylesheet" href="<?php echo url::site(); ?>CSS/css-ie7.css" type="text/css"  media="screen"/><![endif]-->
    <!--[if IE]><link rel="stylesheet" href="<?php echo url::site(); ?>CSS/css-ie8.css" type="text/css" media="screen" /><![endif]-->

     <link rel="stylesheet" href="<?php echo url::site(); ?>CSS/opera.css" type="text/css" media="screen" /> 

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />

    <script type="text/javascript">

//<![CDATA[

 $(document).ready(function() {

     hs.graphicsDir = '<?php echo url::site(); ?>CSS/graphics/';

     SPAdmin.uploadURI = '/upload/index/type/<?=$this->selected_page?>/itemid/<?=$this->id?>/';

    <?php
        $file = Kohana::find_file('views', 'js/' . $this->selected_page, false, "js");
        echo ($file) ? Controller::_kohana_load_view($file, array()) : "";
    ?>

});

//]]>
    </script>
 

</head>
<body>
<div id="dialog" style="display:none;"></div>
<div id="logo" >

    <div id="" class="" style="float: right;">

        Вы авторизованы как: <a href="/settings/useredit/id/<?=$this->moderId?>" <?php if(isset($this->editUserSelf) && $this->editUserSelf) { ?>id="selected"<?php } ?>><?=html::specialchars($this->user->user_name)?></a>|
 
        <?PHP if(!($GLOBALS['ACCESS'][PAGE_LOGIN] & $this->access)){ ?>
            <a href="<?php echo url::site() . PAGE_LOGIN; ?>/logout">Сменить пользователя</a>
        <?PHP } ?>

    </div>

    <a target="_blank" href="http://<?=$this->firm->domain?>/"><?=$this->firm->domain?></a> | <a href="/help/" target="_blank">Справка</a>

    <br/>
    <br/>
    <div   style="float: right; text-align: right; color: #2D536A;">
        Ваш менеджер: <b>******</b>
    </div>
    <h2>Управление магазином «<?=html::specialchars($this->firm->title)?>»</h2>



    <!--<a href="/settings/firm" <?php if(isset($this->selected_subpage) && $this->selected_subpage == Settings_Controller::SUBPAGE_FIRM) { ?>id="selected"<?php } ?>>«<?=$this->firm->title?>»</a>,-->


</div>

<div id="mainMenu" >

    <div>
	<ul>
 
        <?PHP if($GLOBALS['ACCESS'][PAGE_DASHBOARD] & $this->access){ ?>
            <li <?php if($this->selected_page == PAGE_DASHBOARD) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_DASHBOARD; ?>'); return false;" href="#<?php echo PAGE_DASHBOARD; ?>" >Приветствие</a></li>

        <?PHP } ?>

        <li>&nbsp;</li>
        
        <?PHP if(($GLOBALS['ACCESS'][PAGE_VACANCY] & $this->access && $this->firm->show & SHOW_ON_SITE_VACANCY)){ ?>
            <li <?php if($this->selected_page == PAGE_VACANCY) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_VACANCY; ?>'); return false;" href="#<?php echo PAGE_VACANCY; ?>">Вакансии</a></li>
        <?PHP } ?>

        <?PHP if(($GLOBALS['ACCESS'][PAGE_NEWS] & $this->access && $this->firm->show & SHOW_ON_SITE_NEWS)){ ?>
            <li <?php if($this->selected_page == PAGE_NEWS) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_NEWS; ?>'); return false;" href="#<?php echo PAGE_NEWS; ?>" >Новости</a></li>
        <?PHP } ?>

        <?PHP if(($GLOBALS['ACCESS'][PAGE_PARTNERS] & $this->access && $this->firm->show & SHOW_ON_SITE_PARTNERS)){ ?>
            <li <?php if($this->selected_page == PAGE_PARTNERS) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_PARTNERS; ?>'); return false;" href="#<?php echo PAGE_PARTNERS; ?>" >Партнёры</a></li>
        <?PHP } ?>

        <?PHP if(($GLOBALS['ACCESS'][PAGE_PAGES] & $this->access && $this->firm->show & SHOW_ON_SITE_PAGES)){ ?>
            <li <?php if($this->selected_page == PAGE_PAGES) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_PAGES; ?>'); return false;" href="#<?php echo PAGE_PAGES; ?>"  >Страницы</a></li>
        <?PHP } ?>

        <?PHP if(($GLOBALS['ACCESS'][PAGE_ITEMS] & $this->access)){ ?>
            <li <?php if($this->selected_page == PAGE_ITEMS) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_ITEMS; ?>'); return false;" href="#<?php echo PAGE_ITEMS; ?>"  >Продукция</a></li>
        <?PHP } ?>

        <li>&nbsp;</li>
        
        <?PHP if($GLOBALS['ACCESS'][PAGE_ORDERS] & $this->access){ ?>
            <li <?php if($this->selected_page == PAGE_ORDERS) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_ORDERS; ?>'); return false;" href="#<?php echo PAGE_ORDERS; ?>"
                    >Заказы</a></li>

        <?PHP } ?>

        <?PHP if($GLOBALS['ACCESS'][PAGE_FEEDBACK] & $this->access){ ?>
            <li <?php if($this->selected_page == PAGE_FEEDBACK) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_FEEDBACK; ?>'); return false;" href="#<?php echo PAGE_FEEDBACK; ?>"
                    >Сообщения</a></li>
        <?PHP } ?>

        <?PHP if($GLOBALS['ACCESS'][PAGE_CALLBACK] & $this->access){ ?>
            <li <?php if($this->selected_page == PAGE_CALLBACK) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_CALLBACK; ?>'); return false;" href="#<?php echo PAGE_CALLBACK; ?>"
                    >Обратные звонки</a></li>
        <?PHP } ?>

        <?PHP if($GLOBALS['ACCESS'][PAGE_COMMENTS] & $this->access && $this->firm->comment_settings){ ?>
            <li <?php if($this->selected_page == PAGE_COMMENTS) { ?>class="ui-tabs-selected ui-state-active"<?php } ?>><a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_COMMENTS; ?>'); return false;" href="#<?php echo PAGE_COMMENTS; ?>"
                    >Комментарии</a></li>
        <?PHP } ?>


        <?PHP if($GLOBALS['ACCESS'][PAGE_RESPONSE] & $this->access){ ?>
            <li class="specialTab <?php if($this->selected_page == PAGE_RESPONSE) { ?>ui-tabs-selected ui-state-active<?php } ?>">
                <a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_RESPONSE; ?>'); return false;" href="#<?php echo  PAGE_RESPONSE; ?>"  >Тех.поддержка</a></li>
        <?PHP } ?>
        <?PHP if($GLOBALS['ACCESS'][PAGE_SETTINGS] & $this->access){ ?>
            <li class="specialTab <?php if($this->selected_page == PAGE_SETTINGS) { ?>ui-tabs-selected ui-state-active<?php } ?>">
                <a onclick="SPAdmin.goToURL('<?php echo url::site() . PAGE_SETTINGS; ?>'); return false;" href="#<?php echo  PAGE_SETTINGS; ?>"  >Настройки</a></li>
        <?PHP } ?>
 
	</ul>
    </div>


    <div id="wrapper"  >


         <div id="sidebar"  >
            <table >
                <tr>

                    <?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'menu/' . $this->selected_page, TRUE), array('selected_subpage' => $this->selected_subpage)); ?>

                </tr>
            </table>

             <div id="goToTop" style="text-align:center;"><a  href="#logo"  onclick="scroll(0,0);return false;">Перейти к началу страницы</a></div>
        </div>

            
        <div id="content" >

                    <NOSCRIPT>

                        <div class="uploadifyError">
                            <p>В вашем браузере отключена поддержка JavaScript. Советуем включить, так как часть функционала будет недоступно.</p>
                        </div>

                    </NOSCRIPT>

                    <h3 id="mainTitle"><?php echo html::specialchars($title) ?></h3>

                    <?php echo messages::show($this->error, TYPE_ERROR) ?>

                    <?php echo messages::show($this->info, TYPE_INFO) ?>

                    <table style="width:100%;">
                        <tr>
                            <td><?php echo $content ?></td>
                        </tr>
                    </table>


        </div>

        

    
    </div>

</div>
 
<div id="end" class="footer"><br />
    © 2011<a href="http://www.shopping-plaza.ru" target="_blank">«Shopping-Plaza.ru»</a>
</div>

 

<br/>

<!-- Yandex.Metrika counter -->
<div style="display:none;"><script type="text/javascript">
(function(w, c) {
(w[c] = w[c] || []).push(function() {
    try {
        w.yaCounter10340566 = new Ya.Metrika({id:10340566, enableAll: true});
    }
    catch(e) { }
});
})(window, "yandex_metrika_callbacks");
</script></div>
<script src="//mc.yandex.ru/metrika/watch_visor.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/10340566" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->



</body>
</html>





