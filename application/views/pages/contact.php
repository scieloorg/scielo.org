<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('templates/header'); ?>
<!-- ./header -->

<header>
	<div class="container">
		<div class="menu-lang">
			<ul>
				<li class="info">
					<a href="<?= $about_menu_item['link'] ?>"><?= $about_menu_item['text'] ?></a>
				</li>
				<?php foreach ($available_languages as $language) : ?>
				<li>
					<a href="<?= $language['link'] ?>"><?= $language['language'] ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<h1 class="logo-interno">
			<a href="<?= base_url($this->input->cookie('language')) ?>"></a>
		</h1>
	</div>
</header>

<section>
	<div class="breadcrumb">
		<div class="container">
			<div class="row">
				<div class="breadcrumb-path">
					<ul>
						<?php foreach ($breadcrumbs as $breadcrumb) : ?>
						<li>
							<a href="<?= $breadcrumb['link'] ?>"><?= $breadcrumb['link_text'] ?></a>
                        </li>
						<?php endforeach; ?>
						<li>
							<?= $page['title']['rendered'] ?>
                        </li>
					</ul>
				</div>
			</div>
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-9">
					<h2 class="breadTitle"><?= $page['title']['rendered'] ?></h2>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-3">
					<!-- share -->
					<?php $this->load->view('templates/share'); ?>
					<!-- ./share -->
				</div>
			</div>
		</div>
	</div>
</section>

<section>
    <div class="container">

        <div class="col-xs-12 col-sm-6 col-sm-offset-3">

            <div role="form" class="wpcf7" id="wpcf7-f40-o1" lang="pt-BR" dir="ltr">
                <div class="screen-reader-response"></div>

				<div class="message-has-success hidden"></div>				
				<div class="alert alert-danger hidden"></div>

                <?= $page['content']['rendered'] ?>

            </div>
        </div>
    </div>
</section>

<!-- footer -->
<?php $this->load->view('templates/footer'); ?>
<!-- ./footer -->

<script>
$(function() {
	
	// Include the reCaptcha script if there is a div with class "wpcf7-recaptcha".
	if($('.wpcf7-recaptcha').length > 0) {
		var script = document.createElement('script');
		script.src = 'https://www.google.com/recaptcha/api.js';
		$('head').append(script);
	}

	// Remove form actual 'action' attribute and replace it because we register for the onsubmit event.
	$('form').attr('action', 'javascript:void(0);');

	$('form').on('submit', function() {

		// Avoid the user to submit the form a lot of time while the ajax request is doing its job.
		$('input[type="submit"]').attr('disabled', true);

		// Form ID attribute, it is necessary for the Rest API Service.
		var formID = $('input[name="_wpcf7"]').val();

		// Serialize the form and call via ajax the post service. 
		var params = '&formID=' + formID;

		var formItems = $('form').serializeArray();

		$(formItems).each(function(index, item) {

			// The body of the post should be all data in the form, except fields that begin with "__wpcf7"
			if(item.name.indexOf('_wpcf7') == -1) {
				params += '&' + item.name + '=' + item.value;
			}
		});
	
		$.ajax({
			url: '<?= base_url('contact/send') ?>',
			method: "POST",
			data: params,
			dataType: 'json',
			success: function(response) {
				
				// Enable the input button after the response return
				$('input[type="submit"]').removeAttr('disabled');

				if(response.status == 'mail_sent') {

					$('.message-has-success').html('<p>' + response.message + '</p>');
					$('.message-has-success').removeClass('hidden');

				} else if(response.status == 'validation_failed') {

					$('.alert-danger').html('<p>' + response.message + '</p>');
					$('.alert-danger').removeClass('hidden');

					$(response.invalidFields).each(function(index, field) {	
						
						var path = field.into.split('.');

						var element = path[0];
						var className = path[1];
						var fieldName = path[path.length - 1];
						var parent = $(element + '[class="' + className + ' '+ fieldName +'"]').parent();
						parent.addClass('validation-error');
						parent.append('<p class="validation-message">' + field.message + '</p>');
						
					});
				}
			}
		});
	});
});
</script>
