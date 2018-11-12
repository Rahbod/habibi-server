<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $request CooperationRequests*/
/* @var $form CActiveForm */

$this->breadcrumbs = array(
    'افزودن آدرس جدید',
);

$user = false;
if(isset($_GET['user']))
    $user = Users::model()->findByPk($_GET['user']);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">افزودن آدرس جدید <?php if($user) echo "برای \"{$user->userDetails->getShowName()}\""; ?></h3>
        <a href="<?= $this->createUrl($_GET['return']) ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_address_form', array('model'=>$model)); ?>
    </div>
</div>