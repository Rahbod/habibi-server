<?php
/* @var $this UsersManageController */
/* @var $model CooperationRequests */

$this->breadcrumbs=array(
    'مدیریت درخواست های همکاری' => array('cooperationRequests'),
    'نمایش درخواست '.$model->id
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            نمایش درخواست همکاری #<?= $model->id ?>
        </h3>
        <a href="<?= $this->createUrl('cooperationRequests') ?>" class="btn btn-primary btn-sm pull-left">
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
                    'name' => 'mobile',
                    'value' => function($data){
                        return "<b style='color: #007fff'>".TextMessagesReceive::ShowPhoneNumber($data->mobile)."</b>";
                    },
                    'type' => 'raw'
                ],
                [
                    'label' => $model->getAttributeLabel('create_date'),
                    'value' => "<b><span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->create_date)."</span></b>",
                    'type' => 'raw'
                ],
                'first_name',
                'last_name',
            ),
        )); ?>
    </div>
</div>