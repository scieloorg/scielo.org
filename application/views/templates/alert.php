<?php if($show_alert):?>
<div class="alert-notification">
    <a href="javascript:;" class="close"></a>
    <div class="container">
        <div class="row">
            <div class="<?= $alert_outside_column_size_desktop ?>">
                <div class="row">
                    <?php for($i = 1; $i <= $alert_number_of_columns; $i++):?>
                        <div class="<?= $alert_column_size_desktop ?>">
                            <?= $alert_column_content['column'.$i] ?>
                        </div>
                    <?php endfor;?>    
                </div>
            </div>       

        <?php if($show_alert_link):?>
            <div class="col-xs-12 col-sm-1 col-md-3">
                <div class="cta-notification">
                    <a href="<?= $alert_link ?>" class="btn btn-arrow arrow-white"><?=$alert_link_text?></a>
                </div>
            </div>
        <?php endif;?>
            
        </div>
    </div>
</div>
<?php endif;?>
