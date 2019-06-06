<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<footer class="">
    <div class="collectionSignature">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <span class="logo-svg-footer"></span>
                </div>
                <div class="col-xs-12 col-sm-10 col-md-8 adress-footer">
                    <?= $this->Footer->get_signature() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="partners">
        <?php foreach ($this->Footer->get_partners() as $partner) : ?>
            <a href="<?= $partner->get_link() ?>" target="_blank"><img src="<?= $partner->get_logo() ?>" alt="<?= $partner->get_name() ?>" title="<?= $partner->get_name() ?>"></a>
        <?php endforeach; ?>
    </div>
    <div class="container collectionLicense">
        <a href="<?= $about_menu_item['link'] ?>/<?= $oad_menu_item['link'] ?>" class="ico-oa">
            <?= $this->Footer->get_open_access_declaration() ?>
        </a>
    </div>
</footer>

<script src="<?= get_static_js_path('jquery-1.11.0.min.js') ?>" type="text/javascript"></script>
<script src="<?= get_static_js_path('bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?= get_static_js_path('slick.js') ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= get_static_js_path('scielo.js') ?>" type="text/javascript" charset="utf-8"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-604844-1"></script>
<script>
$(function(){

    scieloLib.Init();

    $('.showBlock').click(function(){
        var field = $(this);
        $(field.data('rel')).fadeIn();
        $(field.data('hide')).fadeOut();
    });

    isEmail = function (email) {
            
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(email);
    };

    isEmpty = function(str) {
        return (!str || 0 === str.length);
    }

    isBlank = function (str) {
        return (!str || /^\s*$/.test(str));
    };

    recaptcha_callback = function() {
        var value = $('#g-recaptcha-response').val();
        if(!isEmpty(value) && !isBlank(value) ) {
            $('#share_submit_btn_id').removeAttr('disabled');
        }
    };

    $('#share_submit_btn_id').click(function() {
       
        var your_email = $('#your_email');
        var recipients = $('#recipients');    
        var valid = true;
        var valid_recipients = true;
        
        if(!isEmail(your_email.val())) {
            your_email.parent().addClass('has-error');
            $('#your_email_error').html('<?= lang('your_email_invalid') ?>');
            valid = false;
        }    

        recipients.val().split(';').forEach(function(email) {
            if(isEmpty(email) || isBlank(email)) {
                recipients.parent().addClass('has-error');
                $('#recipients_error').html('<?= lang('to_email_invalid') ?>');
                valid = false;
            }
        });
       
        if(valid) {

            var params = $('#share_form_id').serialize();

            $.ajax({
			    url: '<?= base_url('share/send_url_by_email') ?>',
			    method: "POST",
			    data: params,
			    dataType: 'text',
                success: function(response) {
                    $('#share_modal_email').modal('hide');
                    $('#share_modal_confirm_id').modal('show');
                    $('#share_form_id').find("input[type=text], textarea").val(null);
                },
                error: function(response) { }
            });
        }
    });
});

window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-604844-1');
</script>
</body>
</html>
