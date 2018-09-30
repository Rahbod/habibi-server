<?php
/* @var $this ContactReceiversController */
/* @var $model ContactReceivers */

$this->breadcrumbs=array(
	'Contact Receivers'=>array('admin'),
	'ایجاد',
);

$this->menu=array(
	array('label'=>'نمایش', 'url'=>array('admin')),
);
$dep = '';
if(isset($_GET['ContactMessages']['department_id']))
	$dep = (int)$_GET['ContactMessages']['department_id'];
$model->department_id = $dep;
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">ایجاد دریافت کننده</h3>
		<a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
			<span class="hidden-xs">بازگشت</span>
			<i class="fa fa-arrow-left"></i>
		</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>