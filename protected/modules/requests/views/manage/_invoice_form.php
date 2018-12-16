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
    <div class="panel panel-default">
        <div class="panel-heading">تعرفه ها</div>
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

    <div class="panel panel-danger">
        <div class="panel-heading">تایید نهایی فاکتور</div>
        <div class="panel-body">
            <div class="alert alert-danger"><b>توجه:</b> در صورتی که دکمه "تایید نهایی" را بزنید برای کاربر پیامی مبنی بر صادر شدن فاکتور ارسال میگردد.</div>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'invoice-form',
            )); ?>

            <div class="text-center">
                <h3 style="padding: 50px 0 20px;">جمع کل: <?php echo number_format($invoice->totalCost())?> <small>تومان</small></h3>
            </div>

            <div class="buttons">
                <?php echo CHtml::submitButton('تایید نهایی',array('class' => 'btn btn-danger btn-lg center-block', 'name' => 'confirm')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
<?php endif;?>

<div class="modal fade" id="add-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    افزودن نوع لوازم
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('requests.views.categories._form',array('popup' => true,'model' => new Categories(), 'logo' => [])) ?>
            </div>
        </div>
    </div>
</div>


<?php
Yii::app()->clientScript->registerScript('model-load', '
    $("body").on("change", ".brand-change-trigger, select.user-change-trigger", function(){
        var el = $(this);
        fetch(el);
    }).on("change", "select.user-change-trigger", function(){
        var el = $(this),
            val = el.val();
        if(val === ""){
            $("#add-address-btn").data("foreign-id", val).attr("disabled", true);
        }else{
            $("#add-address-btn").data("foreign-id", val).attr("disabled", false);
        }
    }).on("click", "#add-address-btn", function(e){
        e.preventDefault();
        var el = $(this),
            url = el.attr("href");
        if(el.data("foreign-id") === ""){
            alert("لطفا یک کاربر انتخاب کنید.");
        }else{
            window.location = url+"&user="+el.data("foreign-id");
        }
    });
    
//    fetch($(".brand-change-trigger"));
    fetch($("select.user-change-trigger"), $("#Requests_user_address_id").data("id"));
    
    function fetch(el, id = false){
        var url = el.data("fetch-url"),
            target = el.data("target"),
            val = el.val();
        if(val !== ""){
            url = url + "/" + val; 
            $.ajax({
                url: url,
                type: "GET",
                dataType: "html",
                success: function(html){
                    $(target).html(html);
                    if(id)
                        $(target).find("[value=\""+id+"\"]").attr("selected", true);
                }
            });
            
            $(target).attr("disabled", false);
            $("#add-address-btn").data("foreign-id", val).attr("disabled", false);
        }else{  
            $(target).attr("disabled", true);
            $("#add-address-btn").data("foreign-id", val).attr("disabled", true);
        }
    }
', CClientScript::POS_READY);
?>