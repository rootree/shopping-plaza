<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
 
<?
$addon = '';
if(isset($_SESSION['firm']) && $_SESSION['firm']){
     
    $addon = '<p >Или перейти на <a href="http://' . $_SESSION['firm']->domain.
               '">главную страницу</a> Интернет-магазина <a href="http://' . $_SESSION['firm']->domain. '">' . html::specialchars($_SESSION['firm']->title). '</a>.</p>
    ';

}?>

<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'public/template', TRUE),
                 array(
                      'content' => '



  <div class="pageband">

    <div class="container">

      <div class="pagetitle">
        <h1>Произошло недоразумение</h1>
      </div>

    </div>

  </div>

 
<div class="container">

  <div class="extra">

    <div class="fullcolumn">

<p >Совершенно непонятно почему вы попали на эту страницу, возможно, страница на которую
                      вы собирались перейти, не существует, или она была перенесена.</p>


<p >Вам стоит вернуться на <a href="javascript:history.back()">шаг назад</a>, и повторить попытку. </p>

'.$addon.'

    </div>
  </div>

</div>



',
                      'title' => 'Произошла ошибка',
                 )); ?>
 