<?php
/* @var $this RequestsManageController */
/* @var $model Requests */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن Requests</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>	</div>
</div>