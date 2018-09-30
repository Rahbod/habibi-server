<?php
/* @var $form CActiveForm */
if(!isset($loading_parent) || empty($loading_parent))
    $loading_parent = false;
?>
<div class="icon-box">
    <div class="icon-inner-box">
        <span class="circle-border">
            <i class="svg-icons user-icon"></i>
        </span>
    </div>
</div>
<div class="button-box">
    <p>تازه وارد هستید؟
        برای ثبت آگهی خود ثبت‌نام کنید</p>
    <div class="register-form">
        <?php
        $model = new Users;
        $model->scenario = 'register';
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'users-register-modal-form',
            'action' => array('/users/public/register'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions'=>array(
                'onsubmit' => 'return false;'
            ),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate'=>'js:function(form,data,hasError){
                    if(!hasError){
                        $.ajax({
                            "type":"POST",
                            "url":"'.CHtml::normalizeUrl(array("/users/public/register/?ajax=users-register-modal-form")).'",
                            "data":form.serialize(),
                            "dataType" : "json",
                            "beforeSend":function(){
                                '.($loading_parent?'$("'.$loading_parent.' .loading-container").show();':'').'
                            },
                            "success":function(data){
                                if (typeof data === "object" && typeof data.status === \'undefined\') {
                                    $.each(data, function (key, value) {
                                        form.find("#" + key + "_em_").show().html(value.toString()).parent().removeClass(\'success\').addClass(\'error\');
                                    });
                                }
                                else if(data.status)
                                {
                                    $("#register-success").html(data.msg);
                                    $("#register-error").html("");
                                    document.getElementById("users-register-modal-form").reset();
                                    if(typeof data.url != \'undefined\')
                                        window.location = data.url;
                                }
                                else
                                    $("#register-error").html(data.msg);
                                $("#users-register-modal-form .captcha a").click();    
                                $("#users-register-modal-form #Users_verifyCode").val("");
                                '.($loading_parent?'$("'.$loading_parent.' .loading-container").hide();':'').'
                            },
                        });
                    }else
                    {
                        $("#users-register-modal-form .captcha a").click();    
                        $("#users-register-modal-form #Users_verifyCode").val(""); 
                    }
                }'
        ))); ?>
        <p id="register-error" class="errorMessage"></p>
        <p id="register-success" class="text-success"></p>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->textField($model,'first_name',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('first_name')));?>
            <?php echo $form->error($model,'first_name'); ?>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->textField($model,'last_name',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('last_name')));?>
            <?php echo $form->error($model,'last_name'); ?>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->telField($model,'mobile',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('mobile')));?>
            <?php echo $form->error($model,'mobile'); ?>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->emailField($model,'email',array('class'=>"form-control ltr text-right",'placeholder'=>$model->getAttributeLabel('email')));?>
            <?php echo $form->error($model,'email'); ?>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->passwordField($model,'password',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('password')));?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->passwordField($model,'repeatPassword',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('repeatPassword')));?>
            <?php echo $form->error($model,'repeatPassword'); ?>
        </div>

        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->textField($model, 'verifyCode',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('verifyCode'))); ?>
            <?php echo $form->error($model,'verifyCode'); ?>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 text-nowrap captcha">
            <?php $this->widget('CCaptcha',array(
                'captchaAction' => '/users/public/captcha',
            )); ?>
        </div>

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="submit" class="btn btn-custom green next-in pull-left">
                ساخت حساب کاربری
                <span class="next-span"><i class="icon-chevron-left"></i></span>
            </button>
            <a href="#" class="gray-link pull-right text-underline text-right" data-toggle="tab" data-target="#login-modal-login-tab">ورود به حساب کاربری</a>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>