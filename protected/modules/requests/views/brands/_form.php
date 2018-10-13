<?php
/* @var $this RequestsBrandsController */
/* @var $model Brands */
/* @var $logo UploadedFiles */
/* @var $form CActiveForm */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brands-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'logo'); ?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderLogo',
			'model' => $model,
			'name' => 'logo',
			'maxFiles' => 1,
			'maxFileSize' => 0.5, //MB
			'url' => Yii::app()->createUrl('/requests/brands/upload'),
			'deleteUrl' => Yii::app()->createUrl('/requests/brands/deleteUpload'),
			'acceptedFiles' => '.jpg, .jpeg, .png',
			'serverFiles' => $logo,
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
		<?php echo $form->error($model,'logo'); ?>
		<div class="uploader-message error"></div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList($model,'country_id', Countries::getList(),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
