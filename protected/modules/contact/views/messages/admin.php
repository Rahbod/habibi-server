<?php
/* @var $this ContactMessagesController */
/* @var $model ContactMessages */

$this->breadcrumbs=array(
	'لیست پیام ها'=>array('admin'),
	'نمایش',
);
$dep = '';
if(isset($_GET['ContactMessages']['department_id']))
	$dep = '?ContactMessages[department_id]='.(int)$_GET['ContactMessages']['department_id'];
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contact-messages-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت پیام ها</h3>
	</div>
	<div class="box-body">
		<p>بخش مورد نظر را انتخاب کنید.</p>
		<div class="search-form well"><?php $this->renderPartial('_search',array('model'=>$model));?></div>
		<?php $this->renderPartial('//partial-views/_flashMessage'); ?>
		<div class="table-responsive">
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
					'email',
					'subject',
					array(
						'name' => 'department_id',
						'value' => '$data->department->title',
						'filter' => CHtml::listData(ContactDepartment::model()->findAll(),'id','title')
					),
					array(
						'name' => 'date',
						'value' => 'JalaliDate::date("Y/m/d - H:i",$data->date)',
						'filter' => false
					),
					array(
						'name' => 'seen',
						'value' => '$data->seenLabels[$data->seen]',
						'filter' => CHtml::activeDropDownList($model,'seen',$model->seenLabels,array('prompt'=>'همه'))
					),
					array(
						'name' => 'reply',
						'value' => '$data->replyLabels[$data->reply]',
						'filter' => CHtml::activeDropDownList($model,'reply',$model->replyLabels,array('prompt'=>'همه'))
					),
					array(
						'id'=>'selectedItems',
						'class'=>'CCheckBoxColumn',
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{view} {delete}'
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

