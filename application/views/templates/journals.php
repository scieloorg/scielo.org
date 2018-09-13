<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <dl>
            <dt><h3><?= lang('search_journals') ?></h3></dt>
            <dd class="search-periodicos">
                <form action="<?= base_url($language.'/journals/list-by-alphabetical-order') ?>">
                    <input type="text" name="search" id="search">
                    <button type="submit" class="btn btn-default btn-input"></button>
                </form>
            </dd>
        </dl>
        <dl>
            <dt><h3><?= lang('journals_by_alphabetical_order') ?></h3></dt>
            <dd class="text">
                <a href="<?= base_url($language.'/journals/list-by-alphabetical-order') ?>"><?= lang('list_journals_by_alphabetical_order') ?></a>
            </dd>
        </dl>
        <dl>
            <dt><h3><?= lang('by_publisher') ?></h3></dt>
            <dd class="text">
                <a href="<?= base_url($language.'/journals/list-by-publishers') ?>"><?= lang('publisher_list') ?></a>
            </dd>
        </dl>
        <dl>
            <dt><h3><?= lang('by_subject') ?></h3></dt>
            <dd class="text">
                <a href="<?= base_url($language.'/journals/list-by-alphabetical-order') ?>"><?= lang('all') ?></a>
            </dd>
            <?php foreach ($subject_areas as $subject_area) : ?>
            <?php
                $id_subject_area = $subject_area['id_subject_area'];
                $name_url = str_replace(',', '', $subject_area['name_' . $language]);
                $name_url = str_replace('+','-', urlencode(remove_accents(strtolower($name_url))));
            ?>            
            <dd>
                <a href="<?= base_url($language.'/journals/list-by-subject-area/'.$id_subject_area.'/'.$name_url) ?>"><?= $subject_area['name_' . $language] ?></a>
            </dd>
            <?php endforeach; ?>
        </dl>
    </div>
</div>
