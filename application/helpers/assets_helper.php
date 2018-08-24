<?php
/**
 * @license
 * Copyright SciELO - Scientific Electronic Library Online All Rights Reserved.
 * @author
 * SciELO https://www.scielo.org/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_static_asset')) {

    function get_static_asset($file = NULL, $type)
    {
        if (!is_null($file) && $file !== '') {
            return STATIC_ASSETS_PATH.($type.$file);
        }

        return NULL;
    }
}

if (!function_exists('get_static_css_path')) {

    function get_static_css_path($file = NULL)
    {
       return get_static_asset($file, 'css/');      
    }
}

if (!function_exists('get_static_js_path')) {

    function get_static_js_path($file = NULL)
    {
       return get_static_asset($file, 'js/');     
    }
}

if (!function_exists('get_static_image_path')) {

    function get_static_image_path($file = NULL)
    {
       return get_static_asset($file, 'images/');   
    }
}