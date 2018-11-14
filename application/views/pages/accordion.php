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
		<?php if (!empty($page['content']['rendered'])) : ?>
		<div class="row">
			<div class="col-xs-12">
				<?= $page['content']['rendered'] ?>
			</div>        
		</div>
		<?php endif; ?>

        <div class="sci-accordion">
            <?php foreach ($page['acf']['acordeons'] as $key => $acordeon) : ?>
            <div class="row row-accordion">
                <div class="col-xs-12">
                    <h3><a href="#accordion-<?= $key ?>" data-toggle="tab" class="btn btn-accordion"><?= $acordeon['title'] ?></a></h3>
                </div>
            </div>
            <div class="row row-accordion-content" id="accordion-<?= $key ?>">
                <div class="col-xs-12">
                    <?= $acordeon['content'] ?>
                </div>
            </div>
            <?php endforeach; ?>            
        </div>
    </div>
</section>

<!-- footer -->
<?php $this->load->view('partials/footer'); ?>
<!-- ./footer -->
