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

// Feature togglers
define('ENABLED_COUNTS_DISPLAY', getenv('ENABLED_COUNTS_DISPLAY'));

// Define these values to be used later on.
define('BASE_URL', $base_url);
define('BASE_URI', $base_uri);
define('APPPATH_URI', BASE_URI . APPPATH);
define('STATIC_ASSETS_PATH', BASE_URL . 'static/');

// API Token Authentication.
define('API_USR', 'app'); // @TODO - Define on production
define('API_PWD', '#w7e45b22'); // @TODO - Define on production
define('SALT', 'qKMlWO3nX7D7QZPYjqPfxBXVsr8r27eB'); // @TODO - Define on production

// SMPT Authentication credentials.
define('SCIELO_SMTP_AUTH', false); // @TODO - Define on production
define('SMTP_SMTP_SECURE', ''); // @TODO - Define on production
define('SCIELO_SMTP_SERVER', 'localhost'); // @TODO - Define on production
define('SCIELO_SMTP_PORT', '1025'); // @TODO - Define on production
define('SCIELO_SMTP_USERNAME', ''); // @TODO - Define on production
define('SCIELO_SMTP_PASSWORD', ''); // @TODO - Define on production

// Twitter API Authentication.
define('TWITTER_ACCESS_TOKEN', '71320992-ECLCq3q1cFLsQTQXMUDOVHRMFtcQlxxP07U8ET2IM'); // @TODO - Define on production
define('TWITTER_ACCESS_TOKEN_SECRET', 'iEZ9pEtncHZsJAib6J1Luo60fY8mCxaUfE5mLzgMoqtYn'); // @TODO - Define on production
define('TWITTER_CONSUMER_KEY', 'piIRji7BUY0WpDwpmNNmx5Xxh'); // @TODO - Define on production
define('TWITTER_CONSUMER_SECRET', 'TQYoeLNcjHwGEXRJkPYHs3oEVRL6f7pFVzXsmY9FeDzoUt0hDz'); // @TODO - Define on production
define('TWITTER_SCREEN_NAME', 'RedeSciELO'); // @TODO - Define on production

// Google reCAPTCHA key.
define('GOOGLE_RECAPTCHA_SITE_KEY', '6LfmU3AUAAAAANT43HVpmaewLxfH-Vblm2azNvpx'); // @TODO - Define on production
define('GOOGLE_RECAPTCHA_SERVER_KEY', '6LfmU3AUAAAAAGSyKyYoiVst5mggGpldC3pxshIx'); // @TODO - Define on production
define('GOOGLE_RECAPTCHA_VERIFY_URL', 'https://www.google.com/recaptcha/api/siteverify');

// Google Client API Key
define('GOOGLE_CLIENT_API_APPNAME', 'SciELO.or'); // @TODO - Define on production
define('GOOGLE_CLIENT_API_KEY', 'AIzaSyBSVZxxAvUlB_c4sBJgBFGeJ1o9A4neCn8'); // @TODO - Define on production

// API Default Path. Very Important: Remember to add the last slash in this URL.
define('WORDPRESS_URL', 'http://scielohomolog.parati.ag/scielo-org-adm/'); // @TODO - Define on production
define('WORDPRESS_API_PATH', WORDPRESS_URL . 'wp-json');
define('WORDPRESS_API_PATH_EN', WORDPRESS_URL . 'en/wp-json');
define('WORDPRESS_API_PATH_ES', WORDPRESS_URL . 'es/wp-json');
define('WORDPRESS_PAGES_API_PATH', '/wp/v2/pages');
define('WORDPRESS_CONTACT_API_PATH', '/contact-form-7/v1/contact-forms/{ID}/feedback');

// Alert API Path.
define('ALERT_API_PATH', WORDPRESS_API_PATH . WORDPRESS_PAGES_API_PATH . '/103');
define('ALERT_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/103');
define('ALERT_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/103');

// Tabs API Path.
define('TABS_API_PATH', WORDPRESS_API_PATH . WORDPRESS_PAGES_API_PATH . '/80');
define('TABS_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/80');
define('TABS_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/80');

// Footer API Path.
define('FOOTER_API_PATH', WORDPRESS_API_PATH . WORDPRESS_PAGES_API_PATH . '/126');
define('FOOTER_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/126');
define('FOOTER_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/126');

// URL for the About Rest API
define('ABOUT_API_PATH', WORDPRESS_API_PATH . WORDPRESS_PAGES_API_PATH . '/93');
define('ABOUT_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/93');
define('ABOUT_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/93');

