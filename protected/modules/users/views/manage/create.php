<?php
/* @var $this UsersManageController */
/* @var $model Users */

$role = UserRoles::model()->findByPk(isset($_GET['role'])?$_GET['role']:1);
if($role->role == 'user') {
    $this->breadcrumbs = array(
        'کاربران' => array("admin?role=$role->id"),
        'افزودن کاربر جدید',
    );
    $labels = [
        'کاربران',
        'کاربر'
    ];
}
elseif($role->role == 'repairman') {
    $this->breadcrumbs = array(
        'تعمیرکاران' => array("admin?role=$role->id"),
        'افزودن تعمیرکار جدید',
    );
    $labels = [
        'تعمیرکاران',
        'تعمیرکار'
    ];
}
elseif($role->role == 'operator') {
    $this->breadcrumbs = array(
        'اپراتورها' => array("admin?role=$role->id"),
        'افزودن اپراتور جدید',
    );
    $labels = [
        'اپراتورها',
        'اپراتور'
    ];
}
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">افزودن <?= $role->name ?> جدید</h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>