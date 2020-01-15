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
								<a href="<?= base_url($language) ?>">Home</a>
							</li>
							<li>
								<a href="<?= $about_menu_item['link'] ?>"><?= $about_menu_item['text'] ?></a>
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
					<h2 class="breadTitle"><?= lang('displaying_results_for_term')."<i>".htmlspecialchars(strip_tags($query))."</i>"; ?></h2>
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

		<?php if($paged_json){ ?>
				
			<?php for($i=0;$i<count($paged_json);$i++) { ?>

				<?php
					$link_text = $paged_json[$i]['title']['rendered'];

					// Verify if the page is of the type 'attachment'
					/*

					To have the system search the contents of attachments but 
					not show attachments directly in the results list, read and 
					follow the steps in this article:
					https://searchwp.com/docs/kb/post-parent-attribution/
					
					*/
					 
					if ($paged_json[$i]['type'] == 'attachment'){
						
						$link = $paged_json[$i]['guid']['rendered'];
					
					}

					
					else if($paged_json[$i]['template'] == 'pageModel-linkExternal.php'){

						$link = $paged_json[$i]['acf']['link_'.$language]; 
					
					}else if($paged_json[$i]['template'] == 'pageModel-linkToDocument.php'){

						$link = $paged_json[$i]['acf']['document_'.$language];

					}
					

					else{

						// If the language is Portuguese it is necessary to concatenate the cookie language value. 
						$scielo_url = ($language == SCIELO_LANG) ? base_url($language . '/') : base_url();
						$link = str_replace(WORDPRESS_URL, $scielo_url, $paged_json[$i]['link']);
						
					}
				?>

				<?php if ($paged_json[$i]['template'] != 'pageModel-linkToDocument.php'){ ?>
	            		
            		<div class="row">
						<div class="col-xs-12">
		    
							<a href="<?= $link ?>">

								<?= $link_text ?>
							
							</a>
		            		
		            	</div>
					</div>
					<hr>
				
				<?php }else{ ?>
					
					<div class="row">
						<div class="col-xs-12">
		    
							<a href="<?= $link ?>" target="_blank">

								<?= $link_text ?>
							
							</a>
		            		
		            	</div>
					</div>
					<hr>
				
				<?php } ?>
		        
			<?php } ?>
		
		<?php }else{ ?>
				
			<div class="row">
				<div class="col-md-12">
					
					<?= lang('no_items_found_for_term') ?><strong><?= $query; ?></strong>.
					
				</div>
			</div>

		<?php } ?>

	</div>

	<!--
	<div>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<?//= $this->pagination->create_links();?>
			</ul>
		</nav>
	</div>
	-->

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav aria-label="...">
				  
				    <?= $this->pagination->create_links();?>
				  
				</nav>
			</div>	
		</div>		
	</div>

	
</section>

<!-- footer -->
<?php $this->load->view('partials/footer'); ?>
<!-- ./footer -->
