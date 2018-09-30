<?php
/* @var $this ContactMessagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contact Messages',
);

$this->menu=array(
	array('label'=>'ایجاد ContactMessages', 'url'=>array('create')),
	array('label'=>'نمایش ContactMessages', 'url'=>array('admin')),
);
?>

<h1>Contact Messages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
