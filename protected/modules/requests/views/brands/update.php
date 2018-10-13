<?php
/* @var $this RequestsBrandsController */
/* @var $model Brands */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش برند <?php echo $model->title; ?></h3>
        <a href="<?= $this->createUrl('brands/models/'.$model->id) ?>" class="btn btn-warning btn-sm">
            <i class="fa fa-bars"></i>
            <span class="hidden-xs">لیست مدل ها</span>
        </a>
        <a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">
            <i class="fa fa-remove"></i>
            <span class="hidden-xs">حذف برند</span>
        </a>
        <a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model,
            'logo' => $logo)); ?>    </div>
</div>
