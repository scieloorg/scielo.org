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

		<!-- abas: colecoes, periodicos, numeros -->
		<section class="collection">
			<div class="row row-tab-desk">
				<div class="col-md-12 nav-center">

					<ul class="nav nav-tabs">
						<li class="active">
							<h2><a  href="#tab-colecoes" data-toggle="tab">Coleções</a></h2>
						</li>
						<li>
							<h2><a href="#tab-periodicos" data-toggle="tab">Periódicos</a></h2>
						</li>
						<li>
							<h2><a href="#tab-numeros" data-toggle="tab">SciELO em números</a></h2>
						</li>
					</ul>

				</div>
			</div>


			<div class="tab-content clearfix">

				<div class="row row-tab-mobile">
					<div class="col-xs-12">
						<h2><a href="#tab-colecoes" data-toggle="tab" class="btn btn-tab-mobile active">Coleções</a></h2>
					</div>
				</div>

				<div class="tab-pane active" id="tab-colecoes">
					<!-- conteudo colecoes -->
					<div class="row">
						<div class="col-sm-3 col-md-3">
							<dl>
								<dt><h3>Coleções de livros</h3></dt>
								<dd class="scielo-books">
									<a href="">
										<h4>SciELO Livros</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
							</dl>
							<dl>
								<dt><h3>Coleções de periódicos</h3></dt>
								<dd class="flag-rsa">
									<a href="">
										<h4>África do Sul</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-arg">
									<a href="">
										<h4>Argentina</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-bol">
									<a href="">
										<h4>Bolívia</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-bra">
									<a href="">
										<h4>Brasil</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-chi">
									<a href="">
										<h4>Chile</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
							</dl>
						</div>
						<div class="col-sm-3 col-md-3">
							<dl>
								<dd class="flag-col">
									<a href="">
										<h4>Colômbia</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-crc">
									<a href="">
										<h4>Costa Rica</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-cub">
									<a href="">
										<h4>Cuba</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-esp">
									<a href="">
										<h4>Espanha</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-mex">
									<a href="">
										<h4>México</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-per">
									<a href="">
										<h4>Peru</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-por">
									<a href="">
										<h4>Portugal</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-uru">
									<a href="">
										<h4>Uruguai</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
							</dl>
						</div>
						<div class="col-sm-3 col-md-3">
							<dl>
								<dd class="flag-ven">
									<a href="">
										<h4>Venezuela</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
								<dd class="flag-crc">
									<a href="">
										<h4>Saúde Pública</h4>
										<span>78 periódicos • 25.004 artigos</span>
									</a>
								</dd>
							</dl>
							<dl>
								<dt><h3>Em desenvolvimento</h3></dt>
								<dd class="flag-ecu">
									<a href="">
										<h4>Equador</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
								<dd class="flag-par">
									<a href="">
										<h4>Paraguai</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
							</dl>
							<dl>
								<dt><h3>Descontinuadas</h3></dt>
								<dd class="scielo-books">
									<a href="">
										<h4>Brasil Proceedings</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
								<dd class="scielo-books">
									<a href="">
										<h4>Social Sciences</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
							</dl>
						</div>
						<div class="col-sm-3 col-md-3">
							<dl>
								<dd class="scielo-books">
									<a href="">
										<h4>West Indian Medical Journal</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
							</dl>

							<dl>
								<dt><h3>Divulgação científica</h3></dt>
								<dd class="scielo-books">
									<a href="">
										<h4>Ciência e Cultura</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
								<dd class="scielo-books">
									<a href="">
										<h4>ComCiência</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
								<dd class="scielo-books">
									<a href="">
										<h4>Pesquisa FAPESP</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
								<dd class="scielo-books">
									<a href="">
										<h4>Revista Virtual de Química</h4>
										<span>1.011 títulos • 655 em acesso aberto</span>
									</a>
								</dd>
							</dl>
						</div>
					</div>
				</div>


				<div class="row row-tab-mobile">
					<div class="col-xs-12">
						<h2><a href="#tab-periodicos" data-toggle="tab" class="btn btn-tab-mobile">Periódicos</a></h2>
					</div>
				</div>

				<div class="tab-pane" id="tab-periodicos">
					<div class="row">
						<div class="col-md-12">

							<dl>
								<dt><h3>Pesquise periódicos</h3></dt>
								<dd class="search-periodicos">
									<input type="text">
									<a href="" class="btn btn-default btn-input"></a>
								</dd>
							</dl>
							<dl>
								<dt><h3>Por ordem alfabética</h3></dt>
								<dd class="text">
									<a href="">Lista de periódicos por ordem alfabética</a>
								</dd>
							</dl>
							<dl>
								<dt><h3>Por publicador</h3></dt>
								<dd class="text">
									<a href="">Lista de publicadores</a>
								</dd>
							</dl>
							<dl>
								<dt><h3>Por assunto</h3></dt>
								<dd class="text">
									<a href="">Todos</a>
								</dd>
								<dd>
									<a href="">Ciências Agrárias</a>
								</dd>
								<dd>
									<a href="">Ciências Biológicas</a>
								</dd>
								<dd>
									<a href="">Ciências da Saúde</a>
								</dd>
								<dd>
									<a href="">Ciências Exatas e da Terra</a>
								</dd>
								<dd>
									<a href="">Ciências Humanas</a>
								</dd>
								<dd>
									<a href="">Ciências Sociais Aplicadas</a>
								</dd>
								<dd>
									<a href="">Engenharias</a>
								</dd>
								<dd>
									<a href="">Linguistica</a>
								</dd>
								<dd>
									<a href="">Letras e Artes</a>
								</dd>
							</dl>

						</div>
					</div>
				</div>

				<div class="row row-tab-mobile">
					<div class="col-xs-12">
						<h2><a href="#tab-numeros" data-toggle="tab" class="btn btn-tab-mobile">Números</a></h2>
					</div>
				</div>

				<div class="tab-pane" id="tab-numeros">
					<div class="row">
						<div class="col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3">
							<dl>
								<dt>25</dt>
								<dd>
									coleções
								</dd>
							</dl>
							<dl>
								<dt>1.285</dt>
								<dd>
									periódicos ativos
								</dd>
							</dl>
						</div>
						<div class="col-md-3">
							<dl>
								<dt>745 mil</dt>
								<dd>
									artigos publicados
								</dd>
							</dl>
							<dl>
								<dt>16 milhões</dt>
								<dd>
									de citações
								</dd>
							</dl>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center">
							<a href="" class="btn btn-default btn-arrow arrow-blue">Veja mais dados no <strong>SciELO Analytics</strong></a>
						</div>
					</div>
				</div>
			</div>

		</section>

		<!-- abas: twitter e blog -->
		<section class="blog">
			<div class="row row-tab-desk">
				<div class="col-md-12 nav-center">
					<ul class="nav nav-tabs">
						<li class="active">
							<h2><a href="#tab-blog" data-toggle="tab">SciELO em Perspectiva</a></h2>
						</li>
						<li>
							<h2><a href="#tab-twitter" data-toggle="tab">Twitter @RedeSciELO</a></h2>
						</li>
					</ul>
				</div>
			</div>

			<div class="tab-content clearfix">
			
				<div class="row row-tab-mobile">
					<div class="col-xs-12">
						<h2><a href="#tab-blog" data-toggle="tab" class="btn btn-tab-mobile">SciELO em Perspectiva</a></h2>
					</div>
				</div>

				<div class="tab-pane tab-pane-white" id="tab-blog">

					<!-- conteudo blog -->
					<?php $this->load->view('templates/blog'); ?>
					<!-- ./conteudo blog -->

				</div>

				<div class="row row-tab-mobile">
					<div class="col-xs-12">
						<h2><a href="#tab-twitter" data-toggle="tab" class="btn btn-tab-mobile">Twitter @RedeSciELO</a></h2>
					</div>
				</div>


				<div class="tab-pane tab-pane-white" id="tab-twitter">

					<!-- conteudo twitter -->
					<?php $this->load->view('templates/twitter'); ?>
					<!-- ./conteudo twitter -->				

				</div>
			</div>
		</section>

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