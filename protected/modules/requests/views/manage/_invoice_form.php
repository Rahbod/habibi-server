<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
/* @var $invoice Invoices */
/* @var $invoiceItems InvoiceItems */
/* @var $form CActiveForm */

$itemModel = new InvoiceItems();
?>

<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<div class="panel panel-default">
    <div class="panel-heading">اطلاعات فاکتور</div>
    <div class="panel-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'invoice-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions' => [
                'validateOnSubmit' => true,
            ]
        )); ?>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <?php echo $form->labelEx($invoice,'payment_method'); ?>
                        <?php echo $form->dropDownList($invoice,'payment_method',Invoices::$paymentMethodLabels,array('class'=>'form-control')); ?>
                        <?php echo $form->error($invoice,'payment_method'); ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <?php echo $form->labelEx($invoice,'additional_cost'); ?>
                        <div class="input-group">
                            <?php echo $form->textField($invoice,'additional_cost',array('class'=>'form-control')); ?>
                            <span class="input-group-addon">تومان</span>
                        </div>
                        <?php echo $form->error($invoice,'additional_cost'); ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <?php echo $form->labelEx($invoice,'additional_description'); ?>
                        <?php echo $form->textArea($invoice,'additional_description',array('class'=>'form-control')); ?>
                        <?php echo $form->error($invoice,'additional_description'); ?>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <?php echo CHtml::submitButton('ثبت',array('class' => 'btn btn-success')); ?>
            </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php if(!$invoice->getIsNewRecord()):?>
    <div class="panel panel-warning">
        <div class="panel-heading">اجرت ها</div>
        <div class="panel-body">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'invoice-items-form',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions' => [
                    'validateOnSubmit' => true,
                ]
            )); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <?php echo $form->labelEx($itemModel,'tariff_id'); ?>
                            <?php echo $form->dropDownList($itemModel,'tariff_id',CHtml::listData(Tariffs::model()->findAll(), 'id', 'titleCost'),array('class'=>'form-control')); ?>
                            <?php echo $form->error($itemModel,'tariff_id'); ?>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <?php echo $form->labelEx($itemModel,'cost'); ?>
                            <div class="input-group">
                                <?php echo $form->textField($itemModel,'cost',array('class'=>'form-control')); ?>
                                <span class="input-group-addon">تومان</span>
                            </div>
                            <?php echo $form->error($itemModel,'cost'); ?>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <?php echo CHtml::submitButton('افزودن',array('class' => 'btn btn-success')); ?>
                </div>

            <?php $this->endWidget(); ?>

            <hr>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'items-grid',
                'dataProvider'=>$invoiceItems->search(),
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
                        'name' => 'tariff_id',
                        'value' => '$data->tariff?$data->tariff->title:"-"',
                    ],
                    [
                        'header' => 'هزینه اجرت',
                        'value' => 'number_format($data->tariff->cost) . " تومان"',
                    ],
                    [
                        'header' => 'تخفیف',
                        'value' => function($data) {
                            if($data->cost < $data->tariff->cost)
                                return number_format(intval($data->tariff->cost - $data->cost)) . " تومان";
                            return '--';
                        },
                    ],
                    [
                        'header' => 'هزینه نهایی سرویس',
                        'name' => 'cost',
                        'value' => 'number_format($data->cost) . " تومان"',
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{delete}',
                        'deleteButtonUrl' => 'Yii::app()->createUrl("/requests/manage/deleteInvoiceItem", array("invoice_id" => $data->invoice_id, "tariff_id" => $data->tariff_id))',
                    ),
                ),
            )); ?>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">اطلاعات نهایی فاکتور</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-push-3 col-md-push-3 col-sm-push-3">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th width="50%" class="text-left">جمع کل</th>
                            <td width="50%"><?php echo number_format($invoice->totalCost() + $invoice->total_discount)?> <small>تومان</small></td>
                        </tr>
                        <tr>
                            <th width="50%" class="text-left">جمع تخفیفات</th>
                            <td width="50%"><?php echo number_format($invoice->total_discount)?> <small>تومان</small></td>
                        </tr>
                        <tr style="font-size: 24px;font-weight: bold">
                            <th width="50%" class="text-left">مبلغ نهایی پرداخت</th>
                            <td width="50%"><?php echo number_format($invoice->totalCost())?> <small>تومان</small></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="buttons">
                <?php echo CHtml::link('مشاهده درخواست', array('/requests/'.$model->id.'#invoice-panel'), array('style' => 'display:inline-block','class' => 'btn btn-primary btn-lg center-block')); ?>
            </div>
        </div>
    </div>
<?php endif;?>