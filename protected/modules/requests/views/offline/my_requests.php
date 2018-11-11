<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
$this->breadcrumbs=array(
	'مدیریت',
);

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت درخواست های فوری من</h3>
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
                'pagerCssClass' => 'blank',
                'rowHtmlOptionsExpression' => 'array("data-max" => $data->getMaxID())',
                'columns'=>array(
                    [
                        'name' => 'user_id',
                        'value' => '$data->user && $data->user->userDetails?$data->user->userDetails->getShowName():"-"',
                        'filter' => Users::getUsersByRole('user',true)
                    ],
                    [
                        'name' => 'category_id',
                        'value' => '$data->category?$data->category->title:"-"',
                        'filter' => Categories::getList()
                    ],
                    [
                        'name' => 'create_date',
                        'value' => function($data){
                            return "<b dir='ltr'>".JalaliDate::date("Y/m/d H:i", $data->create_date)."</b>";
                        },
                        'type' => 'raw',
                        'filter' => false
                    ],
                    [
                        'name' => 'request_type',
                        'header' => 'پلتفرم',
                        'value' => function($data){
                            /** @var $data Requests */
                            return $data->getRequestTypeLabel(true);
                        },
                        'htmlOptions' => ['class' => 'text-center'],
                        'type' => 'raw',
                        'filter' => false
                    ],
                    [
                        'name' => 'status',
                        'value' => function($data){
                            /** @var $data Requests */
                            return "<span class='label label-{$data->getStatusLabel(true)}'>{$data->getStatusLabel()}</span>";
                        },
                        'type' => 'raw',
                        'filter' => $model->statusLabels
                    ],
                    [
                        'header' => '',
                        'value' => function($data){
                            /** @var $data Requests */
                            return CHtml::link('بررسی درخواست', Yii::app()->createUrl('/requests/manage/view/'.$data->id.'?pending'),[
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
                            return CHtml::link('انتقال به زباله دان', Yii::app()->createUrl('/requests/manage/delete/'.$data->id.'/?pending'),[
                                'class' => 'btn btn-xs btn-danger',
                                'onclick' => 'if(!confirm("آیا از حذف درخواست اطمینان دارید؟")) return false;'
                            ]);
                        },
                        'htmlOptions' => ['class' => 'text-center'],
                        'type' => 'raw',
                    ],
                ),
            )); ?>
        </div>
    </div>
</div>
<style>
    .bg-success {
        background-color: #dff0d8 !important;
    }
</style>
<?php
Yii::app()->clientScript->registerScript('load-interval','
    var last = $("tbody tr:last-of-type").data("max");
    
    fetch();
    setInterval(function(){
        fetch();
    }, 15000);
    
    function fetch(){
        $.ajax({
            url:"'.$this->createUrl('/requests/manage/pending?pendingAjax=true&table=true&last=').'"+last,
            type: "get",
            dataType: "json",
            success: function(data){
                if(data.table){
                    $(data.table).each(function(key, tr) {                       
                        $("#requests-grid tbody").append(tr);
                        $("#requests-grid tbody tr:last-of-type").addClass("bg-success");
                    });
                }    
                last = data.last;
            }
        });
    }
', CClientScript::POS_END);