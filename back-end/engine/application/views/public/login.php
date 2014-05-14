<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="loginE">

<center>
<br/>
<br/>
<br/>
<?php echo Controller::_kohana_load_view(Kohana::find_file('views', 'public/login_form', TRUE),
         array()); ?>
<br/>
<br/>
<br/>
</center>

</div>