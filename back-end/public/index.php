<?php

// 1 - дома
// 3 - сервер
$runningOn = 1;

define('IN_PRODUCTION', false);

switch ($runningOn) {
    case 1:
        $kohana_application = 'D:\Source\magaz\front-end\engine\application';
        $kohana_modules     = 'D:\Source\magaz\common-files\modules';
        $kohana_system      = 'D:\Source\magaz\common-files\system';
        break;
    case 3:
        $kohana_application = '/var/shopping-plaza.ru/front-end/application';
        $kohana_modules     = '/var/shopping-plaza.ru/common-files/modules';
        $kohana_system      = '/var/shopping-plaza.ru/common-files/system';
        break;
}


/**
 * Test to make sure that Kohana is running on PHP 5.2 or newer. Once you are
 * sure that your environment is compatible with Kohana, you can comment this
 * line out. When running an application on a new server, uncomment this line
 * to check the PHP version quickly.
 */
version_compare(PHP_VERSION, '5.2', '<') and exit('Kohana requires PHP 5.2 or newer.');

/**
 * Set the error reporting level. Unless you have a special need, E_ALL is a
 * good level for error reporting.
 */
error_reporting(E_ALL & ~E_STRICT);

/**
 * Turning off display_errors will effectively disable Kohana error display
 * and logging. You can turn off Kohana errors in application/config/common.php
 */
ini_set('display_errors', true);

/**
 * If you rename all of your .php files to a different extension, set the new
 * extension here. This option can left to .php, even if this file has a
 * different extension.
 */
define('EXT', '.php');

//
// DO NOT EDIT BELOW THIS LINE, UNLESS YOU FULLY UNDERSTAND THE IMPLICATIONS.
// ----------------------------------------------------------------------------
// $Id: news.php 3915 2009-01-20 20:52:20Z zombor $
//

$kohana_pathinfo = pathinfo(__FILE__);
// Define the front controller name and docroot
define('DOCROOT', $kohana_pathinfo['dirname'] . DIRECTORY_SEPARATOR);
define('KOHANA', $kohana_pathinfo['basename']);

// If the front controller is a symlink, change to the real docroot
is_link(KOHANA) and chdir(dirname(realpath(__FILE__)));

// If kohana folders are relative paths, make them absolute.
$kohana_application = file_exists($kohana_application) ? $kohana_application : DOCROOT . $kohana_application;
$kohana_modules     = file_exists($kohana_modules) ? $kohana_modules : DOCROOT . $kohana_modules;
$kohana_system      = file_exists($kohana_system) ? $kohana_system : DOCROOT . $kohana_system;

// Define application and system paths
define('APPPATH', str_replace('\\', '/', realpath($kohana_application)) . '/');
define('MODPATH', str_replace('\\', '/', realpath($kohana_modules)) . '/');
define('SYSPATH', str_replace('\\', '/', realpath($kohana_system)) . '/');

// Clean up
unset($kohana_application, $kohana_modules, $kohana_system);

// Initialize Kohana
require SYSPATH . 'core/Bootstrap' . EXT;


