<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $form CActiveForm */
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
            'action' => Yii::app()->createUrl('/users/public/changePassword'),
            'htmlOptions' => array('class' => 'inline-form'),
            'enableAjaxValidation'=>false,
        )); ?>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo $form->labelEx($model,'oldPassword'); ?>
                        <?php echo $form->passwordField($model,'oldPassword',array('placeholder'=>$model->getAttributeLabel('oldPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                        <?php echo $form->error($model,'oldPassword'); ?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo $form->labelEx($model,'newPassword'); ?>
                        <?php echo $form->passwordField($model,'newPassword',array('placeholder'=>$model->getAttributeLabel('newPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                        <?php echo $form->error($model,'newPassword'); ?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo $form->labelEx($model,'repeatPassword'); ?>
                        <?php echo $form->passwordField($model,'repeatPassword',array('placeholder'=>$model->getAttributeLabel('repeatPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                        <?php echo $form->error($model,'repeatPassword'); ?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo CHtml::submitButton('تغییر کلمه عبور',array('class'=>'btn btn-success pull-left')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>