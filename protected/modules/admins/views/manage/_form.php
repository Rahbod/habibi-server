<?php
/* @var $this AdminsManageController */
/* @var $model Admins */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScript('resetForm','document.getElementById("admins-form").reset();');
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admins-form',
	'enableAjaxValidation'=>true,

)); ?>
    <div class="message"></div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>100 , 'class'=>'form-control', (!$model->isNewRecord?'disabled':'s') => true)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
    <?php
    if(!$model->isNewRecord){
    ?>
        <div class="form-group">
            <?php echo $form->labelEx($model,'oldPassword'); ?>
            <?php echo $form->passwordField($model,'oldPassword',array('size'=>50,'maxlength'=>100,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'oldPassword'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'newPassword'); ?>
            <?php echo $form->passwordField($model,'newPassword',array('size'=>50,'maxlength'=>100,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'newPassword'); ?>
        </div>
    <?php
    }else{
    ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>100,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

    <?php } ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'repeatPassword'); ?>
        <?php echo $form->passwordField($model,'repeatPassword',array('size'=>50,'maxlength'=>100,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'repeatPassword'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->emailField($model,'email',array('size'=>50,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'role_id'); ?>
        <?php echo $form->dropDownList($model,'role_id' ,CHtml::listData(  AdminRoles::model()->findAll('role <> "superAdmin"') , 'id' , 'name'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'role_id'); ?>
    </div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش', array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>