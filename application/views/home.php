<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>SciELO - Scientific Electronic Library Online</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />

	<!-- css bootstrap -->
	<link href="<?= get_static_css_path('bootstrap.css')?> " rel="stylesheet" type="text/css" media="screen" />

	<!-- css scielo.org novo -->
	<link href="<?= get_static_css_path('slick.css') ?>" rel="stylesheet">
	<link href="<?= get_static_css_path('slick-theme.css') ?>" rel="stylesheet">

	<!-- css scielo.org novo -->
	<link href="<?= get_static_css_path('style.css') ?>" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
	<meta name="description" content="Biblioteca Virtual em Saúde"/>
</head>
<body>

	<!-- alert -->
	<?php $this->load->view('templates/alert'); ?>
	<!-- ./alert -->

	<div class="container">

		<!-- capa -->
		<section class="cover">
			<div class="menu-lang">
				<ul>
					<li class="info">
						<a href="">Sobre o SciELO</a>
					</li>
					<li class="es">
						<a href="">Español</a>
					</li>
					<li class="en">
						<a href="">English</a>
					</li>
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

	<script src="<?= get_static_js_path('jquery-1.11.0.min.js') ?>" type="text/javascript"></script>
	<script src="<?= get_static_js_path('bootstrap.min.js') ?>" type="text/javascript"></script>
	<script src="<?= get_static_js_path('slick.js') ?>" type="text/javascript" charset="utf-8"></script>
	<script src="<?= get_static_js_path('scielo.js') ?>" type="text/javascript" charset="utf-8"></script>
	<script>
	$(function(){
		scieloLib.Init();
	});
	</script>
</body>
</html>
