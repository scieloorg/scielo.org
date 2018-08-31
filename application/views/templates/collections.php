<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
$lang_index = $this->input->cookie('language');
$lang_index = isset($lang_index) ? $lang_index : 'en';
?>
<div class="row">
    <div class="col-sm-3 col-md-3">
        <dl>
            <dt><h3>Coleções de livros</h3></dt>
            <?php foreach ($this->Collections->get_books_list() as $key => $book) : ?>
                <dd class="scielo-books">
                    <a href="http://<?= $book->domain ?>">
                        <h4><?= $book->name[$lang_index] ?></h4>
                        <span><?= $key ?> títulos • <?= $key ?> em acesso aberto</span>
                    </a>
                </dd>
            <?php endforeach; ?> 
        </dl>
        <dl>
            <dt><h3>Coleções de periódicos</h3></dt>
            <?php foreach ($this->Collections->get_journals_list() as $key => $journal) : ?>
                 <dd class="flag-<?= $journal->code ?>">
                    <a href="http://<?= $journal->domain ?>">
                        <h4><?= $journal->name[$lang_index] ?></h4>
                        <span><?= $journal->journal_count['current'] ?> periódicos • <?= $journal->document_count ?> artigos</span>
                    </a>
                </dd>
            <?php endforeach; ?>

        </dl>
    </div>
    <div class="col-sm-3 col-md-3">
        <dl>
            <dt><h3>Em desenvolvimento</h3></dt>            
            <?php foreach ($this->Collections->get_development_list() as $key => $development) : ?>
                <dd class="flag-<?= $development->code ?>">
                    <a href="http://<?= $development->domain ?>">
                        <h4><?= $development->name[$lang_index] ?></h4>
                        <span><?= $key ?> títulos • <?= $key ?> em acesso aberto</span>
                    </a>
                </dd>
            <?php endforeach; ?>
        </dl>
        <dl>
            <dt><h3>Descontinuadas</h3></dt>
            <?php foreach ($this->Collections->get_discontinued_list() as $key => $discontinued) : ?>
                <dd class="scielo-books">
                    <a href="http://<?= $discontinued->domain ?>">
                        <h4><?= $discontinued->name[$lang_index] ?></h4>
                        <span><?= $key ?> títulos • <?= $key ?> em acesso aberto</span>
                    </a>
                </dd>
            <?php endforeach; ?>
        </dl>
    </div>
    <div class="col-sm-3 col-md-3">
        <dl>
            <dt><h3>Divulgação científica</h3></dt>
            <?php foreach ($this->Collections->get_scientific_list() as $key => $scientific) : ?>
                <dd class="scielo-books">
                    <a href="http://<?= $scientific->domain ?>">
                        <h4><?= $scientific->name[$lang_index] ?></h4>
                        <span><?= $key ?> títulos • <?= $key ?> em acesso aberto</span>
                    </a>
                </dd>
            <?php endforeach; ?>
        </dl>
    </div>
</div>
