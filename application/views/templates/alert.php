<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if($this->Alert->is_visible()):?>
<div class="alert-notification">
    <a href="javascript:;" class="close"></a>
    <div class="container">
        <div class="row">
            <div class="<?= $this->Alert->get_outside_column_size_desktop() ?>">
                <div class="row">
                    <?php for($i = 1; $i <= $this->Alert->get_number_of_columns(); $i++):?>
                        <div class="<?= $this->Alert->get_column_size_desktop() ?>">
                            <?= $this->Alert->get_column_content('column'.$i) ?>
                        </div>
                    <?php endfor;?>    
                </div>
            </div>       

        <?php if($this->Alert->is_link_visible()):?>
            <div class="col-xs-12 col-sm-1 col-md-3">
                <div class="cta-notification">
                    <a href="<?= $this->Alert->get_link() ?>" class="btn btn-arrow arrow-white"><?= $this->Alert->get_link_text() ?></a>
                </div>
            </div>
        <?php endif;?>
            
        </div>
    </div>
</div>
<?php endif;?>
