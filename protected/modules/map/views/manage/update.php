<?php
/* @var $this MapManageController */
/* @var $model GoogleMaps */

$this->breadcrumbs=array(
	'تعیین مکان روی نقشه'
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">تعیین مکان روی نقشه</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>