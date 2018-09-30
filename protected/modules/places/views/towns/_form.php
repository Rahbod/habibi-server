<?php
/* @var $this PlacesTownsController */
/* @var $model Towns */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'towns-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class' => 'form-control',	'size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('class' => 'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
        <span class="desc">انگلیسی وارد شود</span>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'tags'); ?>

        <?php
        $this->widget("ext.tagIt.tagIt",array(
            'model' => $model,
            'attribute' => 'tags',
            'suggestType' => 'json',
            'suggestUrl' => Yii::app()->createUrl('/advertises/tags/list'),
            'data' => $model->tags,
            'placeholder' => 'تایپ کنید و کلید Enter را بزنید یا از لیست انتخاب کنید ...'
        ));
        Yii::app()->clientScript->registerCss('tag-it' ,'
            ul.tagit li.tagit-new{
                width:300px;
            }
        ');
        ?>
        <?php echo $form->error($model,'tags'); ?>
    </div>


    <div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>