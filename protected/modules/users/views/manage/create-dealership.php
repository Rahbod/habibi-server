<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $avatar array */
/* @var $request DealershipRequests */

$this->breadcrumbs=array(
	'کاربران'=>array('admin'),
	'افزودن نمایشگاه',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">افزودن نمایشگاه جدید</h3>
        <a href="<?= $this->createUrl($request?'dealershipRequests':'dealerships') ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_dealership_form', compact('model', 'avatar', 'request')); ?>
    </div>
</div>