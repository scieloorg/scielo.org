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
 * Cache_util Class
 *
 * This controller clear the cache and redirect to the home. 
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Cache_util extends CI_Controller
{

	/**
	 * Update cache database. This function is only acessible by
	 * command line, to run this method execute:
	 * `php index.php cache_util update_database`
	 */
	public function update_database()
	{
		if (!defined("STDIN") && php_sapi_name() != "cli") {
			exit("Not allowed");
		}

		log_message("debug", "Running cache update tool, it may take some minutes, please wait.");

		try {
			$this->clean_database_cache();
			log_message("debug", "Update finished comfortably.");
		} catch (Exception $e) {
			log_message("error", "Something went wrong, please verify traceback.");
			log_message("error", var_dump($e));
		}

		exit(0);
	}

	/**
	 * Check if the database timeout is over, clear the cache and redirect to home.
	 * Note that if the timeout for the database clean up is over, it is necessary
	 * to make the requests and process the data to normalize it.
	 *
	 * Maps to the following URL
	 * 		http://your-website-url/cache_util/clean_cache
	 * 
	 * @return void
	 */
	public function clean_cache()
	{

		// Get the date of the last database cache clean BEFORE the clear.
		$last_clean_database_cache = $this->cache->get('last_clean_database_cache');

		$this->cache->clear();

		// If the date is null, so it is the first time getting all the database data.
		if (is_null($last_clean_database_cache) || empty($last_clean_database_cache)) {

			// $this->clean_database_cache();

		} else {

			$date1 = new DateTime($last_clean_database_cache);
			$date2 = new DateTime();

			$diff = $date2->diff($date1); // Get DateInterval Object

			// Verify if it pass than 30 days since the last processing.
			if ($diff->format('%d') > 30) {

				// $this->clean_database_cache();
			}

			// Keep the last_clean_database_cache date on the cache for future processing.
			$this->cache->set('last_clean_database_cache', $last_clean_database_cache, THIRTY_DAYS_TIMEOUT);
		}

		redirect(get_cookie('language'));
	}

	/**
	 * Export all data from the endpoint in the SQL format necessary to populate the tables.
	 * 1. Delete all data from the database using using the Codeigniter Database Library.
	 * 2. Get all the data from the endpoint and set it all in the cache.
	 * 3. Process the cached data and generate the SQL queries.
	 * 4. Execute the SQL queries against the database using the Codeigniter Database Library.
	 * 5. Set the datetime in the cache for future check before the cache is cleaned up.
	 *
	 * @return	void
	 */
	private function clean_database_cache()
	{

		$key = 'identifiers';
		$identifiers = $this->cache->get($key);

		if (is_null($identifiers) || empty($identifiers)) {

			$first_identifiers = json_decode($this->content->get_from(SCIELO_JOURNAL_IDENTIFIERS_URL), true);
			$second_identifiers = json_decode($this->content->get_from(SCIELO_JOURNAL_IDENTIFIERS_URL . "?offset=1000"), true);

			$identifiers = array();

			foreach ($first_identifiers['objects'] as $object) {
				$identifiers[] = $object;
			}

			foreach ($second_identifiers['objects'] as $object) {
				$identifiers[] = $object;
			}

			$this->cache->set($key, $identifiers, THIRTY_DAYS_TIMEOUT);
		}

		foreach ($identifiers as $key => $object) {

			$code = $object['code'];
			$collection = $object['collection'];

			$url = str_replace('{collection}', $collection, SCIELO_JOURNAL_COLLECTION_URL);
			$url = str_replace('{code}', $code, $url);

			$journal = $this->cache->get($code);

			if (is_null($journal) || empty($journal)) {
				$journal = json_decode($this->content->get_from($url), true);
				$this->cache->set($code, $journal, THIRTY_DAYS_TIMEOUT);
			}
		}

		$subject_areas_array = array();

		foreach ($identifiers as $key => $object) {

			$code = $object['code'];
			$journal = $this->cache->get($code);

			if (!empty($journal['subject_areas'])) {

				foreach ($journal['subject_areas'] as $subject_area) {
					$subject_areas_array[$subject_area] = true;
				}
			}
		}

		$subject_areas_sql_array = array();
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

			$subject_areas_sql_array[] = "INSERT INTO `subject_areas`(`id_subject_area`, `name_pt`, `name_en`, `name_es`) VALUES ({$id_subject_area}, {$values});";
			$id_subject_area++;
		}

		$journals_sql_array = array();

		foreach ($identifiers as $key => $object) {

			$code = $object['code'];
			$journal = $this->cache->get($code);
			$journals_sql_array[] = "INSERT INTO `journals`(`id_journal`, `acronym`, `publisher_city`, `publisher_name`, `publisher_country`, `institutional_url`, `status`, `scielo_url`, `title`, `title_search`) VALUES(" . ++$key . ", \"" . $journal['acronym'] . "\", \"" . str_replace("\"", "", $journal['publisher_city']) . "\", \"" . str_replace("\"", "", $journal['publisher_name'][0]) . "\", \"" . str_replace("\"", "", $journal['publisher_country'][1]) . "\", \"" . $journal['institutional_url'] . "\", \"" . $journal['status'] . "\", \"" . $journal['scielo_url'] . "\", \"" . str_replace("\"", "", $journal['title']) . "\", \"" . str_replace("\"", "", remove_accents($journal['title'])) . "\");";

			if (!empty($journal['subject_areas'])) {

				foreach ($journal['subject_areas'] as $subject_area) {

					switch ($subject_area) {

						case 'Health Sciences':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (1, {$key});";
							break;

						case 'Psicanalise':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (2, {$key});";
							break;

						case 'Human Sciences':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (3, {$key});";
							break;

						case 'Applied Social Sciences':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (4, {$key});";
							break;

						case 'Agricultural Sciences':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (5, {$key});";
							break;

						case 'Exact and Earth Sciences':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (6, {$key});";
							break;

						case 'Biological Sciences':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (7, {$key});";
							break;

						case 'Engineering':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (8, {$key});";
							break;

						case 'Linguistics, Letters and Arts':
							$journals_sql_array[] = "INSERT INTO `subject_areas_journals`(`id_subject_area`, `id_journal`) VALUES (9, {$key});";
							break;
					}
				}
			}
		}

		$this->cache->set('last_clean_database_cache', date('Y-m-d\TH:i:sO'), THIRTY_DAYS_TIMEOUT);

		// Start Transaction
		$this->db->query('BEGIN TRANSACTION;');

		// Delete 'subject_areas_journals' table data.
		$this->db->query('DELETE FROM subject_areas_journals;');
		// Delete 'subject_areas' table data.
		$this->db->query('DELETE FROM subject_areas;');
		// Delete 'journals' table data.
		$this->db->query('DELETE FROM journals;');

		// Run all the SQL queries in the arrays.
		foreach ($subject_areas_sql_array as $subject_areas_sql) {
			$this->db->query($subject_areas_sql);
		}

		foreach ($journals_sql_array as $journals_sql) {
			$this->db->query($journals_sql);
		}

		// Commit
		$this->db->query('COMMIT;');
	}
}
