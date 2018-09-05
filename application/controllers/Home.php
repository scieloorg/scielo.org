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
	 * Constructor for Home controller.
	 * Setup the default language and load the others available to the view.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->set_language();
		$this->load_static_texts_by_language();
		$this->load_about_link(); // The about link is the same in any page, so I load it here in the constructor.			
		$this->load_footer(); // The footer is the same in any page, so I load it here in the constructor.	
	}

	/**
	 * Index Page for Home controller.
	 *
	 * @return void
	 */
	public function index()
	{

		// In the home page the metadata comes from the tabs API return json data.
		$this->load_page_metadata('pageMetadataHome', TABS_EN_API_PATH, TABS_ES_API_PATH, TABS_API_PATH);
		$this->load_alert();
		$this->load_collections();
		$this->load_blog_rss_feed();
		$this->load_twitter();
		$this->load_tabs();

		$this->load->view('home');
	}

	/**
	 * Manage all the route for pages, except home, for Home controller.
	 * Load pages using the slugs passed and the correct template according to the last page type.
	 * 
	 * @param  array	$page_slugs The url token identifier for the specifics pages.
	 * @return void
	 * @return void
	 */
	public function page(...$page_slugs)
	{

		$breadcrumb = array();

		if (!isset($page_slugs) || count($page_slugs) == 0) {
			show_404();
		}

		// Iterate through the array getting each page by slug and mounting the breadcrumb
		$breadcrumbs[] = array('link' => base_url($this->language . '/'), 'link_text' => 'Home');

		for ($i = 0; $i < count($page_slugs) - 1; $i++) {

			$page_slug = $page_slugs[$i];
			$english_url = SLUG_EN_API_PATH . $page_slug;
			$spanish_url = SLUG_ES_API_PATH . $page_slug;
			$portuguese_url = SLUG_API_PATH . $page_slug;

			$page = $this->get_content_from_cache($page_slug, FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url, $page_slug);

			// Verify is the first item is an array, because the pages we got by slug come as the first element of an array.
			if (is_array($page[0])) {
				$page = $page[0];
			}

			$scielo_url = ($this->language == SCIELO_LANG) ? base_url($this->language . '/') : base_url();
			$link = str_replace(WORDPRESS_URL, $scielo_url, $page['link']);
			$link_text = $page['title']['rendered'];

			$breadcrumbs[] = array('link' => $link, 'link_text' => $link_text);
		}

		$this->load->vars('breadcrumbs', $breadcrumbs);

		// Get the last page to show the right template.
		$last_page_slug = $page_slugs[count($page_slugs) - 1];

		$english_url = SLUG_EN_API_PATH . $last_page_slug;
		$spanish_url = SLUG_ES_API_PATH . $last_page_slug;
		$portuguese_url = SLUG_API_PATH . $last_page_slug;

		$this->load_page_metadata('pageMetadataAbout' . $last_page_slug, $english_url, $spanish_url, $portuguese_url, true, $last_page_slug);

		$page = $this->get_content_from_cache($last_page_slug, FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url, $last_page_slug);

		// Verify is the first item is an array, because the pages we got by slug come as the first element of an array.
		if (is_array($page[0])) {
			$page = $page[0];
		}
		
		// All the pages use the array, so pass it early.
		$this->load->vars('page', $page);
				
		// Check the template type of each page to load the correspond view		
		if (empty($page['template'])) {

			$this->load->view('pages/content');

		} elseif ($page['template'] == 'pageModel-menu.php') {
				
			// Special attention on the mounting of the breadcrumb
			// It is menu page type, get all the subpages using the 'id' attribute.
			$search = 'pageID';
			$replace = $page['id'];
			$english_url = str_replace($search, $replace, SUBPAGES_EN_API_PATH);
			$spanish_url = str_replace($search, $replace, SUBPAGES_ES_API_PATH);
			$portuguese_url = str_replace($search, $replace, SUBPAGES_API_PATH);

			// List of subpages
			$subpages = $this->get_content_from_cache('subpages' . $last_page_slug, FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url);

			$this->load->vars('subpages', $subpages);
			$this->load->view('pages/menu');

		} elseif ($page['template'] == 'pageModel-accordionContent.php') {

			$this->load->view('pages/accordion');

		} elseif ($page['template'] == 'pageModel-contactForm.php') {

			$this->load->view('pages/contact');

		} elseif ($page['template'] == 'pageModel-bibliography.php') {

			$this->load->view('pages/bibliography');

		} elseif ($page['template'] == 'pageModel-bookList.php') {

			$this->load->view('pages/booklist');
		}
	}

	/**
	 * Get the About Page link and text for Home controller.
	 *
	 * @return void
	 */
	private function load_about_link()
	{

		// Load the about page content from the json array
		$about = $this->get_content_from_cache('about', FOUR_HOURS_TIMEOUT, ABOUT_EN_API_PATH, ABOUT_ES_API_PATH, ABOUT_API_PATH);

		$about_url = explode('/', $about['link']);
		$about_url = $about_url[count($about_url) - 2];

		$about_menu_item = array('link' => base_url($this->language . '/' . $about_url), 'text' => $about['title']['rendered']);
		$this->load->vars('about_menu_item', $about_menu_item);
	}

	/**
	 * Load the page metadata from the cache and pass it to be shown in the template head section.
	 * 
	 * @param  int 		$key		    The cache content key to be searched.
	 * @param  string 	$english_url	The Rest API Service URL to load the content in English.
	 * @param  string 	$spanish_url	The Rest API Service URL to load the content in Spanish.
	 * @param  string 	$portuguese_url	The Rest API Service URL to load the content in Portuguese.
	 * @param  boolean 	$is_slug	    Flag to verify if the page result comes from a query by slug.
	 * @param  string 	$page_slug	    The page slug to be query by REST API Service.
	 * @return void
	 */
	private function load_page_metadata($key, $english_url, $spanish_url, $portuguese_url, $is_slug = false, $page_slug = null)
	{

		$pageMetadata = $this->get_content_from_cache($key, FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url, $page_slug);

		// Verify is the first item is an array, because the pages we got by slug come as the first element of an array.
		if ($is_slug && is_array($pageMetadata[0])) {
			$pageMetadata = $pageMetadata[0];
		}

		$this->load->model('PageMetadata');

		$this->PageMetadata->initialize($pageMetadata);
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
	 * Load from cache and setup the collections tab content to be shown in the tab template.
	 * 
	 * @return void
	 */
	private function load_collections()
	{

		$collections = $this->put_content_in_cache('collections', SCIELO_COLLECTIONS_URL, FOUR_HOURS_TIMEOUT);

		$this->load->model('Collections');

		$this->Collections->initialize($collections);
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

		$portugueseKey = $key . SCIELO_LANG;
		$cachedContentPortuguese = $this->put_blog_rss_feed_in_cache($portugueseKey, SCIELO_BLOG_URL, ONE_HOUR_TIMEOUT);

		$englishKey = $key . SCIELO_EN_LANG;
		$cachedContentEnglish = $this->put_blog_rss_feed_in_cache($englishKey, SCIELO_BLOG_EN_URL, ONE_HOUR_TIMEOUT);

		$spanishKey = $key . SCIELO_ES_LANG;
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
	 * Load the content of the user from the twitter REST API to be show in its respective template.
	 * 
	 * @return void
	 */
	private function load_twitter()
	{
		
		$key = 'tweets';
		$tweets = $this->cache->get($key);

		if (is_null($tweets)) {
			$tweets = $this->twitter->get_connection()->get('statuses/user_timeline', ['count' => 10, 'tweet_mode' => 'extended', 'include_entities' => true, 'exclude_replies' => true]);
			$this->cache->set($key, $tweets, ONE_HOUR_TIMEOUT);
		}
		
		$this->load->vars('tweets', $tweets);
	}

	/**
	 * Get the cache content for the language selected by the user.
	 * 
	 * @param  int 		$key		    The cache content key to be searched.
	 * @param  int		$timeout	    The time before the content expire in the cache.
	 * @param  string 	$english_url	The Rest API Service URL to load the content in English.
	 * @param  string 	$spanish_url	The Rest API Service URL to load the content in Spanish.
	 * @param  string 	$portuguese_url	The Rest API Service URL to load the content in Portuguese.
	 * @param  string 	$slug	        If none of the previous URL return the data,try to get by slug with a default URL.
	 * @return string
	 */
	private function get_content_from_cache($key, $timeout, $english_url, $spanish_url, $portuguese_url, $slug = null)
	{

		$key .= '-';
		$content = '';
		$callback = '';

		switch ($this->language) {

			case SCIELO_LANG:
				$key = $key . SCIELO_LANG;
				$content = $this->put_content_in_cache($key, $portuguese_url, $timeout);
				break;

			case SCIELO_EN_LANG:
				$key = $key . SCIELO_EN_LANG;
				$content = $this->put_content_in_cache($key, $english_url, $timeout);
				$callback = SLUG_CALLBACK_EN_API_PATH . $slug;
				break;

			case SCIELO_ES_LANG:
				$key = $key . SCIELO_ES_LANG;
				$content = $this->put_content_in_cache($key, $spanish_url, $timeout);
				$callback = SLUG_CALLBACK_ES_API_PATH . $slug;
				break;
		}

		if (count($content) == 0) {
			$content = $this->put_content_in_cache($key, $callback, $timeout);
		}

		if (count($content) == 0) {
			show_404();
		}

		return $content;
	}

	/**
	 * Put the content in the cache, and if the content not exists in the load from the API Rest Service URL
	 * and put it with the respective timeout.
	 * After that, returns to the caller the cached content.
	 * 
	 * @param  int 		$key     The cache content key to be searched.
	 * @param  string 	$url     The Rest API Service URL to load the content.
	 * @param  int		$timeout The time before the content expire in the cache.
	 * @return string
	 */
	private function put_content_in_cache($key, $url, $timeout)
	{

		$cachedContent = $this->cache->get($key);

		if (is_null($cachedContent) || empty($cachedContent)) {
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
	private function get_content_by_language($portugueseContent, $englishContent, $spanishContent)
	{

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
	 * Load the lang files and an array containing the available languages to be show in the templates.
	 * 
	 * @return void
	 */
	private function load_static_texts_by_language()
	{

		$language_url = base_url('language');
		$portuguese = array('link' => $language_url . '/pt', 'language' => 'Português');
		$english = array('link' => $language_url . '/en', 'language' => 'English');
		$spanish = array('link' => $language_url . '/es', 'language' => 'Español');

		$available_languages = array();

		switch ($this->language) {

			case SCIELO_LANG:
				$this->lang->load('scielo', 'portuguese-brazilian');
				$available_languages[] = $english;
				$available_languages[] = $spanish;
				break;

			case SCIELO_EN_LANG:
				$this->lang->load('scielo', 'english');
				$available_languages[] = $portuguese;
				$available_languages[] = $spanish;
				break;

			case SCIELO_ES_LANG:
				$this->lang->load('scielo', 'spanish');
				$available_languages[] = $english;
				$available_languages[] = $portuguese;
				break;
		}

		$this->load->vars('available_languages', $available_languages);
	}

	/**
	 * Set default language (english) if none was selected and make it available to all templates. 
	 * Note that, if a differente language is at the browser url, it has a higher precedence than user location. 
	 * 
	 * @return void
	 */
	private function set_language()
	{

		$this->language = get_cookie('language', TRUE);

		// Because the webite could be deploy in a server subfolder we remove the base_uri.
		$language_url = str_replace(BASE_URI,'',$_SERVER['REQUEST_URI']);
		$language_url = substr($language_url, 0, 2);
		
		// Verify if the language is set in the cookie.
		if (isset($this->language) && !empty($this->language)) {

			$this->set_language_if_in_URL($language_url, SCIELO_LANG);
			$this->set_language_if_in_URL($language_url, SCIELO_ES_LANG);
			$this->set_language_if_in_URL($language_url, SCIELO_EN_LANG);

		} else {

			// If the language is at the browser URL, it has a higher precedence than user location. 
			if(!$this->set_language_if_equal_to($language_url)) {

				// The language isn't in the browser URL, so we get the user location, if it's not one of the tree languages, set it to english (default). 
				$language_location = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

				if(!$this->set_language_if_equal_to($language_location)) {
					$this->set_language_cookie(SCIELO_EN_LANG);
				}
			}
		}	
		
		$this->load->vars('language', $this->language);
	}

	/**
	 * Set language if in the URL. 
	 * 
	 * @param  string	$language_url
	 * @param  string	$language
	 * @return void
	 */
	private function set_language_if_in_URL($language_url, $language) {

		if($language_url == $language && $this->language != $language) {

			$this->set_language_cookie($language);			
		}
	}

	/**
	 * Set language if it's equal to the parameter passed or return FALSE. 
	 * 
	 * @param  string	$language
	 * @return boolean
	 */
	private function set_language_if_equal_to($language) {

		switch ($language) {

			case SCIELO_LANG:
				$this->set_language_cookie(SCIELO_LANG);
				return TRUE;

			case SCIELO_ES_LANG:
				$this->set_language_cookie(SCIELO_ES_LANG);
				return TRUE;

			case SCIELO_EN_LANG:
				$this->set_language_cookie(SCIELO_EN_LANG);	
				return TRUE;
		}

		return FALSE;		
	}

	/**
	 * Set language in the cookie for 30 days. 
	 * 
	 * @param  string	$language
	 * @return void
	 */
	private function set_language_cookie($language)
	{

		$this->language = $language;
		delete_cookie('language');
		set_cookie('language', $this->language, ONE_DAY_TIMEOUT * 30);
	}
}
