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
 * Contact Class
 *
 * This controller is the endpoint to send any contact form content through the website. 
 * It communicates with the Service Rest API.
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Contact extends CI_Controller
{

    /**
     * Send a post request using the curl built-in PHP function.
     *
     * Maps to the following URL
     * 		http://your-website-url/contact/send
     * 
     * @return void
     */
    public function send()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $formID = $this->input->post('formID');
            $url = str_replace('formID', $formID, FORM_POST_REQUEST_API_PATH);

            $response = $this->content->send_post_request_to_wordpress($url, $_POST, TRUE);

            print_r($response);
        }
    }
}
