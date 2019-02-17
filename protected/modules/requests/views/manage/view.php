<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$query = '';
if (isset($_GET['pending']))
    $query = '?pending';


$invoice = $model->getLastInvoice(true);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            نمایش درخواست  <?= $model->user->userDetails->getShowName() ?>

            <?php if($model->status): ?>
                <label class='label label-<?= $model->getStatusLabel(true) ?>'><?= $model->getStatusLabel() ?></label>
            <?php endif; ?>
        </h3>
    </div>
    <div class="box-body">

        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>

        <div class="form-group buttons text-left">
            <!-- Invoicing -->
            <?php if($model->status >= Requests::STATUS_CONFIRMED && $model->status <= Requests::STATUS_AWAITING_PAYMENT): ?>
                <a href="<?= $this->createUrl('invoicing')."/$model->id" ?>" class="btn btn-info">صدور فاکتور</a>
            <?php endif; ?>

            <!-- Manually Approve Payment -->
            <?php if($model->status == Requests::STATUS_AWAITING_PAYMENT): ?>
                <a href="<?= $this->createUrl('approvePayment')."/$model->id" ?>" class="btn btn-warning" onclick='if(!confirm("آیا از تایید پرداخت فاکتور اطمینان دارید؟")) return false;'>تایید پرداخت نقدی</a>
            <?php endif; ?>

            <?php if($model->status < Requests::STATUS_PAID): ?>
                <?php if($model->status != Requests::STATUS_DELETED): ?>
                        <a href="<?= $this->createUrl('delete')."/$model->id{$query}" ?>" class="btn btn-danger" onclick='if(!confirm("آیا از حذف این درخواست اطمینان دارید؟")) return false;'>انتقال به زباله دان</a>
                <?php else: ?>
                    <a href="<?= $this->createUrl('delete')."/$model->id{$query}" ?>" class="btn btn-danger" onclick='if(!confirm("آیا از حذف این درخواست اطمینان دارید؟")) return false;'>حذف کامل</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if($model->status == Requests::STATUS_OPERATOR_CHECKING):?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'manage-form',
                        'enableAjaxValidation'=>false,
                        'enableClientValidation'=>true,
                    )); ?>

                    <?php echo $form->errorSummary($model);?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <?php echo $form->labelEx($model,'service_date'); ?>
                                <?php
                                $serviceDate = $model->service_date;
                                $serviceTime = $model->service_time;
                                $model->service_date = $model->requested_date;
                                $model->service_time = $model->requested_time;
                                ?>
                                <?php $this->widget('ext.PDatePicker.PDatePicker', array(
                                    'id'=>'service_date',
                                    'model' => $model,
                                    'attribute' => 'service_date',
                                    'options'=>array(
                                        'format'=>'YYYY/MM/DD',
                                    ),
                                    'htmlOptions'=>array(
                                        'class'=>'form-control'
                                    ),
                                ));?>
                                <?php echo $form->error($model,'service_date'); ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <?php echo $form->labelEx($model,'service_time'); ?>
                                <?php echo $form->dropDownList($model,'service_time',Requests::$serviceTimes,array('class'=>'form-control')); ?>
                                <?php echo $form->error($model,'service_time'); ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <?php echo $form->labelEx($model,'repairman_id'); ?>
                                <?php echo $form->dropDownList($model,'repairman_id',
                                    Users::getUsersByRole('repairman', true),
                                    array(
                                        'class'=>'form-control select-picker',
                                        'data-live-search' => true,
                                        'prompt' => 'تعمیرکار را انتخاب کنید...'
                                    )
                                ); ?>
                                <?php echo $form->error($model,'repairman_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'صدور فاکتور' : 'ویرایش',array('class' => 'btn btn-success')); ?>
                    </div>
                    <?php
                    $model->service_date = $serviceDate;
                    $model->service_time = $serviceTime;
                    ?>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        <?php endif;?>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'itemCssClass'=>array('',''),
                    'htmlOptions' => array('class'=>'detail-view table table-striped'),
                    'attributes'=>array(
                        'id',
                        [
                            'label' => $model->getAttributeLabel('category_id'),
                            'value' => $model->category?$model->category->title:'<span class="text-danger">حذف شده</span>',
                        ],
                        [
                            'label' => $model->getAttributeLabel('user_id'),
                            'value' => $model->user && $model->user->userDetails?$model->user->userDetails->getShowName():'<span class="text-danger">حذف شده</span>',
                        ],
                        [
                            'label' => $model->getAttributeLabel('operator_id'),
                            'value' => $model->operator?$model->operator->name_family:'<span class="text-danger">حذف شده</span>',
                            'type' => 'raw'
                        ],
                        [
                            'label' => $model->getAttributeLabel('repairman_id'),
                            'value' => $model->repairman_id?($model->repairman && $model->repairman->userDetails?$model->repairman->userDetails->getShowName(false):'<span class="text-danger">حذف شده</span>'):null,
                            'type' => 'raw'
                        ],

                        [
                            'label' => $model->getAttributeLabel('requested_date'),
                            'value' => $model->requested_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d', $model->requested_date)."</span>":null,
                            'type' => 'raw'
                        ],
                        [
                            'label' => $model->getAttributeLabel('requested_time'),
                            'value' => $model->requested_time?Requests::$serviceTimes[$model->requested_time]:null,
                            'type' => 'raw'
                        ],
                        [
                            'label' => $model->getAttributeLabel('service_date'),
                            'value' => $model->service_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d', $model->service_date)."</span>":null,
                            'type' => 'raw'
                        ],
                        [
                            'label' => $model->getAttributeLabel('service_time'),
                            'value' => $model->service_time?Requests::$serviceTimes[$model->service_time]:null,
                            'type' => 'raw'
                        ],
                        [
                            'label' => $model->getAttributeLabel('create_date'),
                            'value' => "<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->create_date)."</span>",
                            'type' => 'raw'
                        ],
                        [
                            'label' => $model->getAttributeLabel('modified_date'),
                            'value' => "<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->modified_date)."</span>",
                            'type' => 'raw'
                        ]
                    ),
                )); ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <h4>آدرس مشتری</h4>
                <p><?= $model->userAddress?$model->userAddress->showAddress():'<span class="text-danger">حذف شده</span>' ?></p>
                <?php $this->renderPartial('users.views.manage._view_map', array('map_model' => $model->userAddress)); ?>
            </div>
        </div>
    </div>
