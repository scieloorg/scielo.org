<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
$lang_index = isset($language) ? $language : SCIELO_EN_LANG;
?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <dl>
            <dt><h3><?= lang('journals_list') ?></h3></dt>
            <?php foreach ($this->Collections->get_journals_list() as $key => $journal) : ?>
            <?php
            $has_journal_count = array_key_exists('current', $journal->journal_count);
            $has_document_count = !empty($journal->document_count);
            $flag_no_data_css = (!$has_journal_count && !$has_document_count) ? 'flag-no-data' : null;
            ?>
                 <dd class="flag-<?= $journal->code ?> <?= $flag_no_data_css ?>">
                    <a href="http://<?= $journal->domain ?>">
                        <h4><?= $journal->name[$lang_index] ?></h4>
                        <span><?php if ($has_journal_count) : ?><?= $journal->journal_count['current'] ?> <?= lang('journals') ?> •<?php endif; ?> <?php if ($has_document_count) : ?><?= $journal->document_count ?> <?= lang('articles') ?><?php endif; ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>

            <dt><h3><?= lang('development_list') ?></h3></dt>        
            <?php foreach ($this->Collections->get_development_list() as $key => $development) : ?>
            <?php
            $has_journal_count = array_key_exists('current', $development->journal_count);
            $has_document_count = !empty($development->document_count);
            $flag_no_data_css = (!$has_journal_count && !$has_document_count) ? 'flag-no-data' : null;
            ?>
                <dd class="flag-<?= $development->code ?> <?= $flag_no_data_css ?>">
                    <a href="http://<?= $development->domain ?>">
                        <h4><?= $development->name[$lang_index] ?></h4>
                        <span><?php if ($has_journal_count) : ?><?= $development->journal_count['current'] ?> <?= lang('journals') ?> •<?php endif; ?> <?php if ($has_document_count) : ?><?= $development->document_count ?> <?= lang('articles') ?><?php endif; ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>

            <dt><h3><?= lang('discontinued_list') ?></h3></dt>
            <?php foreach ($this->Collections->get_discontinued_list() as $key => $discontinued) : ?>
            <?php
            $has_journal_count = array_key_exists('deceased', $discontinued->journal_count);
            $has_document_count = !empty($discontinued->document_count);
            $scielo_books_no_data_css = (!$has_journal_count && !$has_document_count) ? 'scielo-books-no-data' : null;
            ?>
                <dd class="scielo-books <?= $scielo_books_no_data_css ?>">
                    <a href="http://<?= $discontinued->domain ?>">
                        <h4><?= $discontinued->name[$lang_index] ?></h4>
                        <span><?php if ($has_journal_count) : ?><?= $discontinued->journal_count['deceased'] ?> <?= lang('journals') ?> •<?php endif; ?> <?php if ($has_document_count) : ?><?= $discontinued->document_count ?> <?= lang('articles') ?><?php endif; ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>

            <dt><h3><?= lang('books') ?></h3></dt>
            <?php foreach ($this->Collections->get_books_list() as $key => $book) : ?>
                <dd class="scielo-books scielo-books-no-data">
                    <a href="http://<?= $book->domain ?>">
                        <h4><?= $book->name[$lang_index] ?></h4>
                    </a>
                </dd>
            <?php endforeach; ?> 

            <dt><h3><?= lang('others') ?></h3></dt>
            <?php foreach ($this->Collections->get_others_list() as $key => $other) : ?>
            <?php
            $has_journal_count = array_key_exists('current', $other->journal_count);
            $has_document_count = !empty($other->document_count);
            $scielo_books_no_data_css = (!$has_journal_count && !$has_document_count) ? 'scielo-books-no-data' : null;
            ?>
                <dd class="scielo-books <?= $scielo_books_no_data_css ?>">
                    <a href="http://<?= $other->domain ?>">
                        <h4><?= $other->name[$lang_index] ?></h4>
                        <span><?php if ($has_journal_count) : ?><?= $other->journal_count['current'] ?> <?= lang('journals') ?> •<?php endif; ?> <?php if ($has_document_count) : ?><?= $other->document_count ?> <?= lang('articles') ?><?php endif; ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>
        </dl>
    </div>
</div>
