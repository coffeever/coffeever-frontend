<?php
session_start();
ini_set('max_execution_time', 10);
ini_set('output_buffering',0);

/**
 * Define constant variables
 */
define('INDEX', 'FcvR5y5WI1NlvYyIyWpF');
define('ENABLE_CACHE', false);
define('ENABLE_MINIFY', false);
define('CACHE_DIR', 'cache');
define('ROOT_DIR', __DIR__);
define('DOMAIN_ID', 'xWRcLQbEtzqMr9Mpj');

define('SITE_URL', 'https://coffeever.herokuapp.com');
define('STATIC_URL', 'https://coffeever.herokuapp.com/assets/');
define('API_HOST', "coffeever-api.herokuapp.com");
define('API_USE_SSL', false);

/**
 * Remote address
 */
global $REMOTE_ADDR;
$REMOTE_ADDR = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

/**
 * Detect IP & Enable debug mode && enable error reporting
 */
if($REMOTE_ADDR == 'localhost'){
    define('DEBUG_MODE', true);
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
else{
    define('DEBUG_MODE', true);
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    /*
    define('DEBUG_MODE', false);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    */
}

/**
 * Call required files
 */
require ROOT_DIR.'/helpers/functions.php';
require ROOT_DIR.'/helpers/Mobile_detect.php';
require ROOT_DIR.'/helpers/Router.php';

//Google API PHP Library includes
require ROOT_DIR.'/vendor/autoload.php';

//
//======Define global parameters======
//

/**
 * Actual link
 */
global $ACTUAL_LINK;
$HTTP_HOST = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST'];
$ACTUAL_LINK = "https://$HTTP_HOST$_SERVER[REQUEST_URI]";
if (ENABLE_CACHE) {
    $ROUTE_IDENTIFIER = md5(base64_encode($ACTUAL_LINK));
    if (cacheExists($ROUTE_IDENTIFIER.'.html')) {
        echo getCacheFile($ROUTE_IDENTIFIER.'.html');
        exit();
    }
}

/**
 * Mobile Detect
 */
global $detect;
$detect = new Mobile_Detect;

/**
 * Router page
 */
global $page;
$page = isset($_GET['p']) && !empty($_GET['p'])  && $_GET['p']!='index.html' ? $_GET['p'] : "home";

/**
 * Footer scripts
 */
global $footerAppend;
$footerAppend= array();


/**
 * Set custom config parameters on boot
 */
setConfigParam('PAGE_SIZE',16);
setConfigParam("robots","index,follow");
setConfigParam("ogImage","/assets/img/default.jpg");
setConfigParam("bodyClass","template-index");
setConfigParam("canonical",SITE_URL. str_replace('//','/',$_SERVER['REQUEST_URI'].'/'));

/**
 * Call handlers then router
 */
require ROOT_DIR.'/handle-forms.php';
require ROOT_DIR.'/router.php';

?>
