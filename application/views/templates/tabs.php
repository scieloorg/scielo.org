<?php foreach($tab_group as $group): ?>
<section>
    <div class="row row-tab-desk">
        <div class="col-md-12 nav-center">
            <ul class="nav nav-tabs">
                <?php 
                    foreach($group['group'] as $key => $tab): 
                        $tabContent = get_tab_content($tab['tab_content_type'], $key);
                ?>
                <li <?php if($key == 0):?>class="active"<?php endif;?>>
                    <h2><a  href="#<?= $tabContent['ID'] ?>" data-toggle="tab"><?= $tab['tab_title'] ?></a></h2>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>

    <div class="tab-content clearfix">
        <?php 
            foreach($group['group'] as $key => $tab):
                $tabContent = get_tab_content($tab['tab_content_type'], $key, $tab['tab_html_content']);
        ?>
        <div class="row row-tab-mobile">
            <div class="col-xs-12">
                <h2><a href="#<?= $tabContent['ID'] ?>" data-toggle="tab" class="btn btn-tab-mobile active"><?= $tab['tab_title'] ?></a></h2>
            </div>
        </div>
        
        <div class="tab-pane <?php if($key == 0):?>active<?php endif;?> <?php if($tab['tab_content_type'] == 4 || $tab['tab_content_type'] == 5):?>tab-pane-white<?php endif;?>" id="<?= $tabContent['ID'] ?>">
            <?php $this->load->view($tabContent['content']); ?>
        </div>
        <?php endforeach;?>            
    </div>
</section>
<?php endforeach; ?>
