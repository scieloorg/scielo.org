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
 * PageMetadata Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class PageMetadata
{

    /**
     * List of all the data used in the footer setup.
     *
     * @var	array
     */
    private $json_array = array();

    /**
     * Define the text of <title> tag in the head.
     *
     * @var	string
     */
    private $pageTitle;

    /**
     * Define the text of <meta> description tag in the head.
     *
     * @var	string
     */
    private $pageDescription;

    /**
     * Gets the footer json array and call other setup methods.
     *
     * @param   array  $footer_json The rest API service data converted in an array.
     * @return	void
     */
    public function initialize($json_array)
    {

        $this->json_array = $json_array['acf'];

        $this->set_page_title();

        $this->set_page_description();
    }

    /**
     * Returns the text of <title> tag in the head.
     *
     * @return	string
     */
    public function get_page_title()
    {

        return $this->pageTitle;
    }

    /**
     * Returns the text of <meta> description tag in the head.
     *
     * @return	string
     */
    public function get_page_description()
    {

        return $this->pageDescription;
    }

    /**
     * Set the signature with the content of the json array.
     *
     * @return	void
     */
    private function set_page_title()
    {

        if (array_key_exists('pageTitle', $this->json_array)) {

            $this->pageTitle = $this->json_array['pageTitle'];
        }
    }

    /**
     * Set the partners with the content of the json array.
     *
     * @return	void
     */
    private function set_page_description()
    {
        if (array_key_exists('pageDescription', $this->json_array)) {

            $this->pageDescription = $this->json_array['pageDescription'];
        }
        
    }
}
