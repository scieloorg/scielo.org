<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('partials/header'); ?>
<!-- ./header -->

<!-- language-menu -->
<?php $this->load->view('partials/language-menu'); ?>
<!-- ./language-menu -->

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
					<?php $this->load->view('partials/share'); ?>
					<!-- ./share -->
				</div>
			</div>
		</div>
	</div>
</section>

<section>
    <div class="container">
        <div class="page-updated-at">
            <?php $date = new DateTime($page['date']);?>
            <?= "(" . lang('updated') . ": " . $date->format('d/m/Y') . ")" ?>
        </div>
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
                            <img src="<?= $book['bookCover_' . $language] ?>" alt="">
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
                                        <strong><?= lang('download') ?></strong>
                                    </li>
                                    <li class="ico-pdf">
                                        <a href="<?= $book['downloadPDF_' . $language] ?>">
                                        <?= lang('ebook_pdf') ?>
                                        </a>
                                    </li>
                                    <li class="ico-epub">
                                        <a href="<?= $book['downloadEbook_' . $language] ?>">
                                        <?= lang('ebook_epub') ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4><?= lang('abstract') ?></h4>
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
<?php $this->load->view('partials/footer'); ?>
<!-- ./footer -->
