<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('templates/header'); ?>
<!-- ./header -->

<!-- alert -->
<?php $this->load->view('templates/alert'); ?>
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
		<h1 class="logo"></h1>
		<form name="searchForm" id="searchForm" action="https://search.scielo.org/" method="get">
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
				<a href="https://search.scielo.org/"><?= lang('search_link_text') ?></a>
			</div>
		</form>
	</section>
	<!-- ./capa -->

	<!-- tabs -->
	<?php $this->load->view('templates/tabs'); ?>
	<!-- ./tabs -->
	
</div>

<!-- footer -->
<?php $this->load->view('templates/footer'); ?>
<!-- ./footer -->
