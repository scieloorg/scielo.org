<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('partials/header'); ?>
<!-- ./header -->

<!-- alert -->
<?php $this->load->view('partials/alert'); ?>
<!-- ./alert -->

<div class="container">

	<!-- capa -->
	<section class="cover">
		<div class="menu-lang">
			<ul>
				<li class="info">
					<a href="<?= $about_menu_item['link'] ?>"><?= $about_menu_item['text'] ?></a>
				</li>
				<?php foreach ($available_languages as $available_language) : ?>
				<li>
					<a href="<?= $available_language['link'] ?>"><?= $available_language['language'] ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<h1 class="logo">
			<span>Scientific Electronic Library Online</span>
		</h1>
		<form name="searchForm" id="searchForm" action="<?= SCIELO_SEARCH_URL ?>" method="get">
			<input type="hidden" name="lang" id="lang" value="<?= $language ?>">
			<input type="hidden" name="count" id="count" value="15">
			<input type="hidden" name="from" id="from" value="0">
			<input type="hidden" name="output" id="output" value="site">
			<input type="hidden" name="sort" id="sort" value="">
			<input type="hidden" name="format" id="format" value="summary">
			<input type="hidden" name="fb" id="fb" value="">
			<input type="hidden" name="page" id="page" value="1">

			<div class="search-box">
				<input type="text" name="q" placeholder="<?= lang('search_placeholder') ?>" autofocus>
				<a href="javascript:$('#searchForm').submit();" class="btn btn-default btn-input"></a>
				<a href="<?= SCIELO_ADVANCED_SEARCH_URL ?>"><?= lang('search_link_text') ?></a>
			</div>
		</form>
	</section>
	<!-- ./capa -->

	<!-- tabs -->
	<?php $this->load->view('partials/tabs'); ?>
	<!-- ./tabs -->
	
</div>

<!-- footer -->
<?php $this->load->view('partials/footer'); ?>
<!-- ./footer -->
