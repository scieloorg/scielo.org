<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="share">
    <ul>
        <li>
            <span>
                <?= lang('share') ?>
            </span>
        </li>
        <li>
            <a href="javascript:window.print();" class="showTooltip" data-toggle="tooltip" data-placement="top" title="<?= lang('print') ?>">
                <span class="glyphBtn print"></span>
            </a>
        </li>
        <li>
            <a href="https://scielosp.org/journals/feed/" target="_blank" class="showTooltip" data-toggle="tooltip" data-placement="top" title="Atom">
                <span class="glyphBtn rssMini"></span>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="showTooltip" target="_blank" data-toggle="modal" data-target="#share_modal_email" title="<?= lang('send_by_email') ?>">
                <span class="glyphBtn sendMail"></span>
            </a>
        </li>
        <li>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank" class="showTooltip" data-toggle="tooltip" data-placement="top" data-toggle="tooltip" data-placement="auto" title="<?= lang('share_on_facebook') ?>">
                <span class="glyphBtn facebook"></span>
            </a>
        </li>
        <li>
            <a href="https://twitter.com/intent/tweet?text=<?= current_url() ?>" target="_blank" class="showTooltip" data-toggle="tooltip" data-placement="top" data-toggle="tooltip" data-placement="auto" title="<?= lang('share_on_twitter') ?>">
                <span class="glyphBtn twitter"></span>
            </a>
        </li>
        <li>
            <a href="" class="dropdown-toggle showTooltip" data-toggle="tooltip" data-placement="auto" title="<?= lang('other_social_networks') ?>">
                <span class="glyphBtn otherNetworks"></span>
            </a>
            <div class="menu-share">
                <ul>
                    <li class="dropdown-header"> <?= lang('other_social_networks') ?></li>
                    <li>
                        <a href="https://plus.google.com/share?url=<?= current_url() ?>" target="_blank" class="shareGooglePlus">
                            <span class="glyphBtn googlePlus"></span> Google+
                        </a>
                    </li>
                    <li>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?= current_url() ?>" target="_blank" class="shareLinkedIn">
                            <span class="glyphBtn linkedIn"></span> LinkedIn
                        </a>
                    </li>
                    <li>
                        <a href="http://www.reddit.com/submit?url=<?= current_url() ?>" target="_blank" class="shareReddit">
                            <span class="glyphBtn reddit"></span> Reddit
                        </a>
                    </li>
                    <li>
                        <a href="http://www.stumbleupon.com/submit?url=<?= current_url() ?>" target="_blank" class="shareStambleUpon">
                            <span class="glyphBtn stambleUpon"></span> StambleUpon
                        </a>
                    </li>
                    <li>
                        <a href="http://www.citeulike.org/posturl?url=<?= current_url() ?>" target="_blank" class="shareCiteULike">
                            <span class="glyphBtn citeULike"></span> CiteULike
                        </a>
                    </li>
                    <li>
                        <a href="http://www.mendeley.com/import/?url=<?= current_url() ?>" target="_blank" class="shareMendeley">
                            <span class="glyphBtn mendeley"></span> Mendeley
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>

<!-- share-modal -->
<div class="modal fade" id="share_modal_email" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">×</span> <span class="sr-only">Fechar</span> </button> 
            <h4 class="modal-title"><?= lang('share_page_email') ?></h4>
         </div>
         <form name="share_form_id" id="share_form_id" action="#" method="post" class="validate">
            <input id="share_url" name="share_url" required="" type="hidden" value="<?= current_url() ?>"> 

            <div class="modal-body">
				<div class="form-group">
					<label class="control-label"><?= lang('your_email') ?>*</label>
                    <input class="form-control valid" id="your_email" name="your_email" required="" type="text" value=""> 
                    <label class="control-label" id="your_email_error"></label>
				</div>
				<div class="form-group">
					<label class="control-label"><?= lang('to_email') ?>*</label>
					<input class="form-control valid multipleMail" id="recipients" name="recipients" required="" type="text" value="">
					<label class="control-label" id="recipients_error"></label> 
					<span class="text-muted"> <?= lang('to_email_help_text') ?> </span>
				</div>
				<div class="form-group">
					<div id="share_captcha_id">
						<div style="width: 304px; height: 78px;">
							<div class="g-recaptcha" data-sitekey="<?= GOOGLE_RECAPTCHA_SITE_KEY ?>" data-callback="recaptcha_callback"></div>
						</div>
					</div>
				</div>
				<div class="form-group extendForm">
					<a href="javascript:;" class="showBlock" id="showBlock" data-rel="#extraFields" data-hide="#showBlock">
						<?= lang('update_subject_and_comments') ?>
					</a> 
					<div id="extraFields" style="display: none;">
						<div class="form-group"> 
							<label><?= lang('email_subject') ?></label>
							<input class="form-control valid" id="subject" name="subject" type="text" value="">
						</div>
						<div class="form-group">
							<label><?= lang('email_comment') ?></label>
							<textarea class="form-control" id="comment" name="comment"></textarea>
						</div>
						<a href="javascript:;" class="showBlock" data-rel="#showBlock" data-hide="#extraFields">
							<?= lang('remove_subject_and_comments') ?>
						</a> 
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="button" value="<?= lang('send_email_button') ?>" class="btn btn-primary" id="share_submit_btn_id" disabled>
			</div>
		</form>
	</div>
	</div>
</div>
<!-- ./share-modal -->

<!-- share-modal-confirm -->
<div class="modal fade in" id="share_modal_confirm_id" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-sm"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button> 
                <h4 class="modal-title"><?= lang('message_title') ?></h4> 
            </div> 
            <div class="modal-body"> 
                <div class="midGlyph success"><?= lang('message_success') ?></div> 
            </div> 
        </div> 
    </div> 
</div>
<!-- ./share-modal-confirm -->
