<?php
/* @var $this ContactDepartmentController */
/* @var $model ContactDepartment */

$this->breadcrumbs=array(
	'مدیریت بخش های تماس'=>array('admin'),
	'نمایش',
);
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت بخش های تماس</h3>
		<a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">
			<i class="fa fa-plus"></i>
			<span class="hidden-xs">افزودن بخش جدید</span>
		</a>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<?php $this->renderPartial('//partial-views/_flashMessage'); ?>
			<?php
			echo CHtml::beginForm('','post',array('id'=>'grid-delete'));
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'contact-department-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'selectableRows'=>20,
				'itemsCssClass'=>'table table-striped',
				'template' => '{pager} {items} {pager}',
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
						'id'=>'selectedItems',
						'class'=>'CCheckBoxColumn',
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update} {delete}'
					),
				),
			));
			echo CHtml::ajaxButton('حذف همه',
				$this->createUrl('DeleteSelected'),array(
					'type'=>'POST',
					'data' => 'js:$("#grid-delete").serialize()',
					'success'=>'js:function(){
						$("#contact-department-grid").yiiGridView("update")
					}',
				),array('class' => 'btn btn-success'));
			echo CHtml::endForm(); ?>
		</div>
	</div>
</div>

