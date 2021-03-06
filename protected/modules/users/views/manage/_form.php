<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $avatar UploadedFiles */
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

    <?php if(!$model->isNewRecord):?>
        <div class="form-group">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->dropDownList($model,'status',$model->statusLabels); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>
    <?php endif; ?>

    <?php if($model->role_id == 2): ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'avatar'); ?>
        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderAvatar',
            'model' => $model,
            'name' => 'avatar',
            'maxFiles' => 1,
            'maxFileSize' => 0.5, //MB
            'url' => Yii::app()->createUrl('/users/manage/upload'),
            'deleteUrl' => Yii::app()->createUrl('/users/manage/deleteUpload'),
            'acceptedFiles' => '.jpg, .jpeg, .png',
            'serverFiles' => isset($avatar)?$avatar:[],
            'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-message").html("");
				}
				else{
					$(".uploader-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
        )); ?>
        <?php echo $form->error($model,'avatar'); ?>
        <div class="uploader-message error"></div>
    </div>
    <?php endif; ?>

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

    <?php if($model->role_id == 2): ?>
        <hr>
        <h4>اطلاعات کاری</h4>
        <div class="form-group">
            <?php echo CHtml::label('تخصص','expertise'); ?>
            <?php echo CHtml::textField('Users[additional_details][expertise]', $model->getAdditionalDetails('expertise'), array('class' => 'form-control')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('تجربه','experience'); ?>
            <?php echo CHtml::textField('Users[additional_details][experience]', $model->getAdditionalDetails('experience'), array('class' => 'form-control')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('توضیحات','description'); ?>
            <?php echo CHtml::textField('Users[additional_details][description]', $model->getAdditionalDetails('description'), array('class' => 'form-control')) ?>
        </div>
    <?php endif; ?>

	<div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->