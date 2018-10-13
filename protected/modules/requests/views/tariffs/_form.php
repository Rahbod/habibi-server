<?php
/* @var $this RequestsTariffsController */
/* @var $model Tariffs */
/* @var $form CActiveForm */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?><?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tariffs-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('class'=>'form-control','size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'cost'); ?>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="input-group">
                    <?php echo $form->textField($model,'cost',array('class'=>'form-control digitFormat','size'=>10,'maxlength'=>10)); ?>
                    <span class="input-group-addon">تومان</span>
                </div>
            </div>
        </div>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
