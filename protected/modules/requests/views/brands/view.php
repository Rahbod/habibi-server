<?php
/* @var $this RequestsBrandsController */
/* @var $model Brands */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست Brands', 'url'=>array('index')),
	array('label'=>'افزودن Brands', 'url'=>array('create')),
	array('label'=>'ویرایش Brands', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Brands', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Brands', 'url'=>array('admin')),
);
?>

<h1>نمایش Brands #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'logo',
		'title',
		'slug',
		'type',
	),
)); ?>
