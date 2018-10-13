<?php
/* @var $this RequestsBrandsController */
/* @var $model Brands */
/* @var $logo UploadedFiles */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن برند جدید</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model, 'logo' => $logo)); ?>	</div>
</div>