<?php
/* @var $this RolesController */
/* @var $model AdminRoles */

$this->breadcrumbs=array(
	'نقش مدیران'=>array('index'),
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن', 'url'=>array('create')),
);
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت نقش مدیران</h3>
		<a href="<?php echo $this->createUrl('create')?>" class="btn btn-default btn-sm">افزودن مدیر</a>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'admin-roles-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'itemsCssClass'=>'table',
				'columns'=>array(
					'name',
					'role',
					array(
						'class'=>'CButtonColumn',
						'template' => '{update} {delete}'
					),
				),
			)); ?>
		</div>
	</div>
</div>

