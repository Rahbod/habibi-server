<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $avatar UploadedFiles */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'مدیریت کاربران'=>array('admin'),
);

$this->menu=array(
	array('label'=>'لیست کاربران', 'url'=>array('admin')),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">تغییر وضعیت کاربر <?= $model->email ?></h3>
	</div>
	<div class="box-body">
        <?php $this->renderPartial('_form', compact('model', 'avatar')); ?>
	</div>
</div>