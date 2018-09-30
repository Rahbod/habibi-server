<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $request DealershipRequests*/
/* @var $form CActiveForm */
/* @var $avatar array */
?>

<div class="form">

<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>true,
)); ?>
	<?php if($request): ?>
		<div class="form-group well">
			<h5>اطلاعات ثبت کننده درخواست</h5>
			<p>نام ثبت کننده: <?= $request->creator_name ?></p>
			<button type="button" class="btn btn-primary"><b>شماره تماس: <?= Controller::parseNumbers($request->creator_mobile) ?></b> <i class="fa fa-phone"></i></button>
			<a onclick="if(!confirm('آیا از حذف این درخواست اطمینان دارید؟')) return false;" href="<?= $this->createUrl('/users/manage/deleteDealershipRequest/'.$request->id) ?>" class="btn btn-danger pull-left"><i class="fa fa-trash"></i> حذف درخواست</a>
		</div>
	<?php endif; ?>
	<p class="note">فیلد های <span class="required">*</span>دار اجباری هستند.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'dealership_name'); ?>
		<?php echo $form->textField($model,'dealership_name',array('maxlength'=>50,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'dealership_name'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'first_name'); ?> (مدیر)
		<?php echo $form->textField($model,'first_name',array('maxlength'=>50,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'last_name'); ?> (مدیر)
		<?php echo $form->textField($model,'last_name',array('maxlength'=>50,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'mobile'); ?>
        <?php echo $form->textField($model,'mobile',array('maxlength'=>11,'class' => 'form-control')); ?>
        <?php echo $form->error($model,'mobile'); ?>
    </div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('maxlength'=>11,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'state_id'); ?>
		<?php echo $form->dropDownList($model,'state_id', Towns::model()->getTowns(),array(
			'class'=>'form-control select-picker',
			'data-live-search' => true,
			'prompt' => $model->getAttributeLabel('state_id'),
		)); ?>
		<?php echo $form->error($model,'state_id'); ?>
	</div>
    <div class="form-group">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('maxlength'=>1000,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

    <?php if($model->isNewRecord):?>
        <div class="form-group">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>100,'class' => 'form-control')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'repeatPassword'); ?>
            <?php echo $form->passwordField($model,'repeatPassword',array('size'=>60,'maxlength'=>100,'class' => 'form-control')); ?>
            <?php echo $form->error($model,'repeatPassword'); ?>
        </div>
    <?php endif;?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'avatar'); ?>
        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderFile',
            'model' => $model,
            'name' => 'avatar',
            'maxFiles' => 1,
            'maxFileSize' => 2, //MB
            'url' => $this->createUrl('/users/manage/upload'),
            'deleteUrl' => $this->createUrl('/users/manage/deleteUpload'),
            'acceptedFiles' => '.jpeg, .jpg, .png',
            'serverFiles' => $avatar,
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
    </div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->