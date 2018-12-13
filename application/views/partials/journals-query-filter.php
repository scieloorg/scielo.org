<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<script>
  var status = '';
  
  $('#query_filter_all').on('change', function () {
    status = '';
    unset_letter_filter();
    query_filter();
  });

  $('#query_filter_current').on('change', function () {
    status = 'current';
    query_filter();	
  });

  $('#query_filter_deceased').on('change', function () {
    status = 'deceased';
    query_filter();
  });

  $("#letter_filter").on('change', function () {
    status = '';
    query_filter();
  });

  $('#search').on("keyup change",function() {
      
    clearTimeout(window.timer);

    window.timer = setTimeout(function() {  
      query_filter(); 
    },300);
  });
  
  $('#matching').on('change', function () {
    query_filter();
  });

  function untoggle_all_buttons() {
    var field = $('input[name="query_filter"]');
    field.parent().removeAttr('style');
    field.parent().removeClass('active');
    field.prop('checked', false);
  }

  function set_letter_filter(letter) {

    untoggle_all_buttons();
    var filter_label = $('#letter_filter_label');
    filter_label.removeClass('hidden');
    filter_label.addClass('active')

    $('#letter').val(letter);    
    $('#letter_filter').val(letter);
    $('#letter_span').html(letter);
    query_filter();
  }

  function unset_letter_filter() {

    var filter_label = $('#letter_filter_label');
    filter_label.removeClass('active');
    filter_label.addClass('hidden');
    filter_label.prev().attr('style', 'border-top-right-radius: 5px;  border-bottom-right-radius: 5px;');
    
    $('#letter').val(null);
    $('#letter_filter').val(null);
    $('#letter_span').html(null);
  }

  function query_filter() {

    var current_url = '<?= current_url() ?>';

    var replace_url_slug = function(url, slug) {
      if(url.includes(slug)) {
        return url.replace(slug, slug + '-ajax');
      }

      return url;
    };

    if($('#subject_area').length > 0) {

      current_url = replace_url_slug(current_url, 'listar-por-assunto');
      current_url = replace_url_slug(current_url, 'list-by-subject-area');
      current_url = replace_url_slug(current_url, 'listar-por-tema');
  
    } else {
      current_url += '-ajax';
    }

    var matching = $('#matching').val();
    var search = $('#search').val();
    var letter = $('#letter').val();
    var limit = $('#limit').val();
    var loading = $('.collectionListLoading');

    var add_parameter_to = function(param, name, value) {

      if(value !== '') {
        param += '&' + name + '=' + value; 
      }

      return param;
    };

    var param = '';
    param += add_parameter_to(param, 'matching', matching);
    param += add_parameter_to(param, 'search', search);
    param += add_parameter_to(param, 'letter', letter);
    param += add_parameter_to(param, 'status', status);
    param += add_parameter_to(param, 'limit', limit);

    $.ajax({
      url: current_url,
      type: 'GET',
      data: param,
      dataType: 'html',
      beforeSend: function () {
        loading.show();
      }
    }).done(function(data) {
      loading.hide();
      $('#journalsTable').html(data);

    }).error(function() {
      loading.hide();
      console.error('Error found on loading journal list');
    });
  }

  function get_document_height() {
    var body = document.body;
    var html = document.documentElement;

    return Math.max(
      body.scrollHeight, body.offsetHeight,
      html.clientHeight, html.scrollHeight, html.offsetHeight
    );
  }

  function get_scrollTop() {
    return (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
  }

  $(function(){ 
    $(window).scroll(function() {
      if (get_scrollTop() >= (get_document_height() - window.innerHeight)) {
        var new_limit = parseInt($('#limit').val()) + <?= SCIELO_JOURNAL_LIMIT ?>;
        $('#limit').val(new_limit);
        query_filter(); 
      }
    });
  });
</script>
