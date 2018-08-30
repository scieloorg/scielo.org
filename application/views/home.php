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
				<?php foreach ($available_languages as $language) : ?>
				<li>
					<a href="<?= $language['link'] ?>"><?= $language['language'] ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<h1 class="logo"></h1>
		<div class="search-box">
			<input type="text" placeholder="Procure artigos...">
			<a href="" class="btn btn-default btn-input"></a>
			<a href="">Pesquisa avançada</a>
		</div>
	</section>

	<!-- tabs -->
	<?php $this->load->view('templates/tabs'); ?>
	<!-- ./tabs -->
	
</div>

<!-- footer -->
<?php $this->load->view('templates/footer'); ?>
<!-- ./footer -->
