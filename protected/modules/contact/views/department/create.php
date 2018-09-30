<?php
/* @var $this ContactDepartmentController */
/* @var $model ContactDepartment */

$this->breadcrumbs=array(
	'بخش های تماس'=>array('admin'),
	'ایجاد',
);
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">ایجاد بخش جدید</h3>
		<a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
			<span class="hidden-xs">بازگشت</span>
			<i class="fa fa-arrow-left"></i>
		</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>