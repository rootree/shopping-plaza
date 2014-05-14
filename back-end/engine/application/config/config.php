<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Base path of the web site. If this includes a domain, eg: localhost/kohana/
 * then a full URL will be used, eg: http://localhost/kohana/. If it only includes
 * the path, and a site_protocol is specified, the domain will be auto-detected.
 */

/**
 * Force a default protocol to be used by the site. If no site_protocol is
 * specified, then the current protocol is used, or when possible, only an
 * absolute path (with no protocol/domain) is used.
 */
$config['site_protocol'] = 'http';

/**
 * Name of the front controller for this application. Default: news.php
 *
 * This can be removed by using URL rewriting.
 */
$config['index_page'] = '';

/**
 * Fake file extension that will be added to all generated URLs. Example: .html
 */
$config['url_suffix'] = '';

/**
 * Length of time of the internal cache in seconds. 0 or FALSE means no caching.
 * The internal cache stores file paths and config entries across requests and
 * can give significant speed improvements at the expense of delayed updating.
 */
$config['internal_cache'] = FALSE;

/**
 * Internal cache directory.
 */
$config['internal_cache_path'] = APPPATH.'cache/';

/**
 * Enable internal cache encryption - speed/processing loss
 * is neglible when this is turned on. Can be turned off
 * if application directory is not in the webroot.
 */
$config['internal_cache_encrypt'] = FALSE;

/**
 * Encryption key for the internal cache, only used
 * if internal_cache_encrypt is TRUE.
 *
 * Make sure you specify your own key here!
 *
 * The cache is deleted when/if the key changes.
 */
$config['internal_cache_key'] = 'foobar-changeme';

/**
 * Enable or disable gzip output compression. This can dramatically decrease
 * server bandwidth usage, at the cost of slightly higher CPU usage. Set to
 * the compression level (1-9) that you want to use, or FALSE to disable.
 *
 * Do not enable this option if you are using output compression in php.ini!
 */
$config['output_compression'] = FALSE;

/**
 * Enable or disable global XSS filtering of GET, POST, and SERVER data. This
 * option also accepts a string to specify a specific XSS filtering tool.
 */
$config['global_xss_filtering'] = FALSE;

/**
 * Enable or disable hooks.
 */
$config['enable_hooks'] = FALSE;

/**
 * Log thresholds:
 *  0 - Disable logging
 *  1 - Errors and exceptions
 *  2 - Warnings
 *  3 - Notices
 *  4 - Debugging
 */
$config['log_threshold'] = 4;

/**
 * Message logging directory.
 */
$config['log_directory'] = APPPATH.'logs';

/**
 * Enable or disable displaying of Kohana error pages. This will not affect
 * logging. Turning this off will disable ALL error pages.
 */
$config['display_errors'] = TRUE;

/**
 * Enable or disable statistics in the final output. Stats are replaced via
 * specific strings, such as {execution_time}.
 *
 * @see http://docs.kohanaphp.com/general/configuration
 */
$config['render_stats'] = TRUE;

/**
 * Filename prefixed used to determine extensions. For example, an
 * extension to the Controller class would be named MY_Controller.php.
 */
$config['extension_prefix'] = 'MY_';

/**
 * Additional resource paths, or "modules". Each path can either be absolute
 * or relative to the docroot. Modules can include any resource that can exist
 * in your application directory, configuration files, controllers, views, etc.
 */
$config['modules'] = array
(
    // MODPATH.'auth',      // Authentication
    // MODPATH.'kodoc',     // Self-generating documentation
    // MODPATH.'gmaps',     // Google Maps integration
    // MODPATH.'archive',   // Archive utility
    // MODPATH.'payment',   // Online payments
    // MODPATH.'unit_test', // Unit testing
);

/**
 * Список всех проектов
 */
 
defined('PAGE_LOGIN') or define('PAGE_LOGIN', 'login');
defined('PAGE_DASHBOARD') or define('PAGE_DASHBOARD', 'dashboard');
defined('PAGE_MAIN') or define('PAGE_MAIN', 'main');
defined('PAGE_REG') or define('PAGE_REG', 'reg');
defined('PAGE_API') or define('PAGE_API', 'api');
defined('PAGE_TOUR') or define('PAGE_TOUR', 'tour');
defined('PAGE_HELP') or define('PAGE_HELP', 'help');
defined('PAGE_DESIGN') or define('PAGE_DESIGN', 'design');
defined('PAGE_EXAMPLES') or define('PAGE_EXAMPLES', 'examples');
defined('PAGE_PRICE') or define('PAGE_PRICE', 'price');
defined('PAGE_ARTICLE') or define('PAGE_ARTICLE', 'articles');

 
define('PAGE_SETTINGS', 'settings');
define('PAGE_RESPONSE', 'response');

define('PAGE_ITEMS', 'products');
define('PAGE_USERS', 'users');
define('PAGE_CLIENTS', 'clients');
define('PAGE_ORDERS', 'orders');
define('PAGE_FEEDBACK', 'feedback');
define('PAGE_CALLBACK', 'callback');
define('PAGE_VACANCY', 'vacancy');
define('PAGE_NEWS', 'news');
define('PAGE_PARTNERS', 'partners');
define('PAGE_PAGES', 'pages');
define('PAGE_COMMENTS', 'comments');


define('ACCESS_GUEST', 8);
define('ACCESS_ADMIN', 1);
define('ACCESS_MODER', 2);
define('ACCESS_VIEWER', 4);

define('MODER_DELETED', 1);
define('MODER_ACTIVE', 2);

define('ELEMENTS_ON_PAGE', 25);

$GLOBALS['ACCESS'] = array(
    PAGE_MAIN => ACCESS_GUEST,
    PAGE_LOGIN => ACCESS_GUEST,
    PAGE_HELP => ACCESS_GUEST,
    PAGE_TOUR => ACCESS_GUEST,
    PAGE_REG => ACCESS_GUEST,
    PAGE_PRICE => ACCESS_GUEST,
    PAGE_DASHBOARD => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_SETTINGS => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_PAGES =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_PARTNERS =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_NEWS => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_VACANCY =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_CLIENTS =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_USERS =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_ITEMS => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_ORDERS =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_FEEDBACK =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_CALLBACK =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_RESPONSE =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_COMMENTS =>  ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
);
 
switch ($GLOBALS['runningOn']){
    case 1: // Home
 
        $config['site_domain'] = 'shopping-plaza.loc/';

        define('PATH_ENGINE', 'D:\Source\magaz\shopping-plaza.loc\engine');
        define('WATER_MARK', 'D:\Source\magaz\shopping-plaza.loc\engine\water_mark.png');

        break;

    case 3: // Home

        $config['site_domain'] = 'shopping-plaza.ru/';

        define('PATH_ENGINE', '/var/shopping-plaza.ru/public');
        define('WATER_MARK', '/var/shopping-plaza.ru/public/water_mark.png');

        break;
        
}

define('PRODUCTS_VIEW_LIST', 1);
define('PRODUCTS_VIEW_IMG', 2);

define('DEMO_SHOP', 28);
define('DEMO_SHOP_MODER', 56);
