<?php
/* @var $this RequestsBrandsController */
/* @var $model Models */
/* @var $image UploadedFiles */

$this->breadcrumbs=array(
	'مدیریت برند ها'=>array('admin'),
	'مدیریت مدل های '.$model->brand->title=>array('brands/models/'.$model->brand_id),
	$model->title,
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش مدل <?php echo $model->title; ?></h3>
        <a href="<?= $this->createUrl('modelDelete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">
            <i class="fa fa-remove"></i>
            <span class="hidden-xs">حذف مدل</span>
        </a>
        <a href="<?= $this->createUrl('brands/models/'.$model->brand_id) ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_model_form', array(
            'model'=>$model
        )); ?>
    </div>
</div>
