<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $address UserAddresses */
/* @var $form CActiveForm */
?>


<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">افزودن کاربر سریع</h3>
        <a href="<?= $this->createUrl($_GET['return']) ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('//partial-views/_flashMessage') ?>
        <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'users-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit' => true
            )
        )); ?>
            <?php echo $form->errorSummary($model) ?>
            <?php echo $form->errorSummary($address) ?>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'mobile'); ?>
                        <?php echo $form->telField($model,'mobile',array('class'=>"form-control",'maxLength' => 11));?>
                        <?php echo $form->error($model,'mobile'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'first_name'); ?>
                        <?php echo $form->textField($model,'first_name',array('class'=>"form-control"));?>
                        <?php echo $form->error($model,'first_name'); ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'last_name'); ?>
                        <?php echo $form->textField($model,'last_name',array('class'=>"form-control"));?>
                        <?php echo $form->error($model,'last_name'); ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->emailField($model,'email',array('class'=>"form-control ltr text-right"));?>
                        <?php echo $form->error($model,'email'); ?>
                    </div>
                </div>
            </div>

<!--            User Address-->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($address,'transferee'); ?>
                        <?php echo $form->textField($address,'transferee',array('class'=>"form-control",'size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($address,'transferee'); ?>
                    </div>
                </div>

                <?php if(!UserAddresses::$setDefaultLocation):?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <?php echo $form->labelEx($address,'town_id'); ?>
                            <?php echo $form->dropDownList($address,'town_id', Towns::getList(),array(
                                'class'=>'form-control town-change-trigger',
                                'prompt' => 'استان موردنظر را انتخاب کنید...',
                                'data-fetch-url' => $this->createUrl('/places/towns/fetchPlaces'),
                                'data-target' => "#UserAddresses_place_id"
                            )); ?>
                            <?php echo $form->error($address,'town_id'); ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <?php echo $form->labelEx($address,'place_id'); ?>
                            <?php echo $form->dropDownList($address,'place_id', [],array('class'=>'form-control','prompt' => 'ابتدا یک استان انتخاب کنید...','disabled' => true)); ?>
                            <?php echo $form->error($address,'place_id'); ?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($address,'landline_tel'); ?>
                        <?php echo $form->telField($address,'landline_tel',array('class'=>"form-control", 'maxlength' => 11));?>
                        <?php echo $form->error($address,'landline_tel'); ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($address,'emergency_tel'); ?>
                        <?php echo $form->telField($address,'emergency_tel',array('class'=>"form-control", 'maxlength' => 11));?>
                        <?php echo $form->error($address,'emergency_tel'); ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($address,'district'); ?>
                        <?php echo $form->textField($address,'district',array('class'=>"form-control", 'maxlength' => 255));?>
                        <?php echo $form->error($address,'district'); ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <?php echo $form->labelEx($address,'postal_code'); ?>
                        <?php echo $form->textField($address,'postal_code',array('class'=>"form-control", 'maxlength' => 10));?>
                        <?php echo $form->error($address,'postal_code'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($address,'postal_address'); ?>
                <?php echo $form->textArea($address,'postal_address',array('class'=>"form-control"));?>
                <?php echo $form->error($address,'postal_address'); ?>
            </div>


            <div class="form-group">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class' => 'btn btn-success')); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>
</div>


<?php
Yii::app()->clientScript->registerScript('model-load', '
    $("body").on("change", ".town-change-trigger", function(){
        var el = $(this);
        fetch(el);
    });
    
    function fetch(el){
        var url = el.data("fetch-url"),
            target = el.data("target"),
            val = el.val();
        if(val !== ""){
            url = url + "/" + val; 
            $.ajax({
                url: url,
                type: "GET",
                dataType: "html",
                success: function(html){
                    $(target).html(html);
                }
            });
            
            $(target).attr("disabled", false);
        }else  
            $(target).attr("disabled", true);
    }
');
?>