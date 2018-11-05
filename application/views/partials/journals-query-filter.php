<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<script>
  var current_url = '<?= current_url() ?>';
  var search = '<?= $this->input->get('search', true) ?>';	
  var letter = '<?= $this->input->get('letter', true) ?>';
  var limit = '<?= $this->input->get('limit', true) ?>';
    
  $('#query_filter_all').on('change', function () {
    query_filter(current_url, '', search, '', limit);
  });

  $('#query_filter_current').on('change', function () {
    query_filter(current_url, 'current', search, letter, limit);	
  });

  $('#query_filter_deceased').on('change', function () {
    query_filter(current_url, 'deceased', search, letter, limit);
  });

  $("#letter_filter").on('change', function () {
    query_filter(current_url, '', search, letter, limit);
  });

  $('#limit').on('change', function () {
    var status = '<?= $this->input->get('status', true) ?>';
    limit = $(this).val(); 
    query_filter(current_url, status, search, letter, limit);
  });

  function query_filter(current_url, status, search, letter, limit) {

    if(search !== '')
      search = '&search=' + search; 

    if(letter !== '')
      letter = '&letter=' + letter;   

    if(status !== '')
      status = '&status=' + status

    if(limit !== '')
        limit = '&limit=' + limit  

	  window.location = current_url + '?' + search + letter + status + limit;
  }
</script>
