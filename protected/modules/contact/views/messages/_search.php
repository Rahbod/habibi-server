<?php
/* @var $this ContactMessagesController */
/* @var $model ContactMessages */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="form-group">
		<?php echo $form->label($model,'department_id'); ?>
		<?php echo $form->dropDownList($model,'department_id',CHtml::listData(ContactDepartment::model()->findAll(),'id','title'), array('class' => 'form-control')); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton('جستجو',array('class' => 'btn btn-success')); ?>
	</div>
<?php $this->endWidget(); ?>