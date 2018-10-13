<?php
/* @var $this RequestsTariffsController */
/* @var $model Tariffs */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن Tariffs</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>	</div>
</div>