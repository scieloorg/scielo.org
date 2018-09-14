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
 * This controller handles the functionalities for journals. 
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Journals extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
	 * Export all data from the endpoint in the SQL format necessary to populate the tables.
	 *
     * @return	void
	 */
    public function export_to_sql()
    {

        $key = 'identifiers';
        $identifiers = $this->cache->get($key);

        if (is_null($identifiers) || empty($identifiers)) {
            
            $first_identifiers = json_decode($this->content->get_from_wordpress(SCIELO_JOURNAL_IDENTIFIERS_URL), true);
            $second_identifiers = json_decode($this->content->get_from_wordpress(SCIELO_JOURNAL_IDENTIFIERS_URL . "?offset=1000"), true);
            
            $identifiers = array();

            foreach ($first_identifiers['objects'] as $object) {
                $identifiers[] = $object; 
            }

            foreach ($second_identifiers['objects'] as $object) {
                $identifiers[] = $object; 
            }

            $this->cache->set($key, $identifiers, ONE_DAY_TIMEOUT);
        }
       
        $subject_areas_array = array();

        foreach ($identifiers as $key => $object) {

            $code = $object['code'];
            $collection = $object['collection'];

            $url = str_replace('{collection}', $collection, SCIELO_JOURNAL_COLLECTION_URL);
            $url = str_replace('{code}', $code, $url);

            $journal = $this->cache->get($code);

            if (is_null($journal) || empty($journal)) {
                $journal = json_decode($this->content->get_from_wordpress($url), true);
                $this->cache->set($code, $journal, ONE_DAY_TIMEOUT);
            }

            print "INSERT INTO journals(`id_journal`, `acronym`, `publisher_city`, `publisher_name`, `publisher_country`, `institutional_url`, `status`, `scielo_url`, `title`) VALUES(" . ++$key . ", \"" . $journal['acronym'] . "\", \"" . str_replace("\"", "",$journal['publisher_city']) . "\", \"" . str_replace("\"", "",$journal['publisher_name'][0]) . "\", \"" . str_replace("\"", "",$journal['publisher_country'][1]) . "\", \"" . $journal['institutional_url'] . "\", \"" . $journal['status'] . "\", \"" . $journal['scielo_url'] . "\", \"" . str_replace("\"", "",$journal['title']) . "\");<br>";

            if (!empty($journal['subject_areas'])) {

                foreach ($journal['subject_areas'] as $subject_area) {
                    $subject_areas_array[$subject_area] = true;

                    switch ($subject_area) {

                        case 'Health Sciences':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (1, {$key});<br>";
                            break;

                        case 'Psicanalise':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (2, {$key});<br>";
                            break;

                        case 'Human Sciences':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (3, {$key});<br>";
                            break;

                        case 'Applied Social Sciences':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (4, {$key});<br>";
                            break;

                        case 'Agricultural Sciences':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (5, {$key});<br>";
                            break;

                        case 'Exact and Earth Sciences':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (6, {$key});<br>";
                            break;

                        case 'Biological Sciences':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (7, {$key});<br>";
                            break;

                        case 'Engineering':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (8, {$key});<br>";
                            break;

                        case 'Linguistics, Letters and Arts':
                            print "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (9, {$key});<br>";
                            break;
                    }
                }
            }
        }

        $id_subject_area = 1;
        foreach ($subject_areas_array as $key => $subject_area) {

            $values = '';

            switch ($key) {

                case 'Health Sciences':
                    $values = "'Ciências da Saúde','{$key}','Ciencias de la salud'";
                    break;

                case 'Psicanalise':
                    $values = "'{$key}','Psychoanalysis','Psicoanálisis'";
                    break;

                case 'Human Sciences':
                    $values = "'Ciências Humanas','{$key}','Ciencias Humanas'";
                    break;

                case 'Applied Social Sciences':
                    $values = "'Ciências Sociais Aplicadas','{$key}','Ciencias Sociales Aplicadas'";
                    break;

                case 'Agricultural Sciences':
                    $values = "'Ciências Agrárias','{$key}','Ciencias Agrarias'";
                    break;

                case 'Exact and Earth Sciences':
                    $values = "'Ciências Exatas e da Terra','{$key}','Ciencias Exactas y de la Tierra'";
                    break;

                case 'Biological Sciences':
                    $values = "'Ciências Biológicas','{$key}','Ciencias biologicas'";
                    break;

                case 'Engineering':
                    $values = "'Engenharias','{$key}','Ingeniería'";
                    break;

                case 'Linguistics, Letters and Arts':
                    $values = "'Lingüística, Letras e Artes','{$key}','Lingüística, Letras y Artes'";
                    break;
            }

            print "INSERT INTO `subject_areas`(`id_subject_area`, `name_pt`, `name_en`, `name_es`) VALUES ({$id_subject_area}, {$values});<br>";
            $id_subject_area++;
        }
    }
}
