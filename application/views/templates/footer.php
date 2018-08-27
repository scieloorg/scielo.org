<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<footer class="">
    <div class="collectionSignature">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <span class="logo-svg-footer"></span>
                </div>
                <div class="col-xs-12 col-sm-10 col-md-8 adress-footer">
                    <?= $scielo_signature ?>
                </div>
            </div>
        </div>
    </div>
    <div class="partners">
        <?php foreach($scielo_partners as $partner):?>
            <a href="<?= $partner['link'] ?>" target="_blank"><img src="<?= $partner['logo'] ?>" alt="<?= $partner['name'] ?>" title="<?= $partner['name'] ?>"></a>
        <?php endforeach;?>
    </div>
    <div class="container collectionLicense">
        <a href="/collection/about/" class="ico-oa">
            <?= $scielo_open_access_declaration ?>
        </a>
    </div>
</footer>