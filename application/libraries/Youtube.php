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
 * Youtube Class
 *
 * This class uses the Google Cliente API library get content from youtube.
 *
 * @category	Libraries
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Youtube
{

    /**
     * Youtube constructor.
     */
    public function __construct()
    {
        // Include autoloader
        require BASEPATH . '../google-api-php-client-2.2.2/vendor/autoload.php';
    }

    /**
     * Return the youtube videos for the SciELO channel.
     * 
     * @return array
     */
    public function get_videos()
    {

        $client = $this->get_google_client();
        $google_service_youTube = new Google_Service_YouTube($client);

        if($client) {
            $channels = $google_service_youTube->channels->listChannels(
                'contentDetails',
                array('forUsername' => SCIELO_YOUTUBE_CHANNEL)
            );

            // Retrieve the first channel
            $playlistId = $channels->getItems()[0]->getContentDetails()->getRelatedPlaylists()->getUploads();

            $playlistItems = $google_service_youTube->playlistItems->listPlaylistItems(
                'snippet,contentDetails',
                array('maxResults' => 50, 'playlistId' => $playlistId)
            );

            $videoIds = array();
            foreach ($playlistItems->getItems() as $item) {
                $videoIds[] = $item->getContentDetails()->videoId;
            }

            $videos = $google_service_youTube->videos->listVideos(
                'snippet,contentDetails',
                array('id' => implode(',', $videoIds))
            );

            $youtube_videos = array();

            foreach ($videos->getItems() as $video) {
                $youtube_videos[] = array(
                    'id' => $video->getId(),
                    'title' => $video->getSnippet()->getTitle(),
                    'description' => $video->getSnippet()->getDescription(),
                    'thumbnail' => $video->getSnippet()->getThumbnails()->getHigh()->getUrl(),
                    'publishedAt' => $video->getSnippet()->getPublishedAt()
                );
            }
        } else {
            $youtube_videos = array();
        }

        return $youtube_videos;
    }

    /**
     * Return the google client object.
     * 
     * @return object
     */
    private function get_google_client()
    {

        $client = new Google_Client();
        $client->setApplicationName(GOOGLE_CLIENT_API_APPNAME);
        $client->setDeveloperKey(GOOGLE_CLIENT_API_KEY);
        $client->addScope(Google_Service_YouTube::YOUTUBE_FORCE_SSL);
        $client->setAccessType('offline');        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth

        return $client;
    }



}
