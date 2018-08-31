<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row slider-twitter" >
    <?php foreach ($tweets as $tweet) : ?>
    <?php
        $tweetElapsedTime = get_tweet_elapsed_time($tweet->created_at) ;

        $media_url = NULL;

        if(isset($tweet->entities->media[0]->media_url)){
            $media_url = $tweet->entities->media[0]->media_url;
        }
    ?>
    <div class="col-xs-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <?php if(!is_null($media_url)):?>
                    <img src="<?= $media_url ?>" alt="capa-post-twitter-1" title="capa-post-twitter-1">
                <?php endif;?>
            </div>
            <div class="card-body card-body-twitter">

                <div class="row row-avatar">
                    <div class="col-xs-12">
                        <a href="https://twitter.com/RedeSciELO" class="avatar"></a>
                        <div class="twitter-info">
                            <strong>SciELO</strong>
                            <span>@RedeSciELO</span>
                        </div>
                    </div>
                </div>
                <p>
                    <?= json_tweet_text_to_HTML($tweet) ?>
                </p>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <span><?= $tweetElapsedTime ?></span>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <div class="twitter-actions">
                            <a href="" class="btn btn-comment"></a>
                            <a href="" class="btn btn-retweet"></a>
                            <a href="" class="btn btn-like"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-sm-offset-6 col-md-4 col-md-offset-8">
        <a href="https://twitter.com/RedeSciELO" class="btn btn-default btn-arrow arrow-blue btn-link-blog">Siga-nos no <strong>Twitter @RedeSciELO</strong></a>
    </div>
</div>
