<?php
/* @var $this RolesController */
/* @var $model AdminRoles */
/* @var $actions array */

$this->breadcrumbs=array(
    'پیشخوان'=> array('/admins'),
    'مدیران'=> array('/admins/manage'),
    'نقش مدیران'=>array('admin'),
    'ویرایش',
);

$this->menu=array(
    array('label'=>'مدیریت نقش مدیران', 'url'=>array('admin')),
    array('label'=>'افزودن نقش', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش نقش <?php echo $model->name; ?></h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model,'actions'=>$actions)); ?>
    </div>
</div>