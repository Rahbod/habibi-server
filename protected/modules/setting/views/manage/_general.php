<?php
/* @var $this SettingManageController */
/* @var $model SiteSetting */
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">تنظیمات عمومی</h3>
    </div>
    <div class="box-body">
    <?
    $form = $this->beginWidget('CActiveForm',array(
        'id'=> 'general-setting',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>

    <?php $this->renderPartial('//partial-views/_flashMessage') ?>

    <?php
    foreach($model as $field):
        if($field->name != 'social_links'):
            if($field->name == 'keywords'):?>
                <div class="form-group">
                    <?php echo CHtml::label($field->title,''); ?>
                    <?
                    $this->widget("ext.tagIt.tagIt",array(
                        'name' => "SiteSetting[$field->name]",
                        'data' => (!empty($field->value))?CJSON::decode($field->value):''
                    ));
                    ?>
                    <p style="clear: both;font-size: 12px;color: #aaa">عبارت را وارد کرده و اینتر بزنید.</p>
                    <?php echo $form->error($field,'name'); ?>
                </div>
            <?php else:?>
                <div class="form-group">
                    <?php echo CHtml::label($field->title,''); ?>
                    <?php echo CHtml::textField("SiteSetting[$field->name]",$field->value,array('size'=>60,'class'=>'form-control')); ?>
                    <?php echo $form->error($field,'name'); ?>
                </div>
            <?php
            endif;
        endif;
    endforeach;
    ?>
    <div class="form-group buttons">
        <?php echo CHtml::submitButton('ذخیره',array('class' => 'btn btn-success')); ?>
    </div>
    <?
    $this->endWidget();
    ?>
    </div>
</div>