<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
$steps =explode('/',$this->route);
$recycleBin = end($steps) === 'recycleBin';
$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن درخواست', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?php if($recycleBin): ?>
            <h3 class="box-title">مدیریت درخواست های معلق</h3>
            <a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
                بازگشت
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php else: ?>
            <h3 class="box-title">مدیریت درخواست</h3>
            <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن درخواست</a>
            <a href="<?= $this->createUrl('recycleBin') ?>" class="btn btn-warning btn-sm pull-left">
                <i class="fa fa-trash-o"></i>
                زباله دان
            </a>
        <?php endif; ?>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'requests-grid',
                'dataProvider'=>$model->search($recycleBin),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped',
                'template' => '{summary} {pager} {items} {pager}',
                'ajaxUpdate' => true,
                'afterAjaxUpdate' => "function(id, data){
                    $('html, body').animate({
                    scrollTop: ($('#'+id).offset().top-130)
                    },1000,'easeOutCubic');
                }",
                'pager' => array(
                    'header' => '',
                    'firstPageLabel' => '<<',
                    'lastPageLabel' => '>>',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'cssFile' => false,
                    'htmlOptions' => array(
                        'class' => 'pagination pagination-sm',
                    ),
                ),
                'pagerCssClass' => 'blank',
                'columns'=>array(
                    [
                        'name' => 'category_id',
                        'value' => '$data->category?$data->category->title:"-"',
                        'filter' => Categories::getList()
                    ],
                    [
                        'name' => 'user_id',
                        'value' => '$data->user && $data->user->userDetails?$data->user->userDetails->getShowName():"-"',
                        'filter' => Users::getUsersByRole('user',true)
                    ],
                    [
                        'name' => 'operator_id',
                        'value' => '$data->operator && $data->operator->userDetails?$data->operator->userDetails->getShowName(false):"-"',
                        'filter' => Users::getUsersByRole('operator',true)
                    ],
                    [
                        'name' => 'repairman_id',
                        'value' => '$data->repairman && $data->repairman->userDetails?$data->repairman->userDetails->getShowName(false):"-"',
                        'filter' => Users::getUsersByRole('repairman',true)
                    ],
                    [
                        'name' => 'modified_date',
                        'value' => 'JalaliDate::date("Y/m/d", $data->modified_date)',
                        'filter' => false
                    ],
                    [
                        'name' => 'status',
                        'value' => function($data){
                            /** @var $data Requests */
                            return "<span class='label label-{$data->getStatusLabel(true)}'>{$data->getStatusLabel()}</span>";
                        },
                        'type' => 'raw',
                        'filter' => $recycleBin?false:$model->statusLabels
                    ],
                    [
                        'header' => '',
                        'value' => function($data){
                            /** @var $data Requests */
                            if($data->status >= Requests::STATUS_PENDING &&
                               $data->status <= Requests::STATUS_AWAITING_PAYMENT)
                                return CHtml::link('صدور فاکتور', array('/requests/manage/invoicing/'.$data->id), array('class' => 'btn btn-xs btn-info'));
                            else if($data->status == Requests::STATUS_DELETED)
                                return CHtml::link('بازیابی درخواست', array('/requests/manage/restore/'.$data->id), array('class' => 'btn btn-xs btn-warning'));
                            return '';
                        },
                        'type' => 'raw',
                        'filter' => false
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'buttons' =>array(
                            'delete' => array(
                                'visible' => '$data->status < Requests::STATUS_PAID'
                            )
                        )
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>