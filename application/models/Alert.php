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
 * Alert Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Alert
{

    /**
	 * List of all the data used in the alert setup.
	 *
	 * @var	array
	 */
    private $alert_json = array();

    /**
	 * Flag indicating if the alert is to be show.
	 *
	 * @var	boolean
	 */
    private $show;

    /**
	 * Define the number of columns to know the size of them in the bootstrap grid and how many content is there.
	 *
	 * @var	string
	 */
    private $number_of_columns;

    /**
	 * Define the default size for mobile is 12 (i.e, 'xs' stands for extra small).
	 *
	 * @var	string
	 */
    private $column_size_desktop;

    /**
	 * Define the default size of the outter content column.
	 *
	 * @var	string
	 */
    private $outside_column_size_desktop;

    /**
	 * List of all the data used in the columns.
	 *
	 * @var	array
	 */
    private $column_content = array();

    /**
	 * Flag indicating if there exist a link on the rightmost side of the alert (i,e. the last column).
	 *
	 * @var	boolean
	 */
    private $show_link;

    /**
	 * The link's URL (href).
	 *
	 * @var	string
	 */
    private $link;

    /**
	 * The link's text.
	 *
	 * @var	string
	 */
    private $link_text;

    /**
	 * Gets the alert json array and call other setup methods.
	 *
     * @param   array  $alert_json The rest API service data converted in an array.
	 * @return	void
	 */
    public function initialize($alert_json)
    {
        $this->alert_json = $alert_json;

        $this->set_visibility();

        $this->set_content();

        $this->set_link();
    }

    /**
	 * Check if the alert is setup to be visible.
	 *
	 * @return	boolean
	 */
    public function is_visible() {

        return $this->show == TRUE;
	}
	
	/**
	 * Returns the size of the outside column (bootstrap grid size).
	 *
	 * @return	string
	 */
	public function get_outside_column_size_desktop() {

		return $this->outside_column_size_desktop;
	}

	/**
	 * Returns the number of columns to know the size of them in the bootstrap grid and how many content is there.
	 *
	 * @return	array
	 */
	public function get_number_of_columns() {

		return $this->number_of_columns;
	}

	/**
	 * Returns the default column size for desktop (mobile is always 12 and 'xs' stands for extra small).
	 *
	 * @return	string
	 */
	public function get_column_size_desktop() {

		return $this->column_size_desktop;
	}

	/**
	 * Returns the list of all the data used in the columns.
	 *
	 * @return	array
	 */
	public function get_column_content($key) {

		return $this->column_content[$key];
	}

	/**
	 * Return true if the flag indicating if there exist a link on the rightmost side of the alert (i,e. the last column) is true.
	 *
	 * @return	boolean
	 */
	public function is_link_visible() {

		return $this->show_link == TRUE;
	}

	/**
	 * Returns the link's URL (href).
	 *
	 * @return	string
	 */
	public function get_link() {

		return $this->link;
	}

	/**
	 * Returns the link's text.
	 *
	 * @return	string
	 */
	public function get_link_text() {

		return $this->link_text;
	}

    /**
	 * Verify in the member alert array if the index 'code' doesn't exist and if it's not 'rest_forbidden'.
	 *
	 * @return	boolean
	 */
    private function set_visibility()
    {
        $this->show = (!isset($this->alert_json['code']) || $this->alert_json['code'] != 'rest_forbidden');
    }

    /**
	 * Set the columns size and content using the array values and some conditinal code.
	 *
	 * @return	void
	 */
    private function set_content()
    {

        // First check if it is to proceed or not.
        if($this->is_visible()) {

            // Define firt the number of columns to know the size of them in the bootstrap grid and how many content is there.
			$this->number_of_columns = $this->alert_json['acf']['cols'];

			// The default size for mobile is 12 (i.e, 'xs' stands for extra small).
			$this->column_size_desktop = "col-xs-12 ";

			// Define the default size of the outter content column.
			$this->outside_column_size_desktop = "col-xs-12 col-sm-12 col-md-12";

			// Get the content of each column.
			for($i = 1; $i <= $this->number_of_columns; $i++) {
				$this->column_content['column'.$i] = $this->alert_json['acf']['column'.$i];
			}

			// Define the size of the grid for each column. Note that it's bootstrap dependent.
			switch($this->number_of_columns) {
				case 1: $this->column_size_desktop .= "col-sm-12 col-md-12"; break;
				case 2: $this->column_size_desktop .= "col-sm-6 col-md-6"; break;
				case 3: $this->column_size_desktop .= "col-sm-4 col-md-4"; break;
				case 4: $this->column_size_desktop .= "col-sm-3 col-md-3"; break;
			}

        }

    }

    /**
	 * Set the link's URL, text and if it will appear in the view, through is flag.
	 *
	 * @return	void
	 */
    private function set_link()
    {

        // First check if it is to proceed or not.
        if($this->is_visible()) {

            // Check if the link exists to be show as the last column on the alert.
            $this->show_link = ( isset($this->alert_json['acf']['link']) && isset($this->alert_json['acf']['linkText']) );
            
            if($this->show_link) {

                // Get the link's content and anchor.
				$this->link  = $this->alert_json['acf']['link'];
				$this->link_text  = $this->alert_json['acf']['linkText'];
				
				if($this->link){
					$this->outside_column_size_desktop = "col-xs-12 col-sm-11 col-md-9";
				}else{
					$this->outside_column_size_desktop = "col-xs-12 col-sm-12 col-md-12";
				}
				
            }
			
        }

    }
}
