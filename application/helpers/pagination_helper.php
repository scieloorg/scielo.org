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

if (!function_exists('init_pagination')) {

    /**
     * Initialize the codeigniter pagination library.
     *
     * @param    array    $config Part of the configs from the controller.
     * @return    void
     */
    function init_pagination($config)
    {

        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';

        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['uri_segment'] = 5;
        $config['query_string_segment'] = 'offset';
        $config['page_query_string'] = true;

        $CI = &get_instance();

        $CI->pagination->initialize($config);
    }

}

if (!function_exists('create_letter_filter')) {

    /**
     * Creates the button group with alphabet letters for filtering.
     *
     * @param   string    $url The url of each button link in the group.
     * @return  string
     */
    function create_letter_filter($url)
    {

        $html = '';
        // Uses the ascii table from the 65 (A) to 90 (Z) position.
        for ($i = 65; $i <= 90; $i++) {
            $letter = chr($i);

            $html .= '<button type="button" class="btn btn-sm btn-default ' . is_letter_selected($letter) . '" onclick="javascript:window.location=\'' . $url . '/?letter=' . $letter . '\'">' . $letter . '</button>';
        }

        return $html;
    }
}

if (!function_exists('is_letter_selected')) {

    /**
     * Verify and return the class for the active letter.
     *
     * @param   string  $letter  The letter to compare with the one (GET parameter).
     * @return  string
     */
    function is_letter_selected($letter)
    {

        $CI = &get_instance();

        if ($CI->input->get('letter') == $letter) {
            return "btn-primary";
        }
    }
}

if (!function_exists('create_last_letter_html')) {

    /**
     * Create a block of html with letter of the list itens in the table.
     *
     * @param   string  $last_letter  The last letter to compare with the current one.
     * @param   string  $text         The text to extract the first letter.
     * @return  string
     */
    function create_last_letter_html(&$last_letter, $text)
    {

        $current_letter = strtoupper(substr(trim($text), 0, 1));

        $html = '';

        if ($last_letter !== $current_letter) {
            $last_letter = $current_letter;

            $html = '<tr class="separator-by-letter">
                        <td colspan="2">
                            <strong id="letter-' . $last_letter . '">
                            ' . $last_letter . '
                            </strong>
                        </td>
                    </tr>';
        }

        return $html;
    }
}
