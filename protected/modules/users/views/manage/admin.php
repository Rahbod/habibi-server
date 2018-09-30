<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
    'کاربران'=>array('admin'),
    'مدیریت کاربران',
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت کاربران</h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'admins-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped table-hover',
                'columns'=>array(
                    array(
                        'header' => 'نام کامل',
                        'value' => '$data->userDetails->getShowName()',
                        'filter' => CHtml::activeTextField($model,'first_name')
                    ),
                    array(
                        'header' => 'وضعیت',
                        'value' => '$data->statusLabels[$data->status]',
                        'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
                    ),array(
                        'header' => 'کلمه عبور',
                        'value' => function($data){
                            return $data->useGeneratedPassword()?$data->generatePassword():"کلمه عبور توسط کاربر تغییر یافته";
                        }
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'buttons' => array(
                            'view' => array(
                                'url' => 'Yii::app()->createUrl("/users/manage/view",array("id" => $data->id))'
                            )
                        )
                    )
                )
            )); ?>
        </div>
    </div>
</div>