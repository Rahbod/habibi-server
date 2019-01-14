<?php
/* @var $this AdminsManageController */
/* @var $model Admins */
/* @var $actions array */

$this->breadcrumbs=array(
    'پیشخوان'=> array('/admins'),
    'مشتریان'=> array('/admins/manage'),
	'نقش مشتریان'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت نقش مشتریان', 'url'=>array('admin')),
);
?>

<h1>افزودن نقش</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'actions'=>$actions)); ?>