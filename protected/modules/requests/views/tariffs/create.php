<?php
/* @var $this RequestsTariffsController */
/* @var $model Tariffs */
/* @var $type string */

$this->breadcrumbs=array(
	'مدیریت'=>array('tariffs/admin/'.$type),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن <?php echo $type == 'tariffs' ? 'اجرت' : 'قطعه'?> جدید</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model, 'type' => $type)); ?>	</div>
</div>