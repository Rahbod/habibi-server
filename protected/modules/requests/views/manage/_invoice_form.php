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
            'filter'=>$invoiceItems,
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
                    'buttons' =>array(
                        'delete' => array(
                            'visible' => '$data->status < Requests::STATUS_PAID'
                        )
                    )
                ),
            ),
        )); ?>
    </div>
</div>


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