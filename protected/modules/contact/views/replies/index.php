<?php
/* @var $this ContactRepliesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contact Replies',
);

$this->menu=array(
	array('label'=>'ایجاد ContactReplies', 'url'=>array('create')),
	array('label'=>'نمایش ContactReplies', 'url'=>array('admin')),
);
?>

<h1>Contact Replies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
