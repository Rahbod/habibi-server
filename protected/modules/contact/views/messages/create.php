<?php
/* @var $this ContactMessagesController */
/* @var $model ContactMessages */

$this->breadcrumbs=array(
	'Contact Messages'=>array('admin'),
	'ایجاد',
);

$this->menu=array(
	array('label'=>'نمایش', 'url'=>array('admin')),
);
?>

<h1>ایجاد ContactMessages</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>