<?php
/* @var $this UsersManageController */
/* @var $model DealershipRequests */

$this->breadcrumbs=array(
    'نمایشگاه ها'=>array('dealerships'),
    'مدیریت درخواست های ثبت نمایشگاه ها',
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت درخواست های ثبت نمایشگاه ها</h3>
        <a href="<?= $this->createUrl('dealerships') ?>" class="btn btn-default btn-sm">مدیریت نمایشگاه ها</a>
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
                    'dealership_name',
                    'manager_name',
                    'manager_last_name',
                    'creator_name',
                    'creator_mobile',
                    array(
                        'name' => 'create_date',
                        'filter' => false,
                        'value' => function($data){
                            return JalaliDate::date("Y/m/d - H:i", $data->create_date);
                        }
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{add}',
                        'buttons' => array(
                            'add' => array(
                                'label' => 'ثبت نمایشگاه',
                                'options' => array('class' => 'btn btn-xs btn-info'),
                                'url' => 'Yii::app()->createUrl("/users/manage/createDealership/".$data->id)'
                            )
                        )
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view} {delete}',
                        'buttons' => array(
                            'delete' => array(
                                'url' => 'Yii::app()->createUrl("/users/manage/deleteRequest/".$data->id)'
                            ),
                            'view' => array(
                                'url' => 'Yii::app()->createUrl("/users/manage/dealershipRequest/".$data->id)'
                            )
                        )
                    )
                )
            )); ?>
        </div>
    </div>
</div>