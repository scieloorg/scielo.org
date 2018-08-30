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
 * About Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class About
{

    /**
     * List of all the data used in the about setup.
     *
     * @var	array
     */
    private $about_json = array();

    /**
     * Define the h1 title of the about page.
     *
     * @var	string
     */
    private $title;

    /**
     * Define the html content of the about page.
     *
     * @var	string
     */
    private $content;

    /**
     * Gets the about json array and call other setup methods.
     *
     * @param   array  $about_json The rest API service data converted in an array.
     * @return	void
     */
    public function initialize($about_json)
    {
        $this->about_json = $about_json;

        $this->set_title();

        $this->set_content();
    }

    /**
     * Returns the h1 title text of the about page.
     *
     * @return	string
     */
    public function get_title()
    {

        return $this->title;
    }

    /**
     * Returns the the html content html of the about page.
     *
     * @return	string
     */
    public function get_content()
    {
        return $this->content;
    }

    /**
     * Set the h1 title of the about page using the array values and some conditinal code.
     *
     * @return	void
     */
    private function set_title()
    {
        if (array_key_exists('title', $this->about_json)) {

            $this->title = $this->about_json['title']['rendered'];
        }
    }

    /**
     * Set the html content of the about page using the array values and some conditinal code.
     *
     * @return	void
     */
    private function set_content()
    {
        if (array_key_exists('content', $this->about_json)) {

            $this->content = $this->about_json['content']['rendered'];
        }
    }
}
