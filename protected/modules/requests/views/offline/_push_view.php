<?php
/** @var $data TextMessagesReceive */
?>

<div class="push-item emergency" data-max="<?= $data->getMaxID() ?>">
    <a href="<?= Yii::app()->createUrl('/requests/offline/view/'.$data->id.'?pending') ?>">
        <i class="alarm-icon"></i>
        <h5>
            درخواست فوری جدید
            <small><?= $data->sender ?></small>
        </h5>
    </a>
</div>
