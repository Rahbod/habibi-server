<?php
/* @var $this UsersManageController */
/* @var $model DealershipRequests */

$this->breadcrumbs=array(
    'نمایشگاه ها'=>array('dealerships'),
    'مدیریت درخواست های ثبت نمایشگاه ها'=>array('dealershipRequests'),
    'نمایشگاه '. $model->dealership_name,
    'نمایش',
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">نمایش اطلاعات درخواست نمایشگاه <?= $model->dealership_name ?></h3>
        <a href="<?= $this->createUrl('dealerships') ?>" class="btn btn-default btn-sm">مدیریت نمایشگاه ها</a>
        <a href="<?= $this->createUrl('dealershipRequests') ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
            <h4 style="display: block; overflow: hidden">
                <button class="btn btn-primary"><b>شماره تماس: <?= Controller::parseNumbers($model->creator_mobile) ?></b> <i class="fa fa-phone"></i></button>
                <a href="<?= $this->createUrl('/users/manage/createDealership/'.$model->id) ?>" class="btn btn-success"><i class="fa fa-car"></i> ثبت نمایشگاه</a>
                <a onclick="if(!confirm('آیا از حذف این درخواست اطمینان دارید؟')) return false;" href="<?= $this->createUrl('/users/manage/deleteDealershipRequest/'.$model->id) ?>" class="btn btn-danger pull-left"><i class="fa fa-trash"></i> حذف درخواست</a>
            </h4>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'htmlOptions' => array('class' => 'table table-striped'),
            'attributes'=>array(
                array(
                    'name' => 'create_date',
                    'type' => 'raw',
                    'value' => "<div class='ltr text-danger text-right'>".JalaliDate::date('Ym/d/ H:i', $model->create_date)."</div>"
                ),
                array(
                    'name' => 'dealership_name',
                    'type' => 'raw',
                    'value' => "<b>{$model->dealership_name}</b>"
                ),
                'manager_name',
                'manager_last_name',
                'creator_name',
                array(
                    'name' => 'creator_mobile',
                    'type' => 'raw',
                    'value' => "<b>".Controller::parseNumbers($model->creator_mobile)."</b>"
                ),
                'email',
                'phone',
                'address:html',
                'description:html',
            ),
        )); ?>
    </div>
</div>