<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
 */
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
 */
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
 */
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| SciELO - Scientific Electronic Library Online constants
|--------------------------------------------------------------------------
|
| This is the default constants used in the application to access rest api and other services.
|
|
 */
// Base URL (keeps this out of the config.php)
if (isset($_SERVER['HTTP_HOST'])) {
    $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
    $base_url .= '://' . $_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

    // Base URI (It's different to base URL!)
    $base_uri = parse_url($base_url, PHP_URL_PATH);
    if (substr($base_uri, 0, 1) != '/')
        $base_uri = '/' . $base_uri;
    if (substr($base_uri, -1, 1) != '/')
        $base_uri .= '/';
} else {
    $base_url = 'http://localhost/';
    $base_uri = '/';
}

// Define these values to be used later on
define('BASE_URL', $base_url);
define('BASE_URI', $base_uri);
define('APPPATH_URI', BASE_URI . APPPATH);
define('STATIC_ASSETS_PATH', BASE_URL.'static/');

// API Token
define('API_USR',''); // @TODO - Define on production
define('API_PWD',''); // @TODO - Define on production
define('SALT', ''); // @TODO - Define on production

// API Default Path
define('WORDPRESS_URL', 'http://scielohomolog.parati.ag/scielo-org-adm');
define('WORDPRESS_API_PATH', WORDPRESS_URL.'/wp-json');
define('WORDPRESS_API_PATH_EN', WORDPRESS_URL.'/en/wp-json');
define('WORDPRESS_API_PATH_ES', WORDPRESS_URL.'/es/wp-json');
define('WORDPRESS_PAGES_API_PATH', '/wp/v2/pages');

// Alert API Path
define('ALERT_API_PATH', WORDPRESS_API_PATH.WORDPRESS_PAGES_API_PATH.'/103');
define('ALERT_EN_API_PATH', WORDPRESS_API_PATH_EN.WORDPRESS_PAGES_API_PATH.'/103');
define('ALERT_ES_API_PATH', WORDPRESS_API_PATH_ES.WORDPRESS_PAGES_API_PATH.'/103');

// Tabs API Path
define('TABS_API_PATH', WORDPRESS_API_PATH.WORDPRESS_PAGES_API_PATH.'/80');
define('TABS_EN_API_PATH', WORDPRESS_API_PATH_EN.WORDPRESS_PAGES_API_PATH.'/80');
define('TABS_ES_API_PATH', WORDPRESS_API_PATH_ES.WORDPRESS_PAGES_API_PATH.'/80');

// Footer API Path
define('FOOTER_API_PATH', WORDPRESS_API_PATH.WORDPRESS_PAGES_API_PATH.'/126');
define('FOOTER_EN_API_PATH', WORDPRESS_API_PATH_EN.WORDPRESS_PAGES_API_PATH.'/126');
define('FOOTER_ES_API_PATH', WORDPRESS_API_PATH_ES.WORDPRESS_PAGES_API_PATH.'/126');

// URL for the Wordpress Rest API
define('WP_TOKEN_URL', WORDPRESS_API_PATH.'/jwt-auth/v1/token');
define('WP_POSTS_URL', WORDPRESS_API_PATH.'/wp/v2/posts');
define('WP_PAGES_URL', WORDPRESS_API_PATH.'/wp/v2/pages');
define('WP_CATEGORIES_URL', WORDPRESS_API_PATH.'/wp/v2/categories');

// URL for the SciELO Blog
define('SCIELO_BLOG_URL', 'https://blog.scielo.org/feed/');
define('ONE_HOUR_TIMEOUT', (60 * 60));
define('FOUR_HOURS_TIMEOUT', (ONE_HOUR_TIMEOUT * 4));
define('ONE_DAY_TIMEOUT', (ONE_HOUR_TIMEOUT * 24));

// We dont need these variables any more
unset($base_uri, $base_url);
