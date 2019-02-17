<?php
/* @var $this RequestsTariffsController */
/* @var $model Tariffs */
/* @var $type string */

$this->breadcrumbs=array(
	'مدیریت',
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $type == 'tariffs' ? 'مدیریت اجرت ها' : 'مدیریت قطعات'?></h3>
        <a href="<?= $this->createUrl('tariffs/create/'.$type) ?>" class="btn btn-default btn-sm">افزودن <?php echo $type == 'tariffs' ? 'اجرت' : 'قطعه'?> جدید</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'tariffs-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
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
                    'title',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{update} {delete}'
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>