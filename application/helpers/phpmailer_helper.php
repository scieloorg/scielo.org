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

if (!function_exists('get_phpmailer')) {

    /**
     * get_phpmailer
     *
     * Lets you instantiate a PHPMailer object
     *
     * @return	mail	phpmailer object
     */
    function get_phpmailer()
    {

        $mail = new PHPMailer\PHPMailer\PHPMailer;
        $mail->isSMTP();
        $mail->isHTML(true);

        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->SMTPAuth = SCIELO_SMTP_AUTH;  // enable SMTP authentication
        $mail->SMTPSecure = SMTP_SMTP_SECURE; // Use tls
        $mail->Host = SCIELO_SMTP_SERVER; // SMTP server
        $mail->Port = SCIELO_SMTP_PORT;  // set the SMTP port 
        $mail->Username = SCIELO_SMTP_USERNAME;  // username
        $mail->Password = SCIELO_SMTP_PASSWORD;            // password
        $mail->WordWrap = 50; // set word wrap
        $mail->CharSet = "UTF-8";

        return $mail;
    }
}
