<?php
/* @var $this ContactRepliesController */
/* @var $model ContactReplies */

$this->breadcrumbs=array(
	'Contact Replies'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'ایجاد ContactReplies', 'url'=>array('create')),
	array('label'=>'ویرایش ContactReplies', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف ContactReplies', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'نمایش ContactReplies', 'url'=>array('admin')),
);
?>

<h1>View ContactReplies #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'message_id',
		'body',
		'date',
	),
)); ?>
