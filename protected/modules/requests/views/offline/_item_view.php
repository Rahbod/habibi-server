<?php
/** @var $data TextMessagesReceive */
?>

<tr data-max="<?= $data->getMaxID() ?>">
    <td><b style='color: #007fff'><?= TextMessagesReceive::ShowPhoneNumber($data->sender) ?></b></td>
    <td><?= "<b dir='ltr'>".JalaliDate::date("Y/m/d H:i", $data->create_date)."</b>" ?></td>
    <td class="text-center"><span class='label label-<?= $data->getStatusLabel(true) ?>'><?= $data->getStatusLabel() ?></span></td>
    <td class="text-center"><?= CHtml::link('بررسی درخواست', Yii::app()->createUrl('/requests/offline/view/'.$data->id),[
            'class' => 'btn btn-xs btn-info'
        ]) ?></td>
    <td class="text-center"><?= CHtml::link('حذف درخواست', Yii::app()->createUrl('/requests/offline/delete/'.$data->id),[
            'class' => 'btn btn-xs btn-danger'
        ]) ?></td>
</tr>
