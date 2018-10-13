<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    )
)); ?>
    <?php
    echo $form->errorSummary($model)
    ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('class'=>"form-control",'size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'first_name'); ?>
        <?php echo $form->textField($model,'first_name',array('class'=>"form-control"));?>
        <?php echo $form->error($model,'first_name'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'last_name'); ?>
        <?php echo $form->textField($model,'last_name',array('class'=>"form-control"));?>
        <?php echo $form->error($model,'last_name'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'mobile'); ?>
        <?php echo $form->telField($model,'mobile',array('class'=>"form-control",'maxLength' => 11));?>
        <?php echo $form->error($model,'mobile'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->emailField($model,'email',array('class'=>"form-control ltr text-right"));?>
        <?php echo $form->error($model,'email'); ?>
    </div>
<!--    <div class="form-group">-->
<!--        --><?php //echo $form->labelEx($model,'password'); ?>
<!--        --><?php //echo $form->passwordField($model,'password',array('class'=>"form-control"));?>
<!--        --><?php //echo $form->error($model,'password'); ?>
<!--    </div>-->
<!---->
<!--    <div class="form-group">-->
<!--        --><?php //echo $form->labelEx($model,'repeatPassword'); ?>
<!--        --><?php //echo $form->passwordField($model,'repeatPassword',array('class'=>"form-control"));?>
<!--        --><?php //echo $form->error($model,'repeatPassword'); ?>
<!--    </div>-->
    
<!--	<div class="form-group">-->
<!--		--><?php //echo $form->labelEx($model,'roles'); ?>
<!--		--><?php //echo $form->textField($model,'roles',array('size'=>60,'maxlength'=>100)); ?>
<!--		--><?php //echo $form->error($model,'roles'); ?>
<!--	</div>-->

	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->