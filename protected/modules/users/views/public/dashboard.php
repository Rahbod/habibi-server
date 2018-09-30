<?php
/* @var $this UsersPublicController */
/* @var $user Users */
/* @var $sells Cars */
$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>

<div class="content-box white-bg">
    <div class="center-box">
        <ul class="nav nav-pills">
            <li class="active"><a class="btn btn-gray btn-wide" data-toggle="tab" href="#sell-tab">آگهی فروش</a></li>
            <li><a class="btn btn-gray btn-wide" data-toggle="tab" href="#parking-tab">پارکینگ</a></li>
            <li><a class="btn btn-gray btn-wide" data-toggle="tab" href="#alerts-tab">گوش به زنگ</a></li>
            <!--            <li><a class="btn btn-gray btn-wide" data-toggle="tab" href="#exchange-tab">معاوضه</a></li>-->
        </ul>
        <div class="tab-content panel-tabs">
            <div class="tab-pane fade active in" id="sell-tab">
                <?php $this->renderPartial('//partial-views/_flashMessage', ['prefix' => 'sells-']) ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a type="button" class="btn btn-success btn-wide-2x" href="<?= $this->createUrl('/sell') ?>">
                            <i class="addon-icon icon icon-plus"></i>
                            درج آگهی جدید
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h5 class="text-blue pull-left">تعداد آگهی های مجاز <?= Controller::parseNumbers($user->getValidAdCount()) ?></h5>
                    </div>
                </div>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'brands-list',
                    'dataProvider'=>new CArrayDataProvider($sells),
                    'itemsCssClass'=>'advertise-panel-list',
                    'template' => '{items} {pager}',
                    'emptyCssClass' => 'sell-not-allow silver',
                    'emptyTagName' => 'div',
                    'emptyText' => '<div class="inner-flex"><h3>آگهی ثبت نکردی!</h3><p>همین الان ثبت کن</p><a href="'.$this->createUrl('/sell').'" class="btn btn-success">درج آگهی جدید</a></div>',
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
                    'itemView' => 'car.views.public._item_panel_view'
                )); ?>
            </div>
            <div class="tab-pane fade" id="parking-tab">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h5 class="text-blue pull-left">تعداد خودرو های پارکینگ <span id="count-parked"><?= $user->countParked ?></span></h5>
                    </div>
                </div>
                <div class="alert alert-success view-alert hidden">
                    <p>
                        <span>خودرو با موفقیت از پارکینگ شما خارج شد.</span>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </p>
                </div>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'brands-list',
                    'dataProvider'=>new CArrayDataProvider($user->parked),
                    'itemsCssClass'=>'advertise-panel-list',
                    'template' => '{items} {pager}',
                    'emptyCssClass' => 'sell-not-allow silver',
                    'emptyTagName' => 'div',
                    'emptyText' => '<div class="inner-flex"><h3>پارکینگ خالی است.</h3></div>',
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
                    'itemView' => 'car.views.public._item_parking_view'
                )); ?>
            </div>
            <div class="tab-pane fade" id="alerts-tab">
                <?php $this->renderPartial('//partial-views/_flashMessage', ['prefix' => 'alerts-']) ?>
                <div class="alert alert-success view-alert hidden">
                    <p>
                        <span>گوش به زنگ با موفقیت حذف شد.</span>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a type="button" class="btn btn-success btn-wide-2x alert-btn<?php if($user->countAlerts !==0):?> hidden<?php endif; ?>" href="<?= $this->createUrl('/car/public/alert') ?>">
                            <i class="addon-icon icon icon-plus"></i>
                            درج گوش به زنگ
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h5 class="text-blue pull-left">تعداد گوش به زنگ <span id="count-alert"><?= $user->countAlerts ?></span></h5>
                    </div>
                </div>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'alerts-list',
                    'dataProvider'=>new CArrayDataProvider($user->alerts),
                    'itemsCssClass'=>'advertise-panel-list',
                    'template' => '{items} {pager}',
                    'emptyCssClass' => 'sell-not-allow silver',
                    'emptyTagName' => 'div',
                    'emptyText' => '<div class="inner-flex"><h3>گوش به زنگ نداری!</h3><p>همین الان ثبت کن</p><a href="'.$this->createUrl('/car/public/alert').'" class="btn btn-success">درج گوش به زنگ</a></div>',
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
                    'itemView' => 'car.views.public._item_alert_view'
                )); ?>
            </div>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('active-tab','
	var url = window.location.hash, idx = url.indexOf("#")
	var hash = idx != -1 ? url.substring(idx) : -1;
	if(hash != -1){
		$("[href=\'"+hash+"\']").click();
		$(\'html, body\').animate({
			scrollTop: ($(hash).offset().top-124)
		},0);
	}
',CClientScript::POS_LOAD);
