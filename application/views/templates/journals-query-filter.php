<script>
  var current_url = '<?= current_url() ?>';
  var search = '<?= $this->input->get('search', true) ?>'; 	
    
  $('#query_filter_all').on('change', function () {
    query_filter(current_url, '', search);
  });

  $('#query_filter_current').on('change', function () {
    query_filter(current_url, 'current', search);	
  });

  $('#query_filter_deceased').on('change', function () {
    query_filter(current_url, 'deceased', search);
  })

  function query_filter(current_url, status, search) {

	if(search !== '')
		search = '&search=' + search; 

	if(status !== '')
		status = '&status=' + status

	window.location = current_url + '?' + search + status;
  }
</script>
