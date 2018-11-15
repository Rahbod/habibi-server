<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
/* @var $form CActiveForm */

$route = $this->route;
$route = urlencode($route);

$clientOptions = array(
    'validateOnSubmit' => true
);
?>

<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => $clientOptions
)); ?>

<?php
echo $form->errorSummary($model);
?>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
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
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <?php echo $form->labelEx($model,'service_time'); ?>
                <?php echo $form->dropDownList($model,'service_time',Requests::$serviceTimes,array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'service_time'); ?>
            </div>
        </div>
    </div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'صدور فاکتور' : 'ویرایش',array('class' => 'btn btn-success')); ?>
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