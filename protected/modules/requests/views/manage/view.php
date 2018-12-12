<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
/* @var $form CActiveForm */

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
            نمایش درخواست  <?= $model->user->userDetails->getShowName() ?>

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

        <?php if($model->status == Requests::STATUS_OPERATOR_CHECKING):?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'manage-form',
                        'enableAjaxValidation'=>false,
                        'enableClientValidation'=>true,
                    )); ?>

                    <?php echo $form->errorSummary($model);?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <?php echo $form->labelEx($model,'service_date'); ?>
                                <?php
                                $serviceDate = $model->service_date;
                                $serviceTime = $model->service_time;
                                $model->service_date = $model->requested_date;
                                $model->service_time = $model->requested_time;
                                ?>
                                <?php $this->widget('ext.PDatePicker.PDatePicker', array(
                                    'id'=>'service_date',
                                    'model' => $model,
                                    'attribute' => 'service_date',
                                    'options'=>array(
                                        'format'=>'YYYY/MM/DD',
                                    ),
                                    'htmlOptions'=>array(
                                        'class'=>'form-control'
                                    ),
                                ));?>
                                <?php echo $form->error($model,'service_date'); ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <?php echo $form->labelEx($model,'service_time'); ?>
                                <?php echo $form->dropDownList($model,'service_time',Requests::$serviceTimes,array('class'=>'form-control')); ?>
                                <?php echo $form->error($model,'service_time'); ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <?php echo $form->labelEx($model,'repairman_id'); ?>
                                <?php echo $form->dropDownList($model,'repairman_id',
                                    Users::getUsersByRole('repairman', true),
                                    array(
                                        'class'=>'form-control select-picker',
                                        'data-live-search' => true,
                                        'prompt' => 'تعمیرکار را انتخاب کنید...'
                                    )
                                ); ?>
                                <?php echo $form->error($model,'repairman_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'صدور فاکتور' : 'ویرایش',array('class' => 'btn btn-success')); ?>
                    </div>
                    <?php
                    $model->service_date = $serviceDate;
                    $model->service_time = $serviceTime;
                    ?>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        <?php endif;?>

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
                    'value' => $model->requested_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d', $model->requested_date)."</span>":null,
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('requested_time'),
                    'value' => $model->requested_time?Requests::$serviceTimes[$model->requested_time]:null,
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('service_date'),
                    'value' => $model->service_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d', $model->service_date)."</span>":null,
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