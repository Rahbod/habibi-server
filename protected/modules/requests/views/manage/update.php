<?php
/* @var $this RequestsManageController */
/* @var $model Requests */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش درخواست <?php echo $model->id; ?></h3>
        <a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">حذف درخواست</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>    </div>
</div>
