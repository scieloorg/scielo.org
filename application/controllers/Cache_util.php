<?php
/**
 * @license
 * Copyright SciELO - Scientific Electronic Library Online All Rights Reserved.
 * @author
 * SciELO https://www.scielo.org/
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Cache_util extends CI_Controller
{

    /**
	 * Clear Cache controller.
	 *
	 * Maps to the following URL
	 * 		http://your-website-url/cache_util/clean_cache
	 */
    public function clean_cache() {
        $this->cache->clear();
    }
}