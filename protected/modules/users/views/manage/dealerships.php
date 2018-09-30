<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
    'کاربران'=>array('admin'),
    'مدیریت نمایشگاه ها',
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت نمایشگاه ها</h3>
        <a href="<?= $this->createUrl('createDealership') ?>" class="btn btn-default btn-sm">افزودن نمایشگاه جدید</a>
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
                    'userDetails.dealership_name',
                    array(
                        'header' => 'مدیر',
                        'value' => '$data->userDetails->getShowName()',
                    ),
                    array(
                        'header' => 'پست الکترونیک',
                        'value' => '$data->email',
                    ),
                    array(
                        'header' => 'پلن',
                        'value' => '$data->activePlan->plan->title',
                    ),
                    array(
                        'header' => 'وضعیت',
                        'value' => '$data->statusLabels[$data->status]',
                        'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{update} {delete}',
                        'buttons' => array(
                            'update' => array(
                                'url' => 'Yii::app()->createUrl("/users/manage/updateDealership",array("id" => $data->id))'
                            )
                        )
                    )
                )
            )); ?>
        </div>
    </div>
</div>