<?php
/* @var $this SiteController */
/* @var $model Pages */
$this->pageTitle=$model->title;
$this->pageHeader=$model->title;
$this->breadcrumbs=array(
    $model->title,
);
?>

<?php $this->renderPartial('//partial-views/_breadcrumb') ?>
<div class="content-box white-bg page-view">
    <div class="center-box relative">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="page-text" dir="auto"><?php
                    $purifier=new CHtmlPurifier();
                    echo $purifier->purify($model->summary);
                    ?></div>
            </div>
            <div class="fade-logo-bg"></div>
        </div>
    </div>
</div>