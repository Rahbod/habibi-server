<?php
/* @var $this RequestsCategoriesController */
/* @var $model Categories */
/* @var $logo UploadedFiles */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش Categories <?php echo $model->id; ?></h3>
        <a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">حذف نوع لوازم</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model, 'logo' => $logo)); ?>
    </div>
</div>
