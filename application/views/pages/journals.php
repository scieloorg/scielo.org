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
							<?php if (isset($subject_area)) : ?>
								: <?= $subject_area['name_' . $language] ?>
							<?php endif; ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-9">
					<h2 class="breadTitle">
						<?= ucfirst(lang('journals')) ?>
						<?php if (isset($subject_area)) : ?>
							: <?= $subject_area['name_' . $language] ?>
						<?php endif; ?>
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
		<?php if (isset($subject_areas)) : ?>			
		<div class="row row-journal-filter">
			<div class="col-md-12">
				<form action="#" id="subject_area_form" class="form-inline">
					<div class="form-group">
						<p class="form-control-static"><strong><?= lang('subject') ?>:</strong></p>
					</div>
					<div class="form-group">
						<select id="subject_area" class="form-control" onchange="javascript:window.location=$('#subject_area').val();">
							<?php foreach ($subject_areas as $_subject_area) : ?>
							<?php
						$id_subject_area = $_subject_area['id_subject_area'];
						$name_url = str_replace(',', '', $_subject_area['name_' . $language]);
						$name_url = str_replace('+', '-', urlencode(remove_accents(strtolower($name_url))));
						?>     
								<option value="<?= $journals_links[$language]['list-by-subject-area'] . '/' . $id_subject_area . '/' . $name_url ?>" <?php if ($subject_area['id_subject_area'] == $id_subject_area) : ?>selected<?php endif; ?>><?= $_subject_area['name_' . $language] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</form>
			</div>
		</div>
		<?php endif; ?>
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
					<input type="text" name="search" id="search" value="<?= $search ?>" class="form-control collectionSearch" placeholder="<?= lang('search_journals_placeholder') ?>" autofocus>
					<button type="submit" class="btn btn-default btn-input"></button>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">

				<div class="list-journals">
					<hr>
					<table>
						<thead>
							<th>
								<?= ucfirst(lang('journals')) ?> <small>(total <?= $total_journals ?>)</small>
							</th>
							<th width="30%">
								<div class="downloadList">
									<span><?= lang('list_download') ?></span>
									<a href="<?= $base_url ?>&export=xls" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_xls_tooltip') ?>" class="glyphBtn downloadXLS showTooltip"></a>
									<a href="<?= $base_url ?>&export=csv" target="_blank" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<?= lang('export_to_cvs_tooltip') ?>" class="glyphBtn downloadCSV showTooltip"></a>
								</div>
							</th>
						</thead>
						<tbody>
							<?php if (empty($journals)) : ?>
								<tr>
									<td colspan="2">
										<strong class="journalTitle">
											<?= lang('no_journals_found_message') ?>
										</strong>
									</td>
								</tr>
							<?php else : ?>
								<?php foreach ($journals as $journal) : ?>
								<tr>
									<td colspan="2">
										<a href="<?= $journal->scielo_url ?>" <?php if ($journal->status == 'deceased') : ?>class="disabled"<?php endif; ?>>
											<strong class="journalTitle">
												<?= $journal->title ?>
											</strong>
										</a>
									</td>
								</tr>
								<?php endforeach; ?>
							<?php endif; ?>
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
