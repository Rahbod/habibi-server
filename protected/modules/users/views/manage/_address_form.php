<?php
/* @var $this UsersManageController */
/* @var $model UserAddresses */
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
    if(isset($_GET['user']))
        echo CHtml::hiddenField(CHtml::activeName($model,'user_id'), $_GET['user']);
    ?>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'transferee'); ?>
                <?php echo $form->textField($model,'transferee',array('class'=>"form-control",'size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'transferee'); ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'town_id'); ?>
                <?php echo $form->dropDownList($model,'town_id', Towns::getList(),array(
                    'class'=>'form-control town-change-trigger',
                    'prompt' => 'استان موردنظر را انتخاب کنید...',
                    'data-fetch-url' => $this->createUrl('/places/towns/fetchPlaces'),
                    'data-target' => "#UserAddresses_place_id"
                )); ?>
                <?php echo $form->error($model,'town_id'); ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'place_id'); ?>
                <?php echo $form->dropDownList($model,'place_id', [],array('class'=>'form-control','prompt' => 'ابتدا یک استان انتخاب کنید...','disabled' => true)); ?>
                <?php echo $form->error($model,'place_id'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'landline_tel'); ?>
                <?php echo $form->telField($model,'landline_tel',array('class'=>"form-control", 'maxlength' => 11));?>
                <?php echo $form->error($model,'landline_tel'); ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'emergency_tel'); ?>
                <?php echo $form->telField($model,'emergency_tel',array('class'=>"form-control", 'maxlength' => 11));?>
                <?php echo $form->error($model,'emergency_tel'); ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'district'); ?>
                <?php echo $form->textField($model,'district',array('class'=>"form-control", 'maxlength' => 255));?>
                <?php echo $form->error($model,'district'); ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'postal_code'); ?>
                <?php echo $form->textField($model,'postal_code',array('class'=>"form-control", 'maxlength' => 10));?>
                <?php echo $form->error($model,'postal_code'); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'postal_address'); ?>
        <?php echo $form->textArea($model,'postal_address',array('class'=>"form-control"));?>
        <?php echo $form->error($model,'postal_address'); ?>
    </div>

    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

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