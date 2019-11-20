<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- header -->
<?php $this->load->view('partials/header'); ?>
<!-- ./header -->

<!-- language-menu -->
<?php //$this->load->view('partials/language-menu'); ?>
<!-- ./language-menu -->

<section>
	<div class="breadcrumb">
		<div class="container">
			<div class="row">
				<div class="breadcrumb-path">
					breadcrumb aqui
				</div>
			</div>
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-9">
					
					<h2 class="breadTitle"><?php echo $titulo; ?></h2>
					
				</div>
				<div class="col-xs-12 col-sm-4 col-md-3">
					<!-- share -->
					<?php //$this->load->view('partials/share'); ?>
					<!-- ./share -->
				</div>
			</div>
		</div>
	</div>
</section>

<section class="collection collectionAbout">
	<div class="container">
		
		<?php
			if($json){
		?>
			<div class="row">
				<div class="col-md-9">
					<strong>Título</strong>
				</div>
				<div class="col-md-3">
					<strong>Anexo</strong>
				</div>
			</div>
			<hr>
		<?php
				for($i=0;$i<count($json);$i++) {
		?>
			
					<div class="row">
						<div class="col-md-9">
							<?php echo ( $json[$i]['title']['rendered'] ? "<a href='".$json[$i]['link']."' target='_blank'>".$json[$i]['title']['rendered']."</a>" : "Nenhum dado para exibir" );?>
						</div>
						<div class="col-md-3">
							<?php echo ( $json[$i]['guid']['rendered'] ? "<a href='".$json[$i]['guid']['rendered']."'>Download</a>" : "Nenhum dado para exibir" );?>
						</div>
					</div>

					<!--
					<div class="row">
						<div class="col-md-3">
							<strong>
								Conteúdo
							</strong>
						</div>
						<div class="col-md-9">
							<strong>
								<?php // echo ( $json[$i]['content']['rendered'] ? $json[$i]['content']['rendered'] : "Nenhum dado para exibir" );?>
							</strong>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<strong>
								Idioma atual
							</strong>
						</div>
						<div class="col-md-9">
							<strong>
								<?php // echo $idioma_atual; ?>
							</strong>
						</div>
					</div>
					-->
					<hr>
				

		<?php
				}
			}else{
		?>
				<div class="row">
					<div class="col-md-12">
						
						Nenhum item encontrado com o termo "<strong><?php echo $query; ?></strong>".
						
					</div>
				</div>
		<?php				
			}
		?>
	</div>
</section>

<!-- footer -->
<?php //$this->load->view('partials/footer'); ?>
<!-- ./footer -->
