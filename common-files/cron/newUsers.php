<?
/**
 * Рассылка для новых пользователей shopping-plaza.ru
*/
defined('SYSPATH') or define('SYSPATH', 'NEED');

$_SERVER['SERVER_NAME'] = 'CRON';

if (!class_exists('Template_Controller')) {
    class Template_Controller
    {
    }
}
$runningOn = 3;
try {
    include('../system/config/common.php');
    ;
} catch (Exception $e) {
    echo '#Error: ' . $e->getMessage();
}

$template = file_get_contents('../system/views/mail/shopping-plaza.php');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db(DB_NAME)) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}

mysql_query("SET NAMES 'utf8'");
mysql_query('SET CHARACTER SET utf8');


$data  = date("Y-m-d", strtotime("-1 day"));
$query = "select title,domain,user_mail as mail  from `firms`
 left join moders on moders.firm_id = firms.id
 WHERE `createDate` = '" . $data . "' ";
echo $query;
$result = mysql_query($query);

if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysql_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}

// До тех пор, пока в результате содержатся ряды, помещаем их в ассоциативный массив.
// Замечание: если запрос возвращает только один ряд - нет нужды в цикле.
// Замечание: если вы добавите extract($row); в начало цикла, вы сделаете
//            доступными переменные $userid, $fullname и $userstatus
while ($row = mysql_fetch_assoc($result)) {


    $title   = 'Первое впечатление';
    $firm    = $row["title"];
    $domain  = $row["domain"];
    $content = 'Здравствуйте, вы создали Интернет-магазин с помощью сервиса <a href="http://shopping-plaza.ru/">Shopping-Plaza</a>. Хотим вас поздравить с этим и 
    поинтересоваться, как ваши успехи? На чём остановились? И не возникло ли
трудностей в использовании сервиса?<br/><br/>Если у вас есть вопросы, вы можете смело писать мне.';

    $template = str_replace(array(
        "<?php defined('SYSPATH') OR die('No direct access allowed.'); ?><HTML>",
        '<?=html::specialchars($title)?>',
        '<?=html::specialchars($firm->title)?>',
        '<?=$firm->domain ?>',
        '<?=$content?>',
    ), array(
        '<HTML>',
        $title,
        $firm,
        $domain,
        $content,
    ), $template);


    $headers = "From: " . MAIL_ADMIN . "\r\n";
    $headers .= "Content-type: text/html\r\n";

    //options to send to cc+bcc
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

    // now lets send the email.
    mail($row["mail"], $title, $template, $headers);

    echo 'Send for ' . $row["mail"] . "\n";
}

mysql_free_result($result);

?> 