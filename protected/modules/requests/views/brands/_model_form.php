<?php
/* @var $this RequestsBrandsController */
/* @var $model Brands */
/* @var $brand_id integer */
/* @var $form CActiveForm */
/* @var $image UploadedFiles */

if($model->isNewRecord)
    $clientOptions = array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form ,data ,hasError){
            if(!hasError)
            {
                var loading = form.find(".loading-container");
                var url = form.attr("action");
                submitAjaxForm(form ,url ,loading ,"if(html.status){ if(typeof html.url == \'undefined\') location.reload(); else window.location = html.url;}");
            }
        }'
    );
else
    $clientOptions = array(
        'validateOnSubmit' => true
    );

$actionUrl = isset($_REQUEST['return']) && !empty($_REQUEST['return'])?array("brands/modelAdd?ajax=create-model-form&return={$_REQUEST['return']}"):array("brands/modelAdd?ajax=create-model-form");
?>
<?php $this->renderPartial('//partial-views/_loading') ?>
<?php $this->renderPartial('//partial-views/_flashMessage') ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>($model->isNewRecord?'create-model-form':'update-model-form'),
    'action' => $model->isNewRecord?$actionUrl:array('brands/modelEdit/'.$model->id),
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => $clientOptions
));
if($model->isNewRecord)
    echo CHtml::hiddenField('Models[brand_id]',$brand_id);
?>
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
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'slug'); ?> (انگلیسی)
		<?php echo $form->textField($model,'slug',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

<?php if(!$model->isNewRecord):?>
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
<?php endif;?>
