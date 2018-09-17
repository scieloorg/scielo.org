<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="row-nested">
            <div class="col-sm-4 col-md-4">
                <dl>
                    <dt><?= $total_collections ?></dt>
                    <dd>
                        <?= lang('collections') ?>
                    </dd>
                </dl>
            </div>
            <div class="col-sm-4 col-md-4">
                <dl>
                    <dt><?= $total_active_journals ?></dt>
                    <dd>
                        <?= strtolower(lang('active_journals')) ?>
                    </dd>
                </dl>
            </div>
            <div class="col-sm-4 col-md-4">
                <dl>
                    <dt><?= $total_published_articles ?></dt>
                    <dd>
                        <?= lang('published_articles') ?>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center">
        <a href="https://analytics.scielo.org" class="btn btn-default btn-arrow arrow-blue">Veja mais dados no <strong>SciELO Analytics</strong></a>
    </div>
</div>
