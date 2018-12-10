<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <dl>
            <dt><h3><?= lang('search_journals') ?></h3></dt>
            <dd class="search-periodicos">
                <form action="<?= $journals_links[$language]['list-by-alphabetical-order'] ?>">
                    <input type="hidden" name="matching" id="matching" value="contains">
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control">
                        <div class="input-group-btn">
                            <button type="button" id="matchingButton" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?=lang('contains')?> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:scieloLib.SetMatching('<?=lang('contains')?>', 'contains');"><?=lang('contains')?></a></li>
                                <li><a href="javascript:scieloLib.SetMatching('<?=lang('extact_title')?>', 'extact_title');"><?=lang('extact_title')?></a></li>
                                <li><a href="javascript:scieloLib.SetMatching('<?=lang('starts_with')?>', 'starts_with');"><?=lang('starts_with')?></a></li>
                            </ul>
                        </div><!-- /input-group-btn -->
                    </div><!-- /input-group -->
                
                </form>
            </dd>
        </dl>
    </div>
    <div class="col-md-2">
       <dl>
            <dt><h3><?= lang('list_journals') ?></h3></dt>
            <dd class="text">
                <a href="<?= $journals_links[$language]['list-by-alphabetical-order'] ?>"><?= lang('list_journals_by_alphabetical_order') ?></a>
            </dd>
            <dd class="text">
                <a href="<?= $journals_links[$language]['list-by-publishers'] ?>"><?= lang('publisher_list') ?></a>
            </dd>
        </dl>
    </div>
    <div class="col-md-10">
        <dl>
            <dt><h3><?= lang('list_journals_by_subject') ?></h3></dt>
            <dd class="text">
                <a href="<?= $journals_links[$language]['list-by-alphabetical-order'] ?>"><?= lang('all') ?></a>
            </dd>
            <?php foreach ($subject_areas as $subject_area) : ?>
            <?php
            $id_subject_area = $subject_area['id_subject_area'];
            $name_url = str_replace(',', '', $subject_area['name_' . $language]);
            $name_url = str_replace('+', '-', urlencode(remove_accents(strtolower($name_url))));
            ?>            
            <dd>
                <a href="<?= $journals_links[$language]['list-by-subject-area'] . '/' . $id_subject_area . '/' . $name_url ?>"><?= $subject_area['name_' . $language] ?></a>
            </dd>
            <?php endforeach; ?>
        </dl>
    </div>
</div>

