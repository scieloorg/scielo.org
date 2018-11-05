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
 * Journals Class
 *
 * This class define a public api for running queries against the local database.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Journals extends CI_Model
{

    private $subject_areas_table = 'subject_areas';
    private $journals_table = 'journals';
    private $subject_areas_journals_table = 'subject_areas_journals';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the subject area by primary key from the table 'subject_areas' using SQL.
     *
     * @param   int $id_subject_area
     * @return	array
     */
    public function get_subject_area($id_subject_area)
    {

        $this->db->from($this->subject_areas_table);
        $this->db->where('id_subject_area', $id_subject_area);

        return $this->get_result_array();
    }

    /**
     * Returns the list of subject areas ordered by name from the table 'subject_areas' using SQL.
     *
     * @param   string $language
     * @return	array
     */
    public function list_all_subject_areas($language)
    {

        $this->db->from($this->subject_areas_table);
        $this->db->order_by('name_' . $language, 'ASC');

        return $this->get_results_array();
    }

    /**
     * Returns the interval list of journals from the offset position, ordered by title from the table 'journals' using SQL.
     *
     * @param   int $limit
     * @param   int $offset
     * @param   string $status
     * @param   string $search
     * @param   string $letter
     * @return	array
     */
    public function list_all_journals($limit, $offset, $status = false, $search = false, $letter = false)
    {

        $this->db->from($this->journals_table);

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title_search', remove_accents($search));
        }

        if ($letter) {
            $this->db->like('title_search', $letter, 'after');
        }

        $this->db->limit($limit, $offset);
        $this->db->group_by('title_search');
        $this->db->order_by('title_search', 'ASC');

        return $this->get_results_obj();
    }

    /**
     * Returns the total of journals from the table 'journals' using SQL.
     *
     * @param   string $status
     * @param   string $search
     * @param   string $letter
     * @return	int
     */
    public function total_journals($status = false, $search = false, $letter = false)
    {

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title_search', remove_accents($search));
        }

        if ($letter) {
            $this->db->like('title_search', $letter, 'after');
        }

        $this->db->group_by('title_search');

        return $this->db->count_all_results($this->journals_table);
    }

    /**
     * Returns the interval list of journals by subject area from the offset position, ordered by title from the table 'journals' using SQL.
     *
     * @param   int $id_subject_area
     * @param   int $limit
     * @param   int $offset
     * @param   string $status
     * @param   string $search
     * @param   string $letter
     * @return	array
     */
    public function list_all_journals_by_subject_area($id_subject_area, $limit, $offset, $status = false, $search = false, $letter = false)
    {

        $this->db->from($this->journals_table);
        $this->db->join($this->subject_areas_journals_table, $this->journals_table . '.id_journal=' . $this->subject_areas_journals_table . '.id_journal', 'left');
        $this->db->where('id_subject_area', $id_subject_area);

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title_search', remove_accents($search));
        }

        if ($letter) {
            $this->db->like('title_search', $letter, 'after');
        }

        $this->db->limit($limit, $offset);
        $this->db->group_by('title_search');
        $this->db->order_by('title_search', 'ASC');

        return $this->get_results_obj();
    }

    /**
     * Returns the total of journals by subject area  from the table 'journals' using SQL.
     *
     * @param   int $id_subject_area
     * @param   string $status
     * @param   string $search
     * @param   string $letter
     * @return	int
     */
    public function total_journals_by_subject_area($id_subject_area, $status = false, $search = false, $letter = false)
    {

        $this->db->where('id_subject_area', $id_subject_area);

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title_search', remove_accents($search));
        }

        if ($letter) {
            $this->db->like('title_search', $letter, 'after');
        }

        $this->db->join($this->subject_areas_journals_table, $this->journals_table . '.id_journal=' . $this->subject_areas_journals_table . '.id_journal', 'left');
        $this->db->group_by('title_search');

        return $this->db->count_all_results($this->journals_table);
    }

    /**
     * Returns the list of pubishers from the offset position, ordered by publisher name from the table 'journals' using SQL.
     *
     * @param   int $limit
     * @param   int $offset
     * @param   string $status
     * @param   string $search
     * @param   string $letter
     * @return	array
     */
    public function list_all_publishers($limit, $offset, $status = false, $search = false, $letter = false) {

        $this->db->select('trim(publisher_name) as publisher_name');
        $this->db->from($this->journals_table);

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('publisher_name', $search);
            $this->db->or_like('title_search', remove_accents($search));
        }

        if ($letter) {
            $this->db->like('publisher_name', $letter, 'after');
        }

        $this->db->limit($limit, $offset);
        $this->db->group_by('publisher_name');
        $this->db->order_by('trim(publisher_name)', 'ASC');

        return $this->get_results_obj();
    }

    /**
     * Returns the total of pubishers from the table 'journals' using SQL.
     *
     * @param   string $status
     * @param   string $search
     * @param   string $letter
     * @return	int
     */
    public function total_publishers($status = false, $search = false, $letter = false) {

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('publisher_name', $search);
            $this->db->or_like('title_search', remove_accents($search));
        }

        if ($letter) {
            $this->db->like('publisher_name', $letter, 'after');
        }

        $this->db->group_by('publisher_name');

        return $this->db->count_all_results($this->journals_table);
    }

    /**
     * Returns the list of journals by publisher name from the offset position, ordered by title from the table 'journals' using SQL.
     *
     * @param   string $publisher_name
     * @param   string $status
     * @return	array
     */
    public function list_all_journals_by_publisher($publisher_name, $status = false)
    {

        $this->db->from($this->journals_table);
        $this->db->where('publisher_name', $publisher_name);

        if ($status) {
            $this->db->where('status', $status);
        }

        $this->db->group_by('title_search');
        $this->db->order_by('title_search', 'ASC');

        return $this->get_results_obj();
    }

    /**
     * Utility function to support the Codeigniter database API.
     *
     * @return	array
     */
    private function get_result_array()
    {

        $result_obj = null;

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $result_obj = $result->row_array();
        }

        $result->free_result();

        return $result_obj;
    }

    /**
     * Utility function to support the Codeigniter database API.
     *
     * @return	array
     */
    private function get_results_array()
    {

        $result_list = array();

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $result_list = $result->result_array();
        }

        $result->free_result();

        return $result_list;
    }

    /**
     * Utility function to support the Codeigniter database API.
     *
     * @return	array
     */
    private function get_results_obj()
    {

        $result_list = array();

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $result_list = $result->result();
        }

        $result->free_result();

        return $result_list;
    }

}
