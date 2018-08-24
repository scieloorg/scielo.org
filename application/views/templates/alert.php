<?php if($show_alert):?>
<div class="alert-notification">
    <a href="javascript:;" class="close"></a>
    <div class="container hidden-sm hidden-md">
        <div class="row">
        <?php for($i = 1; $i <= $alert_number_of_columns; $i++):?>
            <div class="<?= $alert_column_size_desktop ?>">
                <?= $alert_column_content['column'.$i] ?>
            </div>
        <?php endfor;?>           

        <?php if($show_alert_link):?>
            <div class="col-xs-12 col-sm-1 col-md-3">
                <div class="cta-notification">
                    <a href="<?= $alert_link ?>" class="btn btn-arrow arrow-white"><?=$alert_link_text?></a>
                </div>
            </div>
        <?php endif;?>
            
        </div>
    </div>

    <div class="container hidden-xs hidden-lg">
        <div class="row">

            <div class="col-sm-3">
                <div class="logo-20">
                    <img src="<?= get_static_image_path('logo-scielo-20-anos.svg') ?>" alt="logo-scielo-20-anos" title="logo-scielo-20-anos">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="row-nested">
                    <p>
                        <strong>
                            VENHA PARA ONDE A QUALIDADE, INOVAÇÃO <br>E O ACESSO ABERTO FLORESCEM
                        </strong>
                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <p>
                            <strong>Reunião da Rede <br>SciELO</strong><br>
                            24-25 set 2018
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>Conferência <br>internacional</strong><br>
                            26-28 set 2018
                        </p>
                    </div>
                </div>
            </div>
        <?php if($show_alert_link):?>
            <div class="col-sm-2">
                <div class="cta-notification" style="margin-top:3rem;">
                    <a href="<?= $alert_link ?>" class="btn btn-arrow arrow-white"><?= $alert_link_text ?></a>
                </div>
            </div>
        <?php endif;?>
        </div>
    </div>
</div>
<?php endif;?>