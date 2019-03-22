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
                        <?php $this->load->view('partials/share'); ?>
                        <!-- ./share -->

					</div>
				</div>
			</div>
		</div>
	</section>


	<section>
		<div class="container">

			<div class="col-xs-12 content-404">
				<?= lang('page_not_found_with_details') ?>
			</div>

		</div>
	</section>

<!-- footer -->
<?php $this->load->view('partials/footer'); ?>
<!-- ./footer -->
