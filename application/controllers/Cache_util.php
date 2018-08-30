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
 * Cache_util Class
 *
 * This controller clear the cache and redirect to the home. 
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Cache_util extends CI_Controller
{

	/**
	 * Clear the cache and redirect to home.
	 *
	 * Maps to the following URL
	 * 		http://your-website-url/cache_util/clean_cache
	 * 
	 * @return void
	 */
	public function clean_cache()
	{

		$this->cache->clear();

		redirect($this->input->cookie('language'));
	}
}
