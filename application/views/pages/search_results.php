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
					<div class="breadcrumb-path">
						<ul>
							<li>
								<a href="<?= BASE_URL ?>">Home</a>
							</li>
							<li>
								<?= lang('search_btn') ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-9">
					<h2 class="breadTitle"><?= lang('displaying_results_for_term')."<i>".$query."</i>"; ?></h2>
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

<section class="collection collectionAbout">
	<div class="container">
		
		<?php $this->load->view('partials/internal-search-box'); ?>

		<?php if($json){ ?>
				
			<?php for($i=0;$i<count($json);$i++) { ?>
				   
				<?php if ($json[$i]['type'] == 'attachment'){ ?>
					
					<div class="row">
						<div class="col-xs-12">

							<?php echo ( $json[$i]['title']['rendered'] ? "<a href='".$json[$i]['guid']['rendered']."' target='_blank'>".$json[$i]['title']['rendered']."</a>" : "-" );?>

						</div>
					</div>
					<hr>
	                   	
            	<?php }else{ ?>

            		<?php if ($json[$i]['template'] != 'pageModel-linkToDocument.php'){ ?>
	            		
	            		<div class="row">
							<div class="col-xs-12">
			            		
			            		<?php echo ( $json[$i]['title']['rendered'] ? "<a href='".str_replace('scielo-org-adm','scielo-org-site',$json[$i]['link'])."' target='_blank'>".$json[$i]['title']['rendered']."</a>" : "-" );?> - <?= $language; ?>
			            		
			            	</div>
						</div>
						<hr>
					
					<?php } ?>

            	<?php }?>   
		        
			<?php } ?>
		
		<?php }else{ ?>
				
			<div class="row">
				<div class="col-md-12">
					
					<?= lang('no_items_found_for_term') ?><strong><?= $query; ?></strong>.
					
				</div>
			</div>

		<?php } ?>

	</div>
</section>

<!-- footer -->
<?php $this->load->view('partials/footer'); ?>
<!-- ./footer -->
