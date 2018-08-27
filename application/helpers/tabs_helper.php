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

if (!function_exists('get_tab_content')) {

    /**
	 * Return the content of the tab based on the content type.
	 *
	 * @param	int	    $tab_content_type	The content type of the tab is a number from 1 to 6.
     * @param   int     $key                The array iteration index to generate a tab HTML element ID.
     * @param   string  $tab_html_content   The html content of a tab that comes from the rest service API. 
     * @return	arrray
	 */
    function get_tab_content($tab_content_type, $key, $tab_html_content = NULL)
    {

        $tabContent = array();

        if (!is_null($tab_content_type) && $tab_content_type !== '' &&
            !is_null($key) && $key !== '') {

            switch ($tab_content_type) {
                case 1:
                    $tabContent['ID'] = 'tab-colecoes';
                    $tabContent['content'] = 'temp_content/tab-content-collections';
                    break;

                case 2:
                    $tabContent['ID'] = 'tab-periodicos';
                    $tabContent['content'] = 'temp_content/tab-content-journals';
                    break;

                case 3:
                    $tabContent['ID'] = 'tab-numeros';
                    $tabContent['content'] = 'temp_content/tab-content-analytics';
                    break;

                case 4:
                    $tabContent['ID'] = 'tab-blog';
                    $tabContent['content'] = 'templates/blog';
                    break;

                case 5:
                    $tabContent['ID'] = 'tab-twitter';
                    $tabContent['content'] = 'temp_content/tab-content-twitter';
                    break;

                default:
                    $tabContent['ID'] = 'tab-' . $key;
                    $tabContent['content'] = $tab_html_content;                    
                    break;
            }
        }

        return $tabContent;
    }
}
