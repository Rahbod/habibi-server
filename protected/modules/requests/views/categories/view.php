<?php
/* @var $this RequestsCategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست Categories', 'url'=>array('index')),
	array('label'=>'افزودن Categories', 'url'=>array('create')),
	array('label'=>'ویرایش Categories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Categories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Categories', 'url'=>array('admin')),
);
?>

<h1>نمایش Categories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'logo',
	),
)); ?>
