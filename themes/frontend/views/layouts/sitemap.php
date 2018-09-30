<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="fa_ir">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#158BFF" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Yii::app()->request->csrfToken ?>" />
    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <title><?= (!empty($this->pageTitle)?$this->pageTitle.' | ':'').$this->siteName ?></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    $cssCoreUrl = $cs->getCoreScriptUrl();
    //    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    //    $cs->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-select.min.css');
    $cs->registerCssFile($baseUrl.'/css/fontiran.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css?4.7');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/bootstrap-select.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.nicescroll.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.js?4.7', CClientScript::POS_END);
    /* @var $this SiteController */
    /* @var $model Pages */
    $this->pageTitle='نقشه سایت';
    $this->pageHeader='نقشه سایت';
    $this->breadcrumbs=array(
        'نقشه سایت',
    );
    ?>
</head>
<body>
<?php $this->renderPartial('//partial-views/_header');?>
<?php $this->renderPartial('//partial-views/_breadcrumb') ?>
<div class="content-box white-bg page-view">
    <div class="center-box relative">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-push-2 col-md-push-2">
                <div class="page-text" dir="auto">
                    <?php echo $content;?>
                </div>
            </div>
            <div class="fade-logo-bg"></div>
        </div>
    </div>
</div>
<?php $this->renderPartial('//partial-views/_login_popup');?>
<?php $this->renderPartial('//partial-views/_footer');?>
</body>
</html>