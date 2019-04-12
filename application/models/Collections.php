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
 * Collections Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Collections
{

    /**
     * List of all the data used in the collections setup.
     *
     * @var	array
     */
    private $collection_json = array();

    /**
     * List of all the data used in the collections development section.
     *
     * @var	array
     */
    private $development_list = array();

    /**
     * List of all the data used in the collections books section.
     *
     * @var	array
     */
    private $books_list = array();

    /**
     * List of all the data used in the others collections section.
     *
     * @var	array
     */
    private $others_list = array();

    /**
     * List of all the data used in the collections journals section.
     *
     * @var	array
     */
    private $journals_list = array();

    /**
     * List of all the data used in the collections discontinued section and journals subsection.
     *
     * @var	array
     */
    private $discontinued_journals_list = array();

    /**
     * List of all the data used in the collections discontinued section and others subsection.
     *
     * @var array
     */
    private $discontinued_others_list = array();

    /**
     * The user language selected.
     *
     * @var	string
     */
    private $language;

    /**
     * Gets the about json array and call other setup methods.
     *
     * @param   array  $collection_json The rest API service data converted in an array.
     * @return	void
     */
    public function initialize($collection_json, $language)
    {
        $this->collection_json = count($collection_json) > 0 ? $collection_json : array();

        $this->language = $language;

        $this->set_collection_lists();
    }

    /**
     * Gets the collections itens json array.
     *
     */
    public function get_collection_json()
    {
        return $this->collection_json;
    }

    /**
     * Returns the books list.
     *
     * @return	array
     */
    public function get_books_list()
    {

        return $this->books_list;
    }

    /**
     * Returns the journals list.
     *
     * @return	array
     */
    public function get_journals_list()
    {

        ksort($this->journals_list, SORT_LOCALE_STRING);

        return ($this->journals_list);
    }

    /**
     * Returns the development list.
     *
     * @return	array
     */
    public function get_development_list()
    {

        ksort($this->development_list, SORT_LOCALE_STRING);

        return ($this->development_list);
    }

    /**
     * Returns the others list.
     *
     * @return	array
     */
    public function get_others_list()
    {

        ksort($this->others_list, SORT_LOCALE_STRING);

        return ($this->others_list);
    }

    /**
     * Returns the discontinued journals list.
     *
     * @return	array
     */
    public function get_discontinued_journals_list()

    {
        ksort($this->discontinued_journals_list, SORT_LOCALE_STRING);

        return ($this->discontinued_journals_list);
    }

    /**
     * Returns the discontinued others list.
     *
     * @return  array
     */
    public function get_discontinued_others_list()
    {
        ksort($this->discontinued_others_list, SORT_LOCALE_STRING);

        return ($this->discontinued_others_list);

    }

    /**
     * Set the collections list in the respective array by type.
     * Note that in this case I did not created a class (just cast the array), 
     * because this data can change in the future (this data comes from and external service, not wordpress). 
     *
     * @return	void
     */
    private function set_collection_lists()
    {
        if(count($this->collection_json) > 0) {
            foreach ($this->collection_json as $collection) {

                if ($collection['type'] == 'journals') {

                    $index = $collection['name'][$this->language];

                    if ($collection['is_active']) {

                        switch ($collection['status']) {

                            case 'certified': // Section 'Coleções certificadas'  
                                $this->journals_list[$index] = (object)$collection;
                                break;

                            case 'diffusion': // Section 'Outras'
                                $this->others_list[$index] = (object)$collection;
                                break;

                            case 'development': // Section 'Coleção em desenvolvimento'
                                $this->development_list[$index] = (object)$collection;
                                break;
                        }

                    } else {
                        $this->discontinued_list[$index] = (object)$collection;
                    }

                } elseif ($collection['type'] == 'books') {
                    $this->books_list[] = (object)$collection;
                }
            }
        }
    }
}
