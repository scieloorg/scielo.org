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

class Home extends CI_Controller
{

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
		
		$posts = $this->get_content_from_cache('posts', WP_POSTS_URL, ONE_HOUR_TIMEOUT);
		$pages = $this->get_content_from_cache('pages', WP_PAGES_URL, ONE_HOUR_TIMEOUT);
		$categories = $this->get_content_from_cache('categories', WP_CATEGORIES_URL, ONE_HOUR_TIMEOUT);

		$this->load_alert();
		$this->load_blog_rss_feed();	
		$this->load_tabs();			
		$this->load_footer();

		$this->load->vars('posts', $posts);
		$this->load->vars('pages', $pages);
		$this->load->vars('categories', $categories);
		$this->load->view('home');
	}

	/**
	 * Load from cache and setup the alert to be shown in the template top section.
	 * 
	 * @return void
	 */
	private function load_alert() {

		$alert = $this->get_content_from_cache('alert', ALERT_API_PATH, FOUR_HOURS_TIMEOUT);

		$this->load->model('Alert');

		$this->Alert->initialize($alert);
	}

	/**
	 * Load from cache and setup the tabs to be shown in the template tabs section.
	 * 
	 * @return void
	 */
	private function load_tabs() {

		$tabs = $this->get_content_from_cache('tabs', TABS_API_PATH, FOUR_HOURS_TIMEOUT);

		$this->load->model('TabGroup');

	 	$this->TabGroup->initialize($tabs);
	}

	/**
	 * Load from cache and setup the footer (signature and partners) to be shown in the template footer section.
	 * 
	 * @return void
	 */
	private function load_footer() {

		$footer = $this->get_content_from_cache('footer', FOOTER_API_PATH, FOUR_HOURS_TIMEOUT);

		$scielo_signature = NULL;
		$scielo_partners = array();
		$scielo_open_access_declaration = NULL;

		// Iterate through the blocks array getting the signature, partners array and last html content.
		foreach($footer['acf']['blocks'] as $block) {
			switch($block['type']){
				case 1: $scielo_signature = $block['content']; break;
				case 2: $scielo_partners = $block['partners']; break;
				case 3: $scielo_open_access_declaration = $block['content']; break;
			}
		}
		
		$this->load->vars('scielo_signature', $scielo_signature);
		$this->load->vars('scielo_partners', $scielo_partners);
		$this->load->vars('scielo_open_access_declaration', $scielo_open_access_declaration);
	}	

	/**
	 * Load from cache and parse a XML to be shown in the template blog section.
	 * Note that this method does not use the 'get_from_wordpress()' function because it loads the content from a RSS Feed.
	 * 
	 * @return void
	 */
	private function load_blog_rss_feed() {

		$blog_key = 'blog_posts';
		$blog_posts = $this->cache->get($blog_key);

		if(is_null($blog_posts)) {
			$blog_posts = $this->content->get_blog_content();
			$this->cache->set($blog_key, $blog_posts, ONE_HOUR_TIMEOUT);
		}

		$this->load->vars($blog_key, simplexml_load_string($blog_posts, 'SimpleXMLElement', LIBXML_NOCDATA));		
	}

	/**
	 * Verify in the cache if the content exists, if not, load from the API Rest Service URL and put it with the respective timeout.
	 * After that, returns to the caller the cached content.
	 * @param  int 		$key		The cache content key to be searched.
	 * @param  string 	$url		The Rest API Service URL to load the content.
	 * @param  int		$timeout	The time before the content expire in the cache.
	 * @return string
	 */
	private function get_content_from_cache($key, $url, $timeout) {

		$cachedContent = $this->cache->get($key);

		if(is_null($cachedContent)) {
			$cachedContent = json_decode($this->content->get_from_wordpress($url), TRUE);
			$this->cache->set($key, $cachedContent, $timeout); 
		}

		return $cachedContent;
	}
}
