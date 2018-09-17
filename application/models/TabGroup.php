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
 * TabGroup Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class TabGroup
{


    /**
     * List of all the data used in the tabs setup.
     *
     * @var	array
     */
    private $tabs_json = array();

    /**
     * List of all groups objects in the json array.
     *
     * @var	array
     */
    private $groups = array();

    /**
     * Codeigniter instance reference.
     *
     * @var	object
     */
    private $CI;

    /**
     * Just initialize the Codeigniter instance.
     *
     * @return	void
     */
    public function __construct()
    {

        $this->CI = &get_instance();
    }

    /**
     * Gets the tabs json array and call other setup methods.
     *
     * @param   array  $tabs_json The rest API service data converted in an array.
     * @return	void
     */
    public function initialize($tabs_json)
    {

        $this->tabs_json = $tabs_json;

        $this->set_groups();
    }

    /**
     * Returns the groups of tabs.
     *
     * @return	array
     */
    public function get_groups()
    {

        return $this->groups;
    }

    /**
     * Returns the list of all the tabs for the specific group.
     *
     * @return	array
     */
    public function get_tabs($group)
    {

        $tabs = array();

        $this->CI->load->model('Tab');

        foreach ($group as $key => $tabArray) {

            $tabContent = $this->get_tab_content($tabArray['tab_content_type'], $key, $tabArray['tab_html_content']);

            $tab = clone $this->CI->Tab;

            $tab->initialize($tabContent['ID'], $tabArray['tab_title'], $tabContent['content'], ($key == 0), $tabArray['tab_content_type'], $tabArray['linkExternalAddress'], $tabArray['linkExternalText']);

            $tabs[] = $tab;
        }

        return $tabs;
    }

    /**
     * Set the groups with the content of the json array.
     *
     * @return	void
     */
    private function set_groups()
    {

        foreach ($this->tabs_json['acf']['tab_group'] as $group) {
            $this->groups[] = $group['group'];
        }

    }

    /**
     * Return the content of the tab based on the content type.
     *
     * @param	int	    $tab_content_type	The content type of the tab is a number from 1 to 6.
     * @param   int     $key                The array iteration index to generate a tab HTML element ID.
     * @param   string  $tab_html_content   The html content of a tab that comes from the rest service API. 
     * @return	arrray
     */
    private function get_tab_content($tab_content_type, $key, $tab_html_content = null)
    {

        $tabContent = array();

        if (!is_null($tab_content_type) && $tab_content_type !== '' &&
            !is_null($key) && $key !== '') {

            switch ($tab_content_type) {
                case 1:
                    $tabContent['ID'] = 'tab-colecoes';
                    $tabContent['content'] = 'templates/collections';
                    break;

                case 2:
                    $tabContent['ID'] = 'tab-periodicos';
                    $tabContent['content'] = 'templates/journals';
                    break;

                case 3:
                    $tabContent['ID'] = 'tab-numeros';
                    $tabContent['content'] = 'templates/analytics';
                    break;

                case 4:
                    $tabContent['ID'] = 'tab-blog';
                    $tabContent['content'] = 'templates/blog';
                    break;

                case 5:
                    $tabContent['ID'] = 'tab-twitter';
                    $tabContent['content'] = 'templates/twitter';
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
