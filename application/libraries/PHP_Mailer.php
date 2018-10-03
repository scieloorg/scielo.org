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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        require BASEPATH . '../PHPMailer-6.0.5/src/Exception.php';
        require BASEPATH . '../PHPMailer-6.0.5/src/PHPMailer.php';
        require BASEPATH . '../PHPMailer-6.0.5/src/SMTP.php';
    }

}
