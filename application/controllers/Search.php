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
 * Search Class
 *
 * This controller receives the user's search query, interprets and returns the results. 
 *
 * @category	Controllers
 * @author		SciELO - Scientific Electronic Library Online 
 * @link		https://www.scielo.org/
 */
class Search extends CI_Controller
{

    /**
	 * Test
	 * 
	 * @return void
	 */
    public function index(){

        echo "cheguei no controller Search: Meu parametro é: ";
        echo $this->uri->segment(3);
    }

     /**
     * Test 
     * 
     * @return void
     */
    public function query(){

        $url    = "http://scielohomolog.parati.ag/scielo-org-adm/wp-json/swp_api/search?s="; 
        $q      = htmlspecialchars($this->uri->segment(3));

        
        $json_url = $url.$q;
        //$json_url = "http://scielohomolog.parati.ag/scielo-org-adm/wp-json/wp/v2/pages?=search[scielo]";

        $dados["titulo"] = "Essa é a página de resultados da busca";
        $dados["conteudo"] = "Esse é o conteúdo. Daqui a pouco isso vai ser uma lista com os itens da busca";
        $dados["query"] = $q;
        $dados["idioma_atual"] = get_cookie('language', true);
        $dados["json"] = $this->doSearch($q, $json_url);

        $this->load->view("/pages/search_results", $dados);
        
    }

    public function doSearch($q, $json_url){
    
        $rtn = array();
        $q = strtolower($q);
      
        $json = file_get_contents($json_url);
        //$obj = json_decode($json);

        $searchResult = json_decode($json,true);

        $rtn = $searchResult;
        return $rtn;
    
    }

}
