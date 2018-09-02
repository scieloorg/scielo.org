<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('templates/header'); ?>
<!-- ./header -->

<!-- language-menu -->
<?php $this->load->view('templates/language-menu'); ?>
<!-- ./language-menu -->

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
		var t = this;
		// Avoid the user to submit the form a lot of time while the ajax request is doing its job.
		$('input[type="submit"]').attr('disabled', true);

		// Form ID attribute, it is necessary for the Rest API Service.
		var formID = $('input[name="_wpcf7"]').val(),
			formAction = "<?= WORDPRESS_API_PATH.WORDPRESS_CONTACT_API_PATH; ?>",
			params = "",
			formItems = $('form').serializeArray();

		formAction = formAction.replace("{ID}",formID);

		$(formItems).each(function(index, item) {
			// The body of the post should be all data in the form, except fields that begin with "__wpcf7"
			if(item.name.indexOf('_wpcf7') == -1) {
				params += '&' + item.name + '=' + item.value;
			}
		});

		$.ajax({
			url: formAction,
			method: "POST",
			data: params,
			dataType: 'json',
			beforeSend: function() {
				$(".validation-error",t).each(function() {
					$(this).removeClass("validation-error");
					$(this).find(".validation-message").remove();
				});
				$('.alert-danger, .message-has-success').addClass('hidden');
			},
			success: function(response) {

				// Enable the input button after the response return
				$('input[type="submit"]').removeAttr('disabled');

				if(response.status == 'mail_sent') {

					$('.message-has-success').html('<p>' + response.message + '</p>');
					$('.message-has-success').removeClass('hidden');

					$("html,body").animate({
						scrollTop: $(".message-has-success").offset().top
					},200);
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

					$("html,body").animate({
						scrollTop: $(".alert-danger").offset().top
					},200);
				} else {
					$('.alert-danger').html('<p>' + response.message + '</p>');
					$('.alert-danger').removeClass('hidden');

					$("html,body").animate({
						scrollTop: $(".alert-danger").offset().top
					},200);
				}
			},
			error: function(response) {
				$('input[type="submit"]').removeAttr('disabled');
			}
		});
	});
});
</script>
