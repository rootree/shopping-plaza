<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo ((!empty($title)) ? ( html::specialchars($title) . ' ') : "Конструктор Интернет-магазина в аренду — Продавать через Интернет? Это просто!"); ?></title>

<base href="http://shopping-plaza.loc/" />

<script src="/JS/jquery-1.5.1.min.js"></script>
<script src="/JS/initPublic.js"></script>


<link rel="Stylesheet" href="/publicCSS/screen.css" type="text/css" media="screen">
<link rel="Stylesheet" href="/publicCSS/bpit.css" type="text/css" media="screen">
<link rel="Stylesheet" href="/publicCSS/signup.css" type="text/css" media="screen">
 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />



<body class="home signup signup4">

<div class="wrapper" style="width: 100%;">

  <div class="site_header">
  <div class="container">


  <!--  <div class="logo_shopping_plaza">



        <a href="/" ><img src="/publicIMG/LOGO.top.png" alt="Shopping-Plaza" ></a>
    </div>
-->
    <div class="inner">



      <div class="links">
        <a href="/" <?php if(isset($this) && $this->selected_page == PAGE_MAIN) { ?>id="selected"<?php } ?>>Страница приветствия</a>

        <a href="tour/" <?php if(isset($this) && $this->selected_page == PAGE_TOUR) { ?>id="selected"<?php } ?>>Возможности</a>

        <a href="examples/" <?php if(isset($this) && $this->selected_page == PAGE_EXAMPLES) { ?>id="selected"<?php } ?>>Примеры</a>

         <a href="help/" <?php if(isset($this) && $this->selected_page == PAGE_HELP) { ?>id="selected"<?php } ?>>Справка</a>

        <!--<a href="<?php echo   PAGE_ARTICLE; ?>/" <?php if(isset($this) && $this->selected_page == PAGE_ARTICLE) { ?>id="selected"<?php } ?>>Статьи</a> -->

        <a href="api/" <?php if(isset($this) && $this->selected_page == PAGE_API) { ?>id="selected"<?php } ?>>API</a>

        <a href="price/" <?php if(isset($this) && $this->selected_page == PAGE_PRICE) { ?>id="selected"<?php } ?>>Конструктор магазина</a>

      </div>
      <div class="sign_links">

          <a    href="login/" <?php if(isset($this) && $this->selected_page == PAGE_LOGIN) { ?>id="selected"<?php } ?>>Для клиентов</a>
 
       </div>
      <div class="links" style="float:right; text-align:center; margin-top: -5px; ">

          <a href="mailto:support@shopping-plaza.ru">support@shopping-plaza.ru</a>

       </div>
    </div>
  </div>
</div>





 

<NOSCRIPT>

    <div class="input_error">
        <p>В вашем браузере отключена поддержка JavaScript. Советуем включить, так как часть функционала будет недоступно.</p>
    </div>

</NOSCRIPT>



<?php echo $content ?>
 

<div id="footer">

  <div class="legal">


      <a href="/" ><img src="/publicIMG/LOGO.png" alt="Shopping-Plaza"  ></a>

      <br/>
    © 2011-<?=date('Y')?>. «Shopping-Plaza.ru» - аренда Интернет-магазинов.<br>
      <a href="mailto:support@shopping-plaza.ru">support@shopping-plaza.ru</a>
      <br>
      <br>

  </div>
</div>
 

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
    
</body></html>