</div>

<?php if($invoice): ?>
<div class="panel panel-info" id="invoice-panel">
    <div class="panel-heading">
        اطلاعات فاکتور
        <span class="btn btn-sm btn-<?= $invoice->status == Invoices::STATUS_PAID?"success":"warning" ?>"><?= $invoice->status == Invoices::STATUS_PAID?"پرداخت شده":"پرداخت نشده" ?></span>
        <a href="<?= $this->createUrl("print", array("id" => $model->id)) ?>" class="pull-left btn btn-sm btn-default">
            <i class="fa fa-print"></i>
            چاپ فاکتور
        </a>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('//partial-views/_flashMessage', array('prefix' => 'invoice-')) ?>
        <div>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="5%">ردیف</th>
                    <th>قطعات / اجرت</th>
                    <th width="20%">تخفیف</th>
                    <th width="20%">هزینه با تخفیف</th>
                </tr>
                </thead>
                <tbody>
                <?php $key = 0; foreach ($invoice->items as $key => $item):?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td><?= $item->tariff->title ?></td>
                        <td><?= ($item->cost < $item->tariff->cost)?Controller::parseNumbers(number_format(intval($item->tariff->cost - $item->cost))) . " <small>تومان</small>":'--'; ?></td>
                        <td><?= Controller::parseNumbers(number_format($item->cost)) ?> <small>تومان</small></td>
                    </tr>
                <?php endforeach;?>
                <tr class="warning">
                    <td><?= $key+2 ?></td>
                    <td><b>هزینه اضافی</b><p style="margin: 0"><small><?= $invoice->additional_description ?></small></p></td>
                    <td>--</td>
                    <td><?= Controller::parseNumbers(number_format($invoice->additional_cost)) ?> <small>تومان</small></td>
                </tr>
<!--                <tr class="warning text-warning">-->
<!--                    <td colspan="3" style="background-color: #FFF; border: 0px;">&nbsp;</td>-->
<!--                    <th class="text-left">هزینه اضافی</th>-->
<!--                    <td >--><?php //echo number_format($invoice->additional_cost)?><!-- <small>تومان</small></td>-->
<!--                </tr>-->
                <tr class="info text-info">
                    <td colspan="2" style="background-color: #FFF; border: 0px;">&nbsp;</td>
                    <th class="text-left">مجموع</th>
                    <td ><?php echo Controller::parseNumbers(number_format($invoice->totalCost()))?> <small>تومان</small></td>
                </tr>
                <tr class="success text-success">
                    <td colspan="2" style="background-color: #FFF; border: 0px;">&nbsp;</td>
                    <th class="text-left">جمع تخفیفات</th>
                    <td ><?php echo Controller::parseNumbers(number_format($invoice->total_discount))?> <small>تومان</small></td>
                </tr>
                <tr class="danger text-danger" style="font-size: 20px;font-weight: bold">
                    <td colspan="2" style="background-color: #FFF; border: 0px;">&nbsp;</td>
                    <th class="text-left">قیمت کل</th>
                    <td><?php echo Controller::parseNumbers(number_format($invoice->finalCost()))?> <small>تومان</small></td>
                </tr>
                </tbody>
            </table>
        </div>

<!--        <div class="row">-->
<!--            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-push-3 col-md-push-3 col-sm-push-3">-->
<!--                -->
<!--            </div>-->
<!--        </div>-->

        <?php
        if(empty($invoice->final_cost)):
            $form=$this->beginWidget('CActiveForm', array(
                'action' => array('/requests/manage/invoicing/'.$model->id),
                'id'=>'invoice-form',
            ));
        ?>
            <div class="alert alert-danger"><b>توجه:</b> در صورتی که دکمه "تایید نهایی" را بزنید برای مشتری پیامی مبنی بر صادر شدن فاکتور ارسال میگردد.</div>
            <div class="buttons">
                <?php echo CHtml::submitButton('تایید نهایی',array('class' => 'btn btn-danger btn-lg center-block', 'name' => 'confirm')); ?>
            </div>

        <?php
            $this->endWidget();
        endif;
        ?>
    </div>
</div>
<?php endif; ?>