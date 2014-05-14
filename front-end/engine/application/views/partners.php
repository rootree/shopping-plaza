<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="partners">

    <h3>Наши партнёры</h3>

    <? foreach($items as $item) { ?>

 
        <h2  ><?=html::specialchars($item->title) ?></h2>

    <div class="description">
	<p class="padd"><b>Описание</b></p>

       <p class="text"><?=($item->annonce) ?></p>


	<table class="info" cellspacing="0" cellpadding="0">
  <tr>
    <td ><p><b>Адрес сайта: </b></p></td>
    <td><p><?=html::specialchars($item->www) ?></p></td>
  </tr>
  <tr>
    <td><p><b>Адрес: </b></p></td>
    <td><p><?=html::specialchars($item->address) ?></p></td>
  </tr>
  <tr>
    <td style="white-space: nowrap"><p><b>Телефон для связи:</b></p></td>
    <td><p><b><?=html::specialchars($item->tel) ?></b></p></td>
  </tr>
  <tr>
    <td><p><b>Майл для связи:</b></p> </td>
    <td><a href="mailto:<?=html::specialchars($item->mail) ?>"><?=html::specialchars($item->mail) ?></a></td>
  </tr>
  <tr>
    <td><p><b>Факс:</b></p> </td>
    <td><p><?=html::specialchars($item->fax) ?></p></td>
  </tr>
</table>
     </div>
    <?}?>
 
</div>