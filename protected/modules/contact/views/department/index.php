<?php
/* @var $this ContactDepartmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contact Departments',
);

$this->menu=array(
	array('label'=>'ایجاد ContactDepartment', 'url'=>array('create')),
	array('label'=>'نمایش ContactDepartment', 'url'=>array('admin')),
);
?>

<h1>Contact Departments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
