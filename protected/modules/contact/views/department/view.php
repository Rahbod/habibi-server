<?php
/* @var $this ContactDepartmentController */
/* @var $model ContactDepartment */

$this->breadcrumbs=array(
	'Contact Departments'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'ایجاد ContactDepartment', 'url'=>array('create')),
	array('label'=>'ویرایش ContactDepartment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف ContactDepartment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'نمایش ContactDepartment', 'url'=>array('admin')),
);
?>

<h1>View ContactDepartment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
	),
)); ?>
