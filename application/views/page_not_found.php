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
							<li>
								<a href="<?= base_url($language) ?>">Home</a>
							</li>
							<li>
								<?= lang('page_not_found') ?>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">

					<div class="col-xs-12 col-sm-8 col-md-9">
						<h2 class="breadTitle"> <?= lang('page_not_found') ?></h2>
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

			<div class="col-xs-12 content-404">

				<h5>
					<?= lang('page_not_found_tip') ?>
				</h5>

                <form name="searchForm" id="searchForm" action="https://search.scielo.org/" method="get">
                    <input type="hidden" name="lang" id="lang" value="<?= $language ?>">
                    <input type="hidden" name="count" id="count" value="15">
                    <input type="hidden" name="from" id="from" value="0">
                    <input type="hidden" name="output" id="output" value="site">
                    <input type="hidden" name="sort" id="sort" value="">
                    <input type="hidden" name="format" id="format" value="summary">
                    <input type="hidden" name="fb" id="fb" value="">
                    <input type="hidden" name="page" id="page" value="1">

                    <div class="search-box-404">
                        <input type="text" placeholder="<?= lang('search_placeholder') ?>">
                        <a href="javascript:$('#searchForm').submit();" class="btn btn-default btn-input"></a>
                        <a href="https://search.scielo.org/"><?= lang('search_link_text') ?></a>
                    </div>

                </form>
			</div>

		</div>
	</section>

<!-- footer -->
<?php $this->load->view('templates/footer'); ?>
<!-- ./footer -->