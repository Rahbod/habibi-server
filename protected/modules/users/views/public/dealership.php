<?php
/* @var $this UsersPublicController */
/* @var $model DealershipRequestForm */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/bootstrap-select.min.css');
$cs->registerScriptFile($baseUrl.'/js/bootstrap-select.min.js', CClientScript::POS_END);
?>
<div class="content-box white-bg">
    <div class="center-box">
        <div class="row">
            <div class="tab-content relative">
                <div class="register-form auth-tab">
                    <h4 class="title text-center">ثبت نام نمایشگاه</h4>
                    <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2 register-box">
                        <?php
                        $loading_parent = '.tab-content';
                        ?>
                        <div class="icon-box">
                            <div class="icon-inner-box">
                                <i class="svg-mini-car-white"></i>
                            </div>
                        </div>
                        <div class="button-box">
                            <?php
                            $this->renderPartial('//partial-views/_loading');
                            ?>
                            <div class="text-right"><?php $this->renderPartial('//partial-views/_flashMessage'); ?></div>
                            <p style="margin-bottom: 15px">این فرم جهت ثبت درخواست شما فراهم شده و فقط توسط کارشناسان تیم آرا قابل مشاهده است.</p>
                            <?php
                            Yii::app()->user->returnUrl = Yii::app()->request->url;
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'dealership-form',
                                'enableAjaxValidation' => false,
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    'afterValidate'=>'js:function(form,data,hasError){
                                        $("#dealership-form .captcha a").click();    
                                        $("#dealership-form #DealershipRequestForm_verifyCode").val("");
                                        if(!hasError){
                                            '.($loading_parent?'$("'.$loading_parent.' .loading-container").show();':'').'
                                             return true;
                                            /*$.ajax({
                                                "type":"POST",
                                                "url":"'.CHtml::normalizeUrl(array("/login/?ajax=users-login-form")).'",
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
                                                        window.location = data.url;
                                                        $("#login-submit-btn").val(data.msg);
                                                    }
                                                    else
                                                        $("#login-error").html(data.msg);
                                                    '.($loading_parent?'$("'.$loading_parent.' .loading-container").hide();':'').'
                                                },
                                            });*/
                                        }
                                    }'
                                )
                            )); ?>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->textField($model,'dealership_name',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('dealership_name')));?>
                                <?php echo $form->error($model,'dealership_name'); ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->dropDownList($model,'state_id', Towns::model()->getTowns(),array(
                                    'class'=>'form-control select-picker',
                                    'data-live-search' => true,
                                    'prompt' => $model->getAttributeLabel('state_id'),
                                )); ?>
                                <?php echo $form->error($model,'state_id'); ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->textField($model,'manager_name',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('manager_name')));?>
                                <?php echo $form->error($model,'manager_name'); ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->textField($model,'manager_last_name',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('manager_last_name')));?>
                                <?php echo $form->error($model,'manager_last_name'); ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->textField($model,'creator_name',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('creator_name')));?>
                                <?php echo $form->error($model,'creator_name'); ?>
                            </div>
            
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->textField($model,'creator_mobile',array('class'=>"form-control numberFormat", 'maxLength' => 11,'placeholder'=>$model->getAttributeLabel('creator_mobile')));?>
                                <?php echo $form->error($model,'creator_mobile'); ?>
                            </div>
                            
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->textField($model,'phone',array('class'=>"form-control numberFormat", 'maxLength' => 11, 'placeholder'=>$model->getAttributeLabel('phone')));?>
                                <?php echo $form->error($model,'phone'); ?>
                            </div>
            
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php echo $form->emailField($model,'email',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('email')));?>
                                <?php echo $form->error($model,'email'); ?>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->textArea($model,'address',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('address')));?>
                                <?php echo $form->error($model,'address'); ?>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->textArea($model,'description',array('class'=>"form-control",'placeholder'=>$model->getAttributeLabel('description')));?>
                                <?php echo $form->error($model,'description'); ?>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px">
                                <button type="submit" class="btn btn-custom green next-in pull-left" id="login-submit-btn">
                                    ارسال درخواست
                                    <span class="next-span"><i class="icon-chevron-left"></i></span>
                                </button>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('clear-inputs', '
    $("#dealership-form .captcha a").click();    
    $("#dealership-form #DealershipRequestForm_verifyCode").val("");
',CClientScript::POS_LOAD);