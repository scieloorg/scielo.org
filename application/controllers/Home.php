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
		$this->load_openaccessdeclaration_link(); // The open access link in footer section, so I load it here in the constructor.			
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
		$this->load_journals();
		$this->load_analytics();
		$this->load_blog_rss_feed();
		$this->load_twitter();
		$this->load_youtube_videos();
		$this->load_tabs();

		$this->load->view('home');
	}

	/**
	 * Manage all the route for pages, except home, for Home controller.
	 * Load pages using the slugs passed and the correct template according to the last page type.
	 * 
	 * @param  array	$page_slugs The url token identifier for the specifics pages.
	 * @return void
	 */
	public function page(...$page_slugs)
	{

		if (!isset($page_slugs) || count($page_slugs) == 0) {
			redirect('home/page_not_found');
		}

		// Iterate through the array getting each page by slug and mounting the breadcrumb
		$breadcrumb = array();
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

		// Create actual page links
		$this->create_available_page_links();
				
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
	 * List all journals by alphabetical order.
	 *
	 * @return	void
	 */
	public function list_journals_by_alphabetical_order()
	{

		$this->load_journals_page_metadata();

		$offset = $this->input->get('offset', true);

		if (!$offset) {
			$offset = 0;
		}

		$limit = $this->input->get('limit', true);

		if (!$limit) {
			$limit = SCIELO_JOURNAL_LIMIT;
		}

		$params = $this->get_journals_params();
		$export = $this->input->get('export', true);

		if ($export == 'csv') {

			// Export all journals.
			$journals = $this->Journals->list_all_journals(PHP_INT_MAX, 0, $params['status'], $params['matching'], $params['search'], $params['letter']);

			$this->load->vars('journals', $journals);
			$this->load->view('pages/journals-' . $export);

			return;
		}

		$journals = $this->Journals->list_all_journals($limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$total_journals = $this->Journals->total_journals($params['status'], $params['matching'], $params['search'], $params['letter']);

		$journals_links = $this->get_journals_links();
		$base_url = $journals_links[$this->language]['list-by-alphabetical-order'] . "/?limit={$limit}";
		$base_url = $this->add_params_to_base_url($base_url, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$base_url = $this->config_journals_pagination($base_url, $total_journals, $limit, $offset);

		$this->translate_journals_link('list-by-alphabetical-order', $limit, $params['status'], $params['matching'], $params['search'], $params['letter'], $offset);

		$this->load->vars($params);
		$this->load->vars('base_url', $base_url);
		$this->load->vars('limit', $limit);
		$this->load->vars('total_journals', $total_journals);
		$this->load->vars('journals', $journals);
		$this->load->view('pages/journals');
	}

	/**
	 * List all journals by alphabetical order printing the html template.
	 *
	 * @return	void
	 */
	public function list_journals_by_alphabetical_order_ajax()
	{

		$offset = 0;

		$limit = $this->input->get('limit', true);

		if (!$limit) {
			$limit = SCIELO_JOURNAL_LIMIT;
		}

		$params = $this->get_journals_params();

		$journals = $this->Journals->list_all_journals($limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$total_journals = $this->Journals->total_journals($params['status'], $params['matching'], $params['search'], $params['letter']);

		$journals_links = $this->get_journals_links();
		$base_url = $journals_links[$this->language]['list-by-alphabetical-order'] . "/?limit={$limit}";
		$base_url = $this->add_params_to_base_url($base_url, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$base_url = $this->config_journals_pagination($base_url, $total_journals, $limit, $offset);

		$html = $this->load->view('partials/journals-table.php', array('total_journals' => $total_journals, 'journals' => $journals, 'base_url' => $base_url), true);

		print $html;
	}

	/**
	 * List all journals publishers ordered by name.
	 *
	 * @return	void
	 */
	public function list_by_publishers()
	{
		$this->load_journals_page_metadata();

		$offset = $this->input->get('offset', true);

		if (!$offset) {
			$offset = 0;
		}

		$limit = $this->input->get('limit', true);

		if (!$limit) {
			$limit = SCIELO_JOURNAL_LIMIT;
		}

		$params = $this->get_journals_params();
		$export = $this->input->get('export', true);

		if ($export == 'csv') {

			// Export all journals.
			$journals = $this->Journals->list_all_journals(PHP_INT_MAX, 0, $params['status'], $params['matching'], $params['search'], $params['letter']);

			$this->load->vars('journals', $journals);
			$this->load->view('pages/journals-' . $export);

			return;
		}

		$publishers = $this->Journals->list_all_publishers($limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$total_publishers = $this->Journals->total_publishers($params['status'], $params['matching'], $params['search'], $params['letter']);

		$journals_links = $this->get_journals_links();
		$base_url = $journals_links[$this->language]['list-by-publishers'] . "/?limit={$limit}";
		$base_url = $this->add_params_to_base_url($base_url, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$base_url = $this->config_journals_pagination($base_url, $total_publishers, $limit, $offset);

		$this->translate_journals_link('list-by-publishers', $limit, $params['status'], $params['matching'], $params['search'], $params['letter'], $offset);

		$this->load->vars($params);
		$this->load->vars('base_url', $base_url);
		$this->load->vars('limit', $limit);
		$this->load->vars('publishers', $publishers);
		$this->load->view('pages/journals-by-publishers');
	}

	/**
	 * List all journals publishers ordered by name printing the html template.
	 *
	 * @return	void
	 */
	public function list_by_publishers_ajax()
	{

		$offset = 0;

		$limit = $this->input->get('limit', true);

		if (!$limit) {
			$limit = SCIELO_JOURNAL_LIMIT;
		}

		$params = $this->get_journals_params();

		$publishers = $this->Journals->list_all_publishers($limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$total_publishers = $this->Journals->total_publishers($params['status'], $params['matching'], $params['search'], $params['letter']);

		$journals_links = $this->get_journals_links();
		$base_url = $journals_links[$this->language]['list-by-publishers'] . "/?limit={$limit}";
		$base_url = $this->add_params_to_base_url($base_url, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$base_url = $this->config_journals_pagination($base_url, $total_publishers, $limit, $offset);

		$html = $this->load->view('partials/journals-by-publishers-table.php', array('total_publishers' => $total_publishers, 'publishers' => $publishers, 'base_url' => $base_url), true);

		print $html;
	}

	/**
	 * List all journals by subject area ordered by name.
	 *
	 * @return	void
	 */
	public function list_by_subject_area($id_subject_area = false, $subject_area = false)
	{

		$this->load_journals_page_metadata();

		$offset = $this->input->get('offset', true);

		if (!$offset) {
			$offset = 0;
		}

		$limit = $this->input->get('limit', true);

		if (!$limit) {
			$limit = SCIELO_JOURNAL_LIMIT;
		}

		$params = $this->get_journals_params();
		$export = $this->input->get('export', true);

		if ($export == 'csv') {

			// Export all journals.
			if ($id_subject_area) {
				$journals = $this->Journals->list_all_journals_by_subject_area($id_subject_area, PHP_INT_MAX, 0, $params['status'], $params['matching'], $params['search'], $params['letter']);
			} else {
				$journals = $this->Journals->list_all_journals(PHP_INT_MAX, 0, $params['status'], $params['matching'], $params['search'], $params['letter']);
			}

			$this->load->vars('journals', $journals);
			$this->load->view('pages/journals-' . $export);

			return;
		}

		if ($id_subject_area) {
			$journals = $this->Journals->list_all_journals_by_subject_area($id_subject_area, $limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
			$total_journals = $this->Journals->total_journals_by_subject_area($id_subject_area, $params['status'], $params['matching'], $params['search'], $params['letter']);
		} else {
			$journals = $this->Journals->list_all_journals($limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
			$total_journals = $this->Journals->total_journals($params['status'], $params['matching'], $params['search'], $params['letter']);
		}

		$journals_links = $this->get_journals_links();
		$base_url = $journals_links[$this->language]['list-by-subject-area'] . '/' . $id_subject_area . '/' . $subject_area . "/?limit={$limit}";
		$base_url = $this->add_params_to_base_url($base_url, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$base_url = $this->config_journals_pagination($base_url, $total_journals, $limit, $offset);

		$this->translate_journals_link('list-by-subject-area', $limit, $params['status'], $params['matching'], $params['search'], $params['letter'], $offset, $id_subject_area, $subject_area);

		$subject_area = $this->Journals->get_subject_area($id_subject_area);
		$subject_areas = $this->Journals->list_all_subject_areas($this->language);

		$this->load->vars($params);
		$this->load->vars('journals_links', $journals_links);
		$this->load->vars('subject_area', $subject_area);
		$this->load->vars('subject_areas', $subject_areas);
		$this->load->vars('base_url', $base_url);
		$this->load->vars('limit', $limit);
		$this->load->vars('total_journals', $total_journals);
		$this->load->vars('journals', $journals);
		$this->load->view('pages/journals');
	}

	/**
	 * List all journals by subject area ordered by name.
	 *
	 * @return	void
	 */
	public function list_by_subject_area_ajax($id_subject_area = false, $subject_area = false)
	{

		$offset = 0;

		$limit = $this->input->get('limit', true);

		if (!$limit) {
			$limit = SCIELO_JOURNAL_LIMIT;
		}

		$params = $this->get_journals_params();

		if ($id_subject_area) {
			$journals = $this->Journals->list_all_journals_by_subject_area($id_subject_area, $limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
			$total_journals = $this->Journals->total_journals_by_subject_area($id_subject_area, $params['status'], $params['matching'], $params['search'], $params['letter']);
		} else {
			$journals = $this->Journals->list_all_journals($limit, $offset, $params['status'], $params['matching'], $params['search'], $params['letter']);
			$total_journals = $this->Journals->total_journals($params['status'], $params['matching'], $params['search'], $params['letter']);
		}

		$journals_links = $this->get_journals_links();
		$base_url = $journals_links[$this->language]['list-by-subject-area'] . '/' . $id_subject_area . '/' . $subject_area . "/?limit={$limit}";
		$base_url = $this->add_params_to_base_url($base_url, $params['status'], $params['matching'], $params['search'], $params['letter']);
		$base_url = $this->config_journals_pagination($base_url, $total_journals, $limit, $offset);

		$html = $this->load->view('partials/journals-table.php', array('total_journals' => $total_journals, 'journals' => $journals, 'base_url' => $base_url), true);

		print $html;
	}

	/**
	 * The default handler for 404 error.
	 *
	 * @return void
	 */
	public function page_not_found()
	{

		// In the page not found the metadata comes from the tabs API return json data.
		$this->load_page_metadata('pageMetadataHome', TABS_EN_API_PATH, TABS_ES_API_PATH, TABS_API_PATH);

		$this->load->view('page_not_found');
	}

	/**
	 * Get the journals params returning an array.
	 *
	 * @return array
	 */
	private function get_journals_params()
	{

		$params = array();
		$params['status'] = $this->input->get('status', true);
		$params['matching'] = $this->input->get('matching', true);
		$params['search'] = $this->input->get('search', true);
		$params['letter'] = $this->input->get('letter', true);

		return $params;
	}

	/**
	 * Private method to add parameters to base url.
	 *
	 * @param  string 	$base_url
	 * @param  string 	$status
	 * @param  string   $matching 
	 * @param  string   $search
	 * @param  string   $letter
	 * @return string
	 */
	private function add_params_to_base_url($base_url, $status, $matching, $search, $letter)
	{

		if ($status) {
			$base_url .= '&status=' . $status;
		}

		if ($matching) {
			$base_url .= '&matching=' . $matching;
		}

		if ($search) {
			$base_url .= '&search=' . $search;
		}

		if ($letter) {
			$base_url .= '&letter=' . $letter;
		}

		return $base_url;
	}

	/**
	 * Private method to configure and initialize journals pages pagination.
	 *
	 * @param  string 	$base_url The base url for the pagination links.
	 * @param  string 	$total	  The total of records for the page count.
	 * @param  string   $limit 	  The total of itens per page.
	 * @param  string   $offset   The records start position.
	 * @return string
	 */
	private function config_journals_pagination($base_url, $total, $limit, $offset)
	{

		$config['base_url'] = $base_url;
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['first_link'] = lang('pagination_first_link');
		$config['last_link'] = lang('pagination_last_link');

		init_pagination($config);

		if ($offset) {
			$base_url .= '&offset=' . $offset;
		}

		return $base_url;
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
	 * Get the Open Access Page link and text for Home controller.
	 *
	 * @return void
	 */
	private function load_openaccessdeclaration_link()
	{

		// Load the about page content from the json array
		$oad = $this->get_content_from_cache('open-acess-link', FOUR_HOURS_TIMEOUT, OPENACCESS_EN_API_PATH, OPENACCESS_ES_API_PATH, OPENACCESS_API_PATH);

		$oad_url = explode('/', $oad['link']);

		$oad_url = $oad_url[count($oad_url) - 2];

		$oad_menu_item = array('link' => $oad_url, 'text' => $oad['title']['rendered']);
		$this->load->vars('oad_menu_item', $oad_menu_item);
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

		$this->Collections->initialize($collections, $this->language);
	}

	/**
	 * Load from the database the journals subject areas tab content to be shown in the tab template.
	 * Create the links for the journals based on the language selected.
	 * 
	 * @return void
	 */
	private function load_journals()
	{

		$subject_areas = $this->Journals->list_all_subject_areas($this->language);

		$this->load->vars('subject_areas', $subject_areas);
		$this->load->vars('journals_links', $this->get_journals_links());
	}

	/**
	 * Calculate and load the metrics for the analytics tab content to be shown in the tab template.
	 * 
	 * @return void
	 */
	private function load_analytics()
	{

		$total_collections = count($this->Collections->get_journals_list());
		$total_active_journals = $this->Journals->total_journals('current');

		$total_published_articles = 0;

		foreach ($this->Collections->get_others_list() as $other) {
			$total_published_articles += $other->document_count;
		}

		$this->load->vars('total_collections', $total_collections);
		$this->load->vars('total_active_journals', $total_active_journals);
		$this->load->vars('total_published_articles', $total_published_articles);
	}

	/**
	 * Load from cache and parse a XML to be shown in the template blog section.
	 * Note that this method does not use the 'get_from()' function because it loads the content from a RSS Feed.
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

		libxml_use_internal_errors(true);
		$blog_xml_var = simplexml_load_string($blog_posts, 'SimpleXMLElement', LIBXML_NOCDATA);
 		if($blog_xml_var === false)
			$blog_xml_var = array();
 		$this->load->vars('blog_posts', $blog_xml_var);

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
	 * Load the videos of the RedeSciELO youtube channel using google client API to be show in its respective template.
	 * 
	 * @return void
	 */
	private function load_youtube_videos()
	{
		$key = 'youtube_videos';
		$youtube_videos = $this->cache->get($key);

		if (is_null($youtube_videos)) {
			$youtube_videos = $this->youtube->get_videos();
			$this->cache->set($key, $youtube_videos, ONE_DAY_TIMEOUT);
		}

		$this->load->vars('youtube_videos', $youtube_videos);
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
			redirect('home/page_not_found');
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
			$cachedContent = json_decode($this->content->get_from($url), true);
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
		$languages_translated_files = array('scielo', 'pagination', 'db', 'email');
		$available_languages = array();

		switch ($this->language) {

			case SCIELO_LANG:
				setlocale(LC_ALL, 'pt_BR.UTF8');
				$this->lang->load($languages_translated_files, 'portuguese-brazilian');
				$available_languages[] = $english;
				$available_languages[] = $spanish;
				break;

			case SCIELO_EN_LANG:
				setlocale(LC_ALL, 'en_US.UTF8');
				$this->lang->load($languages_translated_files, 'english');
				$available_languages[] = $portuguese;
				$available_languages[] = $spanish;
				break;

			case SCIELO_ES_LANG:
				setlocale(LC_ALL, 'es_ES.UTF-8');
				$this->lang->load($languages_translated_files, 'spanish');
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

		$this->language = get_cookie('language', true);

		// Because the webite could be deploy in a server subfolder we remove the base_uri.
		$language_url = str_replace(BASE_URI, '', $_SERVER['REQUEST_URI']);
		$language_url = substr($language_url, 0, 2);
		
		// Verify if the language is set in the cookie.
		if (isset($this->language) && !empty($this->language)) {

			$this->set_language_if_in_URL($language_url, SCIELO_LANG);
			$this->set_language_if_in_URL($language_url, SCIELO_ES_LANG);
			$this->set_language_if_in_URL($language_url, SCIELO_EN_LANG);

		} else {

			// If the language is at the browser URL, it has a higher precedence than user location. 
			if (!$this->set_language_if_equal_to($language_url)) {

				// The language isn't in the browser URL, so we get the user location, if it's not one of the tree languages, set it to english (default). 
				$language_location = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

				if (!$this->set_language_if_equal_to($language_location)) {
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
	private function set_language_if_in_URL($language_url, $language)
	{

		if ($language_url == $language && $this->language != $language) {

			$this->set_language_cookie($language);
		}
	}

	/**
	 * Set language if it's equal to the parameter passed or return FALSE. 
	 * 
	 * @param  string	$language
	 * @return boolean
	 */
	private function set_language_if_equal_to($language)
	{

		switch ($language) {

			case SCIELO_LANG:
				$this->set_language_cookie(SCIELO_LANG);
				return true;

			case SCIELO_ES_LANG:
				$this->set_language_cookie(SCIELO_ES_LANG);
				return true;

			case SCIELO_EN_LANG:
				$this->set_language_cookie(SCIELO_EN_LANG);
				return true;
		}

		return false;
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

	/**
	 * Load the page metade and breadcrumb specific for journals URLs. 
	 * 
	 * @return void
	 */
	private function load_journals_page_metadata()
	{
		$pageMetadata = array('acf' => array('pageTitle' => ucfirst(lang('journals')) . ' | SciELO.org', 'pageDescription' => 'Biblioteca Virtual em Saúde'));
		$this->PageMetadata->initialize($pageMetadata);

		$breadcrumb = array();
		$breadcrumbs[] = array('link' => base_url($this->language . '/'), 'link_text' => 'Home');
		$this->load->vars('breadcrumbs', $breadcrumbs);
	}

	/**
	 * Returns the journals links for each language. 
	 * 
	 * @return array
	 */
	private function get_journals_links()
	{

		$journals_links = array();

		$list_by_alphabetical_order = 'list-by-alphabetical-order';
		$journals_links[SCIELO_LANG][$list_by_alphabetical_order] = base_url(SCIELO_LANG . '/periodicos/listar-por-ordem-alfabetica');
		$journals_links[SCIELO_EN_LANG][$list_by_alphabetical_order] = base_url(SCIELO_EN_LANG . '/journals/list-by-alphabetical-order');
		$journals_links[SCIELO_ES_LANG][$list_by_alphabetical_order] = base_url(SCIELO_ES_LANG . '/revistas/listar-por-orden-alfabetico');

		$list_by_publishers = 'list-by-publishers';
		$journals_links[SCIELO_LANG][$list_by_publishers] = base_url(SCIELO_LANG . '/periodicos/listar-por-publicador');
		$journals_links[SCIELO_EN_LANG][$list_by_publishers] = base_url(SCIELO_EN_LANG . '/journals/list-by-publishers');
		$journals_links[SCIELO_ES_LANG][$list_by_publishers] = base_url(SCIELO_ES_LANG . '/revistas/listar-por-el-publicador');

		$list_by_subject_area = 'list-by-subject-area';
		$journals_links[SCIELO_LANG][$list_by_subject_area] = base_url(SCIELO_LANG . '/periodicos/listar-por-assunto');
		$journals_links[SCIELO_EN_LANG][$list_by_subject_area] = base_url(SCIELO_EN_LANG . '/journals/list-by-subject-area');
		$journals_links[SCIELO_ES_LANG][$list_by_subject_area] = base_url(SCIELO_ES_LANG . '/revistas/listar-por-tema');

		return $journals_links;
	}

	/**
	 * Make requests to wordpress api and get the links for other languages using the actual page slug. 
	 * 
	 * @return void
	 */
	private function create_available_page_links()
	{

		$actual_slug = str_replace(base_url($this->language . '/'), "", current_url());

		$actual_slug = explode('/', $actual_slug);
		$actual_slug = $actual_slug[count($actual_slug) - 1];
		$actual_page = '';

		switch ($this->language) {

			case SCIELO_LANG:
				$actual_page = $this->put_content_in_cache("actual_page_pt{$actual_slug}", SLUG_API_PATH . $actual_slug, ONE_DAY_TIMEOUT);
				break;

			case SCIELO_ES_LANG:
				$actual_page = $this->put_content_in_cache("actual_page_es{$actual_slug}", SLUG_ES_API_PATH . $actual_slug, ONE_DAY_TIMEOUT);
				break;

			case SCIELO_EN_LANG:
				$actual_page = $this->put_content_in_cache("actual_page_en{$actual_slug}", SLUG_EN_API_PATH . $actual_slug, ONE_DAY_TIMEOUT);
				break;
		}

		$slug = $actual_page[0]['slug'];

		$page_pt = $this->put_content_in_cache("page_pt{$slug}", SLUG_API_PATH . $slug, ONE_DAY_TIMEOUT);
		$portuguese = array('link' => str_replace(WORDPRESS_URL, base_url(SCIELO_LANG . '/'), $page_pt[0]['link']), 'language' => 'Português');

		$page_en = $this->put_content_in_cache("page_en{$slug}", SLUG_CALLBACK_EN_API_PATH . $slug, ONE_DAY_TIMEOUT);
		$english = array('link' => str_replace(WORDPRESS_URL, base_url(), $page_en[0]['link']), 'language' => 'English');

		$page_es = $this->put_content_in_cache("page_es{$slug}", SLUG_CALLBACK_ES_API_PATH . $slug, ONE_DAY_TIMEOUT);
		$spanish = array('link' => str_replace(WORDPRESS_URL, base_url(), $page_es[0]['link']), 'language' => 'Español');

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
	 * Translate journals links to not lose the search context.
	 *
	 * @param   string $slug
	 * @param   string $limit
	 * @param   string $status
	 * @param   string $matching
	 * @param   string $search
	 * @param   string $letter
	 * @param   string $offset
	 * @return	void
	 */
	private function translate_journals_link($slug, $limit, $status, $matching, $search, $letter, $offset, $id_subject_area = null, $subject_area = null)
	{

		$journals_links = $this->get_journals_links();

		if ($id_subject_area && $subject_area) {

			$language_url_pt = $journals_links[SCIELO_LANG][$slug] . '/' . $id_subject_area . '/' . $subject_area . "/?limit={$limit}";
			$language_url_en = $journals_links[SCIELO_EN_LANG][$slug] . '/' . $id_subject_area . '/' . $subject_area . "/?limit={$limit}";
			$language_url_es = $journals_links[SCIELO_ES_LANG][$slug] . '/' . $id_subject_area . '/' . $subject_area . "/?limit={$limit}";

		} else {

			$language_url_pt = $journals_links[SCIELO_LANG][$slug] . "/?limit={$limit}";
			$language_url_en = $journals_links[SCIELO_EN_LANG][$slug] . "/?limit={$limit}";
			$language_url_es = $journals_links[SCIELO_ES_LANG][$slug] . "/?limit={$limit}";
		}

		if ($status) {

			$language_url_pt .= '&status=' . $status;
			$language_url_en .= '&status=' . $status;
			$language_url_es .= '&status=' . $status;
		}

		if ($matching) {

			$language_url_pt .= '&matching=' . $matching;
			$language_url_en .= '&matching=' . $matching;
			$language_url_es .= '&matching=' . $matching;
		}

		if ($search) {

			$language_url_pt .= '&search=' . $search;
			$language_url_en .= '&search=' . $search;
			$language_url_es .= '&search=' . $search;
		}

		if ($letter) {

			$language_url_pt .= '&letter=' . $letter;
			$language_url_en .= '&letter=' . $letter;
			$language_url_es .= '&letter=' . $letter;
		}

		if ($offset) {

			$language_url_pt .= '&offset=' . $offset;
			$language_url_en .= '&offset=' . $offset;
			$language_url_es .= '&offset=' . $offset;
		}

		$portuguese = array('link' => $language_url_pt, 'language' => 'Português');
		$english = array('link' => $language_url_en, 'language' => 'English');
		$spanish = array('link' => $language_url_es, 'language' => 'Español');

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
	 * Redirect legacy index page URL to the new one
	 */	
	public function redirect_legacy_index_url()
	{
		$lang = $this->input->get('lang', 'en');
		return redirect($lang . '/', 'location', 301);
	}


	/**
	 * Create internal search query
	 */
	public function search(){

		switch ($this->language) {

			case SCIELO_LANG:
				$paged_url  = WORDPRESS_API_PATH."/swp_api/search?posts_per_page=10&s="; 
				$url    	= WORDPRESS_API_PATH."/swp_api/search?nopaging=true&s="; 
				break;

			case SCIELO_EN_LANG:
				$paged_url  = WORDPRESS_API_PATH_EN."/swp_api/search?posts_per_page=10&s="; 
				$url    	= WORDPRESS_API_PATH_EN."/swp_api/search?nopaging=true&s="; 
				break;

			case SCIELO_ES_LANG:
				$paged_url  = WORDPRESS_API_PATH_ES."/swp_api/search?posts_per_page=10&s="; 
				$url    	= WORDPRESS_API_PATH_ES."/swp_api/search?nopaging=true&s="; 
				break;
		}

		// receive input value
        $q = $this->input->get('q');
        
        // Clear input content to avoid xss
        $q = htmlspecialchars(strip_tags($q));

        // Rides Json paged url and embodies to accept blank
        $paged_json_url = $paged_url.rawurlencode($q);

        // Rides Json url and emboda to accept blank
        $json_url = $url.rawurlencode($q);

        // If page number is posted, assign it in the query. $ this-> uri-> segment (3) represents page number
        if($this->uri->segment(3)){
        	$page_num = $this->uri->segment(3);
        	$paged_json_url = $paged_json_url."&page=".$page_num;
        }
        
        // Error status
        $data["error"] = 0;

        // Receive value sent by already formatted search field
        $data["query"] = $q;

        // Force status code test = 500
        // http_response_code(500);

        // Check http response code to avoid errors on front 
        $data["http-response-code"] = http_response_code();

        // If there are no errors
		if ($data["http-response-code"] == 200){

	        // Gets json from nonpaged search
	        $data["json"] = $this->doSearch($q, $json_url);

	        // gets json from paged search
	        $data["paged_json"] = $this->doSearch($q, $paged_json_url);
	                     	
	       
	        /* 
	        ##	Making pagination
	        */
	        $this->load->library('pagination');
	        
	        $scielo_url = ($this->language == SCIELO_LANG) ? base_url($this->language . '/') : base_url();
	        
	        // Displays total query results for pagination creation
	        if($data["json"]){
	        	$search_total_rows = count($data["json"]);
	    	}else{
	    		$search_total_rows = 0;
	    	}
	        // Url to assemble pagination results
	        $data["url"] = base_url()."home/search/"; 
	        

	        // Display number of pages in url and not number of records displayed
			$config['use_page_numbers'] = TRUE;

			// Keep field values sent via get when reloading page
			$config['reuse_query_string'] = TRUE;


			// commented because the route was not made for this url/pt	
			// $config['base_url'] = $scielo_url.'home/search/';
			$config['base_url'] = base_url().'home/search';
			
			
			$config['total_rows'] = $search_total_rows;
			$config['per_page'] = 10;

			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';

			$config['first_link'] = lang('pagination_first_link');
			$config['last_link'] = lang('pagination_last_link');

			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';

			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';

			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';


			// set page title
			$pageMetadata = array('acf' => array('pageTitle' => ucfirst(lang('search_btn')) . ' | SciELO.org'));
			$this->PageMetadata->initialize($pageMetadata);

			$this->pagination->initialize($config);
	
		}else{

			// Json request error
			$data["error"] = 1;
		}	

		$this->load->view("/pages/search_results", $data);
			
    }

	/**
	 * Internal search query 
	 */
    public function doSearch($q, $json_url){
    
        $rtn = array();
        $q = strtolower($q);
       	$json = file_get_contents($json_url);
        $searchResult = json_decode($json,true);
        $rtn = $searchResult;

        return $rtn;
           
    }
    
}
