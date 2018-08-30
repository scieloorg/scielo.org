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
		$this->load_footer(); // The footer is the same in any page, so I load it here in the constructor		
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
		$this->load_blog_rss_feed();
		$this->load_tabs();
		$this->load_collections();

		$this->load->view('home');
	}

	/**
	 * About Page for Home controller.
	 *
	 * @return void
	 */
	public function about($page_slug = null)
	{
		/**
		 * Here we have two scenarios to treat in first place:
		 * 1) We don't have subpage ($subpage), i.e, we are at the root about url
		 * 2) We have subpage, i.e, we are at an URL like http://site-url/en/about-scielo/subpage
		 * 2.1) Get the subpage by slug ($subpage variable) and cache it.
		 * 2.1) Verify the type of the page in the "template" field.
		 * 2.2) Redirect for the corresponding page.
		 * 
		 * Obs.: I think it will be necessary for subpages that are menu pages.
		 */
		if (is_null($page_slug)) {

			// In the about page the metadata comes from the About API return json data.
			$this->load_page_metadata('pageMetadataAbout', ABOUT_EN_API_PATH, ABOUT_ES_API_PATH, ABOUT_API_PATH);

			// Load the about page content from the json array
			$about = $this->get_content_from_cache('about', FOUR_HOURS_TIMEOUT, ABOUT_EN_API_PATH, ABOUT_ES_API_PATH, ABOUT_API_PATH);

			// URLs for the subpages
			$search = 'pageID';
			$replace = $about['id'];
			$english_url = str_replace($search, $replace, SUBPAGES_EN_API_PATH);
			$spanish_url = str_replace($search, $replace, SUBPAGES_ES_API_PATH);
			$portuguese_url = str_replace($search, $replace, SUBPAGES_API_PATH);

			// List of subpages
			$aboutSubPages = $this->get_content_from_cache('aboutSubPages', FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url);

			$this->load->model('About');

			$this->About->initialize($about);

			$this->load->vars('aboutSubPages', $aboutSubPages);
			$this->load->view('about');

		} else {
			$this->load_page_by_slug($page_slug);
		}
	}

	/**
	 * About subpage for Home controller.
	 *
	 * @return void
	 */
	public function about_subpage($page_slug, $subpage_slug)
	{
		// Get the page slug and title for breacrumb
		print_r($page_slug);

		// Get the content dependent on the type of the subpage
		print_r($subpage_slug);

		// Load to the correct template
	}

	/**
	 * Load the page using the slug passed and the correct template according to the page type.
	 * 
	 * @param  string	$page_slug The url token identifier for the specific page.
	 * @return void
	 */
	private function load_page_by_slug($page_slug)
	{

		// Note that it is necessary to concatenate the slug here in the API URLs.
		$english_url = SLUG_EN_API_PATH . $page_slug;
		$spanish_url = SLUG_ES_API_PATH . $page_slug;
		$portuguese_url = SLUG_API_PATH . $page_slug;

		$this->load_page_metadata('pageMetadataAbout' . $page_slug, $english_url, $spanish_url, $portuguese_url, TRUE);

		$page = $this->get_content_from_cache($page_slug, FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url);

		// Verify is the first item is an array, because the pages we got by slug come as the first element of an array.
		if (is_array($page[0])) {
			$page = $page[0];
		}

		// All the pages use the array, so pass it early.
		$this->load->vars('page', $page);
			
		// Check the template type of each page to load the correspond view		
		if(empty($page['template'])) {
			
			$this->load->view('pages/content');

		} elseif($page['template'] == 'pageModel-menu.php') {
			
			// Special attention on the mounting of the breadcrumb
			// It is menu page type, get all the subpages using the 'id' attribute.
			$search = 'pageID';
			$replace = $page['id'];
			$english_url = str_replace($search, $replace, SUBPAGES_EN_API_PATH);
			$spanish_url = str_replace($search, $replace, SUBPAGES_ES_API_PATH);
			$portuguese_url = str_replace($search, $replace, SUBPAGES_API_PATH);

			// List of subpages
			$subpages = $this->get_content_from_cache('subpages'.$page_slug, FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url);

			$this->load->vars('subpages', $subpages);
			$this->load->view('pages/menu');

		} elseif($page['template'] == 'pageModel-accordionContent.php') {

			$this->load->view('pages/accordion');

		} elseif($page['template'] == 'pageModel-contactForm.php') {

			$this->load->view('pages/contact');
		}
	}

	/**
	 * Load the page metadata from the cache and pass it to be shown in the template head section.
	 * 
	 * @param  int 		$key		    The cache content key to be searched.
	 * @param  string 	$english_url	The Rest API Service URL to load the content in English.
	 * @param  string 	$spanish_url	The Rest API Service URL to load the content in Spanish.
	 * @param  string 	$portuguese_url	The Rest API Service URL to load the content in Portuguese.
	 * @param  boolean 	$is_slug	    Flag to verify if the page result comes from a query by slug.
	 * @return void
	 */
	private function load_page_metadata($key, $english_url, $spanish_url, $portuguese_url, $is_slug = FALSE)
	{

		$pageMetadata = $this->get_content_from_cache($key, FOUR_HOURS_TIMEOUT, $english_url, $spanish_url, $portuguese_url);

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

		$portugueseKey = $key . SCIELO_LANG;
		$cachedContentPortuguese = $this->put_content_in_cache($portugueseKey, $portuguese_url, $timeout);

		$englishKey = $key . SCIELO_EN_LANG;
		$cachedContentEnglish = $this->put_content_in_cache($englishKey, $english_url, $timeout);

		$spanishKey = $key . SCIELO_ES_LANG;
		$cachedContentSpanish = $this->put_content_in_cache($spanishKey, $spanish_url, $timeout);;

		return $this->get_content_by_language($cachedContentPortuguese, $cachedContentEnglish, $cachedContentSpanish);
	}

	/**
	 * Put the content in the cache, and if the content not exists in the load from the API Rest Service URL
	 * and put it with the respective timeout. If the content not exists in the cache and the rest service doesn't
	 * return anything, show a 404 error.
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

		if (is_null($cachedContent)) {
			$cachedContent = json_decode($this->content->get_from_wordpress($url), true);
			$this->cache->set($key, $cachedContent, $timeout);
		}

		// The content does not exist. Show 404 error page.
		if(empty($cachedContent)) {
			show_404();
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
	 * The array containing the available languages and the static texts for other items to be shown in the templates.
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
		$about_menu_item = array();
		$read_more_text = "";

		switch ($this->language) {

			case SCIELO_LANG:
				$available_languages[] = $english;
				$available_languages[] = $spanish;
				$about_menu_item = array('link' => base_url(SCIELO_LANG . '/sobre-o-scielo'), 'text' => 'Sobre o SciELO');
				$read_more_text = "Leia mais";
				break;

			case SCIELO_EN_LANG:
				$available_languages[] = $portuguese;
				$available_languages[] = $spanish;
				$about_menu_item = array('link' => base_url(SCIELO_EN_LANG . '/about-scielo'), 'text' => 'About SciELO');
				$read_more_text = "Read more";
				break;

			case SCIELO_ES_LANG:
				$available_languages[] = $english;
				$available_languages[] = $portuguese;
				$about_menu_item = array('link' => base_url(SCIELO_ES_LANG . '/sobre-el-scielo'), 'text' => 'Sobre el SciELO');
				$read_more_text = "Lea mas";
				break;
		}

		$this->load->vars('available_languages', $available_languages);
		$this->load->vars('about_menu_item', $about_menu_item);
		$this->load->vars('read_more_text', $read_more_text);
	}

	/**
	 * Set default language (english) if none was selected.
	 * 
	 * @return void
	 */
	private function set_language()
	{

		$this->language = $this->input->cookie('language', true);

		if (!isset($this->language) || empty($this->language)) {

			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

			switch ($lang) {

				case SCIELO_LANG:
					$this->language = SCIELO_LANG;
					break;

				case SCIELO_ES_LANG:
					$this->language = SCIELO_ES_LANG;
					break;

				default:
					$this->language = SCIELO_EN_LANG;
					break;
			}

			$this->input->set_cookie('language', $this->language, ONE_DAY_TIMEOUT * 30);
		}
	}
}
