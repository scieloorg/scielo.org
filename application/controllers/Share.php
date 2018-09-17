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
 * Share Class
 *
 * This controller handles the functionalities for sharing the page via email. 
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Share extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load_translated_texts_by_language();
    }

    /**
     * Send a simple mail containing the current url and some data supplied in a form.
     * It's obligatory that the google reCAPTCHA request returns 'success':true to send the email.
     *
     * @return	void
     */
    public function send_url_by_email()
    {
        if ($this->input->is_ajax_request() && $this->input->method(true) == 'POST') {

            // First verify if google reCAPTCHA is correct.
            $g_recaptcha_response = $this->input->post('g-recaptcha-response');
            $g_recaptcha_post_data = array('secret' => GOOGLE_RECAPTCHA_SERVER_KEY, 'response' => $g_recaptcha_response, 'remoteip' => $this->input->ip_address());
            $g_recaptcha = json_decode($this->content->send_post_request_to(GOOGLE_RECAPTCHA_VERIFY_URL, $g_recaptcha_post_data), true);

            // More information on: https://developers.google.com/recaptcha/docs/verify#api-request
            if (!$g_recaptcha['success']) {
                return;
            }

            $share_url = $this->input->post('share_url');
            $your_email = $this->input->post('your_email');
            $recipients = $this->input->post('recipients');
            $subject = $this->input->post('subject');
            $comment = $this->input->post('comment');

            if (!$subject) {
                $subject = lang('share_email_subject');
            }

            $mail = get_phpmailer();

            $mail->setFrom('suporte.aplicacao@scielo.org', 'SciELO.org');
            $mail->AddReplyTo("suporte.aplicacao@scielo.org");

            if (strpos($recipients, ';') !== false) {

                $recipients = explode(';', $recipients);

                foreach ($recipients as $email) {
                    $mail->addAddress($email);
                }

            } else {

                $mail->addAddress($recipients);
            }

            $your_email = '<a href="mailto:' . $your_email . '">' . $your_email . '</a>';
            $share_url = '<a href="' . $share_url . '">' . $share_url . '</a>';

            $mail->Subject = $subject;
            $mail->Body = str_replace('share_url', $share_url, str_replace('your_email', $your_email, lang('share_email_body'))) . $comment;
            $mail->AltBody = strip_tags($mail->Body);

            $mail->send();
        }
    }

    /**
     * Load the lang file containing translated texts.
     * Note that it has less logic than the similar function in the Home controller.
     * 
     * @return void
     */
    private function load_translated_texts_by_language()
    {

        $language = get_cookie('language', true);

        switch ($language) {

            case SCIELO_LANG:
                $this->lang->load('scielo', 'portuguese-brazilian');
                break;

            case SCIELO_EN_LANG:
                $this->lang->load('scielo', 'english');
                break;

            case SCIELO_ES_LANG:
                $this->lang->load('scielo', 'spanish');
                break;
        }

    }
}
	