<?php
/* @var $this ContactReceiversController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contact Receivers',
);

$this->menu=array(
	array('label'=>'ایجاد ContactReceivers', 'url'=>array('create')),
	array('label'=>'نمایش ContactReceivers', 'url'=>array('admin')),
);
?>

<h1>Contact Receivers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
