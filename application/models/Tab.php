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
 * Tab Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Tab
{

    /**
	 * Define the id property to be show in the HTML element..
	 *
	 * @var	string
	 */
    private $id;

    /**
	 * Define the title of the tab to be show in the HTML element.
	 *
	 * @var	string
	 */
    private $title;

    /**
	 * Define the file path of content of the ta.
	 *
	 * @var	string
	 */
    private $content;

    /**
	 * Define the flag indicating if the CSS class 'active' need to be set in the HTML.
	 *
	 * @var	boolean
	 */
    private $active;

    /**
	 * Define the number indicating the type of the conten.
	 *
	 * @var	int
	 */
    private $contentType;

    /**
	 * Initialize all the instance properties. Note that I 'should' use the constructor, but the model in Codeigniter is autoloaded.
	 *
     * @param   string  $id
     * @param   string  $title
     * @param   string  $content
     * @param   boolean $active 
     * @param   int     $contentType 
	 * @return	void
	 */
    public function initialize($id, $title, $content, $active, $contentType)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->active = $active;
        $this->contentType = $contentType;
    }

    /**
	 * Return the id property to be show in the HTML.
	 *
	 * @return	string
	 */
    public function get_id()
    {
        return $this->id;
    }

    /**
	 * Return the title of the tab.
	 *
	 * @return	string
	 */
    public function get_title()
    {
        return $this->title;
    }

    /**
	 * Return the file path of content of the tab.
	 *
	 * @return	string
	 */
    public function get_content()
    {
        return $this->content;
    }

    /**
	 * Return the content type of the tab. It's dependent of the json array data.
	 *
	 * @return	string
	 */
    public function get_content_type()
    {
        return $this->contentType;
    }

    /**
	 * Return true if the flag indicating if the CSS class 'active' need to be set in the HTML.
	 *
	 * @return	boolean
	 */
    public function is_active()
    {
        return $this->active == TRUE;
    }




}
