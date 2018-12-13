<div class="btn-group" data-toggle="buttons">
    <label class="btn <?php if (!$status && !$letter) : ?>active<?php endif; ?>">
        <input type="radio" autocomplete="off" name="query_filter" id="query_filter_all" value="all">
        <?= lang('all') ?>
    </label>
    <label class="btn <?php if ($status == 'current') : ?>active<?php endif; ?>">
        <input type="radio" autocomplete="off" name="query_filter" id="query_filter_current" value="current">
        <span class="lbl-corrente hidden-xs"><?= lang('active_journals') ?></span>
        <span class="lbl-corrente hidden-sm hidden-md hidden-lg"><?= lang('actives') ?></span>
    </label>
    <label class="btn <?php if ($status == 'deceased') : ?>active<?php endif; ?>" style="border-top-right-radius: 5px;  border-bottom-right-radius: 5px;">
        <input type="radio" autocomplete="off" name="query_filter" id="query_filter_deceased" value="deceased">
        <span class="lbl-nao-corrente hidden-xs"><?= lang('deceased_journals') ?></span>
        <span class="lbl-nao-corrente hidden-sm hidden-md hidden-lg"><?= lang('deceaseds') ?></span>
    </label>	
    <label class="btn <?php if ($letter) : ?>active<?php endif; ?> hidden" id="letter_filter_label">
        <input type="radio" autocomplete="off" name="letter_filter" id="letter_filter" value="<?= $letter ?>">
        <?= lang('letter') ?> <span id="letter_span"></span>
    </label>
</div>
