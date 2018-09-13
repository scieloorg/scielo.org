<?php
$now = gmdate("D-d-M-Y-H:i:s");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=journals-{$now}.csv");
?>
<?= lang('journals').", scielo_url\n" ?>
<?php foreach ($journals as $journal) : ?>
<?= $journal->title ?>, <?= $journal->scielo_url."\n" ?>
<?php endforeach; ?>
