<table>
    <thead>
        <th>
            <?= ucfirst(lang('journals')) ?><span id="totalLabel"></span> <small>(total <?= $total_journals ?>)</small>
        </th>
        <th width="30%">
            <div class="downloadList">
                <span><?= lang('list_download') ?></span>
                <a href="<?= $base_url ?>&export=csv" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_cvs_tooltip') ?>" class="glyphBtn downloadCSV showTooltip"></a>
            </div>
        </th>
    </thead>
    <tbody>
        
        <?php if (empty($journals)) : ?>
            <tr>
                <td colspan="2">
                    <strong class="journalTitle">
                        <?= lang('no_journals_found_message') ?>
                    </strong>
                </td>
            </tr>
        <?php else : ?>
        <?php 
    $last_letter = '';
    foreach ($journals as $journal) :
        $last_letter_html = create_last_letter_html($last_letter, $journal->title_search);
    ?>
            <?= $last_letter_html ?>
            <tr>
                <td colspan="2">
                    <a href="<?= $journal->scielo_url ?>" <?php if ($journal->status == 'deceased') : ?>class="disabled"<?php endif; ?>>
                        <strong class="journalTitle">
                            <?= $journal->title ?>
                        </strong>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
