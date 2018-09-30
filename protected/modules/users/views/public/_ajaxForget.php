<?php
if(!isset($loading_parent) || empty($loading_parent))
    $loading_parent = false;
?>
<div class="icon-box">
    <div class="icon-inner-box">
        <i class="svg-icons mail-icon"></i>
    </div>
</div>
<div class="button-box">
    <p>رمز عبور خود را فراموش کرده اید؟
        لطفاً پست الکترونیکی خود را وارد کنید.
    </p>
    <?php
    $model2 = new UsersForgetPassword;
    Yii::app()->user->returnUrl = Yii::app()->request->url;
    $form2 = $this->beginWidget('CActiveForm', array(
        'id' => 'forgot-form',
        'action' => Yii::app()->createUrl('/users/public/forgetPassword'),
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
                        "url":"'.CHtml::normalizeUrl(array("/users/public/forgetPassword/?ajax")).'",
                        "data":form.serialize(),
                        "dataType" : "json",
                        "beforeSend":function(){
                            '.($loading_parent?'$("'.$loading_parent.' .loading-container").show();':'').'
                        },
                        "success":function(data){
                            if(data.state == 1)
                            {
                                $("#forgot-error").removeClass("errorMessage").addClass("successMessage").html(data.msg);
                                setTimeout(function(){
                                    window.location = data.url;
                                }, 2000);
                            }
                            else
                                $("#forgot-error").html(data.msg);
                            '.($loading_parent?'$("'.$loading_parent.' .loading-container").hide();':'').'
                        },
                    });
                }
            }'
        )
    )); ?>
    <p id="forgot-error" class="errorMessage"></p>
    <div class="form-group">
        <?php echo $form2->textField($model2, 'email', array('class' => 'ltr text-right form-control', 'placeholder' => 'پست الکترونیک')); ?>
        <?php echo $form2->error($model2, 'email'); ?>
    </div>
    <button type="submit" class="btn btn-custom blue next-in pull-left">
        بازیابی رمز عبور
        <span class="next-span"><i class="icon-chevron-left"></i></span>
    </button>
    <?php $this->endWidget(); ?>
    <a href="#" class="gray-link pull-left text-underline text-left" data-toggle="tab" data-target="#login-modal-login-tab">بازگشت</a>
</div>