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
 * Footer Class
 *
 * This class uses the json array from the rest API service to configure and setup all the varibles 
 * used to customize the template view. It has logic that is dependent of the json content.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Footer
{

    /**
     * List of all the data used in the footer setup.
     *
     * @var	array
     */
    private $footer_json = array();

    /**
     * Define the text of the signature in the footer.
     *
     * @var	string
     */
    private $signature;

    /**
     * List of all the partners used in the footer.
     *
     * @var	array
     */
    private $partners = array();

    /**
     * Define the text of the open access declaration in the footer.
     *
     * @var	string
     */
    private $open_access_declaration;

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
     * Gets the footer json array and call other setup methods.
     *
     * @param   array  $footer_json The rest API service data converted in an array.
     * @return	void
     */
    public function initialize($footer_json)
    {

        $this->footer_json = $footer_json['acf']['blocks'];

        $this->set_signature();

        $this->set_partners();

        $this->set_open_access_declaration();
    }

    /**
     * Returns the text of the signature in the footer.
     *
     * @return	string
     */
    public function get_signature()
    {

        return $this->signature;
    }

    /**
     * Returns the partners of footer.
     *
     * @return	array
     */
    public function get_partners()
    {

        return $this->partners;
    }

    /**
     * Returns the text of the open access declaration in the footer.
     *
     * @return	string
     */
    public function get_open_access_declaration()
    {

        return $this->open_access_declaration;
    }

    /**
     * Set the signature with the content of the json array.
     *
     * @return	void
     */
    private function set_signature()
    {

        foreach ($this->footer_json as $block) {
            if ($block['type'] == 1) {
                $this->signature = $block['content'];

                return;
            }
        }
    }

    /**
     * Set the partners with the content of the json array.
     *
     * @return	void
     */
    private function set_partners()
    {

        $this->CI->load->model('Partner');

        foreach ($this->footer_json as $block) {
            if ($block['type'] == 2) {
                foreach ($block['partners'] as $partnerArray) {

                    $partner = clone $this->CI->Partner;

                    $partner->initialize($partnerArray['link'], $partnerArray['logo'], $partnerArray['name']);

                    $this->partners[] = $partner;
                }

                return;
            }
        }
    }

    /**
     * Set the open_access_declaration with the content of the json array.
     *
     * @return	void
     */
    private function set_open_access_declaration()
    {
        foreach ($this->footer_json as $block) {
            if ($block['type'] == 3) {
                $this->open_access_declaration = $block['content'];

                return;
            }
        }
    }
}
