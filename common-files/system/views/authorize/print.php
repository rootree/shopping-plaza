<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title><?php echo html::specialchars($title) ?></title>

    <link href="<?php echo url::site(); ?>CSS/jquery-ui-1.8.12.custom.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo url::site(); ?>CSS/uploadify.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo url::site(); ?>CSS/highslide.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo url::site(); ?>CSS/highslide-ie6.css" type="text/css" rel="stylesheet" />

    <script src="<?php echo url::site(); ?>JS/jquery-1.5.1.min.js"></script>
    <script src="<?php echo url::site(); ?>JS/jquery-ui-1.8.12.custom.min.js"></script>
    <script src="<?php echo url::site(); ?>JS/highslide.js"></script>
    <script src="<?php echo url::site(); ?>JS/nicEdit.js"></script> 
    <script src="<?php echo url::site(); ?>JS/SPAdmin.js"></script>
    <script src="<?php echo url::site(); ?>JS/init.js"></script>

     
    <script type="text/javascript" src="<?php echo url::site(); ?>JS/swfobject.js"></script>
    <script type="text/javascript" src="<?php echo url::site(); ?>JS/jquery.uploadify.v2.1.4.min.js"></script>
 
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>


    <link href="<?php echo url::site(); ?>CSS/css-base.css" rel="stylesheet" type="text/css" />
 
    <!--[if IE 7]><link rel="stylesheet" href="<?php echo url::site(); ?>CSS/css-ie7.css" type="text/css" /><![endif]-->
    <!--[if IE 8]><link rel="stylesheet" href="<?php echo url::site(); ?>CSS/css-ie8.css" type="text/css" /><![endif]-->
 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />

</head>
<body>

 
    <h3 id="mainTitle"><?php echo html::specialchars($title) ?></h3>

    <table width="100%">
        <tr>
            <td><?php echo $content ?></td>
        </tr>
    </table>
 
    <div id="end" class="footer"><br />
        © 2011<a href="http://www.shopping-plaza.ru" target="_blank">«Shopping-Plaza.ru»</a>
    </div>
 
</body>
</html>





