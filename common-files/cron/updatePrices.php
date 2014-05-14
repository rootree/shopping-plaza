<?php
/**
 * Обновление всего каталога продукции для Яндекс.Маркета
 * плюс генерация excel прайса
 */

defined('SYSPATH') or define('SYSPATH', 'NEED');

$_SERVER['SERVER_NAME'] = 'CRON';

if(!class_exists('Template_Controller')){
    class Template_Controller{}
}
$runningOn = 3;
try {
    include('../system/config/common.php') ;;
} catch(Exception $e) {
    echo '#Error: ' .$e->getMessage();
}

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



$query = "SELECT 
    *
FROM firms
WHERE  updatePrices > 0 ";
;
$result = mysql_query($query);

if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysql_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}

while ($row = mysql_fetch_assoc($result)) {


    if($targetID == $row['product_id']) echo PHP_EOL;

	$yandex = new Catalog_Controller();
	$yandex->yandex();

	$zipFile = SuperPath::get($this->firmID, false, IMAGES_TYPE_PRICE). ".zip"  ;

	$excel = new Products_Controller();
	$excel->excel();
}


?>