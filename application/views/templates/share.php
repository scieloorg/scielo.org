<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="share">
    <ul>
        <li>
            <span>
                <?= lang('share') ?>
            </span>
        </li>
        <li>
            <a href="" class="showTooltip" data-toggle="tooltip" data-placement="top" title="<?= lang('print') ?>">
                <span class="glyphBtn print"></span>
            </a>
        </li>
        <li>
            <a href="" class="showTooltip" data-toggle="tooltip" data-placement="top" title="Atom">
                <span class="glyphBtn rssMini"></span>
            </a>
        </li>
        <li>
            <a href="" class="showTooltip" data-toggle="tooltip" data-placement="top" title="<?= lang('send_by_email') ?>">
                <span class="glyphBtn sendMail"></span>
            </a>
        </li>
        <li>
            <a href="" class="showTooltip" data-toggle="tooltip" data-placement="top" data-toggle="tooltip" data-placement="auto" title="<?= lang('share_on_facebook') ?>">
                <span class="glyphBtn facebook"></span>
            </a>
        </li>
        <li>
            <a href="" class="showTooltip" data-toggle="tooltip" data-placement="top" data-toggle="tooltip" data-placement="auto" title="<?= lang('share_on_twitter') ?>">
                <span class="glyphBtn twitter"></span>
            </a>
        </li>
        <li>
            <a href="" class="dropdown-toggle showTooltip" data-toggle="tooltip" data-placement="auto" title="<?= lang('other_social_networks') ?>">
                <span class="glyphBtn otherNetworks"></span>
            </a>
            <div class="menu-share">
                <ul>
                    <li class="dropdown-header"> <?= lang('other_social_networks') ?></li>
                    <li>
                        <a href="" class="shareGooglePlus">
                            <span class="glyphBtn googlePlus"></span> Google+
                        </a>
                    </li>
                    <li>
                        <a href="" class="shareLinkedIn">
                            <span class="glyphBtn linkedIn"></span> LinkedIn
                        </a>
                    </li>
                    <li>
                        <a href="" class="shareReddit">
                            <span class="glyphBtn reddit"></span> Reddit
                        </a>
                    </li>
                    <li>
                        <a href="" class="shareStambleUpon">
                            <span class="glyphBtn stambleUpon"></span> StambleUpon
                        </a>
                    </li>
                    <li>
                        <a href="" class="shareCiteULike">
                            <span class="glyphBtn citeULike"></span> CiteULike
                        </a>
                    </li>
                    <li>
                        <a href="" class="shareMendeley">
                            <span class="glyphBtn mendeley"></span> Mendeley
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
