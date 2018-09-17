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
 * Language Class
 *
 * This controller handles the user choice of the language for the website. 
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Language extends CI_Controller
{

    /**
	 * Set default language cookie to english and redirect to the home page. 
	 * 
	 * @return void
	 */
    public function en()
    {
        $this->set_language_cookie(SCIELO_EN_LANG);

        $this->redirect_to_home(SCIELO_EN_LANG);
    }

    /**
	 * Set default language cookie to spanish and redirect to the home page. 
	 * 
	 * @return void
	 */
    public function es()
    {
        $this->set_language_cookie(SCIELO_ES_LANG);

        $this->redirect_to_home(SCIELO_ES_LANG);
    }

    /**
	 * Set default language cookie to portuguese and redirect to the home page. 
	 * 
	 * @return void
	 */
    public function pt()
    {
        $this->set_language_cookie(SCIELO_LANG);

        $this->redirect_to_home(SCIELO_LANG);
    }

    /**
	 * Set default language cookie. 
	 * 
     * @param  string $value 
	 * @return void
	 */
    private function set_language_cookie($value)
    {
        $this->input->set_cookie('language', $value, ONE_DAY_TIMEOUT * 30);
    }

    /**
	 * Redirect to the home page. 
	 * 
     * @param  string $lang 
	 * @return void
	 */
    private function redirect_to_home($lang)
    {
        redirect($lang);
    }
}
