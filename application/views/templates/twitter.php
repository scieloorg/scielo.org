<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row slider-twitter" >
    <?php foreach ($tweets as $tweet) : ?>
    <?php
        $profile_img = $tweet->user->profile_image_url;
        
        $tweetElapsedTime = get_tweet_elapsed_time($tweet->created_at) ;

        $media_url = NULL;

        if(isset($tweet->entities->media[0]->media_url)){
            $media_url = $tweet->entities->media[0]->media_url;
        }else{
            $media_url = get_static_image_path('blog/post1.png');
        }
    ?>
    <div class="col-xs-12 col-md-4">
        <div class="card">
            <div class="card-header" style="background-image:url('<?= $media_url ?>')">
            </div>
            <div class="card-body card-body-twitter">

                <div class="row row-avatar">
                    <div class="col-xs-12">
                        <a href="https://twitter.com/RedeSciELO" class="avatar" style="background-image:url('<?= $profile_img ?>')"></a>
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
                            <a href="https://twitter.com/RedeSciELO" class="btn btn-retweet" target="_blank"></a>
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
        <a href="https://twitter.com/RedeSciELO" class="btn btn-default btn-arrow arrow-blue btn-link-blog"><?= lang('twitter_text') ?></a>
    </div>
</div>
