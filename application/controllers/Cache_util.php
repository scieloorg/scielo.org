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

class Cache_util extends CI_Controller
{

    /**
	 * Clear Cache controller.
	 *
	 * Maps to the following URL
	 * 		http://your-website-url/cache_util/clean_cache
	 * 
	 * @return void
	 */
    public function clean_cache() {
        $this->cache->clear();
    }
}