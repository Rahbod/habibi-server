<?php
/* @var $this RequestsBrandsController */
/* @var $model Brands */

$this->breadcrumbs=array(
	'مدیریت برندها',
);

$this->menu=array(
	array('label'=>'افزودن برند جدید', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت برندها</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن برند جدید</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'brands-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped table-hover',
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
                    'slug',
                    [
                        'header' => 'تعداد مدل ها',
                        'value' => function($model) {
                            /* @var $model Brands */
                            return Controller::parseNumbers(Models::getList($model->id, true)). ' مدل';
                        }
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{models} {update} {delete}',
                        'buttons' => array(
                            'models' => array(
                                'label' => 'مدل ها',
                                'imageUrl' => Yii::app()->theme->baseUrl."/img/list-512.png",
                                'url' => 'Yii::app()->createUrl("/requests/brands/models/".$data->id)',
                                'options' => array('class' => 'list-icon')
                            )
                        )
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>