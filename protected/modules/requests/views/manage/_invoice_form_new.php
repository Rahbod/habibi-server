<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
/* @var $invoice Invoices */
/* @var $invoiceForm CActiveForm */
/* @var $form CActiveForm */
?>

<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<div class="panel panel-primary">
    <div class="panel-heading">نوع پرداخت</div>
    <div class="panel-body">
        <?php $invoiceForm=$this->beginWidget('CActiveForm', array(
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
                        <?php echo $invoiceForm->labelEx($invoice,'payment_method'); ?>
                        <?php echo $invoiceForm->dropDownList($invoice,'payment_method',Invoices::$paymentMethodLabels,array('class'=>'form-control')); ?>
                        <?php echo $invoiceForm->error($invoice,'payment_method'); ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <?php echo CHtml::submitButton('ثبت نوع پرداخت',array('class' => 'btn btn-success', 'style' => 'margin-top:25px;width:150px;')); ?>
                    </div>
                </div>
            </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php if(!$invoice->getIsNewRecord()):?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'invoice-pieces-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ]
    )); ?>
        <div class="panel panel-primary">
            <div class="panel-heading">قطعات و اجرت</div>
            <div class="panel-body">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">قطعات</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <label>قطعه</label>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <label>مبلغ</label>
                                </div>
                            </div>

                            <?php $this->widget('ext.dynamicField.dynamicField', array(
                                'id'=>'dynamic-piece',
                                'models' => $pieceModels,
                                'attributes'=>[
                                    [
                                        'name' => 'piece_title',
                                        'inputType'=>'textField',
                                        'htmlOptions' =>[
                                            'class'=>'form-control auto-complete',
                                            'data-source' => $this->createUrl('searchPiece')
                                        ]
                                    ],
                                    [
                                        'name' => 'piece_cost',
                                        'inputType'=>'textField',
                                        'htmlOptions' =>[
                                            'class' => 'form-control'
                                        ]
                                    ],
                                ],
                                'template' =>
                                    '<div class="form-group">'.
                                        '<div class="row">'.
                                            '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">{input-0}</div>'.
                                            '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">'.
                                                '<div class="input-group">'.
                                                    '{input-1}<span class="input-group-addon">تومان</span>'.
                                                '</div>'.
                                            '</div>'.
                                        '</div>'.
                                    '</div>',
                                'addButton' =>[
                                    'title' => '+ افزودن قطعه جدید',
                                    'class' => 'btn btn-default'
                                ],
                                'afterAdd' => 'function(){$(".auto-complete").autoComplete();}'
                            )); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">اجرت</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <label>اجرت</label>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <label>مبلغ</label>
                                </div>
                            </div>

                            <?php $this->widget('ext.dynamicField.dynamicField', array(
                                'id'=>'dynamic-tariff',
                                'models' => $tariffModels,
                                'attributes'=>[
                                    [
                                        'name' => 'tariff_title',
                                        'inputType'=>'textField',
                                        'htmlOptions' =>[
                                            'class'=>'form-control auto-complete',
                                            'data-source' => $this->createUrl('searchTariff')
                                        ]
                                    ],
                                    [
                                        'name' => 'tariff_cost',
                                        'inputType'=>'textField',
                                        'htmlOptions' =>[
                                            'class' => 'form-control'
                                        ]
                                    ],
                                ],
                                'template' =>
                                    '<div class="form-group">'.
                                        '<div class="row">'.
                                            '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">{input-0}</div>'.
                                            '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">'.
                                                '<div class="input-group">'.
                                                    '{input-1}<span class="input-group-addon">تومان</span>'.
                                                '</div>'.
                                            '</div>'.
                                        '</div>'.
                                    '</div>',
                                'addButton' =>[
                                    'title' => '+ افزودن اجرت جدید',
                                    'class' => 'btn btn-default'
                                ],
                                'afterAdd' => 'function(){$(".auto-complete").autoComplete();}'
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">سایر</div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <?php echo $invoiceForm->labelEx($invoice,'additional_cost'); ?>
                            <div class="input-group">
                                <?php echo $invoiceForm->textField($invoice,'additional_cost', ['class' => 'form-control']); ?>
                                <span class="input-group-addon">تومان</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <?php echo $invoiceForm->labelEx($invoice,'discount_percent'); ?>
                            <div class="input-group">
                                <?php echo $invoiceForm->textField($invoice,'discount_percent', ['class' => 'form-control']); ?>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <?php echo $invoiceForm->labelEx($invoice,'credit_increase_percent'); ?>
                            <div class="input-group">
                                <?php echo $invoiceForm->textField($invoice,'credit_increase_percent', ['class' => 'form-control']); ?>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 50px;">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-push-3 col-md-push-3 col-sm-push-3">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="50%" class="text-left">جمع کل</th>
                                    <td width="50%"><?php echo number_format($invoice->totalCost())?> <small>تومان</small></td>
                                </tr>
                                <tr>
                                    <th width="50%" class="text-left">جمع تخفیفات</th>
                                    <td width="50%"><?php echo number_format($invoice->total_discount)?> <small>تومان</small></td>
                                </tr>
                                <tr>
                                    <th width="50%" class="text-left">اعتبار تخصیص داده شده به کاربر</th>
                                    <td width="50%"><?php echo number_format($invoice->creditIncrease())?> <small>تومان</small></td>
                                </tr>
                                <tr style="font-size: 24px;font-weight: bold">
                                    <th width="50%" class="text-left">مبلغ قابل پرداخت</th>
                                    <td width="50%"><?php echo number_format($invoice->finalCost())?> <small>تومان</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" style="overflow:hidden;">
            <?php echo CHtml::button('ثبت اطلاعات', ['name' => 'saveItems', 'type' => 'submit', 'class' => 'btn btn-success btn-lg pull-left'])?>
            <?php echo CHtml::link('مشاهده درخواست', array('/requests/'.$model->id.'#invoice-panel'), array('style' => 'margin:0 15px;','class' => 'btn btn-primary btn-lg pull-right')); ?>
        </div>

    <?php $this->endWidget(); ?>
<?php endif;?>