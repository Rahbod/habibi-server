<?php
/* @var $this RequestsTariffsController */
/* @var $model Tariffs */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست Tariffs', 'url'=>array('index')),
	array('label'=>'افزودن Tariffs', 'url'=>array('create')),
	array('label'=>'ویرایش Tariffs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Tariffs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Tariffs', 'url'=>array('admin')),
);
?>

<h1>نمایش Tariffs #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'description',
		'cost',
	),
)); ?>
