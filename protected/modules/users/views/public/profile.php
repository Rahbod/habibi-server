<?php
/* @var $this UsersPublicController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
/* @var $avatar array */

$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>
<div class="content-box white-bg">
    <div class="center-box">
        <?php $this->renderPartial('//partial-views/_flashMessage');?>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'users-form',
            'htmlOptions' => array('class' => 'inline-form'),
            'enableAjaxValidation'=>true,
        )); ?>

        <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php echo $form->labelEx($model,'avatar'); ?>
                <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                    'id' => 'avatar-uploader',
                    'model' => $model,
                    'name' => 'avatar',
                    'maxFiles' => 1,
                    'maxFileSize' => 1, //MB
                    'url' => Yii::app()->createUrl('/users/public/upload'),
                    'deleteUrl' => Yii::app()->createUrl('/users/public/deleteUpload'),
                    'acceptedFiles' => '.jpg, .jpeg, .png',
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
                <div class="uploader-message error"></div>
                <?php echo $form->error($model,'avatar'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->labelEx($model,'first_name'); ?>
                <?php echo $form->textField($model,'first_name',array('placeholder'=>$model->getAttributeLabel('first_name').' *','class'=>'form-control','maxlength'=>50)); ?>
                <?php echo $form->error($model,'first_name'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->labelEx($model,'last_name'); ?>
                <?php echo $form->textField($model,'last_name',array('placeholder'=>$model->getAttributeLabel('last_name').' *','class'=>'form-control','maxlength'=>50)); ?>
                <?php echo $form->error($model,'last_name'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->labelEx($model,'phone'); ?>
                <?php echo $form->textField($model,'phone',array('placeholder'=>$model->getAttributeLabel('phone'),'class'=>'form-control','maxlength'=>11)); ?>
                <?php echo $form->error($model,'phone'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->labelEx($model,'mobile'); ?>
                <?php echo $form->textField($model,'mobile',array('placeholder'=>$model->getAttributeLabel('mobile').' *','class'=>'form-control','maxlength'=>11)); ?>
                <?php echo $form->error($model,'mobile'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->labelEx($model,'zip_code'); ?>
                <?php echo $form->textField($model,'zip_code',array('placeholder'=>$model->getAttributeLabel('zip_code'),'class'=>'form-control','maxlength'=>10)); ?>
                <?php echo $form->error($model,'zip_code'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->labelEx($model,'address'); ?>
                <?php echo $form->textArea($model,'address',array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('address'),'maxlength'=>1000)); ?>
                <?php echo $form->error($model,'address'); ?>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php echo CHtml::submitButton('ذخیره',array('class'=>'btn btn-success pull-left')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>