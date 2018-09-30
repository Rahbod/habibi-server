<?php
/* @var $this ContactDepartmentController */
/* @var $model ContactDepartment */

$this->breadcrumbs=array(
	'بخش های تماس'=>array('index'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'نمایش بخش های تماس', 'url'=>array('admin')),
	array('label'=>'ایجاد بخش جدید', 'url'=>array('create')),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">ویرایش بخش #<?php echo $model->title; ?></h3>
		<a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
		   onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
		   class="btn btn-danger btn-sm">حذف بخش</a>
		<a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
			<span class="hidden-xs">بازگشت</span>
			<i class="fa fa-arrow-left"></i>
		</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>