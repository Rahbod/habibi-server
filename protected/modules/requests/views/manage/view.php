<?php
/* @var $this RequestsManageController */
/* @var $model Requests */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'لیست Requests', 'url'=>array('index')),
	array('label'=>'افزودن Requests', 'url'=>array('create')),
	array('label'=>'ویرایش Requests', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Requests', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Requests', 'url'=>array('admin')),
);
?>

<h1>نمایش Requests #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category_id',
		'brand_id',
		'model_id',
		'user_id',
		'user_address_id',
		'operator_id',
		'repairman_id',
		'create_date',
		'modified_date',
		'description',
		'requested_date',
		'requested_time',
		'service_date',
		'service_time',
		'status',
	),
)); ?>
