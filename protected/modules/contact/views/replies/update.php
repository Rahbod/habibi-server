<?php
/* @var $this ContactRepliesController */
/* @var $model ContactReplies */

$this->breadcrumbs=array(
	'Contact Replies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'نمایش ContactReplies', 'url'=>array('admin')),
	array('label'=>'ایجاد ContactReplies', 'url'=>array('create')),
);
?>

<h1>ویرایش ContactReplies <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>