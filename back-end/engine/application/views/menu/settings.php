<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_SETTINGS] & $this->access){ ?>

<td class="side_menu">

<div id="" class="body_left_panel shadow" >

    <b>Настройки:</b>
    <ol id="nav">
         <?PHP if($this->accessRules['content'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_CONTENT) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>settings/content">1. Интернет-магазина</a></li>
        <?PHP } ?>
         <?PHP if($this->accessRules['index'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_MAIN) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/">2. Главной страницы</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['firm'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_FIRM) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/firm">3. Организации</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['enabled'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_ENABLED) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/enabled">Выкл/Вкл магазина</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['sales'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_SALES) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/sales">5. Режим продаж</a></li>
        <?PHP } ?> 
    </ol>

</div>
 

<div id="" class="body_left_panel shadow" >

    <b>Интеграция:</b>
    <ol id="nav">

        <li>
            <a <?php if($selected_subpage == Products_Controller::SUBPAGE_IMPORT_YML) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/yml/">Обновление из YML</a>
        </li>

        <li><a <?php if($selected_subpage == Products_Controller::SUBPAGE_YANDEX) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>products/yandex/">YML-формат (Яндекс.Маркет)</a></li>

        <?PHP if($this->accessRules['api'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_API) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/api">API-шлюз</a></li>
        <?PHP } ?>
    </ol>

</div>

<div id="" class="body_left_panel shadow" >

    <b>Созданные/Заведённые:</b>
    <ol id="nav">

        <?PHP if($this->accessRules['users'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_USERS) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/users">Администраторы</a></li>
        <?PHP } ?>

        <?PHP if($this->accessRules['delivery'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_DELIVERY) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>settings/delivery">5. Способы доставки</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['pay'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_PAY) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>settings/pay">6. Способы оплаты</a></li>
        <?PHP } ?>

        <?PHP if($this->accessRules['cats'] & $this->access ){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_CATS) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/cats">7. Категории товаров</a></li>
        <?PHP } ?>

        <?PHP if($this->accessRules['catssub'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_CATS_SUB) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/catssub">8. Подкатегории товаров</a></li>
        <?PHP } ?>
    </ol>

</div>
    
<div id="" class="body_left_panel shadow" >

    <b>Добавить:</b>
    <ol id="nav">

        <?PHP if($this->accessRules['usersadd'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_USERS_ADD) { ?>id="selected"<?php } ?>  href="<?php echo url::site(); ?>settings/usersadd">Администратора</a></li>
        <?PHP } ?>

        <?PHP if($this->accessRules['deliveryadd'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_DELIVERY_ADD) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/deliveryadd">Способ доставки</a></li>
        <?PHP } ?>

        <?PHP if($this->accessRules['payadd'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_PAY_ADD) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/payadd">Способ оплаты</a></li>
        <?PHP } ?>

        <?PHP if($this->accessRules['catsadd'] & $this->access && !$this->firm->YMLenabled){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_CATS_ADD) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/catsadd">Категорию товаров</a></li>
        <?PHP } ?>

        <?PHP if($this->accessRules['catsaddsub'] & $this->access && !$this->firm->YMLenabled){ ?>
            <li><a <?php if($selected_subpage == Settings_Controller::SUBPAGE_CATS_ADD_SUB) { ?>id="selected"<?php } ?>   href="<?php echo url::site(); ?>settings/catsaddsub">Подкатегорию</a></li>
        <?PHP } ?>
    </ol>

</div>

</td>

<?PHP } ?>