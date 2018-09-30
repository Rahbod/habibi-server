<?php
/* @var $this MapsManageController */
/* @var $model GoogleMaps */

$this->breadcrumbs=array(
	'Google Maps'=>array('admin'),
	'ایجاد',
);

$this->menu=array(
	array('label'=>'نمایش', 'url'=>array('admin')),
);
?>

<h1>ایجاد GoogleMaps</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>