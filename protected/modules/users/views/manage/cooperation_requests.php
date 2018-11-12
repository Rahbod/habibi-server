<?php
/* @var $this UsersManageController */
/* @var $model CooperationRequests */

$this->breadcrumbs=array(
    'مدیریت درخواست های همکاری',
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت درخواست های همکاری</h3>
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
                    'first_name',
                    'last_name',
                    [
                        'name' => 'mobile',
                        'value' => function($data){
                            return "<b style='color: #007fff'>".TextMessagesReceive::ShowPhoneNumber($data->mobile)."</b>";
                        },
                        'type' => 'raw'
                    ],
                    [
                        'name' => 'create_date',
                        'value' => function($data){
                            return "<b dir='ltr'>".JalaliDate::date("Y/m/d H:i", $data->create_date)."</b>";
                        },
                        'type' => 'raw'
                    ],
                    [
                        'name' => 'status',
                        'value' => function($data){
                            /** @var $data TextMessagesReceive */
                            $css = $data->status == CooperationRequests::STATUS_PENDING?'info':'success';
                            return "<span class='label label-{$css}'>{$data->getStatusLabel()}</span>";
                        },
                        'type' => 'raw',
                        'filter' => CooperationRequests::$statusLabels
                    ],
                    [
                        'header' => '',
                        'value' => function($data){
                            /** @var $data Requests */
                            return CHtml::link('بررسی درخواست', Yii::app()->createUrl('/users/manage/viewRequest/'.$data->id),[
                                'class' => 'btn btn-xs btn-info'
                            ]);
                        },
                        'htmlOptions' => ['class' => 'text-center'],
                        'type' => 'raw',
                    ],
                    [
                        'header' => '',
                        'value' => function($data){
                            /** @var $data Requests */
                            return CHtml::link('حذف درخواست', Yii::app()->createUrl('/users/manage/deleteRequest/'.$data->id),[
                                'class' => 'btn btn-xs btn-danger',
                                'onclick' => 'if(!confirm("آیا از حذف درخواست اطمینان دارید؟")) return false;'
                            ]);
                        },
                        'htmlOptions' => ['class' => 'text-center'],
                        'type' => 'raw',
                    ]
//                    array(
//                        'class'=>'CButtonColumn',
//                        'template' => '{add}',
//                        'buttons' => array(
//                            'add' => array(
//                                'label' => 'ثبت نمایشگاه',
//                                'options' => array('class' => 'btn btn-xs btn-info'),
//                                'url' => 'Yii::app()->createUrl("/users/manage/createDealership/".$data->id)'
//                            )
//                        )
//                    )
                )
            )); ?>
        </div>
    </div>
</div>