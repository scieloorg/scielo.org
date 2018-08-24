<?php
/**
 * @license
 * Copyright SciELO - Scientific Electronic Library Online All Rights Reserved.
 * @author
 * SciELO https://www.scielo.org/
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
	 */
	public function index()
	{
		
		$posts = $this->get_content_from_cache('posts', WP_POSTS_URL, ONE_HOUR_TIMEOUT);
		$pages = $this->get_content_from_cache('pages', WP_PAGES_URL, ONE_HOUR_TIMEOUT);
		$categories = $this->get_content_from_cache('categories', WP_CATEGORIES_URL, ONE_HOUR_TIMEOUT);

		$this->load_alert();
		$this->load_tabs();
		$this->load_blog_rss_feed();
		$this->load_footer();

		$this->load->vars('posts', $posts);
		$this->load->vars('pages', $pages);
		$this->load->vars('categories', $categories);
		$this->load->view('home');
	}

	/**
	 * Load from cache and setup the alert to be shown in the template top section.
	 */
	private function load_alert() {

		$alert = $this->get_content_from_cache('alert', ALERT_API_PATH, FOUR_HOURS_TIMEOUT);

		// Verify if it is to show the alert or not.
		$show_alert = (!isset($alert['code']) || $alert['code'] != 'rest_forbidden');

		if($show_alert) {

			// Define firt the number of columns to know the size of them int the bootstrap grid and how many content is there.
			$alert_number_of_columns = $alert['acf']['cols'];

			// The default size for mobile is 12 (i.e, 'xs' stands for extra small).
			$alert_column_size_desktop = "col-xs-12 ";

			// Define the default size of the outter content column.
			$alert_outside_column_size_desktop = "col-xs-12 col-sm-12 col-md-12";

			$alert_column_content = array();

			// Get the content of each column.
			for($i = 1; $i <= $alert_number_of_columns; $i++) {
				$alert_column_content['column'.$i] = $alert['acf']['column'.$i];
			}

			// Define the size of the grid for each column. Note that it's bootstrap dependent.
			switch($alert_number_of_columns) {
				case 1: $alert_column_size_desktop .= "col-sm-12 col-md-12"; break;
				case 2: $alert_column_size_desktop .= "col-sm-6 col-md-6"; break;
				case 3: $alert_column_size_desktop .= "col-sm-4 col-md-4"; break;
				case 4: $alert_column_size_desktop .= "col-sm-3 col-md-3"; break;
			}

			$this->load->vars('alert_number_of_columns', $alert_number_of_columns);
			$this->load->vars('alert_column_size_desktop', $alert_column_size_desktop);
			$this->load->vars('alert_column_content', $alert_column_content);

			// Check if the link exists to be show as the last column on the alert.
			$show_alert_link = ( isset($alert['acf']['link']) && isset($alert['acf']['linkText']) );
			$this->load->vars('show_alert_link', $show_alert_link);
			
			if($show_alert_link) {

				// Get the link's content and anchor.
				$alert_link  = $alert['acf']['link'];
				$alert_link_text  = $alert['acf']['linkText'];
				$alert_outside_column_size_desktop = "col-xs-12 col-sm-11 col-md-9";

				$this->load->vars('alert_link', $alert_link);
				$this->load->vars('alert_link_text', $alert_link_text);
			}

			$this->load->vars('alert_outside_column_size_desktop', $alert_outside_column_size_desktop);
		}
		
		$this->load->vars('show_alert', $show_alert);
	}

	/**
	 * Load from cache and setup the tabs to be shown in the template tabs section.
	 */
	private function load_tabs() {

		$tabs = $this->get_content_from_cache('tabs', TABS_API_PATH, FOUR_HOURS_TIMEOUT);
		$tab_group = $tabs['acf']['tab_group'];

		// Each tab group is a section on the template (note that the section has a specific CSS class)
		// First group is the '<section class="collection">'
		// Second group is the '<section class="blog">'

		// print_r($tab_group);
	}

	/**
	 * Load from cache and setup the footer (signature and partners) to be shown in the template footer section.
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
	 * @param $key
	 * @param $url
	 * @param $timeout
	 * @return $cached content
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
