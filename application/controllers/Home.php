<?php

/**
 * @author
 * SciELO - Scientific Electronic Library Online 
 * @link 
 * https://www.scielo.org/
 * @license
 * Copyright SciELO All Rights Reserved.
 */

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Home Class
 *
 * This controller handles all the flow of the home and the templates. 
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Home extends CI_Controller
{

	/**
	 * Define the user language selected.
	 *
	 * @var	string
	 */
	private $language;

	/**
	 * Index Page for Home controller.
	 *
	 * Maps to the following URL
	 * 		http://your-website-url/home
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://your-website-url/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 * @return void
	 */
	public function index()
	{

		$this->set_default_language();

		$this->load_alert();
		$this->load_blog_rss_feed();
		$this->load_tabs();
		$this->load_footer();
		$this->load_available_languages();

		$this->load->view('home');
	}

	/**
	 * Load from cache and setup the alert to be shown in the template top section.
	 * 
	 * @return void
	 */
	private function load_alert()
	{

		$alert = $this->get_content_from_cache('alert', FOUR_HOURS_TIMEOUT, ALERT_EN_API_PATH, ALERT_ES_API_PATH, ALERT_API_PATH);

		$this->load->model('Alert');

		$this->Alert->initialize($alert);
	}

	/**
	 * Load from cache and setup the tabs to be shown in the template tabs section.
	 * 
	 * @return void
	 */
	private function load_tabs()
	{

		$tabs = $this->get_content_from_cache('tabs', FOUR_HOURS_TIMEOUT, TABS_EN_API_PATH, TABS_ES_API_PATH, TABS_API_PATH);

		$this->load->model('TabGroup');

		$this->TabGroup->initialize($tabs);
	}

	/**
	 * Load from cache and setup the footer (signature and partners) to be shown in the template footer section.
	 * 
	 * @return void
	 */
	private function load_footer()
	{

		$footer = $this->get_content_from_cache('footer', FOUR_HOURS_TIMEOUT, FOOTER_EN_API_PATH, FOOTER_ES_API_PATH, FOOTER_API_PATH);

		$this->load->model('Footer');

		$this->Footer->initialize($footer);
	}

	/**
	 * Load from cache and parse a XML to be shown in the template blog section.
	 * Note that this method does not use the 'get_from_wordpress()' function because it loads the content from a RSS Feed.
	 * 
	 * @return void
	 */
	private function load_blog_rss_feed()
	{

		$key = 'blog-';

		$portugueseKey = $key.SCIELO_LANG;
		$cachedContentPortuguese = $this->put_blog_rss_feed_in_cache($portugueseKey, SCIELO_BLOG_URL, ONE_HOUR_TIMEOUT);

		$englishKey = $key.SCIELO_EN_LANG;
		$cachedContentEnglish = $this->put_blog_rss_feed_in_cache($englishKey, SCIELO_BLOG_EN_URL, ONE_HOUR_TIMEOUT);

		$spanishKey = $key.SCIELO_ES_LANG;
		$cachedContentSpanish = $this->put_blog_rss_feed_in_cache($spanishKey, SCIELO_BLOG_ES_URL, ONE_HOUR_TIMEOUT);

		$blog_posts = $this->get_content_by_language($cachedContentPortuguese, $cachedContentEnglish, $cachedContentSpanish);

		$this->load->vars('blog_posts', simplexml_load_string($blog_posts, 'SimpleXMLElement', LIBXML_NOCDATA));
	}

	/**
	 * Put the content of the Blog RSS Feed in the cache, and if the content not exists load from the XML RSS URL and put it with the respective timeout.
	 * After that, returns to the caller the cached content.
	 * @param  int 		$key     The cache content key to be searched.
	 * @param  string 	$url     The XML RSS URL to load the content.
	 * @param  int		$timeout The time before the content expire in the cache.
	 * @return string
	 */
	private function put_blog_rss_feed_in_cache($key, $url, $timeout)
	{

		$cachedContent = $this->cache->get($key);

		if (is_null($cachedContent)) {
			$cachedContent = $this->content->get_blog_content($url);
			$this->cache->set($key, $cachedContent, $timeout);
		}

		return $cachedContent;
	}

	/**
	 * Get the cache content for the language selected by the user.
	 * 
	 * @param  int 		$key		    The cache content key to be searched.
	 * @param  int		$timeout	    The time before the content expire in the cache.
	 * @param  string 	$english_url	The Rest API Service URL to load the content in English.
	 * @param  string 	$spanish_url	The Rest API Service URL to load the content in Spanish.
	 * @param  string 	$portuguese_url	The Rest API Service URL to load the content in Portuguese.
	 * @return string
	 */
	private function get_content_from_cache($key, $timeout, $english_url, $spanish_url, $portuguese_url)
	{

		$key .= '-';

		$portugueseKey = $key.SCIELO_LANG;
		$cachedContentPortuguese = $this->put_content_in_cache($portugueseKey, $portuguese_url, $timeout);

		$englishKey = $key.SCIELO_EN_LANG;
		$cachedContentEnglish = $this->put_content_in_cache($englishKey, $english_url, $timeout);

		$spanishKey = $key.SCIELO_ES_LANG;
		$cachedContentSpanish = $this->put_content_in_cache($spanishKey, $spanish_url, $timeout);;

		return $this->get_content_by_language($cachedContentPortuguese, $cachedContentEnglish, $cachedContentSpanish);
	}

	/**
	 * Put the content in the cache, and if the content not exists load from the API Rest Service URL and put it with the respective timeout.
	 * After that, returns to the caller the cached content.
	 * @param  int 		$key     The cache content key to be searched.
	 * @param  string 	$url     The Rest API Service URL to load the content.
	 * @param  int		$timeout The time before the content expire in the cache.
	 * @return string
	 */
	private function put_content_in_cache($key, $url, $timeout)
	{

		$cachedContent = $this->cache->get($key);

		if (is_null($cachedContent)) {
			$cachedContent = json_decode($this->content->get_from_wordpress($url), true);
			$this->cache->set($key, $cachedContent, $timeout);
		}

		return $cachedContent;
	}

	/**
	 * Returns the variable specific to the language selected by the user.
	 * 
	 * @param string $portugueseContent
	 * @param string $englishContent
	 * @param string $spanishContent
	 * @return string
	 */
	private function get_content_by_language($portugueseContent, $englishContent, $spanishContent) {

		switch ($this->language) {

			case SCIELO_LANG:
				return $portugueseContent;
				break;

			case SCIELO_EN_LANG:
				return $englishContent;
				break;

			case SCIELO_ES_LANG:
				return $spanishContent;
				break;
		}
	}

	/**
	 * The array containing the available languages to be shown in the header.
	 * 
	 * @return void
	 */
	private function load_available_languages()
	{

		$language_url = base_url('language');
		$portuguese = array('link' => $language_url . '/portuguese', 'language' => 'Português');
		$english = array('link' => $language_url . '/english', 'language' => 'English');
		$spanish = array('link' => $language_url . '/spanish', 'language' => 'Español');

		$available_languages = array();

		switch ($this->language) {

			case SCIELO_LANG:
				$available_languages[] = $english;
				$available_languages[] = $spanish;
				break;

			case SCIELO_EN_LANG:
				$available_languages[] = $portuguese;
				$available_languages[] = $spanish;
				break;

			case SCIELO_ES_LANG:
				$available_languages[] = $english;
				$available_languages[] = $portuguese;
				break;
		}

		$this->load->vars('available_languages', $available_languages);
	}

	/**
	 * Set default language if none was selected.
	 * 
	 * @return void
	 */
	private function set_default_language()
	{

		$this->language = get_cookie('language', true);

		if (!isset($this->language) || empty($this->language)) {

			delete_cookie('language');

			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

			switch ($lang) {

				case 'pt':
					$this->language = SCIELO_LANG;
					break;

				case 'es':
					$this->language = SCIELO_ES_LANG;
					break;

				default:
					$this->language = SCIELO_EN_LANG;
					break;
			}

			set_cookie('language', $this->language, ONE_DAY_TIMEOUT * 30);
		}
	}
}
