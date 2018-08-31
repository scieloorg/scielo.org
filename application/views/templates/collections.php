<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-sm-3 col-md-3">
        <dl>
            <dt><h3>Coleções de livros</h3></dt>
            <?php foreach ($this->Collections->get_books_list() as $key => $book) : ?>
                <dd class="scielo-books">
                    <a href="<?= $book->domain ?>">
                        <h4><?= $book->name[$this->input->cookie('language')] ?></h4>
                        <span><?= $key ?> títulos • <?= $key ?> em acesso aberto</span>
                    </a>
                </dd>
            <?php endforeach; ?> 
        </dl>
        <dl>
            <dt><h3>Coleções de periódicos</h3></dt>
            <?php foreach ($this->Collections->get_journals_list() as $key => $journal) : ?>
                 <dd class="flag-<?= $journal->code ?>">
                    <a href="<?= $journal->domain ?>">
                        <h4><?= $journal->name[$this->input->cookie('language')] ?></h4>
                        <span><?= $key ?> periódicos • <?= $key ?> artigos</span>
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
                    <a href="<?= $development->domain ?>">
                        <h4><?= $development->name[$this->input->cookie('language')] ?></h4>
                        <span><?= $key ?> títulos • <?= $key ?> em acesso aberto</span>
                    </a>
                </dd>
            <?php endforeach; ?>
        </dl>
        <dl>
            <dt><h3>Descontinuadas</h3></dt>
            <?php foreach ($this->Collections->get_discontinued_list() as $key => $discontinued) : ?>
                <dd class="scielo-books">
                    <a href="<?= $discontinued->domain ?>">
                        <h4><?= $discontinued->name[$this->input->cookie('language')] ?></h4>
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
                    <a href="<?= $scientific->domain ?>">
                        <h4><?= $scientific->name[$this->input->cookie('language')] ?></h4>
                        <span><?= $key ?> títulos • <?= $key ?> em acesso aberto</span>
                    </a>
                </dd>
            <?php endforeach; ?>
        </dl>
    </div>
</div>
