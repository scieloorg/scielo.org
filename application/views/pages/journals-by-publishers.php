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
					<?php $this->load->view('templates/share'); ?>
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
				<div class="btn-group" data-toggle="buttons">
					<label class="btn <?php if (!$status) : ?>active<?php endif; ?>">
						<input type="radio" autocomplete="off" name="query_filter" id="query_filter_all" value="all">
						<?= lang('all') ?>
					</label>
					<label class="btn <?php if ($status == 'current') : ?>active<?php endif; ?>">
						<input type="radio" autocomplete="off" name="query_filter" id="query_filter_current" value="current">
						<span class="lbl-corrente hidden-xs"><?= lang('active_journals') ?></span>
						<span class="lbl-corrente hidden-sm hidden-md hidden-lg"><?= lang('actives') ?></span>
					</label>
					<label class="btn <?php if ($status == 'deceased') : ?>active<?php endif; ?>">
						<input type="radio" autocomplete="off" name="query_filter" id="query_filter_deceased" value="deceased">
						<span class="lbl-nao-corrente hidden-xs"><?= lang('deceased_journals') ?></span>
						<span class="lbl-nao-corrente hidden-sm hidden-md hidden-lg"><?= lang('deceaseds') ?></span>
					</label>
				</div>
			</div>
			<div class="col-md-6">
				<form action="<?= current_url() ?>">
					<input type="text" name="search" id="search" value="<?= $search ?>" class="form-control collectionSearch" placeholder="<?= lang('search_journals_placeholder') ?>">
					<button type="submit" class="btn btn-default btn-input"></button>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">

				<div class="list-publisher">
					<hr>
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
									<a href="<?= $base_url ?>&export=xls" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_xls_tooltip') ?>" class="glyphBtn downloadXLS showTooltip"></a>
									<a href="<?= $base_url ?>&export=csv" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_cvs_tooltip') ?>" class="glyphBtn downloadCSV showTooltip"></a>
								</div>
							</th>
						</thead>
						<thead class="hidden-sm hidden-md hidden-lg">
							<th class="col-xs-12 col-sm-6 col-md-6">
								<?= lang('publisher') ?> / <?= ucfirst(lang('journals')) ?>
								<div class="downloadList">
									<span><?= lang('list_download') ?></span>
									<a href="<?= $base_url ?>&export=xls" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_xls_tooltip') ?>" class="glyphBtn downloadXLS showTooltip"></a>
									<a href="<?= $base_url ?>&export=csv" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_cvs_tooltip') ?>" class="glyphBtn downloadCSV showTooltip"></a>
								</div>
							</th>
						</thead>						
						<tbody>
							<?php foreach ($publishers as $publisher) : ?>
							<?php
								$journals = $this->Journals_model->list_all_journals_by_publisher(addslashes($publisher->publisher_name), $this->input->get('status', true));
							?>
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
						</tbody>
					</table>
					<nav aria-label="Page navigation example">
						<?= $this->pagination->create_links(); ?>
					</nav>
				</div>
			</div>
		</div>

	</div>
</section>

<!-- footer -->
<?php $this->load->view('templates/footer'); ?>
<!-- ./footer -->

<script>
  var current_url = '<?= current_url() ?>';

  $('#query_filter_all').on('change', function () {
    window.location = current_url;
  });

  $('#query_filter_current').on('change', function () {
    window.location = current_url + '?status=current';
  });

  $('#query_filter_deceased').on('change', function () {
    window.location = current_url + '?status=deceased';
  })
</script>
