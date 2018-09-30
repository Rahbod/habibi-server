<?php
/* @var $this UsersPlansController */
/* @var $model Plans */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'plans-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
	'enableAjaxValidation'=>true,
)); ?>
    <?php $this->renderPartial('//partial-views/_flashMessage');?>
    <p class="note">فیلد های دارای <span class="required">*</span> الزامی هستند .</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title' ,array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'status' ,array('class'=>'control-label')); ?>
        <?php echo $form->dropDownList($model,'status',Plans::$statusLabels, array('class' => 'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class="row">
    <?php foreach(Plans::$rulesFields as $role => $fields):?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?= Plans::$roleLabels[$role]?>
                </div>
                <div class="panel-body">
                    <?php foreach($fields as $field):?>
                        <?php if($field['name'] == 'price'):?>
                            <?php if($model->id != 1):?>
                                <div class="form-group">
                                    <?php echo CHtml::label($field['title'], $field['name'], array('class'=>'control-label')); ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">تومان</span>
                                        <?php echo CHtml::textField("Plans[rules][{$role}][{$field['name']}]",$model->getRule($role,$field['name']),array('class' => 'form-control')) ?>
                                    </div>
                                </div>
                            <?php else:?>
                                <div class="form-group">
                                    <?php echo CHtml::label($field['title'], $field['name'], array('class'=>'control-label')); ?>
                                    رایگان
                                </div>
                            <?php endif;?>
                        <?php else:?>
                            <div class="form-group">
                                <?php echo CHtml::label($field['title'], $field['name'], array('class'=>'control-label')); ?>
                                <?php if(isset($field['addon'])): ?><div class="input-group"><span class="input-group-addon"><?= $field['addon'] ?></span><?php endif ?>
                                <?php if(!isset($field['type']) || $field['type'] == 'num'): ?>
                                    <?php echo CHtml::textField("Plans[rules][{$role}][{$field['name']}]",$model->getRule($role,$field['name']),array('class' => 'form-control')) ?>
                                <?php else:?>
                                    <div><?php echo CHtml::checkBox("Plans[rules][{$role}][{$field['name']}]",$model->getRule($role,$field['name'])) ?></div>
                                <?php endif; ?>
                                <?php if(isset($field['addon'])): ?></div><?php endif ?>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    <?php endforeach;?>
    </div>

	<div class="form-group buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش', array('class'=>'btn btn-success'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->