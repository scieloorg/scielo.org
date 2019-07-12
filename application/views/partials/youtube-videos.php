<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php if(count($youtube_videos) > 0): ?>
<div class="row slider-youtube-videos">
    <?php foreach ($youtube_videos as $video) : ?>
   <div class="col-xs-12 col-md-4">
        <div class="card">
            <div class="card-header" style="background-image:url('<?= $video['thumbnail'] ?>')">
            </div>
            <div class="card-body">
                <div class="card-title">
                    <a href="https://www.youtube.com/watch?v=<?= $video['id'] ?>" target="_blank">
                    <span>Por SciELO</span>
                    <h3><?= character_limiter($video['title'], 100) ?></h3>
                    </a>
                </div>
                <p><?= character_limiter($video['description'], 400) ?></p>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-5">
                        <span><?= date('d M Y', strtotime($video['publishedAt'])) ?></span>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-7 text-right">
                        <a href="https://www.youtube.com/watch?v=<?= $video['id'] ?>" class="btn-arrow arrow-blue" target="_blank"><?= lang('watch_video') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="card card-no-content">
            <?= lang('content_error'); ?>
        </div>
    </div>
<?php endif; ?>	
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-sm-offset-6 col-md-4 col-md-offset-8">
        <a href="https://www.youtube.com/user/RedeSciELO/" class="btn btn-default btn-arrow arrow-blue btn-link-blog">RedeSciELO YouTube Channel</a>
    </div>
</div>
