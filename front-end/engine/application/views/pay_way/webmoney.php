<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<br/>

<p><b>Оплата по WebMoney:</b></p>
  
<div class="head">Payment Form title</div>
<div class="cont">
  <p>Номер заказа/платежа: <i>Order number</i></p>
  <p>Назначение: <i>Payment description</i></p>
  <p>Сумма:<strong>10.10</strong></p>
  <div class="icon_menu">
  <div class="all_icon">
  <ul>
    <li><a id="wm" class="selected"></a></li>
    <li><a id="wmcard"></a></li>
    <li><a id="paymer"></a></li>
  </ul>
</div>
</div>
<div class="wm_adress">
<div id="content_wm" class="div_content">
<div class="help">
  <a href="http://www.webmoney.ru/" target="_blank">Что такое WebMoney?</a><br>
  <a href="http://start.webmoney.ru/" target="_blank">Как зарегистрироваться в WebMoney?</a><br>
  <a href="http://www.owebmoney.ru/kurs.shtml" target="_blank">Краткий курс обучения WebMoney</a><br>
  <a href="http://www.webmoney.ru/rus/addfunds/wmz/index.shtml" target="_blank">Как пополнить свой WMZ-кошелёк?</a><br>
  <a href="http://geo.webmoney.ru/" target="_blank">Территория WebMoney</a>
</div>
<div class="form_input">

  <!-- wm form //-->
  <form method="post" accept-charset="windows-1251" action="https://merchant.webmoney.ru/lmi/payment.asp?at=authtype_8">
    <input type="hidden" name="lmi_payment_desc" value="Payment description">
    <input type="hidden" name="lmi_payment_no" value="Order number">
    <input type="hidden" name="lmi_payment_amount" value="10.10">
    <input type="hidden" name="lmi_sim_mode" value="0">
    <div>
      <select id="lmi_payee_purse" name="lmi_payee_purse">
    <option value="R371374951676">WebMoney RUR (WMR)</option>
  </select>

      <input type="submit" style="width: 90px; padding: 2px;" value="Оплатить">
    </div>
  </form>

</div>
</div>
<div id="content_wmcard" class="div_content">
  <div class="help">
    <div><a class="link" href="http://www.webmoney.ru/rus/addfunds/wmz/aboutcards.shtml" target="_blank">Что такое WM-карта?</a></div>
    <div><a class="link" href="http://www.webmoney.ru/rus/addfunds/wmz/cardsdealers.shtml" target="_blank">Как доставить WM-карту на дом?</a></div>
      <div>Пункты продаж WM-карт в:<br>
        <div>Москве&nbsp;&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/metroview.aspx?city=12918&amp;type=6" target="_blank">на схеме метро</a>,&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=55.75&amp;lon=37.63&amp;z=11&amp;t=6" target="_blank">на карте</a>;</div>
        <div>Санкт-Петербурге&nbsp;&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/metroview.aspx?city=28610&amp;type=6" target="_blank">на схеме метро</a>,&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=59.93&amp;lon=30.33&amp;z=11&amp;t=6" target="_blank">на карте</a>;</div>
        <div>Нижнем Новгороде&nbsp;&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/metroview.aspx?city=32494&amp;type=6" target="_blank">на схеме метро</a>,&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=56.3&amp;lon=44&amp;z=11&amp;t=6" target="_blank">на карте</a>;</div>
        <div>Новосибирске&nbsp;&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/metroview.aspx?city=32494&amp;type=6" target="_blank">на схеме метро</a>,&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=55.03&amp;lon=82.94&amp;z=11&amp;t=6" target="_blank">на карте</a>;</div>
        <div>Самаре&nbsp;&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/metroview.aspx?city=16031&amp;type=6" target="_blank">на схеме метро</a>,&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=53.19&amp;lon=50.16&amp;z=11&amp;t=6" target="_blank">на карте</a>;</div>
        <div>Волгограде&nbsp;&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/metroview.aspx?city=6100&amp;type=6" target="_blank">на схеме метро</a>,&nbsp;&nbsp;<a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=48.72&amp;lon=44.5&amp;z=11&amp;t=6" target="_blank">на карте</a>;</div>
        <div><a href="http://geo.webmoney.ru/wmobjects/?t=3&amp;lang=ru" target="_blank">других регионах России</a>.</div>
      </div>
      <div>Пункты продаж WM-карт на <a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=50.45&amp;lon=30.5&amp;z=11&amp;t=6" target="_blank">Украине</a>
        и в <a href="http://geo.webmoney.ru/wmobjects/" target="_blank">других странах</a> (<a href="http://geo.webmoney.ru/wmobjects/map.aspx?lat=50.45&amp;lon=30.5&amp;z=3&amp;t=6" target="_blank">на карте</a>).
      </div>
  </div>
  <div class="form_input">

    <form method="post" accept-charset="windows-1251" action="https://merchant.webmoney.ru/lmi/payment.asp?at=authtype_3">
      <input type="hidden" name="lmi_payment_desc" value="Payment description">
      <input type="hidden" name="lmi_payment_no" value="Order number">
      <input type="hidden" name="lmi_payment_amount" value="10.10">
      <input type="hidden" name="lmi_sim_mode" value="0">
      <div>
        <label>Введите email:</label><br>
        <input type="text" id="lmi_paymer_email" name="lmi_paymer_email" value=""><br>
        <label>Введите код:</label><br>
        <input type="text" id="lmi_paymer_pinnumberinside" name="lmi_paymer_pinnumberinside" value=""><br>
        <label>Выберите тип карты:</label><br>
          <select id="lmi_payee_purse" name="lmi_payee_purse">
    <option value="R371374951676">WebMoney RUR (WMR)</option>
  </select>

        <input type="submit" style="width: 90px; padding: 2px;" value="Оплатить">
      </div>
    </form>

  </div>
</div>
<div id="content_paymer" class="div_content">
  <div class="help">
    <a href="http://wiki.webmoney.ru/wiki/show/paymer" target="_blank">Что такое Paymer?</a>
  </div>
  <div class="form_input">

    <!-- paymer form //-->
    <form method="post" accept-charset="windows-1251" action="https://merchant.webmoney.ru/lmi/payment.asp?at=authtype_6">
      <input type="hidden" name="lmi_payment_desc" value="Payment description">
      <input type="hidden" name="lmi_payment_no" value="Order number">
      <input type="hidden" name="lmi_payment_amount" value="10.10">
      <input type="hidden" name="lmi_sim_mode" value="0">
      <div>
        <label>Введите email:</label><br>
        <input type="text" id="lmi_paymer_email" name="lmi_paymer_email" value=""><br>
        <label>Введите код:</label><br>
        <input type="text" id="lmi_paymer_pinnumberinside" name="lmi_paymer_pinnumberinside" value=""><br>
        <label>Выберите тип чека-пеймер:</label><br>
          <select id="lmi_payee_purse" name="lmi_payee_purse">
    <option value="R371374951676">WebMoney RUR (WMR)</option>
  </select>

        <input type="submit" style="width: 90px; padding: 2px;" value="Оплатить">
      </div>
    </form>

  </div>
</div>
</div>
</div>