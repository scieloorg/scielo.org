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

    public function english()
    {
        $this->set_language_cookie(SCIELO_EN_LANG);

        $this->redirect_to_home();
    }

    public function spanish()
    {
        $this->set_language_cookie(SCIELO_ES_LANG);

        $this->redirect_to_home();
    }

    public function portuguese()
    {
        $this->set_language_cookie(SCIELO_LANG);

        $this->redirect_to_home();
    }

    private function set_language_cookie($value)
    {
        set_cookie('language', $value, ONE_DAY_TIMEOUT * 30);
    }

    private function redirect_to_home()
    {
        redirect('/');
    }
}
