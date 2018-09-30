<?php
/* @var $this PagesManageController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'مدیریت',
);
$template = '{update}{delete}';
if($this->categorySlug == 'document')
    $this->menu=array(
	    array('label'=>'افزودن مستندات جدید', 'url'=>array('manage/create/slug/document')),
    );
if($this->categorySlug == 'base')
{
    $template = '{update}';
}
if($this->categorySlug == 'free')
    $this->menu=array(
	    array('label'=>'افزودن صحفه جدید', 'url'=>array('create')),
    );

?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت <?= $this->categoryName ?></h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
		<div class="table-responsive">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'pages-grid',
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
				'title',
				array(
					'name' => 'summary',
					'value' => 'substr($data->summary,0,300)'
				),
				array(
					'class'=>'CButtonColumn',
					'template' => $template
				),
			),
		)); ?>
		</div>
	</div>
</div>
