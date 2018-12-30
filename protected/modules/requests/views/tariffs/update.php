<?php
/* @var $this RequestsTariffsController */
/* @var $model Tariffs */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش اجرت <?php echo $model->title; ?></h3>
        <a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">حذف اجرت</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>    </div>
</div>
