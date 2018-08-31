<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
$lang_index = $this->input->cookie('language');
$lang_index = isset($lang_index) ? $lang_index : 'en';
?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <dl>
            <dt><h3><?= $collections_texts['books_list'] ?></h3></dt>
            <?php foreach ($this->Collections->get_books_list() as $key => $book) : ?>
                <dd class="scielo-books">
                    <a href="http://<?= $book->domain ?>">
                        <h4><?= $book->name[$lang_index] ?></h4>
                        <span><?= !is_null($book->document_count) ? $book->document_count : '0' ?> <?= $collections_texts['titles'] ?> • <?= $key ?> <?= $collections_texts['open_access'] ?></span>
                    </a>
                </dd>
            <?php endforeach; ?> 

            <dt><h3><?= $collections_texts['journals_list'] ?></h3></dt>
            <?php foreach ($this->Collections->get_journals_list() as $key => $journal) : ?>
                 <dd class="flag-<?= $journal->code ?>">
                    <a href="http://<?= $journal->domain ?>">
                        <h4><?= $journal->name[$lang_index] ?></h4>
                        <span><?= $journal->journal_count['current'] ?> <?= $collections_texts['journals'] ?> • <?= $journal->document_count ?> <?= $collections_texts['articles'] ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>

            <dt><h3><?= $collections_texts['development_list'] ?></h3></dt>        
            <?php foreach ($this->Collections->get_development_list() as $key => $development) : ?>
                <dd class="flag-<?= $development->code ?>">
                    <a href="http://<?= $development->domain ?>">
                        <h4><?= $development->name[$lang_index] ?></h4>
                        <span><?= !is_null($development->document_count) ? $development->document_count : '0' ?> <?= $collections_texts['titles'] ?> • <?= $key ?> <?= $collections_texts['open_access'] ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>

            <dt><h3><?= $collections_texts['discontinued_list'] ?></h3></dt>
            <?php foreach ($this->Collections->get_discontinued_list() as $key => $discontinued) : ?>
                <dd class="scielo-books">
                    <a href="http://<?= $discontinued->domain ?>">
                        <h4><?= $discontinued->name[$lang_index] ?></h4>
                        <span><?= !is_null($discontinued->document_count) ? $discontinued->document_count : '0' ?> <?= $collections_texts['titles'] ?> • <?= $key ?> <?= $collections_texts['open_access'] ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>

            <dt><h3><?= $collections_texts['scientific_list'] ?></h3></dt>
            <?php foreach ($this->Collections->get_scientific_list() as $key => $scientific) : ?>
                <dd class="scielo-books">
                    <a href="http://<?= $scientific->domain ?>">
                        <h4><?= $scientific->name[$lang_index] ?></h4>
                        <span><?= !is_null($scientific->document_count) ? $scientific->document_count : '0' ?> <?= $collections_texts['titles'] ?> • <?= $key ?> <?= $collections_texts['open_access'] ?></span>
                    </a>
                </dd>
            <?php endforeach; ?>
        </dl>
    </div>
</div>
