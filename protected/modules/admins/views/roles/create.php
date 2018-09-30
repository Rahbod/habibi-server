<?php
/* @var $this AdminsManageController */
/* @var $model Admins */
/* @var $actions array */

$this->breadcrumbs=array(
    'پیشخوان'=> array('/admins'),
    'مدیران'=> array('/admins/manage'),
	'نقش مدیران'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت نقش مدیران', 'url'=>array('admin')),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن نقش</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model,'actions'=>$actions)); ?>
	</div>
</div>
		