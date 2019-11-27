<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load helper form
$this->load->helper('form');
?>

<?php echo form_open('home/search'); ?>
<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-8">
        <div class="internal-search-box">
            <div class="input-group">
                <input type="text" name="input-internal-search" id="input-internal-search" class="form-control" placeholder="<?= lang('internal_search_placeholder') ?>" value='<?php if (!empty($query)) echo $query; ?>'>
                <div class="input-group-btn">
                    <input type="submit" class="btn btn-primary" id="btn-internal-search" value="<?= lang('search_btn') ?>" alt="<?= lang('search_btn') ?>" title="<?= lang('search_btn') ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>