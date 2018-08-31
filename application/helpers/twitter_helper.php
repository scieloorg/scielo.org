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

if (!function_exists('utf8_substr_replace')) {

    /**
     * This is a replacement for subtr_replace which should work on UTF-8 Strings.
     *
     * @param	string	$original 
     * @param   string  $replacement
     * @param   string  $position
     * @param   string  $length
     * @return	string
     */
    function utf8_substr_replace($original, $replacement, $position, $length)
    {
        $startString = mb_substr($original, 0, $position, 'UTF-8');
        $endString = mb_substr($original, $position + $length, mb_strlen($original), 'UTF-8');

        $out = $startString . $replacement . $endString;

        return $out;
    }
}

if (!function_exists('json_tweet_text_to_HTML')) {

    /**
     * Converts a JSON tweet text to HTML.
     *
     * @param	string	$tweet 
     * @param   boolean  $links
     * @param   boolean  $users
     * @param   boolean  $hashtags
     * @return	string
     */
    function json_tweet_text_to_HTML($tweet, $links = true, $users = true, $hashtags = true)
    {
        $return = $tweet->full_text;

        $entities = array();

        if ($links && is_array($tweet->entities->urls)) {
            foreach ($tweet->entities->urls as $e) {
                $temp["start"] = $e->indices[0];
                $temp["end"] = $e->indices[1];
                $temp["replacement"] = "<a href='" . $e->expanded_url . "' target='_blank'>" . $e->display_url . "</a>";
                $entities[] = $temp;
            }
        }
        if ($users && is_array($tweet->entities->user_mentions)) {
            foreach ($tweet->entities->user_mentions as $e) {
                $temp["start"] = $e->indices[0];
                $temp["end"] = $e->indices[1];
                $temp["replacement"] = "<a href='https://twitter.com/" . $e->screen_name . "' target='_blank'>@" . $e->screen_name . "</a>";
                $entities[] = $temp;
            }
        }
        if ($hashtags && is_array($tweet->entities->hashtags)) {
            foreach ($tweet->entities->hashtags as $e) {
                $temp["start"] = $e->indices[0];
                $temp["end"] = $e->indices[1];
                $temp["replacement"] = "<a href='https://twitter.com/hashtag/" . $e->text . "?src=hash' target='_blank'>#" . $e->text . "</a>";
                $entities[] = $temp;
            }
        }

        usort($entities, function ($a, $b) {
            return ($b["start"] - $a["start"]);
        });


        foreach ($entities as $item) {
            $return = utf8_substr_replace($return, $item["replacement"], $item["start"], $item["end"] - $item["start"]);
        }

        return ($return);
    }
}

if (!function_exists('get_tweet_elapsed_time')) {

    /**
     * Calculate the tweet elapsed time based on the attribute created_at.
     *
     * @param	string	$created_at 
     * @return	string
     */
    function get_tweet_elapsed_time($created_at)
    {
        $date1 = new DateTime($created_at);
        $date2 = new DateTime();

        $diff = $date2->diff($date1); // Get DateInterval Object

        $tweetDays = $diff->format('%d');
        $tweetHours = $diff->format('%h');

        $tweetElapsedTime = 'Há ';
        if ($tweetDays > 0 && $tweetDays < 2) {
            $tweetElapsedTime .= $tweetDays . ' dia ';
        } elseif ($tweetDays > 0 && $tweetDays > 2) {
            $tweetElapsedTime .= $tweetDays . ' dias ';
        } elseif ($tweetHours > 0) {
            $tweetElapsedTime .= $tweetHours . ' horas ';
        }

        return $tweetElapsedTime;
    }
}
