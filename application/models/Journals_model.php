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
 * Journals_model Class
 *
 * This class define a public api for running queries against the local database.
 *
 * @category	Models
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Journals_model extends CI_Model
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
     * @param   string $id_subject_area
     * @return	array
     */
    public function get_subject_area($id_subject_area)
    {

        $this->db->from($this->subject_areas_table);
        $this->db->where('id_subject_area', $id_subject_area);

        $subject_area = null;

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $subject_area = $result->row_array();
        }

        $result->free_result();

        return $subject_area;
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
        $result = $this->db->get();

        $list_subject_areas = array();

        if ($result->num_rows() > 0) {
            $list_subject_areas = $result->result_array();
        }

        $result->free_result();

        return $list_subject_areas;
    }

    /**
     * Returns the interval list of journals from the offset position, ordered by title from the table 'journals' using SQL.
     *
     * @param   int $limit
     * @param   int $offset
     * @param   string $status
     * @param   string $search
     * @return	array
     */
    public function list_all_journals($limit, $offset, $status = false, $search = false)
    {

        $this->db->from($this->journals_table);
        
        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title', $search);
        }

        $this->db->limit($limit, $offset);
        $this->db->order_by('title', 'ASC');

        $result = $this->db->get();

        $list_journals = array();

        if ($result->num_rows() > 0) {
            $list_journals = $result->result();
        }

        $result->free_result();

        return $list_journals;
    }

    /**
     * Returns the total of journals from the table 'journals' using SQL.
     *
     * @param   string $status
     * @param   string $search
     * @return	array
     */
    public function total_journals($status = false, $search = false)
    {

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title', $search);
        }

        return $this->db->count_all_results($this->journals_table);
    }

    /**
     * Returns the interval list of journals by subject area from the offset position, ordered by title from the table 'journals' using SQL.
     *
     * @param   int $limit
     * @param   int $offset
     * @param   string $status
     * @param   string $search
     * @return	array
     */
    public function list_all_journals_by_subject_area($id_subject_area, $limit, $offset, $status = false, $search = false)
    {

        $this->db->from($this->journals_table);
        $this->db->join($this->subject_areas_journals_table, $this->journals_table . '.id_journal=' . $this->subject_areas_journals_table . '.id_journal', 'left');
        $this->db->where('id_subject_area', $id_subject_area);        
       
        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title', $search);
        }

        $this->db->limit($limit, $offset);
        $this->db->order_by('title', 'ASC');

        $result = $this->db->get();

        $list_journals = array();

        if ($result->num_rows() > 0) {
            $list_journals = $result->result();
        }

        $result->free_result();

        return $list_journals;
    }

    /**
     * Returns the total of journals by subject area  from the table 'journals' using SQL.
     *
     * @param   string $status
     * @param   string $search
     * @return	array
     */
    public function total_journals_by_subject_area($id_subject_area, $status = false, $search = false)
    {

        $this->db->where('id_subject_area', $id_subject_area);
        
        if ($status) {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('title', $search);
        }

        $this->db->join($this->subject_areas_journals_table, $this->journals_table . '.id_journal=' . $this->subject_areas_journals_table . '.id_journal', 'left');
        
        return $this->db->count_all_results($this->journals_table);
    }
}
