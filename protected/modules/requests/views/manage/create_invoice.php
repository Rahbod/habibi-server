<?php
/* @var $this RequestsManageController */
/* @var $model Requests */
/* @var $invoice Invoices */
/* @var $invoiceItems InvoiceItems */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'نمایش درخواست #'.$model->id => $this->createUrl('/requests/'.$model->id),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">صدور فاکتور</h3>
        <a href="<?= $this->createUrl('delete').'/'.$model->id; ?>" class="btn btn-primary btn-sm pull-left">
            بازگشت
            <i class="fa fa-arrow-left"></i>
        </a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_invoice_form', array('model'=>$model, 'invoice' => $invoice, 'invoiceItems' => $invoiceItems)); ?>	</div>
</div>