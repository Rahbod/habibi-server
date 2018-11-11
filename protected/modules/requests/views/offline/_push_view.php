<?php
/** @var $data TextMessagesReceive */
?>

<div class="push-item emergency" data-max="<?= $data->getMaxID() ?>">
    <a href="<?= Yii::app()->createUrl('/requests/offline/view/'.$data->id) ?>">
        <i class="alarm-icon"></i>
        <h5>
            درخواست فوری جدید
            <small dir="ltr" class="text-right"><?= TextMessagesReceive::SplitPhoneNumber($data->sender, false) ?></small>
        </h5>
    </a>
</div>
