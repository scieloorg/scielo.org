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

if (!function_exists('init_pagination')) {

    function init_pagination($config)
    {

        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';

        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['uri_segment'] = 5;
        $config['query_string_segment'] = 'offset';
        $config['page_query_string'] = true;

        $CI = &get_instance();

        $CI->pagination->initialize($config);
    }

}
