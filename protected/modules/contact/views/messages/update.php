<?php
/* @var $this ContactMessagesController */
/* @var $model ContactMessages */

$this->breadcrumbs=array(
	'Contact Messages'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'نمایش ContactMessages', 'url'=>array('admin')),
	array('label'=>'ایجاد ContactMessages', 'url'=>array('create')),
);
?>

<h1>ویرایش ContactMessages <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>