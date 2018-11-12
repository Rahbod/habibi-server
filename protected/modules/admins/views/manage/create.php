<?php
/* @var $this AdminsManageController */
/* @var $model Admins */

if(isset($_GET['role']) && $_GET['role'] == 3)
    $this->breadcrumbs=array(
        'مدیریت اپراتورها'=>array('admin?role=3'),
        'افزودن اپراتور',
    );
else
    $this->breadcrumbs=array(
        'مدیریت مدیران'=>array('admin'),
        'افزودن مدیر',
    );
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن <?= isset($_GET['role']) && $_GET['role'] == 3?'اپراتور':'مدیر' ?></h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>