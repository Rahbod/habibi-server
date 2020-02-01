<?php
/* @var $this RequestsManageController */
/* @var $requestsCount integer */
/* @var $doneRequests integer */
/* @var $sumIncome integer */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'گزارش',
);

$days = [];
for($i=1;$i<=31;$i++)
    $days[$i] = $i;
$months = [];
for($i=1;$i<=12;$i++)
    $months[$i] = $i;
$years = [];
for($i=1397;$i<=1410;$i++)
    $years[$i] = $i;
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">گزارش</h3>
	</div>
	<div class="box-body">
        <div class="form-group">
            <div class="row">
                <?php echo CHtml::form()?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <label>از تاریخ</label>
                        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
                            'id'=>'from_date',
                            'value' => isset($_POST['from_date_altField']) ? $_POST['from_date_altField'] : time(),
                            'options'=>array(
                                'format'=>'YYYY/MM/DD',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'form-control'
                            ),
                        ));?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <label>تا تاریخ</label>
                        <?php $this->widget('ext.PDatePicker.PDatePicker', array(
                            'id'=>'to_date',
                            'value' => isset($_POST['to_date_altField']) ? $_POST['to_date_altField'] : time(),
                            'options'=>array(
                                'format'=>'YYYY/MM/DD',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'form-control'
                            ),
                        ));?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <label>تعمیرکار</label>
                        <?php echo CHtml::dropDownList('repairman', isset($_POST['repairman']) ? $_POST['repairman'] : null, Users::getUsersByRole('repairman', true), ['class'=>'form-control'])?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <label>&nbsp;</label>
                        <div><?php echo CHtml::submitButton('ثبت',array('class' => 'btn btn-success')); ?></div>
                    </div>
                <?php echo CHtml::endForm();?>
            </div>
        </div>
        <?php if(isset($_POST['from_date_altField'])):?>
            <div class="form-group" style="margin-top: 50px;">
                <h5>تعداد کل درخواست ها: <small><?php echo $requestsCount;?></small></h5>
            </div>
            <div class="form-group">
                <h5>تعداد درخواست های انجام شده: <small><?php echo $doneRequests;?></small></h5>
            </div>
            <div class="form-group">
                <h5>مجموع دریافتی ها: <small><?php echo number_format($sumIncome);?> تومان</small></h5>
            </div>
            <hr>
            <div class="form-group">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'requests-grid',
                    'dataProvider'=>$dataProvider,
                    'itemsCssClass'=>'table table-striped',
                    'template' => '{summary} {pager} {items} {pager}',
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
                        array(
                            'class'=>'CButtonColumn',
                            'template' => '{view}'
                        ),
                    ),
                )); ?>
            </div>
        <?php endif;?>
	</div>
</div>