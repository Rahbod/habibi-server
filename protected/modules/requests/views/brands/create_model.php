<?php
/* @var $this RequestsBrandsController */
/* @var $model Models */
/* @var $image UploadedFiles */

$this->breadcrumbs=array(
	'مدیریت برند ها'=>array('admin'),
	'افزودن مدل جدید',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">افزودن مدل جدید</h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_model_form', array(
            'model'=>$model
        )); ?>
    </div>
</div>
