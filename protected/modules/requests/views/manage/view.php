<?php
/* @var $this RequestsManageController */
/* @var $model Requests */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$query = '';
if (isset($_GET['pending']))
    $query = '?pending';

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            نمایش درخواست #<?= $model->id ?>

            <?php if($model->status): ?>
                <label class='label label-<?= $model->getStatusLabel(true) ?>'><?= $model->getStatusLabel() ?></label>
            <?php endif; ?>
        </h3>
    </div>
    <div class="box-body">

        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>

        <div class="form-group buttons text-left">
            <!-- Invoicing -->
            <?php if($model->status >= Requests::STATUS_CONFIRMED && $model->status <= Requests::STATUS_AWAITING_PAYMENT): ?>
                <a href="<?= $this->createUrl('invoicing')."/$model->id" ?>" class="btn btn-info">صدور فاکتور</a>
            <?php endif; ?>

            <!-- Manually Approve Payment -->
            <?php if($model->status == Requests::STATUS_AWAITING_PAYMENT): ?>
                <a href="<?= $this->createUrl('approvePayment')."/$model->id" ?>" class="btn btn-warning" onclick='if(!confirm("آیا از تایید پرداخت فاکتور اطمینان دارید؟")) return false;'>تایید پرداخت نقدی</a>
            <?php endif; ?>

            <?php if($model->status < Requests::STATUS_PAID): ?>
                <?php if($model->status != Requests::STATUS_DELETED): ?>
                        <a href="<?= $this->createUrl('delete')."/$model->id{$query}" ?>" class="btn btn-danger" onclick='if(!confirm("آیا از حذف این درخواست اطمینان دارید؟")) return false;'>انتقال به زباله دان</a>
                <?php else: ?>
                    <a href="<?= $this->createUrl('delete')."/$model->id{$query}" ?>" class="btn btn-danger" onclick='if(!confirm("آیا از حذف این درخواست اطمینان دارید؟")) return false;'>حذف کامل</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'itemCssClass'=>array('',''),
            'htmlOptions' => array('class'=>'detail-view table table-striped'),
            'attributes'=>array(
                'id',
                [
                    'label' => $model->getAttributeLabel('category_id'),
                    'value' => $model->category?$model->category->title:'<span class="text-danger">حذف شده</span>',
                ],
                [
                    'label' => $model->getAttributeLabel('user_id'),
                    'value' => $model->user && $model->user->userDetails?$model->user->userDetails->getShowName():'<span class="text-danger">حذف شده</span>',
                ],
                [
                    'label' => $model->getAttributeLabel('user_address_id'),
                    'value' => $model->userAddress?$model->userAddress->showAddress():'<span class="text-danger">حذف شده</span>',
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('operator_id'),
                    'value' => $model->operator?$model->operator->name_family:'<span class="text-danger">حذف شده</span>',
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('repairman_id'),
                    'value' => $model->repairman_id?($model->repairman && $model->repairman->userDetails?$model->repairman->userDetails->getShowName(false):'<span class="text-danger">حذف شده</span>'):null,
                    'type' => 'raw'
                ],

                [
                    'label' => $model->getAttributeLabel('requested_date'),
                    'value' => $model->requested_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->requested_date)."</span>":null,
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('requested_time'),
                    'value' => $model->requested_time?Requests::$serviceTimes[$model->requested_time]:null,
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('service_date'),
                    'value' => $model->service_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->service_date)."</span>":null,
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('service_time'),
                    'value' => $model->service_time?Requests::$serviceTimes[$model->service_time]:null,
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('create_date'),
                    'value' => "<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->create_date)."</span>",
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('modified_date'),
                    'value' => "<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->modified_date)."</span>",
                    'type' => 'raw'
                ]
            ),
        )); ?>
    </div>
</div>