// URL for the OAD Rest API
define('OPENACCESS_API_PATH', WORDPRESS_API_PATH . WORDPRESS_PAGES_API_PATH . '/149');
define('OPENACCESS_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/149');
define('OPENACCESS_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/149');

// URL for Subpages Rest API
define('SUBPAGES_API_PATH', WORDPRESS_API_PATH . WORDPRESS_PAGES_API_PATH . '/?parent=pageID&orderby=menu_order&order=asc&per_page=50');
define('SUBPAGES_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/?parent=pageID&orderby=menu_order&order=asc&per_page=50');
define('SUBPAGES_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/?parent=pageID&orderby=menu_order&order=asc&per_page=50');

// URL for the Wordpress Rest API.
define('WP_TOKEN_URL', WORDPRESS_API_PATH . '/jwt-auth/v1/token');
define('WP_POSTS_URL', WORDPRESS_API_PATH . '/wp/v2/posts');
define('WP_PAGES_URL', WORDPRESS_API_PATH . '/wp/v2/pages');
define('WP_CATEGORIES_URL', WORDPRESS_API_PATH . '/wp/v2/categories');

// URL for the SciELO Blog.
define('SCIELO_BLOG_URL', 'https://blog.scielo.org/feed/');
define('SCIELO_BLOG_EN_URL', 'https://blog.scielo.org/en/feed/');
define('SCIELO_BLOG_ES_URL', 'https://blog.scielo.org/es/feed/');

// URL for the SciELO Collections.
define('SCIELO_COLLECTIONS_URL', 'http://articlemeta.scielo.org/api/v1/collection/identifiers/');

// URL for the SciELO Journals identifiers and the list limit.
define('SCIELO_JOURNAL_IDENTIFIERS_URL', 'http://articlemeta.scielo.org/api/v1/journal/identifiers/');
define('SCIELO_JOURNAL_COLLECTION_URL', 'http://articlemeta.scielo.org/api/v1/journal/?collection={collection}&issn={code}&format=scieloorg');
define('SCIELO_JOURNAL_LIMIT', 50);

// URL for SciELO search and advance search form action.
define('SCIELO_SEARCH_URL', 'https://search.scielo.org/');
define('SCIELO_ADVANCED_SEARCH_URL', 'https://search.scielo.org/?q=*:*&lang=pt&count=15&from=0&output=site&sort=&format=summary&fb=&page=1&q=*&lang=pt&page=1');

// API Path to query pages by slug.
define('SLUG_API_PATH', WORDPRESS_API_PATH . WORDPRESS_PAGES_API_PATH . '/?slug=');
define('SLUG_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/?filter[meta_key]=_wpglobus_slug_en&filter[meta_value]=');
define('SLUG_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/?filter[meta_key]=_wpglobus_slug_es&filter[meta_value]=');

// API Path to callback slugs.
define('SLUG_CALLBACK_EN_API_PATH', WORDPRESS_API_PATH_EN . WORDPRESS_PAGES_API_PATH . '/?slug=');
define('SLUG_CALLBACK_ES_API_PATH', WORDPRESS_API_PATH_ES . WORDPRESS_PAGES_API_PATH . '/?slug=');

// Default timeouts for the cache API.
define('ONE_HOUR_TIMEOUT', (60 * 60));
define('FOUR_HOURS_TIMEOUT', (ONE_HOUR_TIMEOUT * 4));
define('ONE_DAY_TIMEOUT', (ONE_HOUR_TIMEOUT * 24));
define('THIRTY_DAYS_TIMEOUT', ONE_DAY_TIMEOUT * 30);

// Default SciELO website languages.
define('SCIELO_LANG', 'pt');
define('SCIELO_EN_LANG', 'en');
define('SCIELO_ES_LANG', 'es');

// Define youtube SciELO chanel.
define('SCIELO_YOUTUBE_CHANNEL', 'RedeSciELO');

// We dont need these variables any more.
unset($base_uri, $base_url);

// Turn cookiePolicy script ON or OFF. True = ON, False = OFF. And define script url.
define('COOKIE_POLICY_ENABLED', getenv('COOKIE_POLICY_ENABLED')?getenv('COOKIE_POLICY_ENABLED'): true);
define('COOKIE_POLICY_SCRIPT_URL', getenv('COOKIE_POLICY_SCRIPT_URL')?getenv('COOKIE_POLICY_SCRIPT_URL'):'https://static.scielo.org/js/cookiePolicy.min.js');
