<?php
/* @var $this TownsManageController */
/* @var $model Towns */

$this->breadcrumbs=array(
	'مدیریت استان ها',
);

$this->menu=array(
	array('label'=>'افزودن استان', 'url'=>array('create')),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت استان ها</h3>
		<a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن استان جدید</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'towns-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'itemsCssClass'=>'table table-striped table-hover',
				'template' => '{items} {pager}',
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
					'name',
					'slug',
					array(
						'class'=>'CButtonColumn',
						'template' => '{update}{delete}'
					),
				),
			)); ?>
		</div>
	</div>
</div>
