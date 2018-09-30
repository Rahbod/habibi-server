<?php
/* @var $this ContactRepliesController */
/* @var $model ContactReplies */

$this->breadcrumbs=array(
	'Contact Replies'=>array('admin'),
	'نمایش',
);

$this->menu=array(
	array('label'=>'ایجاد ContactReplies', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contact-replies-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Contact Replies</h1>

<p>
شما می توانید با وارد کردن عملگرهای مقایسه ای (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
یا <b>=</b>) در ابتدای هریک از فیلد های مورد نظر نحوه جستجو را تغییر دهید.
</p>

<?php echo CHtml::link('جستجوی پیشرفته','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
	echo CHtml::beginForm('','post',array('id'=>'grid-delete'));
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contact-replies-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows'=>20,
	'columns'=>array(
		'id',
		'message_id',
		'body',
		'date',
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
echo CHtml::ajaxButton('حذف',
	$this->createUrl('DeleteSelected'),array(
	'type'=>'POST',
	'data' => 'js:$("#grid-delete").serialize()',
	'success'=>'js:function(){
        $("#contact-replies-grid").yiiGridView("update")
    }',

));
echo CHtml::endForm(); ?>
