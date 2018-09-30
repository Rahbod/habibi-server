<?php
/* @var $this ContactReceiversController */
/* @var $model ContactReceivers */

$this->breadcrumbs=array(
	'Contact Receivers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'ایجاد ContactReceivers', 'url'=>array('create')),
	array('label'=>'ویرایش ContactReceivers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف ContactReceivers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'نمایش ContactReceivers', 'url'=>array('admin')),
);
?>

<h1>View ContactReceivers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		'department_id',
	),
)); ?>
