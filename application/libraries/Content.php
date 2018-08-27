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

class Content {

   public function get_blog_content() {

        $url = SCIELO_BLOG_URL;
        $headers = array();
        $headers[] = 'Content-length: 0';
        $headers[] = 'Content-type: application/xml';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => $url
        ));
        $data = curl_exec($curl);

        if (curl_errno($curl) == "403") {
            die();
        }
        curl_close($curl);

        return $data;
    }

    public function get_from_wordpress($url) {

        $apiToken = $this->get_token();

        $headers = array();
        $headers[] = 'Content-length: 0';
        $headers[] = 'Content-type: application/json';
        $headers[] = 'Authorization: Bearer ' . $apiToken;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => $url
        ));
        $data = curl_exec($curl);

        if (curl_errno($curl) == "403") {
            die();
        }
        curl_close($curl);

        return $data;
    }

    private function get_token() {

        $url = WP_TOKEN_URL;
        $curl = curl_init();
        $headers = array();
        $body = "username=" . API_USR . "&password=" . API_PWD;
    
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_URL => $url
        ));
        $data = curl_exec($curl);
        $data = json_decode($data, true);
    
        if (!$data || !isset($data["token"])) {
            die();
        }
        curl_close($curl);
    
        return $data["token"];

    }
}