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

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Twitter Class
 *
 * This class uses the Twitter OAuth REST API library get content from twitter API.
 *
 * @category	Libraries
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Twitter
{

    private $connection;

    /**
     * Twitter constructor.
     */
    public function __construct()
    {
        
        // Include autoloader.
        require BASEPATH . '../twitteroauth/autoload.php';
 
        // Create a connection.
        $this->connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET);
    }

    /**
     * Return the opened connection object.
     * 
     * @return object
     */
    public function get_connection() 
    {
         return $this->connection;
    }
}
