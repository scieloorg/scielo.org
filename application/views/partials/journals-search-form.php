<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<form action="#" onsubmit="javascript:event.preventDefault();">
    <input type="hidden" name="limit" id="limit" value="<?=$limit?>">
    <input type="hidden" name="letter" id="letter" value="<?=$letter?>">

    <div class="input-group input-group-search">
        <input type="text" name="search" id="search" value="<?=$search?>" class="form-control collectionSearch" placeholder="<?=lang('search_journals_placeholder')?>" autofocus>
        <div class="input-group-btn">
            <select name="matching" id="matching" class="form-control">
                <option value="contains" <?php if ($matching == 'contains'): ?>selected<?php endif;?>><?=lang('contains')?></option>
                <option value="extact_title" <?php if ($matching == 'extact_title'): ?>selected<?php endif;?>><?=lang('extact_title')?></option>
                <option value="starts_with" <?php if ($matching == 'starts_with'): ?>selected<?php endif;?>><?=lang('starts_with')?></option>
            </select>
        </div><!-- /btn-group -->
    </div><!-- /input-group -->
    
</form>
