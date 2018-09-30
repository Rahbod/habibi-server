<?php
/* @var $this ContactMessagesController */
/* @var $model ContactMessages */
$this->breadcrumbs=array(
    'لیست پیام ها'=>array('admin'),
    $model->subject
);
$this->menu=array(
    array('label'=>'حذف پیام', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'نمایش لیست پیام ها', 'url'=>array('admin?ContactMessages[department_id]='.$model->department_id))
);
?>
<div class="row">
    <section class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">نمایش پیام #<?php echo $model->subject; ?></h3>
            </div>
            <div class="box-body">
                <?php $this->renderPartial('//partial-views/_flashMessage') ?>

                <?php
                $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        'id',
                        array(
                            'label' => 'عنوان بخش',
                            'value' => $model->department->title
                        ),
                        array(
                            'name' => 'date',
                            'value' => JalaliDate::date('Y/m/d - H:i:s',$model->date)
                        ),
                        'name',
                        'email',
                        'tel',
                        'subject',
                        'body',
                        array(
                            'name' => 'reply',
                            'value' => $model->replyLabels[$model->reply]
                        )
                    )
                )); ?>
            </div>
        </div>
    </section>
    <section class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">ارسال پاسخ</h3>
            </div>
            <div class="box-body">
                <?php
                $rpModel = new ContactReplies();
                $rpModel->message_id = $model->id;
                ?>
                <?= $this->renderPartial('contact.views.replies._form',array('model'=>$rpModel)) ?>
            </div>
        </div>
    </section>
    <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">لیست پاسخ های قبلی</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <?php	$rpModel->setScenario('search');
                    $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'contact-replies-grid',
                            'dataProvider'=>$rpModel->search(),
                            'selectableRows'=>20,
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
                                array(
                                    'name' => 'body',
                                    'type'=> 'raw'
                                ),
                                array(
                                    'name' => 'date',
                                    'value' => 'JalaliDate::date("Y/m/d - H:i:s",$data->date)',
                                ),
                            )
                        )
                    );?>
                </div>
            </div>
        </div>
    </section>
</div>