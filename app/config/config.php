<?php
namespace App;
error_reporting(E_ALL);
class Config
{
    const SHOW_ERRORS = true;
}
 
// DB Params
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');

// set your default time-zone
date_default_timezone_set('Europe/Berlin');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', '');
// Public path
define('PUBLICPATH', '');
// Site Name
define('SITENAME', '');
// App Version
define('APPVERSION', '0.0.1'); 
