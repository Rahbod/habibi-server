<?php
/* @var $this RequestsOfflineController */
/* @var $model TextMessagesReceive */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن درخواست', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">درخواست های آفلاین</h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'requests-grid',
                'dataProvider'=>$model->search(),
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
                'rowHtmlOptionsExpression' => 'array("data-max" => $data->getMaxID())',
                'pagerCssClass' => 'blank',
                'columns'=>array(
                    [
                        'name' => 'sender',
                        'value' => function($data){
                            return "<b style='color: #007fff'>".TextMessagesReceive::ShowPhoneNumber($data->sender)."</b>";
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
                            return "<span class='label label-{$data->getStatusLabel(true)}'>{$data->getStatusLabel()}</span>";
                        },
                        'type' => 'raw',
                    ],
                    [
                        'header' => '',
                        'value' => function($data){
                            /** @var $data Requests */
                            return CHtml::link('بررسی درخواست', Yii::app()->createUrl('/requests/offline/view/'.$data->id.'?pending'),[
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
                            return CHtml::link('حذف درخواست', Yii::app()->createUrl('/requests/offline/delete/'.$data->id.'/?pending'),[
                                'class' => 'btn btn-xs btn-danger'
                            ]);
                        },
                        'htmlOptions' => ['class' => 'text-center'],
                        'type' => 'raw',
                    ]
                ),
            )); ?>
        </div>
    </div>
</div>


<?php
Yii::app()->clientScript->registerScript('load-em-interval','
    var lastEm = $("tbody tr:last-of-type").data("max");
    
    fetch();
    setInterval(function(){
        fetch();
    }, 5000);
    
    function fetch(){
        $.ajax({
            url:"'.$this->createUrl('/requests/offline/admin?pendingAjax=true&table=true&last=').'"+lastEm,
            type: "get",
            dataType: "json",
            success: function(data){
                if(data.table){
                    $(data.table).each(function(key, tr) {                       
                        $("#requests-grid tbody").append(tr);
                        $("#requests-grid tbody tr:last-of-type").addClass("bg-success");
                    });
                }    
                lastEm = data.last;
            }
        });
    }
', CClientScript::POS_END);