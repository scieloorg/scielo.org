<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('templates/header'); ?>
<!-- ./header -->

<!-- language-menu -->
<?php $this->load->view('templates/language-menu'); ?>
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
					<?php $this->load->view('templates/share'); ?>
					<!-- ./share -->
				</div>
			</div>
		</div>
	</div>
</section>

<section class="collection collectionAbout">
	<div class="container">
		<?php if (!empty($page['content']['rendered'])) : ?>
		<div class="row">
			<div class="col-xs-12">
				<?= $page['content']['rendered'] ?>
			</div>        
		</div>
		<?php endif; ?>
		
		<!-- DYNAMIC MENU CONTENT -->
		<div class="list-menu">
			<ul>
			<?php foreach ($subpages as $subpage) : ?>
				<?php
					$link_text = $subpage['title']['rendered'];

					// Verify if the page is of the type 'pageModel-linkExternal.php' or 'pageModel-linkToDocument.php'
					if ($subpage['template'] == 'pageModel-linkExternal.php') {
						$link = $subpage['acf']['link_pt'];
					} else if ($subpage['template'] == 'pageModel-linkToDocument.php') {
						$link = $subpage['acf']['document_pt'];
					} else {
						// If the language is Portuguese it is necessary to concatenate the cookie language value. 
						$scielo_url = ($language == SCIELO_LANG) ? base_url($language . '/') : base_url();
						$link = str_replace(WORDPRESS_URL, $scielo_url, $subpage['link']);
					}
				?>
				<li>
					<a href="<?= $link ?>">
						<?= $link_text ?>
					</a>
				</li>
			<?php endforeach; ?>				
			</ul>
		</div>
		<!-- ./DYNAMIC MENU CONTENT -->
	</div>
</section>

<!-- footer -->
<?php $this->load->view('templates/footer'); ?>
<!-- ./footer -->
