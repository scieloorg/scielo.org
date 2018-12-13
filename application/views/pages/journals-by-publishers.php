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
							<?= ucfirst(lang('journals')) ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-9">
					<h2 class="breadTitle">
						<?= ucfirst(lang('journals')) ?>
					</h2>
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
		<div class="row row-journal-filter">
			<div class="col-md-6">
				<?php $this->load->view('partials/journals-status'); ?>
			</div>
			<div class="col-md-6">
				<?php $this->load->view('partials/journals-search-form'); ?>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-12">

				<div class="list-publisher">
					<hr>
					<?php $this->load->view('partials/journals-letter-filter'); ?>	
					<div id="journalsTable">	
					<table>
						<colgroup>
							<col width="50%">
							<col width="50%">
						</colgroup>	
						<thead class="hidden-xs">
							<th class="col-xs-12 col-sm-6 col-md-6">
								<?= lang('publisher') ?>
							</th>
							<th class="col-xs-12 col-sm-6 col-md-6">
								<?= ucfirst(lang('journals')) ?>
								<div class="downloadList">
									<span><?= lang('list_download') ?></span>
									<a href="<?= $base_url ?>&export=csv" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_cvs_tooltip') ?>" class="glyphBtn downloadCSV showTooltip"></a>
								</div>
							</th>
						</thead>
						<thead class="hidden-sm hidden-md hidden-lg">
							<th class="col-xs-12 col-sm-6 col-md-6">
								<?= lang('publisher') ?> / <?= ucfirst(lang('journals')) ?>
								<div class="downloadList">
									<span><?= lang('list_download') ?></span>
									<a href="<?= $base_url ?>&export=csv" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_cvs_tooltip') ?>" class="glyphBtn downloadCSV showTooltip"></a>
								</div>
							</th>
						</thead>						
						<tbody>
							<?php if (empty($publishers)) : ?>
								<tr>
									<td colspan="2">
										<strong class="journalTitle">
											<?= lang('no_journals_found_message') ?>
										</strong>
									</td>
								</tr>
							<?php else : ?>
								<?php 
								$last_letter = '';
								foreach ($publishers as $publisher) : 								
									$journals = $this->Journals->list_all_journals_by_publisher(addslashes($publisher->publisher_name), $this->input->get('status', true));
									$last_letter_html = create_last_letter_html($last_letter, $publisher->publisher_name);	
								?>
								<?= $last_letter_html ?>
								<tr>
									<td class="col-xs-12 col-sm-6 col-md-6">
										<strong>
											<?= $publisher->publisher_name ?>
										</strong>
									</td>
									<td class="col-xs-12 col-sm-6 col-md-6">
										<?php foreach ($journals as $journal) : ?>
											<a href="<?= $journal->scielo_url ?>" <?php if ($journal->status == 'deceased') : ?>class="disabled"<?php endif; ?>>
												<?= $journal->title ?>
											</a>
										<?php endforeach; ?>
									</td>
								</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
					</div>
					<div style="display: none;" class="collectionListLoading"></div>		
				</div>
			</div>
		</div>

	</div>
</section>

<!-- footer -->
<?php 
$this->load->view('partials/footer');
$this->load->view('partials/journals-query-filter');
?>
<!-- ./footer -->
