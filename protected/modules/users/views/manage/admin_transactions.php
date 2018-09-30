<?php
/* @var $this SiteController */
/* @var $model UserTransactions */
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">تراکنش ها</h3>
    </div>
    <div class="box-body">
    <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
    <div class="table-responsive">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'transactions-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'itemsCssClass'=>'table table-striped',
        'template' => '{summary} {items} {pager}',
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
            array(
                'name'=>'user_name',
                'header'=>'کاربر',
                'value'=>'$data->user && $data->user->userDetails?$data->user->userDetails->getShowName():"کاربر حذف شده"'
            ),
            array(
                'name'=>'token',
                'htmlOptions'=>array('style' => 'font-size:14px;letter-spacing:1px;font-weight:bold'),
            ),
            array(
                'name'=>'amount',
                'value'=>'number_format($data->amount, 0)." تومان"',
            ),
            array(
                'name'=>'gateway_name',
                'value'=>'$data->gateway_name && isset($data->gateways[$data->gateway_name])?$data->gateways[$data->gateway_name]:$data->gateway_name',
                'filter'=>false
            ),
            array(
                'name'=>'status',
                'value'=>function($data){
                    return '<span class="label label-'.(($data->status=='paid')?'success':'danger').'">'.$data->statusLabels[$data->status].'</span>';
                },
                'type'=>'raw',
                'filter'=>CHtml::activeDropDownList($model,'status',$model->statusLabels,array('prompt' => 'همه'))
            ),
            array(
                'name'=>'date',
                'value'=>'$data->date?JalaliDate::date("d F Y - H:i", $data->date):"-"',
                'filter'=>false
            ),
            array(
                'name'=>'description',
                'htmlOptions'=>array('style' => 'font-size:12px'),
            ),
        ),
    )); ?>
    </div>
    </div>
</div>
