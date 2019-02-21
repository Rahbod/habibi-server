<?php
/* @var $this RequestsManageController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'مدیریت',
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت درخواست</h3>
        <a href="<?= $this->createUrl('pending') ?>" style="margin-left: 5px" class="btn btn-success btn-sm pull-left">
            <i class="fa fa-flash"></i>
            درخواست های جدید
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'requests-grid',
                'dataProvider'=>$dataProvider,
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
                        'value' => '$data->operator?$data->operator->name_family:"-"',
                        'filter' => Admins::getByRole('operator',true)
                    ],
                    [
                        'name' => 'repairman_id',
                        'value' => '$data->repairman && $data->repairman->userDetails?$data->repairman->userDetails->getShowName(false):"-"',
                        'filter' => Users::getUsersByRole('repairman',true)
                    ],
                    [
                        'name' => 'modified_date',
                        'value' => function($data){
                            return "<b dir='ltr'>".JalaliDate::date("Y/m/d H:i", $data->modified_date)."</b>";
                        },
                        'type' => 'raw',
                        'filter' => false
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
                        //'filter' => $model->requestTypeLabels
                    ],
                    [
                        'name' => 'status',
                        'value' => function($data){
                            /** @var $data Requests */
                            return "<span class='label label-{$data->getStatusLabel(true)}'>{$data->getStatusLabel()}</span>";
                        },
                        'type' => 'raw',
                        //'filter' => $recycleBin?false:$model->statusLabels
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
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>