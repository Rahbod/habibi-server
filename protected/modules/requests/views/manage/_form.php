<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
/* @var $form CActiveForm */
//if($model->isNewRecord)
//    $clientOptions = array(
//        'validateOnSubmit' => true,
//        'afterValidate' => 'js:function(form ,data ,hasError){
//            if(!hasError)
//            {
//                var loading = form.find(".loading-container");
//                var url = form.attr("action");
//                submitAjaxForm(form ,url ,loading ,"if(html.status){ if(typeof html.url == \'undefined\') location.reload(); else window.location = html.url;}");
//            }
//        }'
//    );
//else

$route = $this->route;

if($model->isNewRecord && isset($_GET['user_id'])) {
    $model->user_id = $_GET['user_id'];
    $route .= "?user_id={$model->user_id}";
}

if($model->isNewRecord && isset($_GET['address_id'])) {
    $model->user_address_id = $_GET['address_id'];
    $route .= $route != $this->route ? "&address_id={$model->user_address_id}" : "?address_id={$model->user_address_id}";
}

$route = urlencode($route);

$clientOptions = array(
    'validateOnSubmit' => true
);
?>

<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'requests-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => $clientOptions
)); ?>

<?php
echo $form->errorSummary($model);
?>

<!--	<div class="form-group">-->
<!--		--><?php //echo $form->labelEx($model,'brand_id'); ?>
<!--        <div class="input-group">-->
<!--            --><?php //echo $form->dropDownList($model,'brand_id', Brands::getList(),array(
//                'class'=>'form-control brand-change-trigger',
//                'prompt' => 'برند موردنظر را انتخاب کنید...',
//                'data-fetch-url' => $this->createUrl('/requests/brands/fetchModels'),
//                'data-target' => "#Requests_model_id"
//            )); ?>
<!--            <span class="input-group-btn">-->
<!--                <a class="btn btn-success" href="--><?//= Yii::app()->createUrl("/requests/brands/create?return=/$route") ?><!--"><i class="fa fa-plus"></i> افزودن برند جدید</a>-->
<!--            </span>-->
<!--        </div>-->
<!--		--><?php //echo $form->error($model,'brand_id'); ?>
<!--	</div>-->
<!---->
<!--	<div class="form-group">-->
<!--		--><?php //echo $form->labelEx($model,'model_id'); ?>
<!--		--><?php //echo $form->dropDownList($model,'model_id', [],array('class'=>'form-control','prompt' => 'ابتدا یک برند انتخاب کنید...','disabled' => true)); ?>
<!--		--><?php //echo $form->error($model,'model_id'); ?>
<!--	</div>-->

	<div class="form-group">
		<?php echo $form->labelEx($model,'user_id'); ?>
        <div class="input-group">
            <?php echo $form->dropDownList($model,'user_id',
                Users::getUsersByRole('user', true),
                array(
                    'class'=>'form-control select-picker user-change-trigger',
                    'data-live-search' => true,
                    'data-fetch-url' => $this->createUrl('/users/manage/fetchAddresses'),
                    'data-target' => "#Requests_user_address_id",
                    'prompt' => 'کاربر درخواست دهنده را انتخاب کنید...'
                )
            ); ?>
            <span class="input-group-btn">
                <a class="btn btn-success" href="<?= Yii::app()->createUrl("/users/manage/quickUser?return=/$route") ?>"><i class="fa fa-plus"></i> افزودن کاربر جدید</a>
            </span>
        </div>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'user_address_id'); ?>
        <div class="input-group">
            <?php echo $form->dropDownList($model,'user_address_id', [],array('class'=>'form-control','prompt' => 'ابتدا کاربر را انتخاب کنید...','data-id' => $model->user_address_id,'disabled' => true)); ?>
            <span class="input-group-btn">
                <a disabled="true" class="btn btn-success" id="add-address-btn" data-toggle="modal" data-target="#add-address" href="<?= Yii::app()->createUrl("/users/manage/addAddress?return=/$route") ?>"><i class="fa fa-plus"></i> افزودن آدرس جدید</a>
            </span>
        </div>
		<?php echo $form->error($model,'user_address_id'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'category_id'); ?>
        <div class="input-group">
            <?php echo $form->dropDownList($model,'category_id', Categories::getList(),array('class'=>'form-control')); ?>
            <span class="input-group-btn">
                <button type="button" data-toggle="modal" data-target="#add-category" class="btn btn-success"><i class="fa fa-plus"></i> افزودن نوع جدید</button>
            </span>
        </div>
        <?php echo $form->error($model,'category_id'); ?>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'repairman_id'); ?>
        <?php echo $form->dropDownList($model,'repairman_id',
            Users::getUsersByRole('repairman', true),
            array(
                'class'=>'form-control select-picker',
                'data-live-search' => true,
                'prompt' => 'تعمیرکار را انتخاب کنید...'
            )
        ); ?>
		<?php echo $form->error($model,'repairman_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('class' => 'form-control','rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'service_date'); ?>
        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
            'id'=>'service_date',
            'model' => $model,
            'attribute' => 'service_date',
            'options'=>array(
                'format'=>'YYYY/MM/DD',
            ),
            'htmlOptions'=>array(
                'class'=>'form-control'
            ),
        ));?>
		<?php echo $form->error($model,'service_date'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'service_time'); ?>
		<?php echo $form->dropDownList($model,'service_time',Requests::$serviceTimes,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'service_time'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>


<div class="modal fade" id="add-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    افزودن نوع لوازم
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('requests.views.categories._form',array('popup' => true,'model' => new Categories(), 'logo' => [])) ?>
            </div>
        </div>
    </div>
</div>


<?php
Yii::app()->clientScript->registerScript('model-load', '
    $("body").on("change", ".brand-change-trigger, select.user-change-trigger", function(){
        var el = $(this);
        fetch(el);
    }).on("change", "select.user-change-trigger", function(){
        var el = $(this),
            val = el.val();
        if(val === ""){
            $("#add-address-btn").data("foreign-id", val).attr("disabled", true);
        }else{
            $("#add-address-btn").data("foreign-id", val).attr("disabled", false);
        }
    }).on("click", "#add-address-btn", function(e){
        e.preventDefault();
        var el = $(this),
            url = el.attr("href");
        if(el.data("foreign-id") === ""){
            alert("لطفا یک کاربر انتخاب کنید.");
        }else{
            window.location = url+"&user="+el.data("foreign-id");
        }
    });
    
//    fetch($(".brand-change-trigger"));
    fetch($("select.user-change-trigger"), $("#Requests_user_address_id").data("id"));
    
    function fetch(el, id = false){
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
                    if(id)
                        $(target).find("[value=\""+id+"\"]").attr("selected", true);
                }
            });
            
            $(target).attr("disabled", false);
            $("#add-address-btn").data("foreign-id", val).attr("disabled", false);
        }else{  
            $(target).attr("disabled", true);
            $("#add-address-btn").data("foreign-id", val).attr("disabled", true);
        }
    }
', CClientScript::POS_READY);
?>