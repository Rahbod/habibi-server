<?php
/* @var $this UsersPlansController */
/* @var $model Plans */

$this->breadcrumbs=array(
	'پلن ها'=>array('admin'),
	'مدیریت',
);?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت پلن ها</h3>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'admin-roles-grid',
				'dataProvider'=>$model->search(),
				'itemsCssClass'=>'table',
				'columns'=>array(
                    'title',
                    array(
                        'header' => 'تعرفه (نمایشگاه)',
                        'value' => '$data->getRule("dealership", "price") == 0 ? "رایگان" : number_format($data->getRule("dealership", "price")) . " تومان"'
                    ),
					array(
                        'header' => 'تعرفه (کاربر عادی)',
                        'value' => '$data->getRule("user", "price") == 0 ? "رایگان" : number_format($data->getRule("user", "price")) . " تومان"'
                    ),
                    array(
                        'name' => 'status',
                        'value' => 'Plans::$statusLabels[$data->status]',
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{update}'
                    ),
				),
			)); ?>
		</div>
	</div>
</div>