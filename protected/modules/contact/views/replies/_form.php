<?php
/* @var $this ContactRepliesController */
/* @var $model ContactReplies */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-replies-form',
	'action' => array('/contact/replies/create'),
	'enableAjaxValidation'=>false,
));
echo $form->hiddenField($model,'message_id');
?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows' => 7,'class'=>'ckeditor form-control')); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class' => 'btn btn-primary pull-left')); ?>
	</div>

<?php $this->endWidget(); ?>