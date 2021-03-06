<?php
/* @var $this PlacesCitiesController */
/* @var $model Places */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'places-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">فیلد های دارای <span class="required">*</span> الزامی هستند.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class' => 'form-control','size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>


    <div class="form-group">
        <?php echo $form->labelEx($model,'slug'); ?>
        <?php echo $form->textField($model,'slug',array('class' => 'form-control','size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'slug'); ?>
        <span class="desc">انگلیسی وارد شود</span>
    </div>

	<div class="form-group">
		<?php echo CHtml::label('استان',''); ?>
		<?php echo $form->dropDownList($model,'town_id',CHtml::listData(Towns::model()->findAll() ,'id','name'), array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'town_id'); ?>
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