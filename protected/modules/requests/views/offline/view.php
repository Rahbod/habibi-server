<?php
/* @var $this RequestsOfflineController */
/* @var $model TextMessagesReceive */

$this->breadcrumbs=array(
    'مدیریت'=>array('admin'),
    $model->id,
);

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            نمایش درخواست فوری #<?= $model->id ?>
        </h3>
        <a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
            بازگشت
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'itemCssClass'=>array('',''),
            'htmlOptions' => array('class'=>'detail-view table table-striped'),
            'attributes'=>array(
                [
                    'name' => 'sender',
                    'value' => function($data){
                        return "<b style='color: #007fff'>".TextMessagesReceive::ShowPhoneNumber($data->sender)."</b>";
                    },
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('create_date'),
                    'value' => "<b><span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->create_date)."</span></b>",
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('operator_id'),
                    'value' => $model->operator?$model->operator->name_family:'<span class="text-danger">حذف شده</span>',
                    'type' => 'raw'
                ],
            ),
        )); ?>
    </div>
</div>