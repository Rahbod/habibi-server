<?php
/* @var $this RequestsCategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن Categories', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت Categories</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن Categories</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'categories-grid',
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
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>