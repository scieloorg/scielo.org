<?php
/**
 * @author
 * SciELO - Scientific Electronic Library Online 
 * @link 
 * https://www.scielo.org/
 * @license
 * Copyright SciELO All Rights Reserved.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_static_asset')) {

    /**
	 * Utility function to return the path to the static asset.
	 *
	 * @param	string	$file	Filename
     * @param   string  $type   Define if it's css, js or image.
	 * @return	string
	 */
    function get_static_asset($file = NULL, $type)
    {
        if (!is_null($file) && $file !== '') {
            return STATIC_ASSETS_PATH.($type.$file);
        }

        return NULL;
    }
}

if (!function_exists('get_static_css_path')) {

    /**
	 * Return the complete filepath to the static css asset.
	 *
	 * @param	string	$file	Filename
     * @return	string
	 */
    function get_static_css_path($file = NULL)
    {
       return get_static_asset($file, 'css/');      
    }
}

if (!function_exists('get_static_js_path')) {

    /**
	 * Return the complete filepath to the static javascript asset.
	 *
	 * @param	string	$file	Filename
     * @return	string
	 */
    function get_static_js_path($file = NULL)
    {
       return get_static_asset($file, 'js/');     
    }
}

if (!function_exists('get_static_image_path')) {

    /**
	 * Return the complete filepath to the static image asset.
	 *
	 * @param	string	$file	Filename
     * @return	string
	 */
    function get_static_image_path($file = NULL)
    {
       return get_static_asset($file, 'images/');   
    }
}
