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
 * PHP_MAiler Class
 *
 * This class loads the PHPMailer library.
 *
 * @category	Libraries
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class PHP_Mailer
{

    public function __construct()
    {
        require_once(BASEPATH . "../phpmailer/PHPMailerAutoload.php");
    }

}
