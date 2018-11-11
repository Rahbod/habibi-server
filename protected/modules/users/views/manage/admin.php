<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $role UserRoles */
if($role->role == 'user') {
    $this->breadcrumbs = array(
        'کاربران' => array("admin?role=$role->id"),
        'مدیریت کاربران',
    );
    $labels = [
        'کاربران',
        'کاربر'
    ];
}
elseif($role->role == 'repairman') {
    $this->breadcrumbs = array(
        'تعمیرکاران' => array("admin?role=$role->id"),
        'مدیریت تعمیرکاران',
    );
    $labels = [
        'تعمیرکاران',
        'تعمیرکار'
    ];
}
elseif($role->role == 'operator') {
    $this->breadcrumbs = array(
        'اپراتورها' => array("admin?role=$role->id"),
        'مدیریت اپراتورها',
    );
    $labels = [
        'اپراتورها',
        'اپراتور'
    ];
}
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->breadcrumbs[0] ?></h3>
        <a href="<?= $this->createUrl("create?role=$role->id") ?>" class="btn btn-default btn-sm">افزودن <?= $labels[1] ?> جدید</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'admins-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped table-hover',
                'columns'=>array(
                    array(
                        'header' => 'نام کامل',
                        'value' => '$data->userDetails?$data->userDetails->getShowName():$data->username',
                        'filter' => CHtml::activeTextField($model,'first_name')
                    ),
                    array(
                        'header' => 'وضعیت',
                        'value' => '$data->statusLabels[$data->status]',
                        'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
                    ),array(
                        'header' => 'کلمه عبور',
                        'value' => function($model) use($labels) {
                            /* @var$model Users */
                            return $model->useGeneratedPassword()?$model->generatePassword():"کلمه عبور توسط {$labels[1]} تغییر یافته";
                        }
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'buttons' => array(
                            'view' => array(
                                'url' => 'Yii::app()->createUrl("/users/manage/view",array("id" => $data->id))'
                            )
                        )
                    )
                )
            )); ?>
        </div>
    </div>
</div>