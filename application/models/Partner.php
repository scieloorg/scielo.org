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
 * Partner Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Partner
{

    /**
     * Define the link URL of the partner to be show in the HTML element.
     *
     * @var	string
     */
    private $link;

    /**
     * Define the logo image path of the partner to be show in the HTML element.
     *
     * @var	string
     */
    private $logo;

    /**
     * Define the link text of the partner to be show in the HTML element.
     *
     * @var	string
     */
    private $name;

    /**
     * Initialize.
     *
     * @param   string  $link
     * @param   string  $logo
     * @param   string  $name
     * @return	void
     */
    public function initialize($link, $logo, $name)
    {
        $this->link = $link;
        $this->logo = $logo;
        $this->name = $name;
    }

    /**
     * Returns the link URL.
     *
     * @return	string
     */
    public function get_link()
    {

        return $this->link;
    }

    /**
     * Returns the logo file path.
     *
     * @return	string
     */
    public function get_logo()
    {

        return $this->logo;
    }

    /**
     * Returns the the link text of the partner.
     *
     * @return	string
     */
    public function get_name()
    {

        return $this->name;
    }
}
