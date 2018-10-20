<?php
/** @var $data TextMessagesReceive */
?>

<div class="push-item emergency" data-max="<?= $data->getMaxID() ?>">
    <a href="<?= Yii::app()->createUrl('/requests/offline/view/'.$data->id.'?pending') ?>">
        <i class="alarm-icon"></i>
        <h5>
            درخواست اورژانس جدید
            <small><?= $data->category?$data->category->title:"-" ?></small>
        </h5>
    </a>
</div>
