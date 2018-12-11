<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<form action="<?=current_url()?>">
    <input type="hidden" name="limit" value="<?=$this->input->get('limit', true)?>">
    <input type="hidden" name="letter" value="<?=$this->input->get('letter', true)?>">
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-padding-right-min">
            <div class="input-group input-group-search">
                <input type="text" name="search" id="search" value="<?=$search?>" class="form-control collectionSearch" placeholder="<?=lang('search_journals_placeholder')?>" autofocus>
                <div class="input-group-btn">
                    <select name="matching" id="matching" class="form-control">
                        <option value="contains" <?php if ($this->input->get('matching', true) == 'contains'): ?>selected<?php endif;?>><?=lang('contains')?></option>
                        <option value="extact_title" <?php if ($this->input->get('matching', true) == 'extact_title'): ?>selected<?php endif;?>><?=lang('extact_title')?></option>
                        <option value="starts_with" <?php if ($this->input->get('matching', true) == 'starts_with'): ?>selected<?php endif;?>><?=lang('starts_with')?></option>
                    </select>
                </div><!-- /btn-group -->
            </div><!-- /input-group -->
        </div>
        <div class="col-xs-12 col-sm-2 col-padding-left-min">
            <button type="submit" class="btn btn-primary btn-search"><?= lang('search_btn') ?></button>
        </div>
    </div>

</form>
