<?php
$scl = SiteSetting::getOption('social_links')?:null;
if($scl):
$scl = CJSON::decode($scl, false);
$tw = $scl->twitter;
$fb = $scl->facebook;
$tl = $scl->telegram;
$in = $scl->instagram;
$yo = $scl->youtube;
?>
<div class="social-networks">
    <div class="social-icons">
        <?php if($tl): ?><a target="_blank" class="pull-left" href="<?= $tl; ?>"><span class="svg-icons telegram-icon grayscale"></span></a><?php endif; ?>
        <?php if($fb): ?><a target="_blank" class="pull-left" href="<?= $fb; ?>"><span class="svg-icons facebook-icon grayscale"></span></a><?php endif; ?>
        <?php if($in): ?><a target="_blank" class="pull-left" href="<?= $in; ?>"><span class="svg-icons instagram-icon grayscale"></span></a><?php endif; ?>
        <?php if($yo): ?><a target="_blank" class="pull-left" href="<?= $yo; ?>"><span class="svg-icons youtube-icon grayscale"></span></a><?php endif; ?>
        <?php if($tw): ?><a target="_blank" class="pull-left" href="<?= $tw; ?>"><span class="svg-icons twitter-icon grayscale"></span></a><?php endif; ?>
    </div>
</div>
<?php
endif;