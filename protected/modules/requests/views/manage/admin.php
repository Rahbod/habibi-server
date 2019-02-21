<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
$days = [];
for($i=1;$i<=31;$i++)
    $days[$i] = $i;
$months = [];
for($i=1;$i<=12;$i++)
    $months[$i] = $i;
$years = [];
for($i=1397;$i<=1410;$i++)
    $years[$i] = $i;

$steps =explode('/',$this->route);
$recycleBin = end($steps) === 'recycleBin';
$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن درخواست', 'url'=>array('create')),
);


$pending = isset($_GET['pending']);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?php if($recycleBin): ?>
            <h3 class="box-title">مدیریت درخواست های معلق</h3>
            <a href="<?= $this->createUrl($pending?'pending':'admin') ?>" class="btn btn-primary btn-sm pull-left">
                بازگشت
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php else: ?>
            <h3 class="box-title">مدیریت درخواست</h3>
            <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن درخواست</a>
<!--            <a href="--><?//= $this->createUrl('recycleBin') ?><!--" class="btn btn-warning btn-sm pull-left">-->
<!--                <i class="fa fa-trash-o"></i>-->
<!--                زباله دان-->
<!--            </a>-->
            <a href="<?= $this->createUrl('pending') ?>" style="margin-left: 5px" class="btn btn-success btn-sm pull-left">
                <i class="fa fa-flash"></i>
                درخواست های جدید
            </a>
        <?php endif; ?>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
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
//                    [
//                        'name' => 'operator_id',
//                        'value' => '$data->operator?$data->operator->name_family:"-"',
//                        'filter' => Admins::getByRole('operator',true)
//                    ],
                    [
                        'name' => 'repairman_id',
                        'value' => '$data->repairman && $data->repairman->userDetails?$data->repairman->userDetails->getShowName(false):"-"',
                        'filter' => Users::getUsersByRole('repairman',true)
                    ],
                    [
                        'name' => 'requested_date',
                        'value' => function($data){
                            return "<b dir='ltr'>".JalaliDate::date("Y/m/d", $data->requested_date)."</b>";
                        },
                        'type' => 'raw',
                        'htmlOptions' => [
                            'style' => 'width: 180px'
                        ],
                        'filter' => CHtml::dropDownList('Requests[requested_date][day]', isset($_GET['Requests']['requested_date']['day']) ? $_GET['Requests']['requested_date']['day'] : null, $days, ['prompt'=>'روز','style'=>'float:right;width:40px']).
                            CHtml::dropDownList('Requests[requested_date][month]', isset($_GET['Requests']['requested_date']['month']) ? $_GET['Requests']['requested_date']['month'] : null, $months, ['prompt'=>'ماه','style'=>'float:right;width:40px']).
                            CHtml::dropDownList('Requests[requested_date][year]', isset($_GET['Requests']['requested_date']['year']) ? $_GET['Requests']['requested_date']['year'] : null, $years, ['prompt'=>'سال','style'=>'float:right;width:60px'])
                    ],
                    [
                        'name' => 'service_date',
                        'value' => function($data){
                            return $data->service_date ? "<b dir='ltr'>".JalaliDate::date("Y/m/d", $data->service_date)."</b>" : '-';
                        },
                        'type' => 'raw',
                        'htmlOptions' => [
                            'style' => 'width: 180px'
                        ],
                        'filter' => CHtml::dropDownList('Requests[service_date][day]', isset($_GET['Requests']['service_date']['day']) ? $_GET['Requests']['service_date']['day'] : null, $days, ['prompt'=>'روز','style'=>'float:right;width:40px']).
                            CHtml::dropDownList('Requests[service_date][month]', isset($_GET['Requests']['service_date']['month']) ? $_GET['Requests']['service_date']['month'] : null, $months, ['prompt'=>'ماه','style'=>'float:right;width:40px']).
                            CHtml::dropDownList('Requests[service_date][year]', isset($_GET['Requests']['service_date']['year']) ? $_GET['Requests']['service_date']['year'] : null, $years, ['prompt'=>'سال','style'=>'float:right;width:60px'])
                    ],
                    [
                        'name' => 'request_type',
                        'header' => '',
                        'value' => function($data){
                            /** @var $data Requests */
                            return $data->getRequestTypeLabel(true);
                        },
                        'htmlOptions' => ['class' => 'text-center'],
                        'type' => 'raw',
                        'filter' => $model->requestTypeLabels
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
                        'value' => function($data) use ($pending){
                            /** @var $data Requests */
                            if($data->status >= Requests::STATUS_PENDING &&
                               $data->status <= Requests::STATUS_AWAITING_PAYMENT)
                                return CHtml::link('صدور فاکتور', array('/requests/manage/invoicing/'.$data->id), array('class' => 'btn btn-xs btn-info'));
                            else if($data->status == Requests::STATUS_DELETED)
                                return CHtml::link('بازیابی درخواست', array('/requests/manage/restore/'.$data->id.($pending?'?pending':'')), array('class' => 'btn btn-xs btn-warning'));
                            return '';
                        },
                        'type' => 'raw',
                        'filter' => false
                    ],
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>