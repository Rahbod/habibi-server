<?php
/* @var $this ContactRepliesController */
/* @var $model ContactReplies */

$this->breadcrumbs=array(
	'Contact Replies'=>array('admin'),
	'ایجاد',
);

$this->menu=array(
	array('label'=>'نمایش', 'url'=>array('admin')),
);
?>

<h1>ایجاد ContactReplies</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>