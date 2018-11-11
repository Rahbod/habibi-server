<?php
/* @var $this RequestsCategoriesController */
/* @var $model Categories */
/* @var $logo UploadedFiles */
/* @var $form CActiveForm */
$action = $model->isNewRecord?'create':"update?id=$model->id";
if (isset($popup)) $popup = true;
else $popup = false;
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?><?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
    'action' => array("/requests/categories/$action"),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => $popup?'js:function(form ,data ,hasError){
            if(!hasError)
            {
                var loc = window.location.hash, idx = loc.indexOf("#");
	            var hash = idx != -1 ? loc.substring(idx) : -1;
                var redUrl = location.href;
                if(hash!="#add-model")
                    redUrl+="#add-model";
                    
                var loading = form.find(".loading-container");
                var url = form.attr("action");
                
                var callback = "if(html.status){ window.location = \'"+redUrl+"\';location.reload(); }else{ alert(html.msg); }";
                console.log(callback);
                submitAjaxForm(form ,url ,loading ,callback);
            }
            return false;
        }':'js:function(form ,data ,hasError){
            if(!hasError){
                var loading = form.find(".loading-container");
                var url = form.attr("action");                
                submitAjaxForm(form ,url ,loading ,"if(html.status){ if(typeof html.url == \'undefined\') location.reload(); else window.location = html.url; }else{ alert(html.msg); }");
            }
            return false;
        }'
    )));
    echo CHtml::hiddenField('ajax');
?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'logo'); ?>
        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderLogoCategory',
            'model' => $model,
            'name' => 'logo',
            'maxFiles' => 1,
            'maxFileSize' => 0.5, //MB
            'url' => Yii::app()->createUrl('/requests/categories/upload'),
            'deleteUrl' => Yii::app()->createUrl('/requests/categories/deleteUpload'),
            'acceptedFiles' => '.png',
            'serverFiles' => $logo,
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
        <?php echo $form->error($model,'logo'); ?>
        <div class="uploader-message error"></div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>