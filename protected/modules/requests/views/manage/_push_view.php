<?php
/** @var $data Requests */
?>

<div class="push-item" data-max="<?= $data->getMaxID() ?>">
    <a href="<?= Yii::app()->createUrl('/requests/manage/view/'.$data->id.'?pending') ?>">
        <i class="bell-icon"></i>
        <h5>
            درخواست جدید
            <small><?= $data->category?$data->category->title:"-" ?></small>
        </h5>
    </a>
</div>
