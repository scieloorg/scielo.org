<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('templates/header'); ?>
<!-- ./header -->

<header>
	<div class="container">
		<div class="menu-lang">
			<ul>
				<li class="info">
					<a href="<?= $about_menu_item['link'] ?>"><?= $about_menu_item['text'] ?></a>
				</li>
				<?php foreach ($available_languages as $language) : ?>
				<li>
					<a href="<?= $language['link'] ?>"><?= $language['language'] ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<h1 class="logo-interno">
			<a href="<?= base_url($this->input->cookie('language')) ?>"></a>
		</h1>
	</div>
</header>

<section>
	<div class="breadcrumb">
		<div class="container">
			<div class="row">
				<div class="breadcrumb-path">
					<ul>
						<?php foreach ($breadcrumbs as $breadcrumb) : ?>
						<li>
							<a href="<?= $breadcrumb['link'] ?>"><?= $breadcrumb['link_text'] ?></a>
                        </li>
						<?php endforeach; ?>
						<li>
							<?= $page['title']['rendered'] ?>
                        </li>
					</ul>
				</div>
			</div>
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-9">
					<h2 class="breadTitle"><?= $page['title']['rendered'] ?></h2>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-3">
					<!-- share -->
					<?php $this->load->view('templates/share'); ?>
					<!-- ./share -->
				</div>
			</div>
		</div>
	</div>
</section>

<section>
    <div class="container">

        <?php if (!empty($page['content']['rendered'])) : ?>
		<div class="row">
			<div class="col-xs-12">
				<?= $page['content']['rendered'] ?>
			</div>        
		</div>
		<?php endif; ?>

        <div class="list-ebook">
            <ul>
                <?php foreach ($page['acf']['books'] as $book) : ?>
                <li>
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?= $book['bookCover_' . $this->input->cookie('language')] ?>" alt="">
                        </div>
                        <div class="col-md-7">
                            <h3><?= $book['bookTitle'] ?></h3>
                            <div class="info-ebook">
                                <?= $book['bookData'] ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="download">
                                <ul>
                                    <li>
                                        <strong><?= $book_texts['download'] ?></strong>
                                    </li>
                                    <li class="ico-pdf">
                                        <a href="<?= $book['downloadPDF_' . $this->input->cookie('language')] ?>">
                                        <?= $book_texts['ebook_pdf'] ?>
                                        </a>
                                    </li>
                                    <li class="ico-epub">
                                        <a href="<?= $book['downloadEbook_' . $this->input->cookie('language')] ?>">
                                        <?= $book_texts['ebook_epub'] ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4><?= $book_texts['abstract'] ?></h4>
                            <?= $book['abstract'] ?>                            
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- footer -->
<?php $this->load->view('templates/footer'); ?>
<!-- ./footer -->
