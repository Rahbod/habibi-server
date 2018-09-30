<?php
/* @var $this UsersPlansController */
/* @var $model Plans */

$this->breadcrumbs=array(
	'پلن ها'=>array('admin'),
	$model->title=>array('update','id'=>$model->id),
	'ویرایش',
);
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">ویرایش پلن <?php echo $model->title; ?></h3>
	</div>
	<div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>