<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row slider-blog">
    <?php foreach ($blog_posts->channel->item as $post) : ?>
    <?php 
    $content = $post->children("content", true);
    preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $img);
    preg_match("'<p><strong>Por(.*?)<\/strong><\/p>'", $content, $author);

    // @TODO - Feed RSS em inglês e espanhol não possui imagens de conteúdo.
    $img = array_key_exists('src', $img) ?  $img['src'] : get_static_image_path('blog/post1.png');

    ?>
    <div class="col-xs-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <img src="<?= $img ?>" alt="capa-post-scielo20anos" title="capa-post-scielo20anos">
            </div>
            <div class="card-body">
                <div class="card-title">
                    <a href="<?= $post->link ?>">
                        <?php if (is_array($author) && count($author) > 0) : ?>
                        <span><?= strip_tags($author[0]) ?></span>
                        <?php else : ?>	
                        <span>Por SciELO</span>
                        <?php endif; ?>	
                        <h3><?= $post->title ?></h3>
                    </a>
                </div>
                <p><?= str_replace('Read More &#8594;', '', strip_tags($post->description)) ?></p>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <span><?= date('d M Y', strtotime($post->pubDate)) ?></span>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <a href="<?= $post->link ?>" class="btn-arrow arrow-blue">Leia mais</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>	
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-sm-offset-6 col-md-4 col-md-offset-8">
        <a href="https://blog.scielo.org/" class="btn btn-default btn-arrow arrow-blue btn-link-blog">Acesse o blog <strong>Scielo em perspectiva</strong></a>
    </div>
</div>
