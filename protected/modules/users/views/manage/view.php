<?php
/* @var $this UsersManageController */
/* @var $model Users */
Yii::app()->clientScript->registerCss('imgSize','
.national-card-image
{
	max-width:500px;
	max-height:500px;
}
');

$this->breadcrumbs=array(
	'کاربران'=>array('index'),
	$model->userDetails->getShowName(),
);
if($model->role_id == 2)
{
	$this->menu=array(
		array('label'=>'مدیرت کاربران', 'url'=>array($model->role_id == 2?'adminPublishers':'admin')),
		array('label'=>'نمایش تراکنش های کاربر', 'url'=>array("userTransactions",'id'=>$model->id)),
		array('label'=>'حذف کاربر', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف کاربر اطمینان دارید؟')),
//		array('label'=>'تایید اطلاعات کاربر', 'url'=>array('confirmPublisher', 'id'=>$model->id, 'view-page' => true), 'linkOptions' => array('style' => 'margin-top:30px')),
//		array('label'=>'رد اطلاعات کاربر', 'url'=>array('refusePublisher', 'id'=>$model->id, 'view-page' => true)),
//		array('label'=>'تایید شناسه درخواستی کاربر', 'url'=>array('confirmDevID', 'id'=>$model->id, 'view-page' => true), 'linkOptions' => array('style' => 'margin-top:30px')),
//		array('label'=>'رد شناسه درخواستی کاربر', 'url'=>array('deleteDevID', 'id'=>$model->id, 'view-page' => true)),
//		array('label'=>'تایید اطلاعات مالی کاربر', 'url'=>"#" , 'linkOptions' => array('style' => 'margin-top:30px', 'class' => 'change-finance-status', 'data-id' => $model->id, 'data-value' => "accepted")),
//		array('label'=>'رد اطلاعات مالی کاربر', 'url'=>"#" , 'linkOptions' => array('class' => 'change-finance-status', 'data-id' => $model->id, 'data-value' => "refused")),
//		array('label'=>'افزایش اعتبار کاربر', 'url'=>array('changeCredit', 'id'=>$model->id), 'linkOptions' => array('style' => 'margin-top:30px;font-weight:bold')),
	);

	Yii::app()->clientScript->registerScript('changeFinanceStatus', "
		$('body').on('click', '.change-finance-status', function(){
			$.ajax({
				url:'".$this->createUrl('/users/manage/changeFinanceStatus')."',
				type:'POST',
				dataType:'JSON',
				data:{user_id:$(this).data('id'), value:$(this).data('value')},
				success:function(data){
					if(data.status){
						alert('با موفقیت انجام شد.');
						location.reload();
					}else
						alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
				}
			});
		});
	");
}
else
	$this->menu=array(
		array('label'=>'مدیرت کاربران', 'url'=>array($model->role_id == 2?'adminPublishers':'admin')),
		array('label'=>'حذف کاربر', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف کاربر اطمینان دارید؟')),
//		array('label'=>'تایید اطلاعات کاربر', 'url'=>array('confirmPublisher', 'id'=>$model->id, 'view-page' => true), 'linkOptions' => array('style' => 'margin-top:30px')),
//		array('label'=>'رد اطلاعات کاربر', 'url'=>array('refusePublisher', 'id'=>$model->id, 'view-page' => true)),
//		array('label'=>'افزایش اعتبار کاربر', 'url'=>array('changeCredit', 'id'=>$model->id), 'linkOptions' => array('style' => 'margin-top:30px;font-weight:bold')),
	);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">نمایش اطلاعات <?php echo $model->userDetails->getShowName(); ?></h3>
	</div>
	<div class="box-body">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'نام و نام خانوادگی',
				'value'=>$model->userDetails->getShowName(),
			),
			array(
				'name'=>'شماره تماس',
				'value'=>$model->userDetails->phone,
			),
			array(
				'name'=>'کد پستی',
				'value'=>$model->userDetails->zip_code,
			),
			array(
				'name'=>'آدرس',
				'value'=>$model->userDetails->address,
			),
			array(
				'name'=>'نوع کاربری',
				'value'=>$model->role->name,
			),
			array(
				'name'=>'وضعیت',
				'value'=>$model->statusLabels[$model->status],
			),
		),
	)); ?>
	</div>
</div>
