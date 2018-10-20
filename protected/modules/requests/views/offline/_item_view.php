<?php
/** @var $data Requests */
?>

<tr data-max="<?= $data->getMaxID() ?>">
    <td><?= $data->user && $data->user->userDetails?$data->user->userDetails->getShowName():"-" ?></td>
    <td><?= $data->category?$data->category->title:"-" ?></td>
    <td><?= "<b>".JalaliDate::date("Y/m/d H:i", $data->create_date)."</b>" ?></td>
    <td class="text-center"><?= $data->getRequestTypeLabel(true) ?></td>
    <td class="text-center"><?= CHtml::link('بررسی درخواست', Yii::app()->createUrl('/requests/manage/view/'.$data->id.'?pending'),[
            'class' => 'btn btn-xs btn-info'
        ]) ?></td>
    <td class="text-center"><?= CHtml::link('انتقال به زباله دان', Yii::app()->createUrl('/requests/manage/delete/'.$data->id.'/?pending'),[
            'class' => 'btn btn-xs btn-danger'
        ]) ?></td>
</tr>
